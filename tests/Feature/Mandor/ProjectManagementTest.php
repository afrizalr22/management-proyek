<?php

namespace Tests\Feature\Mandor;

use App\Livewire\Mandor\Projects\Index;
use App\Livewire\Mandor\Projects\Show;
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

class ProjectManagementTest extends TestCase
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
            'name' => 'Owner Project Management',
            'status' => 'active',
        ]);

        $this->owner->assignRole('owner');

        $this->mandor = User::factory()->create([
            'name' => 'Mandor Project Management',
            'status' => 'active',
        ]);

        $this->mandor->assignRole('mandor');

        $this->worker = User::factory()->create([
            'name' => 'Pekerja Project Management',
            'status' => 'active',
        ]);

        $this->worker->assignRole('pekerja');

        $this->client = Client::query()->create([
            'company_name' => 'PT Project Management Test',
            'contact_person' => 'Kontak Project',
            'city' => 'Jakarta Selatan',
            'status' => 'active',
        ]);

        $this->project = $this->createProject(
            $this->mandor,
            'planning',
            1,
            'Project Utama Mandor'
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

    public function test_mandor_can_open_project_index(): void
    {
        $this->actingAs($this->mandor)
            ->get(
                route('mandor.projects.index')
            )
            ->assertOk()
            ->assertSee(
                $this->project->project_code
            )
            ->assertSee(
                $this->project->project_name
            );
    }

    public function test_non_mandor_user_cannot_open_project_index(): void
    {
        $this->actingAs($this->owner)
            ->get(
                route('mandor.projects.index')
            )
            ->assertForbidden();

        $this->actingAs($this->worker)
            ->get(
                route('mandor.projects.index')
            )
            ->assertForbidden();
    }

    public function test_project_index_only_displays_projects_owned_by_logged_in_mandor(): void
    {
        $secondProject = $this->createProject(
            $this->mandor,
            'on_progress',
            2,
            'Project Kedua Mandor'
        );

        $otherMandor = User::factory()->create([
            'name' => 'Mandor Lain',
            'status' => 'active',
        ]);

        $otherMandor->assignRole('mandor');

        $otherProject = $this->createProject(
            $otherMandor,
            'planning',
            3,
            'Project Rahasia Mandor Lain'
        );

        Livewire::actingAs($this->mandor)
            ->test(Index::class)
            ->assertSee(
                $this->project->project_name
            )
            ->assertSee(
                $secondProject->project_name
            )
            ->assertDontSee(
                $otherProject->project_name
            )
            ->assertViewHas(
                'projects',
                function (
                    $projects
                ) use (
                    $secondProject,
                    $otherProject
                ): bool {
                    $items = $projects
                        ->getCollection();

                    return $items->contains(
                        'id',
                        $this->project->id
                    )
                        && $items->contains(
                            'id',
                            $secondProject->id
                        )
                        && ! $items->contains(
                            'id',
                            $otherProject->id
                        );
                }
            );
    }

    public function test_project_index_statistics_only_use_logged_in_mandor_projects(): void
    {
        $this->createProject(
            $this->mandor,
            'on_progress',
            2,
            'Project Berjalan'
        );

        $this->createProject(
            $this->mandor,
            'completed',
            3,
            'Project Selesai'
        );

        $this->createProject(
            $this->mandor,
            'cancelled',
            4,
            'Project Dibatalkan'
        );

        $otherMandor = User::factory()->create([
            'name' => 'Mandor Statistik Lain',
            'status' => 'active',
        ]);

        $otherMandor->assignRole('mandor');

        $this->createProject(
            $otherMandor,
            'planning',
            5,
            'Project Mandor Lain'
        );

        Livewire::actingAs($this->mandor)
            ->test(Index::class)
            ->assertViewHas(
                'statistics',
                function (
                    array $statistics
                ): bool {
                    return $statistics['total'] === 4
                        && $statistics['active'] === 2
                        && $statistics['completed'] === 1;
                }
            );
    }

    public function test_project_index_can_search_projects(): void
    {
        $targetProject = $this->createProject(
            $this->mandor,
            'planning',
            2,
            'Renovasi Gedung Selatan'
        );

        $otherProject = $this->createProject(
            $this->mandor,
            'planning',
            3,
            'Pembangunan Gudang Utara'
        );

        Livewire::actingAs($this->mandor)
            ->test(Index::class)
            ->set(
                'search',
                'Renovasi Gedung Selatan'
            )
            ->assertSee(
                $targetProject->project_name
            )
            ->assertDontSee(
                $this->project->project_name
            )
            ->assertDontSee(
                $otherProject->project_name
            );
    }

    public function test_project_index_can_filter_projects_by_status(): void
    {
        $onProgressProject = $this->createProject(
            $this->mandor,
            'on_progress',
            2,
            'Project Sedang Berjalan'
        );

        $completedProject = $this->createProject(
            $this->mandor,
            'completed',
            3,
            'Project Sudah Selesai'
        );

        Livewire::actingAs($this->mandor)
            ->test(Index::class)
            ->set(
                'status',
                'on_progress'
            )
            ->assertSee(
                $onProgressProject->project_name
            )
            ->assertDontSee(
                $this->project->project_name
            )
            ->assertDontSee(
                $completedProject->project_name
            );
    }

    public function test_project_index_can_sort_projects_by_name(): void
    {
        $alphaProject = $this->createProject(
            $this->mandor,
            'planning',
            2,
            'Alpha Project'
        );

        $zuluProject = $this->createProject(
            $this->mandor,
            'planning',
            3,
            'Zulu Project'
        );

        Livewire::actingAs($this->mandor)
            ->test(Index::class)
            ->set(
                'sort',
                'name_asc'
            )
            ->assertViewHas(
                'projects',
                function (
                    $projects
                ) use (
                    $alphaProject,
                    $zuluProject
                ): bool {
                    $ids = $projects
                        ->getCollection()
                        ->pluck('id')
                        ->values();

                    $alphaPosition =
                        $ids->search(
                            $alphaProject->id
                        );

                    $zuluPosition =
                        $ids->search(
                            $zuluProject->id
                        );

                    return $alphaPosition !== false
                        && $zuluPosition !== false
                        && $alphaPosition
                            < $zuluPosition;
                }
            );
    }

    public function test_project_index_reset_filters_returns_default_state(): void
    {
        Livewire::actingAs($this->mandor)
            ->test(Index::class)
            ->set(
                'search',
                'Project'
            )
            ->set(
                'status',
                'planning'
            )
            ->set(
                'sort',
                'name_desc'
            )
            ->call(
                'resetFilters'
            )
            ->assertSet(
                'search',
                ''
            )
            ->assertSet(
                'status',
                ''
            )
            ->assertSet(
                'sort',
                'latest'
            );
    }

    public function test_project_owner_mandor_can_open_project_detail(): void
    {
        $this->actingAs($this->mandor)
            ->get(
                route(
                    'mandor.projects.show',
                    [
                        'project' => $this->project,
                    ]
                )
            )
            ->assertOk()
            ->assertSee(
                $this->project->project_code
            )
            ->assertSee(
                $this->project->project_name
            )
            ->assertSee(
                $this->client->company_name
            );
    }

    public function test_other_mandor_cannot_open_project_detail(): void
    {
        $otherMandor = User::factory()->create([
            'name' => 'Mandor Tidak Berhak',
            'status' => 'active',
        ]);

        $otherMandor->assignRole('mandor');

        $this->actingAs($otherMandor)
            ->get(
                route(
                    'mandor.projects.show',
                    [
                        'project' => $this->project,
                    ]
                )
            )
            ->assertForbidden();
    }

    public function test_non_mandor_user_cannot_open_project_detail(): void
    {
        $this->actingAs($this->owner)
            ->get(
                route(
                    'mandor.projects.show',
                    [
                        'project' => $this->project,
                    ]
                )
            )
            ->assertForbidden();

        $this->actingAs($this->worker)
            ->get(
                route(
                    'mandor.projects.show',
                    [
                        'project' => $this->project,
                    ]
                )
            )
            ->assertForbidden();
    }

    public function test_project_detail_summary_uses_valid_task_statuses(): void
    {
        $completedTask = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-PROJECT-COMPLETED',
            'Task Selesai',
            'completed',
            100
        );

        $activeTask = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-PROJECT-ACTIVE',
            'Task Sedang Dikerjakan',
            'in_progress',
            50
        );

        Livewire::actingAs($this->mandor)
            ->test(
                Show::class,
                [
                    'project' => $this->project,
                ]
            )
            ->assertSee(
                $completedTask->title
            )
            ->assertSee(
                $activeTask->title
            )
            ->assertViewHas(
                'summary',
                function (
                    array $summary
                ): bool {
                    return $summary['total_tasks'] === 2
                        && $summary['completed_tasks'] === 1
                        && $summary['active_workers'] === 1;
                }
            );
    }

    public function test_project_detail_only_displays_documentation_from_approved_reports(): void
    {
        $task = $this->createTask(
            $this->project,
            $this->worker,
            'TSK-DOCUMENTATION-001',
            'Task Dokumentasi Project',
            'in_progress',
            40
        );

        $approvedReport = $this->createReport(
            $this->project,
            $task,
            $this->worker,
            'RPT-PROJECT-APPROVED',
            'approved',
            40
        );

        $submittedReport = $this->createReport(
            $this->project,
            $task,
            $this->worker,
            'RPT-PROJECT-SUBMITTED',
            'submitted',
            45
        );

        $revisionReport = $this->createReport(
            $this->project,
            $task,
            $this->worker,
            'RPT-PROJECT-REVISION',
            'revision',
            50
        );

        $approvedDocumentation =
            $this->createDocumentation(
                $this->project,
                $task,
                $this->worker,
                $approvedReport,
                'Foto Project Approved',
                1
            );

        $submittedDocumentation =
            $this->createDocumentation(
                $this->project,
                $task,
                $this->worker,
                $submittedReport,
                'Foto Project Submitted',
                2
            );

        $revisionDocumentation =
            $this->createDocumentation(
                $this->project,
                $task,
                $this->worker,
                $revisionReport,
                'Foto Project Revision',
                3
            );

        $standaloneDocumentation =
            $this->createDocumentation(
                $this->project,
                $task,
                $this->worker,
                null,
                'Foto Project Standalone',
                4
            );

        Livewire::actingAs($this->mandor)
            ->test(
                Show::class,
                [
                    'project' => $this->project,
                ]
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
            ->assertViewHas(
                'summary',
                function (
                    array $summary
                ): bool {
                    return $summary[
                        'documentations'
                    ] === 1;
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

    public function test_project_detail_does_not_leak_other_project_data(): void
    {
        $otherProject = $this->createProject(
            $this->mandor,
            'planning',
            2,
            'Project Kedua Untuk Isolasi'
        );

        $otherTask = $this->createTask(
            $otherProject,
            $this->worker,
            'TSK-OTHER-PROJECT',
            'Task Project Lain Tidak Boleh Tampil',
            'in_progress',
            20
        );

        Livewire::actingAs($this->mandor)
            ->test(
                Show::class,
                [
                    'project' => $this->project,
                ]
            )
            ->assertDontSee(
                $otherTask->title
            );
    }

    private function createProject(
        User $mandor,
        string $status,
        int $sequence,
        ?string $name = null
    ): Project {
        return Project::query()->create([
            'client_id' => $this->client->id,

            'mandor_id' => $mandor->id,

            'project_code' => sprintf(
                'PRJ-MANDOR-%03d',
                $sequence
            ),

            'project_name' => $name
                ?? 'Project Mandor '.$sequence,

            'location' => 'Jakarta Selatan',

            'description' => 'Project untuk pengujian manajemen Project Mandor.',

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

            'description' => 'Task untuk pengujian Project Mandor.',

            'location' => 'Area Project',

            'priority' => 'medium',

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
        int $progress
    ): DailyReport {
        return DailyReport::query()->create([
            'project_id' => $project->id,

            'task_id' => $task->id,

            'user_id' => $worker->id,

            'report_number' => $number,

            'report_date' => '2026-09-24',

            'activities' => 'Aktivitas laporan untuk pengujian Project Mandor.',

            'work_status' => 'in_progress',

            'reported_progress' => $progress,

            'obstacles' => null,

            'notes' => 'Laporan untuk pengujian detail Project Mandor.',

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
                'documentations/testing/project-%03d.jpg',
                $sequence
            ),

            'original_name' => sprintf(
                'project-%03d.jpg',
                $sequence
            ),

            'mime_type' => 'image/jpeg',

            'file_size' => 1024,

            'description' => 'Dokumentasi untuk pengujian Project Mandor.',

            'documentation_date' => '2026-09-24',

            'taken_at' => sprintf(
                '2026-09-24 %02d:00:00',
                8 + $sequence
            ),
        ]);
    }
}
