<?php

namespace Tests\Feature\Mandor;

use App\Livewire\Mandor\WorkProgress\Index;
use App\Livewire\Mandor\WorkProgress\Projects as WorkProgressProjects;
use App\Models\Client;
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

class ProjectTaskWorkflowTest extends TestCase
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
            '2026-09-20 08:00:00'
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
            'name' => 'Owner Project',
            'status' => 'active',
        ]);

        $this->owner->assignRole('owner');

        $this->mandor = User::factory()->create([
            'name' => 'Mandor Project',
            'status' => 'active',
        ]);

        $this->mandor->assignRole('mandor');

        $this->worker = User::factory()->create([
            'name' => 'Pekerja Project',
            'status' => 'active',
        ]);

        $this->worker->assignRole('pekerja');

        $this->client = Client::query()->create([
            'company_name' => 'PT Workflow Project',
            'contact_person' => 'Kontak Project',
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

    public function test_project_mandor_can_open_work_progress_page(): void
    {
        $this->actingAs($this->mandor)
            ->get(
                route(
                    'mandor.projects.work-progress.index',
                    [
                        'project' => $this->project,
                    ]
                )
            )
            ->assertOk()
            ->assertSee(
                $this->project->project_name
            )
            ->assertSee(
                'Buat Task'
            )
            ->assertSee(
                'Kembali ke Daftar Progress'
            )
            ->assertSee(
                route(
                    'mandor.work-progress.index'
                ),
                false
            );
    }

    public function test_other_mandor_cannot_open_work_progress_page(): void
    {
        $otherMandor = User::factory()->create([
            'status' => 'active',
        ]);

        $otherMandor->assignRole('mandor');

        $this->actingAs($otherMandor)
            ->get(
                route(
                    'mandor.projects.work-progress.index',
                    [
                        'project' => $this->project,
                    ]
                )
            )
            ->assertForbidden();
    }

    public function test_mandor_can_open_global_work_progress_and_only_see_own_projects(): void
    {
        $ownCompletedProject = $this->createProject(
            $this->mandor,
            'completed',
            2
        );

        $otherMandor = User::factory()->create([
            'name' => 'Mandor Lain',
            'status' => 'active',
        ]);

        $otherMandor->assignRole('mandor');

        $otherProject = $this->createProject(
            $otherMandor,
            'planning',
            3
        );

        $this->actingAs($this->mandor)
            ->get(
                route(
                    'mandor.work-progress.index'
                )
            )
            ->assertOk()
            ->assertSee(
                'Progress Pekerjaan'
            )
            ->assertSee(
                $this->project->project_name
            )
            ->assertSee(
                $ownCompletedProject->project_name
            )
            ->assertDontSee(
                $otherProject->project_name
            )
            ->assertSee(
                route(
                    'mandor.projects.work-progress.index',
                    [
                        'project' => $this->project,
                    ]
                ),
                false
            )
            ->assertSee(
                'Lihat Progress'
            );
    }

    public function test_global_work_progress_can_filter_projects_by_search_and_status(): void
    {
        $completedProject = $this->createProject(
            $this->mandor,
            'completed',
            2
        );

        $onProgressProject = $this->createProject(
            $this->mandor,
            'on_progress',
            3
        );

        Livewire::actingAs($this->mandor)
            ->test(
                WorkProgressProjects::class
            )
            ->set(
                'search',
                $completedProject->project_code
            )
            ->assertSee(
                $completedProject->project_name
            )
            ->assertDontSee(
                $this->project->project_name
            )
            ->assertDontSee(
                $onProgressProject->project_name
            )
            ->call(
                'resetFilters'
            )
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

    public function test_non_mandor_user_cannot_open_global_work_progress_page(): void
    {
        $this->actingAs($this->owner)
            ->get(
                route(
                    'mandor.work-progress.index'
                )
            )
            ->assertForbidden();

        $this->actingAs($this->worker)
            ->get(
                route(
                    'mandor.work-progress.index'
                )
            )
            ->assertForbidden();
    }

    public function test_project_mandor_can_create_task_for_active_project_worker(): void
    {
        Livewire::actingAs($this->mandor)
            ->test(
                Index::class,
                [
                    'project' => $this->project,
                ]
            )
            ->set(
                'workerIds',
                [$this->worker->id]
            )
            ->set(
                'title',
                'Pekerjaan Struktur Utama'
            )
            ->set(
                'description',
                'Melaksanakan pekerjaan struktur lantai pertama.'
            )
            ->set(
                'location',
                'Area Lantai Satu'
            )

            ->set(
                'startAt',
                '2026-09-21T08:00'
            )
            ->set(
                'dueAt',
                '2026-09-25T17:00'
            )

            ->set(
                'mandorNotes',
                'Gunakan perlengkapan keselamatan.'
            )
            ->call('createTask')
            ->assertHasNoErrors();

        $task = Task::query()->sole();

        $this->assertDatabaseHas('task_workers', [
            'task_id' => $task->id,
            'worker_id' => $this->worker->id,
        ]);

        $this->assertSame(
            $this->project->id,
            $task->project_id
        );

        $this->assertSame(
            $this->mandor->id,
            $task->mandor_id
        );

        $this->assertSame(
            $this->worker->id,
            $task->worker_id
        );

        $this->assertSame(
            'assigned',
            $task->status
        );

        $this->assertSame(
            '1.00',
            $task->weight
        );
    }

    public function test_worker_from_other_project_cannot_receive_task(): void
    {
        $otherMandor = User::factory()->create([
            'status' => 'active',
        ]);

        $otherMandor->assignRole('mandor');

        $otherWorker = User::factory()->create([
            'status' => 'active',
        ]);

        $otherWorker->assignRole('pekerja');

        $otherProject = $this->createProject(
            $otherMandor,
            'planning',
            2
        );

        $this->assignWorker(
            $otherProject,
            $otherWorker
        );

        $this->taskForm(
            $otherWorker
        )
            ->call('createTask')
            ->assertHasErrors('workerIds.0');


        $this->assertSame(
            0,
            Task::query()->count()
        );
    }

    public function test_inactive_worker_cannot_receive_task(): void
    {
        $this->worker->update([
            'status' => 'inactive',
        ]);

        $this->taskForm(
            $this->worker
        )
            ->call('createTask')
->assertHasErrors('workerIds');

        $this->assertSame(
            0,
            Task::query()->count()
        );
    }

    public function test_inactive_project_assignment_cannot_receive_task(): void
    {
        ProjectWorker::query()
            ->where(
                'project_id',
                $this->project->id
            )
            ->where(
                'worker_id',
                $this->worker->id
            )
            ->update([
                'status' => 'inactive',
                'ended_at' => now(),
            ]);

        $this->taskForm(
            $this->worker
        )
            ->call('createTask')
            ->assertHasErrors('workerIds.0');

        $this->assertSame(
            0,
            Task::query()->count()
        );
    }

    public function test_completed_and_cancelled_projects_cannot_receive_new_task(): void
    {
        foreach (
            [
                'completed',
                'cancelled',
            ] as $index => $status
        ) {
            $project = $this->createProject(
                $this->mandor,
                $status,
                $index + 10
            );

            $this->assignWorker(
                $project,
                $this->worker
            );

            $this->taskForm(
                $this->worker,
                $project
            )
                ->call('createTask')
->assertHasErrors('task');
        }

        $this->assertSame(
            0,
            Task::query()->count()
        );
    }

    public function test_task_form_cannot_be_opened_for_completed_project(): void
    {
        $this->project->update([
            'status' => 'completed',
            'progress' => 100,
        ]);

        Livewire::actingAs($this->mandor)
            ->test(
                Index::class,
                [
                    'project' => $this->project,
                ]
            )
            ->call('openTaskForm')
            ->assertSet('showTaskForm', false)
            ->assertHasErrors([
                'task',
            ]);
    }

    public function test_legacy_weight_does_not_limit_new_task_creation(): void
{
    Task::query()->create([
        'project_id' => $this->project->id,
        'mandor_id' => $this->mandor->id,
        'worker_id' => $this->worker->id,
        'task_code' => 'TSK-LEGACY-WEIGHT',
        'title' => 'Task dengan Bobot Lama',
        'priority' => 'medium',
        'status' => 'assigned',
        'start_at' => '2026-09-20 08:00:00',
        'due_at' => '2026-09-25 17:00:00',
        'progress' => 0,
        'weight' => 100,
    ]);

    $this->taskForm($this->worker)
        ->call('createTask')
        ->assertHasNoErrors();

    $this->assertDatabaseCount('tasks', 2);

    $newTask = Task::query()
        ->where('task_code', '!=', 'TSK-LEGACY-WEIGHT')
        ->sole();

    $this->assertSame('assigned', $newTask->status);

    $this->assertDatabaseHas('task_workers', [
        'task_id' => $newTask->id,
        'worker_id' => $this->worker->id,
    ]);
    }

    public function test_cancelled_tasks_are_excluded_from_actual_progress(): void
    {
        Task::query()->create([
            'project_id' => $this->project->id,
            'mandor_id' => $this->mandor->id,
            'worker_id' => $this->worker->id,
            'task_code' => 'TSK-ACTIVE-PROGRESS',
            'title' => 'Task Masih Berjalan',
            'priority' => 'medium',
            'status' => 'in_progress',
            'start_at' => '2026-09-20 08:00:00',
            'due_at' => '2026-09-25 17:00:00',
            'progress' => 40,
            'weight' => 10,
        ]);

        Task::query()->create([
            'project_id' => $this->project->id,
            'mandor_id' => $this->mandor->id,
            'worker_id' => $this->worker->id,
            'task_code' => 'TSK-CANCELLED-PROGRESS',
            'title' => 'Task Dibatalkan',
            'priority' => 'medium',
            'status' => 'cancelled',
            'start_at' => '2026-09-20 08:00:00',
            'due_at' => '2026-09-25 17:00:00',
            'progress' => 100,
            'weight' => 90,
        ]);

        Livewire::actingAs($this->mandor)
            ->test(Index::class, [
                'project' => $this->project,
            ])
            ->assertViewHas('actualProgress', 40);
    }

    public function test_task_due_date_cannot_be_before_start_date(): void
    {
        $this->taskForm(
            $this->worker
        )
            ->set(
                'startAt',
                '2026-09-25T08:00'
            )
            ->set(
                'dueAt',
                '2026-09-24T17:00'
            )
            ->call('createTask')
            ->assertHasErrors([
                'dueAt' => 'after_or_equal',
            ]);

        $this->assertSame(
            0,
            Task::query()->count()
        );
    }

    public function test_non_mandor_user_cannot_open_work_progress_page(): void
    {
        $this->actingAs($this->owner)
            ->get(
                route(
                    'mandor.projects.work-progress.index',
                    [
                        'project' => $this->project,
                    ]
                )
            )
            ->assertForbidden();

        $this->actingAs($this->worker)
            ->get(
                route(
                    'mandor.projects.work-progress.index',
                    [
                        'project' => $this->project,
                    ]
                )
            )
            ->assertForbidden();
    }

    public function test_work_progress_calculates_actual_planned_and_variance_correctly(): void
    {
        Task::query()->create([
            'project_id' => $this->project->id,
            'mandor_id' => $this->mandor->id,
            'worker_id' => $this->worker->id,
            'task_code' => 'TSK-PROGRESS-001',
            'title' => 'Task Progress Pertama',
            'priority' => 'medium',
            'status' => 'in_progress',
            'start_at' => '2026-09-20 08:00:00',
            'due_at' => '2026-09-30 17:00:00',
            'started_at' => '2026-09-20 08:00:00',
            'progress' => 50,
            'weight' => 60,
        ]);

        Task::query()->create([
            'project_id' => $this->project->id,
            'mandor_id' => $this->mandor->id,
            'worker_id' => $this->worker->id,
            'task_code' => 'TSK-PROGRESS-002',
            'title' => 'Task Progress Kedua',
            'priority' => 'medium',
            'status' => 'completed',
            'start_at' => '2026-09-20 08:00:00',
            'due_at' => '2026-09-30 17:00:00',
            'started_at' => '2026-09-20 08:00:00',
            'completed_at' => '2026-09-20 07:30:00',
            'progress' => 100,
            'weight' => 40,
        ]);

        Livewire::actingAs($this->mandor)
            ->test(
                Index::class,
                [
                    'project' => $this->project,
                ]
            )
            ->assertViewHas(
                'actualProgress',
                75
            )
            ->assertViewHas(
                'plannedProgress',
                1
            )
            ->assertViewHas(
                'progressVariance',
                74
            )
            ->assertViewHas(
                'taskStatistics',
                function (array $statistics): bool {
                    return $statistics['total'] === 2
                        && $statistics['active'] === 1
                        && $statistics['completed'] === 1;
                }
            );
    }

    public function test_task_can_be_created_for_multiple_active_workers(): void
{
    $otherWorker = User::factory()->create([
        'status' => 'active',
    ]);

    $otherWorker->assignRole('pekerja');

    $this->assignWorker($this->project, $otherWorker);

    $this->taskForm($this->worker)
        ->set('workerIds', [
            $this->worker->id,
            $otherWorker->id,
        ])
        ->call('createTask')
        ->assertHasNoErrors();

    $task = Task::query()->sole();

    $this->assertEqualsCanonicalizing(
        [$this->worker->id, $otherWorker->id],
        $task->workers()->pluck('users.id')->all()
    );

    $this->assertSame('1.00', $task->weight);
    $this->assertSame('assigned', $task->status);
    $this->assertDatabaseCount('task_workers', 2);
}

public function test_task_requires_at_least_one_worker(): void
{
    $this->taskForm($this->worker)
        ->set('workerIds', [])
        ->call('createTask')
        ->assertHasErrors('workerIds');

    $this->assertDatabaseCount('tasks', 0);
    $this->assertDatabaseCount('task_workers', 0);
}

public function test_duplicate_worker_selection_is_rejected(): void
{
    $this->taskForm($this->worker)
        ->set('workerIds', [
            $this->worker->id,
            $this->worker->id,
        ])
        ->call('createTask')
        ->assertHasErrors('workerIds.0');

    $this->assertDatabaseCount('tasks', 0);
    $this->assertDatabaseCount('task_workers', 0);
}

public function test_invalid_member_rejects_entire_task_creation(): void
{
    // Assignment tersedia, tetapi akun ini bukan role Pekerja.
    $this->assignWorker($this->project, $this->owner);

    $this->taskForm($this->worker)
        ->set('workerIds', [
            $this->worker->id,
            $this->owner->id,
        ])
        ->call('createTask')
        ->assertHasErrors('workerIds');

    $this->assertDatabaseCount('tasks', 0);
    $this->assertDatabaseCount('task_workers', 0);
    }

        private function taskForm(
        User $worker,
        ?Project $project = null
    ) {
        return Livewire::actingAs($this->mandor)
            ->test(Index::class, [
                'project' => $project ?? $this->project,
            ])
            ->set('workerIds', [$worker->id])
            ->set('title', 'Pekerjaan Pengujian')
            ->set('description', 'Deskripsi pekerjaan pengujian.')
            ->set('location', 'Lokasi Pengujian')
            ->set('startAt', '2026-09-21T08:00')
            ->set('dueAt', '2026-09-25T17:00')
            ->set('mandorNotes', 'Catatan pengujian.');
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
                'PRJ-TASK-%03d',
                $sequence
            ),
            'project_name' => 'Project Task '.$sequence,
            'location' => 'Jakarta Selatan',
            'description' => 'Project untuk pengujian Task.',
            'start_date' => '2026-09-20',
            'end_date' => '2026-10-20',
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
            'joined_at' => '2026-09-20',
        ]);
    }
}
