<?php

namespace App\Livewire\Pekerja\Tasks;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    #[Url(except: '')]
    public string $priority = '';

    #[Url(except: 'deadline')]
    public string $sort = 'deadline';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingPriority(): void
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
            'priority',
        ]);

        $this->sort = 'deadline';

        $this->resetPage();
    }

    public function startTask(
        int $taskId
    ): void {
        $worker = $this->worker();

        DB::transaction(
            function () use (
                $taskId,
                $worker
            ): void {
                $task = Task::query()
                    ->with('project')
                    ->whereKey($taskId)
                    ->where(
                        'worker_id',
                        $worker->id
                    )
                    ->lockForUpdate()
                    ->firstOrFail();

                abort_unless(
                    $task->project
                        && in_array(
                            $task->project->status,
                            [
                                'planning',
                                'on_progress',
                            ],
                            true
                        ),
                    409,
                    'Task tidak dapat dimulai karena Project telah selesai atau dibatalkan.'
                );

                abort_unless(
                    $task->status === 'assigned',
                    409
                );

                $task->update([
                    'status' => 'in_progress',

                    'started_at' => $task->started_at
                        ?? now(),
                ]);
            }
        );

        session()->flash(
            'success',
            'Task berhasil dimulai.'
        );
    }

    private function worker(): User
    {
        $worker = Auth::user();

        abort_unless(
            $worker instanceof User
                && $worker->hasRole('pekerja')
                && $worker->isActive(),
            403
        );

        return $worker;
    }

    private function taskQuery(
        int $workerId
    ): Builder {
        return Task::query()
            ->where(
                'worker_id',
                $workerId
            );
    }

    private function statistics(
        int $workerId
    ): array {
        $query = $this->taskQuery(
            $workerId
        );

        return [
            'total' => (clone $query)
                ->where(
                    'status',
                    '!=',
                    'cancelled'
                )
                ->count(),

            'assigned' => (clone $query)
                ->where(
                    'status',
                    'assigned'
                )
                ->count(),

            'active' => (clone $query)
                ->whereIn(
                    'status',
                    [
                        'in_progress',
                        'submitted',
                        'revision',
                    ]
                )
                ->count(),

            'completed' => (clone $query)
                ->where(
                    'status',
                    'completed'
                )
                ->count(),

            'overdue' => (clone $query)
                ->whereIn(
                    'status',
                    [
                        'assigned',
                        'in_progress',
                        'submitted',
                        'revision',
                    ]
                )
                ->whereNotNull(
                    'due_at'
                )
                ->where(
                    'due_at',
                    '<',
                    now()
                )
                ->count(),
        ];
    }

    private function applySorting(
        Builder $query
    ): Builder {
        return match ($this->sort) {
            'latest' => $query
                ->latest('id'),

            'oldest' => $query
                ->oldest('id'),

            'priority' => $query
                ->orderByRaw(
                    "
                            CASE priority
                                WHEN 'urgent' THEN 1
                                WHEN 'high' THEN 2
                                WHEN 'medium' THEN 3
                                WHEN 'low' THEN 4
                                ELSE 5
                            END
                        "
                )
                ->orderByRaw(
                    'CASE
                            WHEN due_at IS NULL
                            THEN 1
                            ELSE 0
                        END'
                )
                ->orderBy(
                    'due_at'
                ),

            'progress_highest' => $query
                ->orderByDesc(
                    'progress'
                )
                ->latest('id'),

            'progress_lowest' => $query
                ->orderBy(
                    'progress'
                )
                ->latest('id'),

            default => $query
                ->orderByRaw(
                    'CASE
                            WHEN due_at IS NULL
                            THEN 1
                            ELSE 0
                        END'
                )
                ->orderBy(
                    'due_at'
                )
                ->latest('id'),
        };
    }

    public function render()
    {
        $worker = $this->worker();

        $allowedStatuses = [
            'assigned',
            'in_progress',
            'submitted',
            'revision',
            'completed',
            'cancelled',
        ];

        $allowedPriorities = [
            'low',
            'medium',
            'high',
            'urgent',
        ];

        $search = trim(
            $this->search
        );

        $tasks = $this->taskQuery(
            $worker->id
        )
            ->with([
                'project:id,project_code,project_name,location,status',

                'mandor:id,name',

                'dailyReports' => fn ($query) => $query
                    ->where(
                        'user_id',
                        $worker->id
                    )
                    ->latest('id'),
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
                                    'task_code',
                                    'like',
                                    $searchValue
                                )
                                ->orWhere(
                                    'title',
                                    'like',
                                    $searchValue
                                )
                                ->orWhere(
                                    'description',
                                    'like',
                                    $searchValue
                                )
                                ->orWhere(
                                    'location',
                                    'like',
                                    $searchValue
                                )
                                ->orWhereHas(
                                    'project',
                                    fn (
                                        Builder $projectQuery
                                    ) => $projectQuery
                                        ->where(
                                            'project_name',
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
                fn (Builder $query) => $query->where(
                    'status',
                    $this->status
                )
            )
            ->when(
                in_array(
                    $this->priority,
                    $allowedPriorities,
                    true
                ),
                fn (Builder $query) => $query->where(
                    'priority',
                    $this->priority
                )
            );

        $tasks = $this
            ->applySorting(
                $tasks
            )
            ->paginate(8);

        return view(
            'livewire.pekerja.tasks.index',
            [
                'worker' => $worker->fresh(),

                'tasks' => $tasks,

                'statistics' => $this->statistics(
                    $worker->id
                ),
            ]
        );
    }
}
