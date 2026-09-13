<?php

namespace App\Livewire\Pekerja;

use App\Models\DailyReport;
use App\Models\Documentation;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    private const ACTIVE_TASK_STATUSES = [
        'assigned',
        'in_progress',
        'submitted',
        'revision',
    ];

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

    private function reportQuery(
        int $workerId
    ): Builder {
        return DailyReport::query()
            ->where(
                'user_id',
                $workerId
            );
    }

    private function documentationQuery(
        int $workerId
    ): Builder {
        return Documentation::query()
            ->where(
                'user_id',
                $workerId
            );
    }

    private function statistics(
        int $workerId
    ): array {
        $taskQuery = $this->taskQuery(
            $workerId
        );

        $totalTasks = (clone $taskQuery)
            ->where(
                'status',
                '!=',
                'cancelled'
            )
            ->count();

        $completedTasks = (clone $taskQuery)
            ->where(
                'status',
                'completed'
            )
            ->count();

        return [
            'active_tasks' =>
                (clone $taskQuery)
                    ->whereIn(
                        'status',
                        self::ACTIVE_TASK_STATUSES
                    )
                    ->count(),

            'new_tasks' =>
                (clone $taskQuery)
                    ->where(
                        'status',
                        'assigned'
                    )
                    ->count(),

            'completed_tasks' =>
                $completedTasks,

            'completion_rate' =>
                $totalTasks > 0
                    ? (int) round(
                        $completedTasks
                        / $totalTasks
                        * 100
                    )
                    : 0,

            'documentations' =>
                $this->documentationQuery(
                    $workerId
                )->count(),

            'photos_today' =>
                $this->documentationQuery(
                    $workerId
                )
                    ->whereDate(
                        'created_at',
                        today()
                    )
                    ->count(),

            'submitted_reports' =>
                $this->reportQuery(
                    $workerId
                )
                    ->whereIn(
                        'status',
                        [
                            'submitted',
                            'revision',
                            'approved',
                        ]
                    )
                    ->count(),

            'reports_this_month' =>
                $this->reportQuery(
                    $workerId
                )
                    ->whereIn(
                        'status',
                        [
                            'submitted',
                            'revision',
                            'approved',
                        ]
                    )
                    ->whereYear(
                        'report_date',
                        today()->year
                    )
                    ->whereMonth(
                        'report_date',
                        today()->month
                    )
                    ->count(),
        ];
    }

    private function priorityTasks(
        int $workerId
    ): Collection {
        return $this->taskQuery(
            $workerId
        )
            ->with([
                'project:id,project_code,project_name,location,status',
            ])
            ->whereIn(
                'status',
                self::ACTIVE_TASK_STATUSES
            )
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
                'CASE WHEN due_at IS NULL THEN 1 ELSE 0 END'
            )
            ->orderBy(
                'due_at'
            )
            ->orderBy(
                'id'
            )
            ->limit(5)
            ->get();
    }

    private function recentActivities(
        int $workerId
    ): Collection {
        $taskActivities = $this->taskQuery(
            $workerId
        )
            ->with([
                'project:id,project_name',
            ])
            ->latest('updated_at')
            ->limit(5)
            ->get()
            ->map(
                function (Task $task): array {
                    $statusLabel = match (
                        $task->status
                    ) {
                        'assigned' =>
                            'ditugaskan',

                        'in_progress' =>
                            'sedang dikerjakan',

                        'submitted' =>
                            'menunggu pemeriksaan',

                        'revision' =>
                            'memerlukan revisi',

                        'completed' =>
                            'telah selesai',

                        'cancelled' =>
                            'dibatalkan',

                        default =>
                            str_replace(
                                '_',
                                ' ',
                                $task->status
                            ),
                    };

                    return [
                        'type' =>
                            'task',

                        'title' =>
                            'Task Diperbarui',

                        'description' =>
                            $task->title
                            .' berstatus '
                            .$statusLabel.'.',

                        'occurred_at' =>
                            $task->updated_at,

                        'color' =>
                            match ($task->status) {
                                'completed' =>
                                    'bg-emerald-500',

                                'revision' =>
                                    'bg-amber-500',

                                'cancelled' =>
                                    'bg-red-500',

                                default =>
                                    'bg-blue-500',
                            },
                    ];
                }
            );

        $reportActivities = $this->reportQuery(
            $workerId
        )
            ->with([
                'task:id,title',
            ])
            ->latest('updated_at')
            ->limit(5)
            ->get()
            ->map(
                function (
                    DailyReport $report
                ): array {
                    [$title, $color] = match (
                        $report->status
                    ) {
                        'approved' => [
                            'Laporan Disetujui',
                            'bg-emerald-500',
                        ],

                        'revision' => [
                            'Laporan Perlu Direvisi',
                            'bg-amber-500',
                        ],

                        'submitted' => [
                            'Laporan Terkirim',
                            'bg-violet-500',
                        ],

                        default => [
                            'Draft Laporan',
                            'bg-slate-400',
                        ],
                    };

                    return [
                        'type' =>
                            'report',

                        'title' =>
                            $title,

                        'description' =>
                            'Laporan '
                            .(
                                $report->report_number
                                ?: 'pekerjaan'
                            )
                            .' untuk '
                            .(
                                $report->task?->title
                                ?: 'task terkait'
                            )
                            .'.',

                        'occurred_at' =>
                            $report->updated_at,

                        'color' =>
                            $color,
                    ];
                }
            );

        $documentationActivities =
            $this->documentationQuery(
                $workerId
            )
                ->with([
                    'task:id,title',
                ])
                ->latest('created_at')
                ->limit(5)
                ->get()
                ->map(
                    fn (
                        Documentation $documentation
                    ): array => [
                        'type' =>
                            'documentation',

                        'title' =>
                            'Dokumentasi Diunggah',

                        'description' =>
                            (
                                $documentation->title
                                ?: 'Dokumentasi pekerjaan'
                            )
                            .' untuk '
                            .(
                                $documentation
                                    ->task
                                    ?->title
                                ?: 'task terkait'
                            )
                            .'.',

                        'occurred_at' =>
                            $documentation->created_at,

                        'color' =>
                            'bg-cyan-500',
                    ]
                );

        return $taskActivities
            ->concat(
                $reportActivities
            )
            ->concat(
                $documentationActivities
            )
            ->filter(
                fn (array $activity): bool =>
                    $activity['occurred_at']
                    !== null
            )
            ->sortByDesc(
                fn (array $activity): int =>
                    $activity['occurred_at']
                        ->getTimestamp()
            )
            ->take(6)
            ->values();
    }

    public function render()
    {
        $worker = $this->worker();

        $activeProjects = $worker
            ->activeWorkerProjects()
            ->whereIn(
                'projects.status',
                [
                    'planning',
                    'on_progress',
                    'in_progress',
                    'ongoing',
                ]
            )
            ->orderBy(
                'projects.end_date'
            )
            ->get();

        return view(
            'livewire.pekerja.dashboard',
            [
                'worker' =>
                    $worker->fresh(),

                'activeProjects' =>
                    $activeProjects,

                'statistics' =>
                    $this->statistics(
                        $worker->id
                    ),

                'priorityTasks' =>
                    $this->priorityTasks(
                        $worker->id
                    ),

                'recentActivities' =>
                    $this->recentActivities(
                        $worker->id
                    ),
            ]
        );
    }
}