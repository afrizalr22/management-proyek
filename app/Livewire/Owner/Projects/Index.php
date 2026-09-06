<?php

namespace App\Livewire\Owner\Projects;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    public string $sort = 'latest';

    public function mount(): void
    {
        $this->authorizeViewProjects();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'status',
            'sort',
        ]);

        $this->sort = 'latest';

        $this->resetPage();
    }

    public function render()
    {
        $projects = Project::query()
            ->with([
                'client:id,company_name,contact_person',
                'mandor:id,name,email',
            ])
            ->withCount([
                'workers',
                'tasks',
            ])
            ->when(
                $this->search !== '',
                function (Builder $query): void {
                    $search = '%'.trim($this->search).'%';

                    $query->where(
                        function (Builder $query) use ($search): void {
                            $query
                                ->where(
                                    'project_code',
                                    'like',
                                    $search
                                )
                                ->orWhere(
                                    'project_name',
                                    'like',
                                    $search
                                )
                                ->orWhere(
                                    'location',
                                    'like',
                                    $search
                                )
                                ->orWhereHas(
                                    'client',
                                    fn (Builder $query) => $query
                                        ->where(
                                            'company_name',
                                            'like',
                                            $search
                                        )
                                )
                                ->orWhereHas(
                                    'mandor',
                                    fn (Builder $query) => $query
                                        ->where(
                                            'name',
                                            'like',
                                            $search
                                        )
                                );
                        }
                    );
                }
            )
            ->when(
                $this->status !== '',
                fn (Builder $query) => $query->where(
                    'status',
                    $this->status
                )
            )
            ->when(
                $this->sort === 'latest',
                fn (Builder $query) => $query
                    ->latest('id')
            )
            ->when(
                $this->sort === 'oldest',
                fn (Builder $query) => $query
                    ->oldest('id')
            )
            ->when(
                $this->sort === 'name_asc',
                fn (Builder $query) => $query
                    ->orderBy('project_name')
            )
            ->when(
                $this->sort === 'name_desc',
                fn (Builder $query) => $query
                    ->orderByDesc('project_name')
            )
            ->when(
                $this->sort === 'progress_highest',
                fn (Builder $query) => $query
                    ->orderByDesc('progress')
            )
            ->when(
                $this->sort === 'progress_lowest',
                fn (Builder $query) => $query
                    ->orderBy('progress')
            )
            ->paginate(9);

        $statistics = [
            'total' => Project::query()->count(),

            'planning' => Project::query()
                ->where('status', 'planning')
                ->count(),

            'on_progress' => Project::query()
                ->where('status', 'on_progress')
                ->count(),

            'nearly_completed' => Project::query()
                ->where('status', 'on_progress')
                ->whereBetween('progress', [75, 99])
                ->count(),

            'completed' => Project::query()
                ->where('status', 'completed')
                ->count(),
        ];

        return view('livewire.owner.projects.index', [
            'projects' => $projects,
            'statistics' => $statistics,
        ]);
    }

    private function authorizeViewProjects(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('view projects'),
            403
        );
    }
}