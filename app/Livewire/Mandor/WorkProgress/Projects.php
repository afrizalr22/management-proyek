<?php

namespace App\Livewire\Mandor\WorkProgress;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Projects extends Component
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

    public function render()
    {
        $mandor = $this->mandor();

        $allowedStatuses = [
            'planning',
            'on_progress',
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

        $projects = $this
            ->projectQuery(
                $mandor->id
            )
            ->with([
                'client:id,company_name',
            ])
            ->withCount([
                'tasks',

                'tasks as completed_tasks_count' => fn (Builder $query) => $query
                    ->where(
                        'status',
                        'completed'
                    ),

                'tasks as active_tasks_count' => fn (Builder $query) => $query
                    ->whereIn(
                        'status',
                        [
                            'assigned',
                            'in_progress',
                            'submitted',
                            'revision',
                        ]
                    ),

                'workerAssignments as active_workers_count' => fn (Builder $query) => $query
                    ->where(
                        'status',
                        'active'
                    ),
            ])
            ->when(
                $search !== '',
                function (
                    Builder $query
                ) use (
                    $search
                ): void {
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
                fn (Builder $query) => $query
                    ->where(
                        'status',
                        $this->status
                    )
            )
            ->orderBy(
                $selectedSort['column'],
                $selectedSort['direction']
            )
            ->paginate(9);

        $baseQuery = $this
            ->projectQuery(
                $mandor->id
            );

        return view(
            'livewire.mandor.work-progress.projects',
            [
                'projects' => $projects,

                'statistics' => [
                    'total' => (clone $baseQuery)
                        ->count(),

                    'active' => (clone $baseQuery)
                        ->whereIn(
                            'status',
                            [
                                'planning',
                                'on_progress',
                            ]
                        )
                        ->count(),

                    'completed' => (clone $baseQuery)
                        ->where(
                            'status',
                            'completed'
                        )
                        ->count(),

                    'averageProgress' => (int) round(
                        (float) (
                            (clone $baseQuery)
                                ->avg('progress')
                            ?? 0
                        )
                    ),
                ],
            ]
        );
    }
}
