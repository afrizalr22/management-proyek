<?php

namespace Tests\Feature\Pekerja;

use App\Livewire\Pekerja\Dashboard;
use App\Models\Client;
use App\Models\DailyReport;
use App\Models\Documentation;
use App\Models\Project;
use App\Models\ProjectWorker;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;

    private User $mandor;

    private User $worker;

    private User $otherWorker;

    private Client $client;

    private Project $project;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(
            '2026-09-24 08:00:00'
        );

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        foreach (
            [
                'owner',
                'mandor',
                'pekerja',
            ] as $role
        ) {
            Role::findOrCreate(
                $role,
                'web'
            );
        }

        $this->owner = User::factory()->create([
            'name' => 'Owner Dashboard Pekerja',
            'status' => 'active',
        ]);

        $this->owner->assignRole('owner');

        $this->mandor = User::factory()->create([
            'name' => 'Mandor Dashboard Pekerja',
            'status' => 'active',
        ]);

        $this->mandor->assignRole('mandor');

        $this->worker = User::factory()->create([
            'name' => 'Pekerja Dashboard Utama',
            'status' => 'active',
        ]);

        $this->worker->assignRole('pekerja');

        $this->otherWorker = User::factory()->create([
            'name' => 'Pekerja Dashboard Lain',
            'status' => 'active',
        ]);

        $this->otherWorker->assignRole('pekerja');

        $this->client = Client::query()->create([
            'company_name' => 'PT Dashboard Pekerja Test',

            'contact_person' => 'Kontak Dashboard',

            'city' => 'Jakarta Selatan',

            'status' => 'active',
        ]);

        $this->project = $this->createProject(
            'planning',
            1,
            'Project Aktif Pekerja'
        );

        $this->assignWorker(
            $this->project,
            $this->worker
        );
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_worker_can_open_dashboard(): void
    {
        $this->actingAs($this->worker)
            ->get(
                route('pekerja.dashboard')
            )
            ->assertOk()
            ->assertSee(
                'Dashboard Pekerja'
            )
            ->assertSee(
                $this->worker->name
            )
            ->assertSee(
                $this->project->project_name
            );
    }

    public function test_non_worker_user_cannot_open_dashboard(): void
    {
        $this->actingAs($this->owner)
            ->get(
                route('pekerja.dashboard')
            )
            ->assertForbidden();

        $this->actingAs($this->mandor)
            ->get(
                route('pekerja.dashboard')
            )
            ->assertForbidden();
    }

    public function test_dashboard_only_displays_active_assigned_projects(): void
    {
        $onProgressProject = $this->createProject(
            'on_progress',
            2,
            'Project Sedang Berjalan'
        );

        $completedProject = $this->createProject(
            'completed',
            3,
            'Project Sudah Selesai'
        );

        $cancelledProject = $this->createProject(
            'cancelled',
            4,
            'Project Dibatalkan'
        );

        $this->assignWorker(
            $onProgressProject,
            $this->worker
        );

        $this->assignWorker(
            $completedProject,
            $this->worker
        );

        $this->assignWorker(
            $cancelledProject,
            $this->worker
        );

        Livewire::actingAs($this->worker)
            ->test(Dashboard::class)
            ->assertViewHas(
                'activeProjects',
                function (
                    $projects
                ) use (
                    $onProgressProject,
                    $completedProject,
                    $cancelledProject
                ): bool {
                    return $projects->contains(
                        'id',
                        $this->project->id
                    )
                        && $projects->contains(
                            'id',
                            $onProgressProject->id
                        )
                        && ! $projects->contains(
                            'id',
                            $completedProject->id
                        )
                        && ! $projects->contains(
                            'id',
                            $cancelledProject->id
                        );
                }
            );
    }

    public function test_inactive_project_assignment_is_not_displayed_as_active_project(): void
    {
        $project = $this->createProject(
            'planning',
            2,
            'Project Assignment Tidak Aktif'
        );

        ProjectWorker::query()->create([
            'project_id' => $project->id,

            'worker_id' => $this->worker->id,

            'assigned_by' => $this->owner->id,

            'status' => 'inactive',

            'joined_at' => '2026-09-01',
        ]);

        Livewire::actingAs($this->worker)
            ->test(Dashboard::class)
            ->assertViewHas(
                'activeProjects',
                fn ($projects): bool => ! $projects->contains(
                    'id',
                    $project->id
                )
            );
    }

    public function test_dashboard_statistics_only_use_logged_in_worker_data(): void
    {
        $assignedTask = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-DASH-001',
            'Task Baru Pekerja',
            'assigned',
            0,
            'high'
        );

        $inProgressTask = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-DASH-002',
            'Task Berjalan Pekerja',
            'in_progress',
            40,
            'medium'
        );

        $completedTask = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-DASH-003',
            'Task Selesai Pekerja',
            'completed',
            100,
            'low'
        );

        $cancelledTask = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-DASH-004',
            'Task Dibatalkan Pekerja',
            'cancelled',
            0,
            'low'
        );

        $otherWorkerTask = $this->createTask(
            $this->project,
            $this->otherWorker,
            'TSK-DASH-OTHER',
            'Task Milik Pekerja Lain',
            'assigned',
            0,
            'urgent'
        );

        $submittedReport = $this->createReport(
            $this->project,
            $inProgressTask,
            $this->worker,
            'RPT-DASH-SUBMITTED',
            'submitted',
            '2026-09-24',
            40
        );

        $approvedReport = $this->createReport(
            $this->project,
            $completedTask,
            $this->worker,
            'RPT-DASH-APPROVED',
            'approved',
            '2026-09-24',
            100
        );

        $draftReport = $this->createReport(
            $this->project,
            $assignedTask,
            $this->worker,
            'RPT-DASH-DRAFT',
            'draft',
            '2026-09-24',
            0
        );

        $this->createReport(
            $this->project,
            $otherWorkerTask,
            $this->otherWorker,
            'RPT-DASH-OTHER',
            'approved',
            '2026-09-24',
            100
        );

        $this->createDocumentation(
            $this->project,
            $inProgressTask,
            $this->worker,
            $submittedReport,
            'Dokumentasi Pekerja Hari Ini',
            1,
            now()
        );

        $this->createDocumentation(
            $this->project,
            $completedTask,
            $this->worker,
            $approvedReport,
            'Dokumentasi Pekerja Kemarin',
            2,
            now()->subDay()
        );

        $this->createDocumentation(
            $this->project,
            $otherWorkerTask,
            $this->otherWorker,
            null,
            'Dokumentasi Pekerja Lain',
            3,
            now()
        );

        Livewire::actingAs($this->worker)
            ->test(Dashboard::class)
            ->assertViewHas(
                'statistics',
                function (
                    array $statistics
                ): bool {
                    return $statistics[
                        'active_tasks'
                    ] === 2
                        && $statistics[
                            'new_tasks'
                        ] === 1
                        && $statistics[
                            'completed_tasks'
                        ] === 1
                        && $statistics[
                            'completion_rate'
                        ] === 33
                        && $statistics[
                            'documentations'
                        ] === 2
                        && $statistics[
                            'photos_today'
                        ] === 1
                        && $statistics[
                            'submitted_reports'
                        ] === 2
                        && $statistics[
                            'reports_this_month'
                        ] === 2;
                }
            );

        $this->assertNotNull(
            $draftReport
        );

        $this->assertNotNull(
            $cancelledTask
        );
    }

    public function test_active_task_statistics_ignore_tasks_from_completed_and_cancelled_projects(): void
    {
        $this->createTask(
            $this->project,
            $this->worker,
            'TSK-ACTIVE-PROJECT',
            'Task Project Aktif',
            'assigned',
            0,
            'medium'
        );

        $completedProject = $this->createProject(
            'completed',
            2,
            'Project Selesai Statistik'
        );

        $cancelledProject = $this->createProject(
            'cancelled',
            3,
            'Project Batal Statistik'
        );

        $this->createTask(
            $completedProject,
            $this->worker,
            'TSK-COMPLETED-PROJECT',
            'Task Aktif Palsu Dari Project Selesai',
            'assigned',
            0,
            'urgent'
        );

        $this->createTask(
            $cancelledProject,
            $this->worker,
            'TSK-CANCELLED-PROJECT',
            'Task Aktif Palsu Dari Project Batal',
            'in_progress',
            20,
            'urgent'
        );

        Livewire::actingAs($this->worker)
            ->test(Dashboard::class)
            ->assertViewHas(
                'statistics',
                function (
                    array $statistics
                ): bool {
                    return $statistics[
                        'active_tasks'
                    ] === 1
                        && $statistics[
                            'new_tasks'
                        ] === 1;
                }
            );
    }

    public function test_priority_tasks_only_display_active_tasks_from_active_projects(): void
    {
        $urgentTask = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-PRIORITY-URGENT',
            'Task Mendesak Dashboard',
            'assigned',
            0,
            'urgent'
        );

        $mediumTask = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-PRIORITY-MEDIUM',
            'Task Sedang Dashboard',
            'in_progress',
            30,
            'medium'
        );

        $completedTask = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-PRIORITY-COMPLETE',
            'Task Selesai Tidak Prioritas',
            'completed',
            100,
            'urgent'
        );

        $cancelledProject = $this->createProject(
            'cancelled',
            2,
            'Project Batal Priority'
        );

        $cancelledProjectTask = $this->createTask(
            $cancelledProject,
            $this->worker,
            'TSK-PRIORITY-CANCELLED-PROJECT',
            'Task Dari Project Batal',
            'assigned',
            0,
            'urgent'
        );

        $otherWorkerTask = $this->createTask(
            $this->project,
            $this->otherWorker,
            'TSK-PRIORITY-OTHER',
            'Task Prioritas Pekerja Lain',
            'assigned',
            0,
            'urgent'
        );

        Livewire::actingAs($this->worker)
            ->test(Dashboard::class)
            ->assertViewHas(
                'priorityTasks',
                function (
                    $tasks
                ) use (
                    $urgentTask,
                    $mediumTask,
                    $completedTask,
                    $cancelledProjectTask,
                    $otherWorkerTask
                ): bool {
                    return $tasks->contains(
                        'id',
                        $urgentTask->id
                    )
                        && $tasks->contains(
                            'id',
                            $mediumTask->id
                        )
                        && ! $tasks->contains(
                            'id',
                            $completedTask->id
                        )
                        && ! $tasks->contains(
                            'id',
                            $cancelledProjectTask->id
                        )
                        && ! $tasks->contains(
                            'id',
                            $otherWorkerTask->id
                        );
                }
            )
            ->assertSee(
                $urgentTask->title
            )
            ->assertSee(
                $mediumTask->title
            )
            ->assertDontSee(
                $otherWorkerTask->title
            );
    }

    public function test_priority_tasks_are_ordered_by_priority(): void
    {
        $lowTask = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-ORDER-LOW',
            'Task Prioritas Rendah',
            'assigned',
            0,
            'low'
        );

        $urgentTask = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-ORDER-URGENT',
            'Task Prioritas Mendesak',
            'assigned',
            0,
            'urgent'
        );

        $highTask = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-ORDER-HIGH',
            'Task Prioritas Tinggi',
            'assigned',
            0,
            'high'
        );

        Livewire::actingAs($this->worker)
            ->test(Dashboard::class)
            ->assertViewHas(
                'priorityTasks',
                function (
                    $tasks
                ) use (
                    $urgentTask,
                    $highTask,
                    $lowTask
                ): bool {
                    $ids = $tasks
                        ->pluck('id')
                        ->values();

                    $urgentPosition =
                        $ids->search(
                            $urgentTask->id
                        );

                    $highPosition =
                        $ids->search(
                            $highTask->id
                        );

                    $lowPosition =
                        $ids->search(
                            $lowTask->id
                        );

                    return $urgentPosition !== false
                        && $highPosition !== false
                        && $lowPosition !== false
                        && $urgentPosition
                            < $highPosition
                        && $highPosition
                            < $lowPosition;
                }
            );
    }

    public function test_recent_activities_only_use_logged_in_worker_data(): void
    {
        $workerTask = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-ACTIVITY-WORKER',
            'Task Aktivitas Pekerja Utama',
            'in_progress',
            50,
            'high'
        );

        $otherTask = $this->createTask(
            $this->project,
            $this->otherWorker,
            'TSK-ACTIVITY-OTHER',
            'Task Aktivitas Pekerja Lain',
            'in_progress',
            50,
            'high'
        );

        $workerReport = $this->createReport(
            $this->project,
            $workerTask,
            $this->worker,
            'RPT-ACTIVITY-WORKER',
            'approved',
            '2026-09-24',
            50
        );

        $this->createReport(
            $this->project,
            $otherTask,
            $this->otherWorker,
            'RPT-ACTIVITY-OTHER',
            'approved',
            '2026-09-24',
            50
        );

        $workerDocumentation =
            $this->createDocumentation(
                $this->project,
                $workerTask,
                $this->worker,
                $workerReport,
                'Dokumentasi Aktivitas Pekerja',
                1,
                now()
            );

        $this->createDocumentation(
            $this->project,
            $otherTask,
            $this->otherWorker,
            null,
            'Dokumentasi Aktivitas Pekerja Lain',
            2,
            now()
        );

        Livewire::actingAs($this->worker)
            ->test(Dashboard::class)
            ->assertViewHas(
                'recentActivities',
                function (
                    $activities
                ) use (
                    $workerTask,
                    $workerDocumentation
                ): bool {
                    $descriptions =
                        $activities
                            ->pluck(
                                'description'
                            )
                            ->implode(' ');

                    return str_contains(
                        $descriptions,
                        $workerTask->title
                    )
                        && str_contains(
                            $descriptions,
                            $workerDocumentation
                                ->title
                        )
                        && ! str_contains(
                            $descriptions,
                            'Task Aktivitas Pekerja Lain'
                        )
                        && ! str_contains(
                            $descriptions,
                            'Dokumentasi Aktivitas Pekerja Lain'
                        );
                }
            );
    }

    public function test_recent_activity_uses_valid_report_status_labels(): void
    {
        $task = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-REPORT-LABEL',
            'Task Label Laporan',
            'in_progress',
            50,
            'medium'
        );

        $this->createReport(
            $this->project,
            $task,
            $this->worker,
            'RPT-LABEL-SUBMITTED',
            'submitted',
            '2026-09-24',
            40
        );

        $this->createReport(
            $this->project,
            $task,
            $this->worker,
            'RPT-LABEL-REVISION',
            'revision',
            '2026-09-23',
            45
        );

        $this->createReport(
            $this->project,
            $task,
            $this->worker,
            'RPT-LABEL-APPROVED',
            'approved',
            '2026-09-22',
            50
        );

        Livewire::actingAs($this->worker)
            ->test(Dashboard::class)
            ->assertViewHas(
                'recentActivities',
                function (
                    $activities
                ): bool {
                    $titles = $activities
                        ->pluck('title');

                    return $titles->contains(
                        'Laporan Terkirim'
                    )
                        && $titles->contains(
                            'Laporan Perlu Direvisi'
                        )
                        && $titles->contains(
                            'Laporan Disetujui'
                        );
                }
            );
    }

    public function test_dashboard_contains_valid_quick_action_links(): void
    {
        $this->actingAs($this->worker)
            ->get(
                route('pekerja.dashboard')
            )
            ->assertOk()
            ->assertSee(
                route(
                    'pekerja.documentation.create'
                ),
                false
            )
            ->assertSee(
                route(
                    'pekerja.report.create'
                ),
                false
            );
    }

    private function createProject(
        string $status,
        int $sequence,
        ?string $name = null
    ): Project {
        return Project::query()->create([
            'client_id' => $this->client->id,

            'mandor_id' => $this->mandor->id,

            'project_code' => sprintf(
                'PRJ-WORKER-%03d',
                $sequence
            ),

            'project_name' => $name
                ?? 'Project Pekerja '.$sequence,

            'location' => 'Jakarta Selatan',

            'description' => 'Project untuk pengujian Dashboard Pekerja.',

            'start_date' => '2026-09-01',

            'end_date' => '2026-12-31',

            'progress' => $status === 'completed'
                    ? 100
                    : 0,

            'status' => $status,
        ]);
    }

    private function assignWorker(
        Project $project,
        User $worker
    ): ProjectWorker {
        return ProjectWorker::query()->create([
            'project_id' => $project->id,

            'worker_id' => $worker->id,

            'assigned_by' => $this->owner->id,

            'status' => 'active',

            'joined_at' => '2026-09-01',
        ]);
    }

    private function createTask(
        Project $project,
        User $worker,
        string $code,
        string $title,
        string $status,
        int $progress,
        string $priority
    ): Task {
        return Task::query()->create([
            'project_id' => $project->id,

            'mandor_id' => $project->mandor_id,

            'worker_id' => $worker->id,

            'task_code' => $code,

            'title' => $title,

            'description' => 'Task untuk pengujian Dashboard Pekerja.',

            'location' => 'Area Project',

            'priority' => $priority,

            'status' => $status,

            'start_at' => '2026-09-24 08:00:00',

            'due_at' => '2026-09-30 17:00:00',

            'started_at' => $status === 'assigned'
                    ? null
                    : '2026-09-24 08:00:00',

            'completed_at' => $status === 'completed'
                    ? '2026-09-24 12:00:00'
                    : null,

            'progress' => $progress,

            'weight' => 10,
        ]);
    }

    private function createReport(
        Project $project,
        Task $task,
        User $worker,
        string $number,
        string $status,
        string $reportDate,
        int $progress
    ): DailyReport {
        return DailyReport::query()->create([
            'project_id' => $project->id,

            'task_id' => $task->id,

            'user_id' => $worker->id,

            'report_number' => $number,

            'report_date' => $reportDate,

            'activities' => 'Aktivitas untuk pengujian Dashboard Pekerja.',

            'work_status' => 'in_progress',

            'reported_progress' => $progress,

            'obstacles' => null,

            'notes' => 'Laporan untuk pengujian Dashboard Pekerja.',

            'submitted_at' => now(),

            'status' => $status,
        ]);
    }

    private function createDocumentation(
        Project $project,
        Task $task,
        User $worker,
        ?DailyReport $report,
        string $title,
        int $sequence,
        Carbon $createdAt
    ): Documentation {
        $documentation =
            Documentation::query()->create([
                'project_id' => $project->id,

                'task_id' => $task->id,

                'daily_report_id' => $report?->id,

                'user_id' => $worker->id,

                'title' => $title,

                'category' => 'progress',

                'photo' => sprintf(
                    'documentations/testing/dashboard-%03d.jpg',
                    $sequence
                ),

                'original_name' => sprintf(
                    'dashboard-%03d.jpg',
                    $sequence
                ),

                'mime_type' => 'image/jpeg',

                'file_size' => 1024,

                'description' => 'Dokumentasi untuk pengujian Dashboard Pekerja.',

                'documentation_date' => $createdAt->toDateString(),

                'taken_at' => $createdAt,
            ]);

        $documentation->forceFill([
            'created_at' => $createdAt,

            'updated_at' => $createdAt,
        ])->save();

        return $documentation->fresh();
    }
}
