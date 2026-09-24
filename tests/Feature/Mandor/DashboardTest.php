<?php

namespace Tests\Feature\Mandor;

use App\Livewire\Mandor\Dashboard;
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
            'name' => 'Owner Dashboard',
            'status' => 'active',
        ]);

        $this->owner->assignRole('owner');

        $this->mandor = User::factory()->create([
            'name' => 'Mandor Dashboard',
            'status' => 'active',
        ]);

        $this->mandor->assignRole('mandor');

        $this->worker = User::factory()->create([
            'name' => 'Pekerja Dashboard',
            'status' => 'active',
        ]);

        $this->worker->assignRole('pekerja');

        $this->client = Client::query()->create([
            'company_name' => 'PT Dashboard Testing',
            'contact_person' => 'Kontak Dashboard',
            'status' => 'active',
        ]);

        $this->project = $this->createProject(
            $this->mandor,
            'planning',
            1
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

    public function test_mandor_can_open_dashboard(): void
    {
        $this->actingAs($this->mandor)
            ->get(
                route('mandor.dashboard')
            )
            ->assertOk()
            ->assertSee(
                $this->mandor->name
            )
            ->assertSee(
                'Lihat Photo Gallery'
            )
            ->assertSee(
                route(
                    'mandor.documentations.index'
                ),
                false
            );
    }

    public function test_non_mandor_user_cannot_open_dashboard(): void
    {
        $this->actingAs($this->owner)
            ->get(
                route('mandor.dashboard')
            )
            ->assertForbidden();

        $this->actingAs($this->worker)
            ->get(
                route('mandor.dashboard')
            )
            ->assertForbidden();
    }

    public function test_dashboard_statistics_only_use_projects_owned_by_logged_in_mandor(): void
    {
        $secondWorker = User::factory()->create([
            'name' => 'Pekerja Dashboard Kedua',
            'status' => 'active',
        ]);

        $secondWorker->assignRole('pekerja');

        $secondProject = $this->createProject(
            $this->mandor,
            'on_progress',
            2
        );

        $this->assignWorker(
            $secondProject,
            $secondWorker
        );

        $completedProject = $this->createProject(
            $this->mandor,
            'completed',
            3
        );

        $otherMandor = User::factory()->create([
            'name' => 'Mandor Dashboard Lain',
            'status' => 'active',
        ]);

        $otherMandor->assignRole('mandor');

        $otherWorker = User::factory()->create([
            'name' => 'Pekerja Mandor Lain',
            'status' => 'active',
        ]);

        $otherWorker->assignRole('pekerja');

        $otherProject = $this->createProject(
            $otherMandor,
            'planning',
            4
        );

        $this->assignWorker(
            $otherProject,
            $otherWorker
        );

        $this->createTask(
            $this->project,
            $this->worker,
            'TSK-DASH-001',
            'Task Hari Ini Belum Selesai',
            'in_progress',
            10
        );

        $this->createTask(
            $secondProject,
            $secondWorker,
            'TSK-DASH-002',
            'Task Hari Ini Selesai',
            'completed',
            100
        );

        $this->createTask(
            $completedProject,
            $this->worker,
            'TSK-DASH-003',
            'Task Project Selesai',
            'completed',
            100
        );

        $this->createTask(
            $otherProject,
            $otherWorker,
            'TSK-DASH-OTHER',
            'Task Mandor Lain',
            'completed',
            100
        );

        $ownTask = Task::query()
            ->where(
                'task_code',
                'TSK-DASH-001'
            )
            ->sole();

        $secondTask = Task::query()
            ->where(
                'task_code',
                'TSK-DASH-002'
            )
            ->sole();

        $otherTask = Task::query()
            ->where(
                'task_code',
                'TSK-DASH-OTHER'
            )
            ->sole();

        $this->createReport(
            $this->project,
            $ownTask,
            $this->worker,
            'RPT-DASH-SUBMITTED',
            'submitted',
            10
        );

        $this->createReport(
            $secondProject,
            $secondTask,
            $secondWorker,
            'RPT-DASH-APPROVED',
            'approved',
            100
        );

        $this->createReport(
            $secondProject,
            $secondTask,
            $secondWorker,
            'RPT-DASH-REVISION',
            'revision',
            80
        );

        $this->createReport(
            $otherProject,
            $otherTask,
            $otherWorker,
            'RPT-DASH-OTHER',
            'submitted',
            100
        );

        Livewire::actingAs($this->mandor)
            ->test(
                Dashboard::class
            )
            ->assertViewHas(
                'statistics',
                function (
                    array $statistics
                ): bool {
                    return $statistics['active_projects'] === 2
                        && $statistics['active_workers'] === 2
                        && $statistics['today_tasks'] === 3
                        && $statistics['completed_today_tasks'] === 2
                        && $statistics['today_task_progress'] === 67
                        && $statistics['today_reports'] === 3
                        && $statistics['reports_awaiting_review'] === 1;
                }
            );
    }

    public function test_today_tasks_do_not_include_other_mandor_projects(): void
    {
        $ownTask = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-TODAY-OWN',
            'Task Dashboard Milik Mandor',
            'in_progress',
            25
        );

        $otherMandor = User::factory()->create([
            'name' => 'Mandor Task Lain',
            'status' => 'active',
        ]);

        $otherMandor->assignRole('mandor');

        $otherWorker = User::factory()->create([
            'name' => 'Pekerja Task Lain',
            'status' => 'active',
        ]);

        $otherWorker->assignRole('pekerja');

        $otherProject = $this->createProject(
            $otherMandor,
            'planning',
            2
        );

        $otherTask = $this->createTask(
            $otherProject,
            $otherWorker,
            'TSK-TODAY-OTHER',
            'Task Dashboard Mandor Lain',
            'in_progress',
            20
        );

        Livewire::actingAs($this->mandor)
            ->test(
                Dashboard::class
            )
            ->assertViewHas(
                'todayTasks',
                function (
                    $tasks
                ) use (
                    $ownTask,
                    $otherTask
                ): bool {
                    return $tasks
                        ->contains(
                            'id',
                            $ownTask->id
                        )
                        && ! $tasks
                            ->contains(
                                'id',
                                $otherTask->id
                            );
                }
            )
            ->assertSee(
                $ownTask->title
            )
            ->assertDontSee(
                $otherTask->title
            );
    }

    public function test_dashboard_only_displays_documentation_from_approved_reports(): void
    {
        $task = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-DOC-001',
            'Task Dokumentasi Dashboard',
            'in_progress',
            40
        );

        $approvedReport = $this->createReport(
            $this->project,
            $task,
            $this->worker,
            'RPT-DOC-APPROVED',
            'approved',
            40
        );

        $submittedReport = $this->createReport(
            $this->project,
            $task,
            $this->worker,
            'RPT-DOC-SUBMITTED',
            'submitted',
            45
        );

        $revisionReport = $this->createReport(
            $this->project,
            $task,
            $this->worker,
            'RPT-DOC-REVISION',
            'revision',
            50
        );

        $approvedDocumentation =
            $this->createDocumentation(
                $this->project,
                $task,
                $this->worker,
                $approvedReport,
                'Foto Dashboard Approved',
                1
            );

        $submittedDocumentation =
            $this->createDocumentation(
                $this->project,
                $task,
                $this->worker,
                $submittedReport,
                'Foto Dashboard Submitted',
                2
            );

        $revisionDocumentation =
            $this->createDocumentation(
                $this->project,
                $task,
                $this->worker,
                $revisionReport,
                'Foto Dashboard Revision',
                3
            );

        $standaloneDocumentation =
            $this->createDocumentation(
                $this->project,
                $task,
                $this->worker,
                null,
                'Foto Dashboard Standalone',
                4
            );

        Livewire::actingAs($this->mandor)
            ->test(
                Dashboard::class
            )
            ->assertViewHas(
                'latestDocumentations',
                function (
                    $documentations
                ) use (
                    $approvedDocumentation,
                    $submittedDocumentation,
                    $revisionDocumentation,
                    $standaloneDocumentation
                ): bool {
                    return $documentations
                        ->contains(
                            'id',
                            $approvedDocumentation->id
                        )
                        && ! $documentations
                            ->contains(
                                'id',
                                $submittedDocumentation->id
                            )
                        && ! $documentations
                            ->contains(
                                'id',
                                $revisionDocumentation->id
                            )
                        && ! $documentations
                            ->contains(
                                'id',
                                $standaloneDocumentation->id
                            );
                }
            )
            ->assertSee(
                $approvedDocumentation->title
            )
            ->assertDontSee(
                $submittedDocumentation->title
            )
            ->assertDontSee(
                $revisionDocumentation->title
            )
            ->assertDontSee(
                $standaloneDocumentation->title
            );
    }

    public function test_dashboard_recent_activities_are_scoped_and_use_valid_report_status_labels(): void
    {
        $task = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-ACTIVITY-001',
            'Task Activity Dashboard',
            'in_progress',
            50
        );

        $submittedReport = $this->createReport(
            $this->project,
            $task,
            $this->worker,
            'RPT-ACTIVITY-SUBMITTED',
            'submitted',
            50
        );

        $revisionReport = $this->createReport(
            $this->project,
            $task,
            $this->worker,
            'RPT-ACTIVITY-REVISION',
            'revision',
            55
        );

        $approvedReport = $this->createReport(
            $this->project,
            $task,
            $this->worker,
            'RPT-ACTIVITY-APPROVED',
            'approved',
            60
        );

        $approvedDocumentation =
            $this->createDocumentation(
                $this->project,
                $task,
                $this->worker,
                $approvedReport,
                'Dokumentasi Activity Approved',
                1
            );

        $otherMandor = User::factory()->create([
            'name' => 'Mandor Activity Lain',
            'status' => 'active',
        ]);

        $otherMandor->assignRole('mandor');

        $otherProject = $this->createProject(
            $otherMandor,
            'planning',
            2
        );

        $otherTask = $this->createTask(
            $otherProject,
            $this->worker,
            'TSK-ACTIVITY-OTHER',
            'Task Activity Mandor Lain',
            'in_progress',
            20
        );

        Livewire::actingAs($this->mandor)
            ->test(
                Dashboard::class
            )
            ->assertViewHas(
                'recentActivities',
                function (
                    $activities
                ) use (
                    $submittedReport,
                    $revisionReport,
                    $approvedReport,
                    $approvedDocumentation,
                    $otherTask
                ): bool {
                    $keys = $activities
                        ->pluck('key');

                    $titles = $activities
                        ->pluck('title');

                    return $keys->contains(
                        'report-'.$submittedReport->id
                    )
                        && $keys->contains(
                            'report-'.$revisionReport->id
                        )
                        && $keys->contains(
                            'report-'.$approvedReport->id
                        )
                        && $keys->contains(
                            'documentation-'
                            .$approvedDocumentation->id
                        )
                        && ! $keys->contains(
                            'task-'.$otherTask->id
                        )
                        && $titles->contains(
                            'Laporan diterima'
                        )
                        && $titles->contains(
                            'Laporan perlu revisi'
                        )
                        && $titles->contains(
                            'Laporan disetujui'
                        );
                }
            );
    }

    private function createProject(
        User $mandor,
        string $status,
        int $sequence
    ): Project {
        return Project::query()->create([
            'client_id' => $this->client->id,

            'mandor_id' => $mandor->id,

            'project_code' => sprintf(
                'PRJ-DASH-%03d',
                $sequence
            ),

            'project_name' => 'Project Dashboard '.$sequence,

            'location' => 'Jakarta Selatan',

            'description' => 'Project untuk pengujian Dashboard Mandor.',

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
        int $progress
    ): Task {
        return Task::query()->create([
            'project_id' => $project->id,

            'mandor_id' => $project->mandor_id,

            'worker_id' => $worker->id,

            'task_code' => $code,

            'title' => $title,

            'description' => 'Task untuk pengujian Dashboard Mandor.',

            'location' => 'Area Dashboard',

            'priority' => 'medium',

            'status' => $status,

            'start_at' => '2026-09-24 08:00:00',

            'due_at' => '2026-09-24 17:00:00',

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
        int $progress
    ): DailyReport {
        return DailyReport::query()->create([
            'project_id' => $project->id,

            'task_id' => $task->id,

            'user_id' => $worker->id,

            'report_number' => $number,

            'report_date' => '2026-09-24',

            'activities' => 'Aktivitas laporan untuk pengujian Dashboard.',

            'work_status' => 'in_progress',

            'reported_progress' => $progress,

            'obstacles' => null,

            'notes' => 'Laporan untuk pengujian Dashboard Mandor.',

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
        int $sequence
    ): Documentation {
        return Documentation::query()->create([
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

            'description' => 'Dokumentasi untuk pengujian Dashboard.',

            'documentation_date' => '2026-09-24',

            'taken_at' => sprintf(
                '2026-09-24 %02d:00:00',
                8 + $sequence
            ),
        ]);
    }
}
