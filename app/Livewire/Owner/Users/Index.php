<?php

namespace App\Livewire\Owner\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $role = 'all';

    #[Url]
    public string $status = 'all';

    #[Url]
    public string $sort = 'latest';

    public int $perPage = 10;

    public function mount(): void
    {
        $this->authorizeViewUsers();

        $this->normalizeFilters();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedRole(): void
    {
        $this->normalizeFilters();
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->normalizeFilters();
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->normalizeFilters();
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        if (!in_array(
            $this->perPage,
            [10, 25, 50],
            true
        )) {
            $this->perPage = 10;
        }

        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'role',
            'status',
            'sort',
        ]);

        $this->role = 'all';
        $this->status = 'all';
        $this->sort = 'latest';

        $this->resetPage();
    }

    private function normalizeFilters(): void
    {
        if (!in_array(
            $this->role,
            [
                'all',
                'owner',
                'mandor',
                'pekerja',
            ],
            true
        )) {
            $this->role = 'all';
        }

        if (!in_array(
            $this->status,
            [
                'all',
                'active',
                'inactive',
            ],
            true
        )) {
            $this->status = 'all';
        }

        if (!in_array(
            $this->sort,
            [
                'latest',
                'oldest',
                'name_asc',
                'name_desc',
            ],
            true
        )) {
            $this->sort = 'latest';
        }
    }

    private function authorizeViewUsers(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && (
                    $user->can('view-any users')
                    || $user->can('view users')
                ),
            403
        );
    }

    public function render()
    {
        $search = trim($this->search);

        $users = User::query()
            ->with([
                'roles:id,name',
            ])
            ->withCount([
                'managedProjects as active_managed_projects_count' =>
                    fn (Builder $query) => $query
                        ->whereIn(
                            'status',
                            [
                                'planning',
                                'on_progress',
                            ]
                        ),

                'projectAssignments as active_project_assignments_count' =>
                    fn (Builder $query) => $query
                        ->where(
                            'status',
                            'active'
                        ),
            ])
            ->when(
                $search !== '',
                fn (Builder $query) => $query
                    ->where(
                        function (
                            Builder $query
                        ) use ($search): void {
                            $query
                                ->where(
                                    'name',
                                    'like',
                                    '%'.$search.'%'
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    '%'.$search.'%'
                                )
                                ->orWhere(
                                    'phone',
                                    'like',
                                    '%'.$search.'%'
                                );
                        }
                    )
            )
            ->when(
                $this->role !== 'all',
                fn (Builder $query) => $query
                    ->whereHas(
                        'roles',
                        fn (Builder $query) =>
                            $query->where(
                                'name',
                                $this->role
                            )
                    )
            )
            ->when(
                $this->status !== 'all',
                fn (Builder $query) => $query
                    ->where(
                        'status',
                        $this->status
                    )
            )
            ->when(
                $this->sort === 'latest',
                fn (Builder $query) =>
                    $query->latest('id')
            )
            ->when(
                $this->sort === 'oldest',
                fn (Builder $query) =>
                    $query->oldest('id')
            )
            ->when(
                $this->sort === 'name_asc',
                fn (Builder $query) =>
                    $query->orderBy('name')
            )
            ->when(
                $this->sort === 'name_desc',
                fn (Builder $query) =>
                    $query->orderByDesc('name')
            )
            ->paginate($this->perPage);

        $statistics = [
            'total' => User::query()->count(),

            'active' => User::query()
                ->where('status', 'active')
                ->count(),

            'mandors' => User::query()
                ->role('mandor')
                ->count(),

            'workers' => User::query()
                ->role('pekerja')
                ->count(),
        ];

        return view(
            'livewire.owner.users.index',
            [
                'users' => $users,
                'statistics' => $statistics,
            ]
        );
    }
}