<?php

namespace App\Livewire\Mandor;

use App\Models\DailyReport;
use App\Models\Documentation;
use App\Models\Project;
use App\Models\ProjectWorker;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    private const ACTIVE_PROJECT_STATUSES = [
        'planning',
        'on_progress',
        'in_progress',
        'ongoing',
    ];

    private const COMPLETED_TASK_STATUSES = [
        'completed',
        'approved',
    ];

    private const PENDING_REPORT_STATUSES = [
        'draft',
        'submitted',
        'pending',
    ];

    /**
     * Mengambil ID Project yang dikelola Mandor login.
     */
    private function projectIds(int $mandorId): Collection
    {
        return Project::query()
            ->where('mandor_id', $mandorId)
            ->pluck('id');
    }

    /**
     * Mengambil ringkasan statistik Dashboard.
     */
    private function statistics(
        int $mandorId,
        Collection $projectIds
    ): array {
        $activeProjectIds = Project::query()
            ->where('mandor_id', $mandorId)
            ->whereIn(
                'status',
                self::ACTIVE_PROJECT_STATUSES
            )
            ->pluck('id');

        $activeWorkers = ProjectWorker::query()
            ->whereIn(
                'project_id',
                $activeProjectIds
            )
            ->where('status', 'active')
            ->distinct()
            ->count('worker_id');

        $todayTasksQuery = Task::query()
            ->whereIn('project_id', $projectIds)
            ->whereDate('start_at', today());

        $todayTasks = (clone $todayTasksQuery)
            ->count();

        $completedTodayTasks = (clone $todayTasksQuery)
            ->whereIn(
                'status',
                self::COMPLETED_TASK_STATUSES
            )
            ->count();

        $todayTaskProgress = $todayTasks > 0
            ? (int) round(
                ($completedTodayTasks / $todayTasks) * 100
            )
            : 0;

        $todayReports = DailyReport::query()
            ->whereIn('project_id', $projectIds)
            ->whereDate('report_date', today())
            ->count();

        $reportsAwaitingReview = DailyReport::query()
            ->whereIn('project_id', $projectIds)
            ->whereIn(
                'status',
                self::PENDING_REPORT_STATUSES
            )
            ->count();

        return [
            'active_projects' =>
                $activeProjectIds->count(),

            'active_workers' =>
                $activeWorkers,

            'today_tasks' =>
                $todayTasks,

            'completed_today_tasks' =>
                $completedTodayTasks,

            'today_task_progress' =>
                $todayTaskProgress,

            'today_reports' =>
                $todayReports,

            'reports_awaiting_review' =>
                $reportsAwaitingReview,
        ];
    }

    /**
     * Mengambil Task yang dimulai hari ini.
     */
    private function todayTasks(
        Collection $projectIds
    ): Collection {
        return Task::query()
            ->with([
                'project:id,project_code,project_name,location',
                'worker:id,name',
            ])
            ->whereIn('project_id', $projectIds)
            ->whereDate('start_at', today())
            ->orderBy('start_at')
            ->get([
                'id',
                'project_id',
                'worker_id',
                'task_code',
                'title',
                'location',
                'priority',
                'status',
                'start_at',
                'due_at',
                'progress',
            ]);
    }

    /**
     * Mengambil aktivitas terbaru dari Task,
     * laporan, dan dokumentasi.
     */
    private function recentActivities(
        Collection $projectIds
    ): Collection {
        $taskActivities = Task::query()
            ->with('project:id,project_name')
            ->whereIn('project_id', $projectIds)
            ->latest('updated_at')
            ->limit(5)
            ->get()
            ->map(function (Task $task): array {
                $completed = in_array(
                    $task->status,
                    self::COMPLETED_TASK_STATUSES,
                    true
                );

                return [
                    'key' => 'task-'.$task->id,
                    'type' => 'task',
                    'title' => $completed
                        ? 'Task diselesaikan'
                        : 'Task diperbarui',
                    'description' =>
                        $task->title.' — '
                        .($task->project?->project_name
                            ?? 'Project tidak ditemukan'),
                    'occurred_at' => $task->updated_at,
                    'href' => route(
                        'mandor.projects.show',
                        [
                            'project' =>
                                $task->project_id,
                        ]
                    ),
                ];
            });

        $reportActivities = DailyReport::query()
            ->with([
                'project:id,project_name',
                'user:id,name',
            ])
            ->whereIn('project_id', $projectIds)
            ->latest('updated_at')
            ->limit(5)
            ->get()
            ->map(function (
                DailyReport $report
            ): array {
                return [
                    'key' => 'report-'.$report->id,
                    'type' => 'report',
                    'title' => $report->status === 'approved'
                        ? 'Laporan disetujui'
                        : 'Laporan diterima',
                    'description' =>
                        ($report->user?->name ?? 'Pekerja')
                        .' — '
                        .($report->project?->project_name
                            ?? 'Project tidak ditemukan'),
                    'occurred_at' =>
                        $report->updated_at,
                    'href' => route(
                        'mandor.daily-reports.show',
                        [
                            'report' => $report->id,
                        ]
                    ),
                ];
            });

        $documentationActivities =
            Documentation::query()
                ->with([
                    'project:id,project_name',
                    'user:id,name',
                ])
                ->whereIn(
                    'project_id',
                    $projectIds
                )
                ->latest('created_at')
                ->limit(5)
                ->get()
                ->map(function (
                    Documentation $documentation
                ): array {
                    return [
                        'key' =>
                            'documentation-'
                            .$documentation->id,

                        'type' =>
                            'documentation',

                        'title' =>
                            'Dokumentasi ditambahkan',

                        'description' =>
                            ($documentation->title
                                ?: 'Dokumentasi pekerjaan')
                            .' — '
                            .($documentation
                                ->project
                                ?->project_name
                                ?? 'Project tidak ditemukan'),

                        'occurred_at' =>
                            $documentation->created_at,

                        'href' => route(
                            'mandor.projects.documentations.index',
                            [
                                'project' =>
                                    $documentation
                                        ->project_id,
                            ]
                        ),
                    ];
                });

        return collect()
            ->concat($taskActivities)
            ->concat($reportActivities)
            ->concat($documentationActivities)
            ->filter(
                fn (array $activity): bool =>
                    $activity['occurred_at']
                    !== null
            )
            ->sortByDesc('occurred_at')
            ->take(5)
            ->values();
    }

    /**
     * Mengambil dokumentasi terbaru.
     */
    private function latestDocumentations(
        Collection $projectIds
    ): Collection {
        return Documentation::query()
            ->with([
                'project:id,project_code,project_name',
                'user:id,name',
            ])
            ->whereIn('project_id', $projectIds)
            ->latest(
                'documentation_date'
            )
            ->latest('id')
            ->limit(3)
            ->get();
    }

    public function render()
    {
        $mandor = Auth::user();

        abort_unless(
            $mandor instanceof User
                && $mandor->hasRole('mandor'),
            403
        );

        $projectIds = $this->projectIds(
            $mandor->id
        );

        return view(
            'livewire.mandor.dashboard',
            [
                'mandor' =>
                    $mandor,

                'statistics' =>
                    $this->statistics(
                        $mandor->id,
                        $projectIds
                    ),

                'todayTasks' =>
                    $this->todayTasks(
                        $projectIds
                    ),

                'recentActivities' =>
                    $this->recentActivities(
                        $projectIds
                    ),

                'latestDocumentations' =>
                    $this->latestDocumentations(
                        $projectIds
                    ),
            ]
        );
    }
}