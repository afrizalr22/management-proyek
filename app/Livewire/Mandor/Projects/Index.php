<?php

namespace App\Livewire\Mandor\Projects;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $status = '';

    #[Url(except: 'latest')]
    public string $sort = 'latest';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingSort(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'status',
        ]);

        $this->sort = 'latest';

        $this->resetPage();
    }

    private function mandor(): User
    {
        $mandor = Auth::user();

        abort_unless(
            $mandor instanceof User
                && $mandor->hasRole('mandor'),
            403
        );

        return $mandor;
    }

    private function projectQuery(
        int $mandorId
    ): Builder {
        return Project::query()
            ->where(
                'mandor_id',
                $mandorId
            );
    }

    private function statistics(
        int $mandorId
    ): array {
        $query = $this->projectQuery(
            $mandorId
        );

        return [
            'total' =>
                (clone $query)->count(),

            'active' =>
                (clone $query)
                    ->whereIn(
                        'status',
                        [
                            'planning',
                            'on_progress',
                            'in_progress',
                            'ongoing',
                        ]
                    )
                    ->count(),

            'completed' =>
                (clone $query)
                    ->where(
                        'status',
                        'completed'
                    )
                    ->count(),

            'average_progress' =>
                (int) round(
                    (float) (
                        (clone $query)
                            ->avg('progress')
                        ?? 0
                    )
                ),
        ];
    }

    public function render()
    {
        $mandor = $this->mandor();

        $allowedStatuses = [
            'planning',
            'on_progress',
            'in_progress',
            'ongoing',
            'on_hold',
            'completed',
            'cancelled',
        ];

        $sortConfiguration = [
            'latest' => [
                'column' => 'id',
                'direction' => 'desc',
            ],

            'oldest' => [
                'column' => 'id',
                'direction' => 'asc',
            ],

            'name_asc' => [
                'column' => 'project_name',
                'direction' => 'asc',
            ],

            'name_desc' => [
                'column' => 'project_name',
                'direction' => 'desc',
            ],

            'progress_highest' => [
                'column' => 'progress',
                'direction' => 'desc',
            ],

            'progress_lowest' => [
                'column' => 'progress',
                'direction' => 'asc',
            ],

            'deadline_nearest' => [
                'column' => 'end_date',
                'direction' => 'asc',
            ],
        ];

        $selectedSort =
            $sortConfiguration[$this->sort]
            ?? $sortConfiguration['latest'];

        $search = trim(
            $this->search
        );

        $projects = $this->projectQuery(
            $mandor->id
        )
            ->with([
                'client:id,company_name',

                'tasks' => fn ($query) =>
                    $query
                        ->latest('updated_at')
                        ->latest('id'),
            ])
            ->withCount([
                'tasks',

                'workerAssignments as active_workers_count' =>
                    fn ($query) => $query
                        ->where(
                            'status',
                            'active'
                        ),
            ])
            ->when(
                $search !== '',
                function (
                    Builder $query
                ) use ($search): void {
                    $searchValue =
                        '%'.$search.'%';

                    $query->where(
                        function (
                            Builder $query
                        ) use (
                            $searchValue
                        ): void {
                            $query
                                ->where(
                                    'project_code',
                                    'like',
                                    $searchValue
                                )
                                ->orWhere(
                                    'project_name',
                                    'like',
                                    $searchValue
                                )
                                ->orWhere(
                                    'location',
                                    'like',
                                    $searchValue
                                )
                                ->orWhereHas(
                                    'client',
                                    fn (
                                        Builder $clientQuery
                                    ) => $clientQuery
                                        ->where(
                                            'company_name',
                                            'like',
                                            $searchValue
                                        )
                                );
                        }
                    );
                }
            )
            ->when(
                in_array(
                    $this->status,
                    $allowedStatuses,
                    true
                ),
                fn (Builder $query) =>
                    $query->where(
                        'status',
                        $this->status
                    )
            )
            ->orderBy(
                $selectedSort['column'],
                $selectedSort['direction']
            )
            ->paginate(9);

        return view(
            'livewire.mandor.projects.index',
            [
                'projects' =>
                    $projects,

                'statistics' =>
                    $this->statistics(
                        $mandor->id
                    ),
            ]
        );
    }
}