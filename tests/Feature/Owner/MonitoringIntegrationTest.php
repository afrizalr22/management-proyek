<?php

namespace Tests\Feature\Owner;

use App\Livewire\Owner\Monitoring\Documentation as MonitoringDocumentation;
use App\Livewire\Owner\Monitoring\Index;
use App\Livewire\Owner\Monitoring\Show;
use App\Models\Client;
use App\Models\Documentation;
use App\Models\Project;
use App\Models\ProjectProgress;
use App\Models\ProjectWorker;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class MonitoringIntegrationTest extends TestCase
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

        foreach (
            [
                'view-any projects',
                'view projects',
            ] as $permission
        ) {
            Permission::findOrCreate(
                $permission,
                'web'
            );
        }

        Role::findByName(
            'owner',
            'web'
        )->syncPermissions([
            'view-any projects',
            'view projects',
        ]);

        $this->owner = User::factory()->create([
            'name' => 'Owner Monitoring',
            'status' => 'active',
        ]);

        $this->owner->assignRole('owner');

        $this->mandor = User::factory()->create([
            'name' => 'Mandor Monitoring',
            'status' => 'active',
        ]);

        $this->mandor->assignRole('mandor');

        $this->worker = User::factory()->create([
            'name' => 'Pekerja Monitoring',
            'status' => 'active',
        ]);

        $this->worker->assignRole('pekerja');

        $this->client = Client::query()->create([
            'company_name' => 'PT Monitoring Utama',
            'contact_person' => 'Kontak Monitoring',
            'phone' => '021123456',
            'email' => 'monitoring@example.com',
            'address' => 'Jakarta',
        ]);

        $this->project = $this->createProject(
            'PRJ-MONITORING-001',
            'Proyek Monitoring Utama',
            $this->mandor,
            'on_progress',
            65
        );

        ProjectWorker::query()->create([
            'project_id' => $this->project->id,
            'worker_id' => $this->worker->id,
            'assigned_by' => $this->mandor->id,
            'status' => 'active',
            'joined_at' => '2026-09-01',
        ]);
    }

    private function createProject(
        string $code,
        string $name,
        User $mandor,
        string $status = 'planning',
        int $progress = 0
    ): Project {
        return Project::query()->create([
            'client_id' => $this->client->id,
            'mandor_id' => $mandor->id,
            'project_code' => $code,
            'project_name' => $name,
            'location' => 'Jakarta Selatan',
            'description' => 'Project untuk pengujian monitoring.',
            'start_date' => '2026-09-01',
            'end_date' => '2026-12-31',
            'progress' => $progress,
            'status' => $status,
        ]);
    }

    private function createTask(
        Project $project,
        string $code,
        string $status = 'in_progress',
        int $progress = 65
    ): Task {
        return Task::query()->create([
            'project_id' => $project->id,
            'mandor_id' => $project->mandor_id,
            'worker_id' => $this->worker->id,
            'task_code' => $code,
            'title' => 'Task '.$code,
            'location' => 'Jakarta Selatan',
            'priority' => 'medium',
            'status' => $status,
            'start_at' => '2026-09-01 08:00:00',
            'started_at' => '2026-09-01 08:00:00',
            'due_at' => '2026-09-30 17:00:00',
            'completed_at' => $status === 'completed'
                    ? '2026-09-20 16:00:00'
                    : null,
            'progress' => $progress,
            'weight' => 1,
        ]);
    }

    private function createDocumentation(
        Project $project,
        Task $task,
        string $title,
        string $category = 'progress'
    ): Documentation {
        return Documentation::query()->create([
            'project_id' => $project->id,
            'task_id' => $task->id,
            'daily_report_id' => null,
            'user_id' => $this->worker->id,
            'title' => $title,
            'category' => $category,
            'photo' => 'documentations/tests/photo.jpg',
            'original_name' => 'photo.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 1024,
            'description' => 'Dokumentasi pengujian monitoring.',
            'documentation_date' => '2026-09-18',
            'taken_at' => '2026-09-18 09:00:00',
        ]);
    }

    public function test_guest_is_redirected_from_owner_monitoring_routes(): void
    {
        $this->get(
            route('owner.monitoring.index')
        )->assertRedirect(
            route('login')
        );

        $this->get(
            route(
                'owner.monitoring.show',
                [
                    'project' => $this->project->id,
                ]
            )
        )->assertRedirect(
            route('login')
        );

        $this->get(
            route(
                'owner.monitoring.documentation',
                [
                    'project' => $this->project->id,
                ]
            )
        )->assertRedirect(
            route('login')
        );
    }

    public function test_non_owner_cannot_access_owner_monitoring_routes(): void
    {
        foreach (
            [
                $this->mandor,
                $this->worker,
            ] as $user
        ) {
            $this->actingAs($user)
                ->get(
                    route('owner.monitoring.index')
                )
                ->assertForbidden();

            $this->actingAs($user)
                ->get(
                    route(
                        'owner.monitoring.show',
                        [
                            'project' => $this->project->id,
                        ]
                    )
                )
                ->assertForbidden();

            $this->actingAs($user)
                ->get(
                    route(
                        'owner.monitoring.documentation',
                        [
                            'project' => $this->project->id,
                        ]
                    )
                )
                ->assertForbidden();
        }
    }

    public function test_owner_can_access_all_monitoring_routes(): void
    {
        $this->actingAs($this->owner)
            ->get(
                route('owner.monitoring.index')
            )
            ->assertOk()
            ->assertSee(
                'Proyek Monitoring Utama'
            );

        $this->actingAs($this->owner)
            ->get(
                route(
                    'owner.monitoring.show',
                    [
                        'project' => $this->project->id,
                    ]
                )
            )
            ->assertOk()
            ->assertSee(
                'PRJ-MONITORING-001'
            );

        $this->actingAs($this->owner)
            ->get(
                route(
                    'owner.monitoring.documentation',
                    [
                        'project' => $this->project->id,
                    ]
                )
            )
            ->assertOk()
            ->assertSee(
                'PRJ-MONITORING-001'
            );
    }

    public function test_on_progress_project_is_counted_and_filterable(): void
    {
        $planningProject = $this->createProject(
            'PRJ-PLANNING-001',
            'Proyek Masih Perencanaan',
            $this->mandor
        );

        Livewire::actingAs($this->owner)
            ->test(Index::class)
            ->assertViewHas(
                'statistics',
                function (array $statistics): bool {
                    return $statistics['total'] === 2
                        && $statistics['in_progress'] === 1
                        && $statistics['completed'] === 0;
                }
            )
            ->set(
                'status',
                'on_progress'
            )
            ->assertSet(
                'status',
                'on_progress'
            )
            ->assertSee(
                $this->project->project_name
            )
            ->assertDontSee(
                $planningProject->project_name
            );
    }

    public function test_owner_can_filter_projects_by_search_and_mandor(): void
    {
        $otherMandor = User::factory()->create([
            'name' => 'Mandor Proyek Lain',
            'status' => 'active',
        ]);

        $otherMandor->assignRole('mandor');

        $otherProject = $this->createProject(
            'PRJ-OTHER-001',
            'Proyek Gedung Lain',
            $otherMandor,
            'planning'
        );

        Livewire::actingAs($this->owner)
            ->test(Index::class)
            ->set(
                'search',
                'PRJ-MONITORING-001'
            )
            ->assertSee(
                $this->project->project_name
            )
            ->assertDontSee(
                $otherProject->project_name
            );

        Livewire::actingAs($this->owner)
            ->test(Index::class)
            ->set(
                'mandorId',
                (string) $otherMandor->id
            )
            ->assertSee(
                $otherProject->project_name
            )
            ->assertDontSee(
                $this->project->project_name
            );
    }

    public function test_owner_detail_contains_project_task_and_progress_data(): void
    {
        $completedTask = $this->createTask(
            $this->project,
            'TSK-MONITORING-001',
            'completed',
            100
        );

        $activeTask = $this->createTask(
            $this->project,
            'TSK-MONITORING-002'
        );

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'project' => $this->project,
                ]
            )
            ->assertSee(
                $this->project->project_code
            )
            ->assertSee(
                $completedTask->title
            )
            ->assertSee(
                $activeTask->title
            )
            ->assertViewHas(
                'projectData',
                function (Project $project): bool {
                    return $project->tasks_count === 2
                        && $project->completed_tasks_count === 1
                        && $project->active_workers_count === 1
                        && $project->progress === 65;
                }
            )
            ->assertViewHas(
                'currentTask',
                fn (?Task $task): bool => $task?->task_code
                    === 'TSK-MONITORING-002'
            );
    }

    public function test_documentation_page_only_displays_selected_project_data(): void
    {
        $task = $this->createTask(
            $this->project,
            'TSK-DOCUMENTATION-001'
        );

        $ownDocumentation =
            $this->createDocumentation(
                $this->project,
                $task,
                'Dokumentasi Proyek Utama'
            );

        $otherProject = $this->createProject(
            'PRJ-DOCUMENTATION-OTHER',
            'Proyek Dokumentasi Lain',
            $this->mandor,
            'on_progress',
            40
        );

        $otherTask = $this->createTask(
            $otherProject,
            'TSK-DOCUMENTATION-OTHER'
        );

        $otherDocumentation =
            $this->createDocumentation(
                $otherProject,
                $otherTask,
                'Dokumentasi Proyek Lain'
            );

        Livewire::actingAs($this->owner)
            ->test(
                MonitoringDocumentation::class,
                [
                    'project' => $this->project,
                ]
            )
            ->assertSee(
                $ownDocumentation->title
            )
            ->assertDontSee(
                $otherDocumentation->title
            )
            ->assertViewHas(
                'totalDocumentations',
                1
            )
            ->assertViewHas(
                'categoryStatistics',
                fn ($statistics): bool => (int) $statistics->get(
                    'progress'
                ) === 1
            );
    }

    public function test_missing_project_returns_not_found(): void
    {
        $missingProjectId =
            Project::query()->max('id') + 1000;

        $this->actingAs($this->owner)
            ->get(
                route(
                    'owner.monitoring.show',
                    [
                        'project' => $missingProjectId,
                    ]
                )
            )
            ->assertNotFound();

        $this->actingAs($this->owner)
            ->get(
                route(
                    'owner.monitoring.documentation',
                    [
                        'project' => $missingProjectId,
                    ]
                )
            )
            ->assertNotFound();
    }

    public function test_owner_monitoring_reads_latest_project_progress(): void
    {
        $this->project->update([
            'progress' => 85,
            'status' => 'on_progress',
        ]);

        Livewire::actingAs($this->owner)
            ->test(Index::class)
            ->assertSee(
                $this->project->project_name
            )
            ->assertViewHas(
                'projects',
                function ($projects): bool {
                    $project = $projects
                        ->getCollection()
                        ->firstWhere(
                            'id',
                            $this->project->id
                        );

                    return $project !== null
                        && $project->progress === 85
                        && $project->status
                            === 'on_progress';
                }
            );

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'project' => $this->project,
                ]
            )
            ->assertViewHas(
                'projectData',
                fn (Project $project): bool => $project->progress === 85
                    && $project->status
                        === 'on_progress'
            );
    }

    public function test_project_progress_history_is_isolated_between_projects(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Project utama memiliki histori 30% → 60%
        |--------------------------------------------------------------------------
        */

        $this->project->update([
            'progress' => 60,
            'status' => 'on_progress',
        ]);

        ProjectProgress::query()->create([
            'project_id' => $this->project->id,
            'user_id' => $this->mandor->id,
            'progress_percentage' => 30,
            'description' => 'Progress Project utama mencapai 30%.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Project kedua memiliki histori 25% → 75%
        |--------------------------------------------------------------------------
        */

        $otherProject = $this->createProject(
            'PRJ-PROGRESS-OTHER-001',
            'Proyek Progress Lain',
            $this->mandor,
            'on_progress',
            75
        );

        ProjectProgress::query()->create([
            'project_id' => $otherProject->id,
            'user_id' => $this->mandor->id,
            'progress_percentage' => 25,
            'description' => 'Progress Project lain mencapai 25%.',
        ]);

        ProjectProgress::query()->create([
            'project_id' => $this->project->id,
            'user_id' => $this->mandor->id,
            'progress_percentage' => 60,
            'description' => 'Progress Project utama mencapai 60%.',
        ]);

        ProjectProgress::query()->create([
            'project_id' => $otherProject->id,
            'user_id' => $this->mandor->id,
            'progress_percentage' => 75,
            'description' => 'Progress Project lain mencapai 75%.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Database harus menyimpan histori masing-masing Project
        |--------------------------------------------------------------------------
        */

        $this->assertSame(
            2,
            ProjectProgress::query()
                ->where(
                    'project_id',
                    $this->project->id
                )
                ->count()
        );

        $this->assertSame(
            2,
            ProjectProgress::query()
                ->where(
                    'project_id',
                    $otherProject->id
                )
                ->count()
        );

        /*
        |--------------------------------------------------------------------------
        | Monitoring Project utama hanya membaca histori miliknya
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'project' => $this->project,
                ]
            )
            ->assertViewHas(
                'projectData',
                function (Project $project) use (
                    $otherProject
                ): bool {
                    $progressValues = $project
                        ->progresses
                        ->pluck(
                            'progress_percentage'
                        )
                        ->all();

                    return $project->id
                            === $this->project->id
                        && $project->progress === 60
                        && $project->progresses_count === 2
                        && $progressValues === [
                            60,
                            30,
                        ]
                        && $project->progresses
                            ->every(
                                fn (
                                    ProjectProgress $progress
                                ): bool => $progress->project_id
                                    === $this->project->id
                            )
                        && ! $project->progresses
                            ->contains(
                                'project_id',
                                $otherProject->id
                            );
                }
            );

        /*
        |--------------------------------------------------------------------------
        | Monitoring Project kedua hanya membaca histori miliknya
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'project' => $otherProject,
                ]
            )
            ->assertViewHas(
                'projectData',
                function (Project $project): bool {
                    $progressValues = $project
                        ->progresses
                        ->pluck(
                            'progress_percentage'
                        )
                        ->all();

                    return $project->progress === 75
                        && $project->progresses_count === 2
                        && $progressValues === [
                            75,
                            25,
                        ]
                        && $project->progresses
                            ->every(
                                fn (
                                    ProjectProgress $progress
                                ): bool => $progress->project_id
                                    === $project->id
                            )
                        && ! $project->progresses
                            ->contains(
                                'project_id',
                                $this->project->id
                            );
                }
            );

        /*
        |--------------------------------------------------------------------------
        | Latest history masing-masing Project tetap terpisah
        |--------------------------------------------------------------------------
        */

        $latestMainProjectProgress =
            ProjectProgress::query()
                ->where(
                    'project_id',
                    $this->project->id
                )
                ->latest('created_at')
                ->latest('id')
                ->first();

        $latestOtherProjectProgress =
            ProjectProgress::query()
                ->where(
                    'project_id',
                    $otherProject->id
                )
                ->latest('created_at')
                ->latest('id')
                ->first();

        $this->assertNotNull(
            $latestMainProjectProgress
        );

        $this->assertNotNull(
            $latestOtherProjectProgress
        );

        $this->assertSame(
            60,
            $latestMainProjectProgress
                ->progress_percentage
        );

        $this->assertSame(
            $this->project->id,
            $latestMainProjectProgress
                ->project_id
        );

        $this->assertSame(
            75,
            $latestOtherProjectProgress
                ->progress_percentage
        );

        $this->assertSame(
            $otherProject->id,
            $latestOtherProjectProgress
                ->project_id
        );
    }
}
