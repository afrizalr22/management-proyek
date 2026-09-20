<?php

namespace Tests\Feature\Owner;

use App\Livewire\Owner\Projects\ManageWorkers;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectWorker;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ProjectWorkerAssignmentTest extends TestCase
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
            '2026-09-21 08:00:00'
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

        Permission::findOrCreate(
            'assign workers',
            'web'
        );

        Role::findByName(
            'owner',
            'web'
        )->syncPermissions([
            'assign workers',
        ]);

        $this->owner = User::factory()->create([
            'name' => 'Owner Penempatan',
            'status' => 'active',
        ]);

        $this->owner->assignRole('owner');

        $this->mandor = User::factory()->create([
            'name' => 'Mandor Penempatan',
            'status' => 'active',
        ]);

        $this->mandor->assignRole('mandor');

        $this->worker = User::factory()->create([
            'name' => 'Pekerja Penempatan',
            'status' => 'active',
        ]);

        $this->worker->assignRole('pekerja');

        $this->client = Client::query()->create([
            'company_name' => 'PT Penempatan Pekerja',
            'contact_person' => 'Kontak Penempatan',
            'status' => 'active',
        ]);

        $this->project = $this->createProject(
            'planning',
            1
        );
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_owner_with_assign_workers_permission_can_open_modal(): void
    {
        Livewire::actingAs($this->owner)
            ->test(
                ManageWorkers::class,
                [
                    'project' => $this->project,
                ]
            )
            ->call(
                'openModal',
                $this->project->id
            )
            ->assertSet(
                'showModal',
                true
            )
            ->assertSet(
                'selectedWorkerIds',
                []
            );
    }

    public function test_owner_can_assign_active_worker_to_project(): void
    {
        $this->manageWorkersComponent()
            ->set(
                'selectedWorkerIds',
                [
                    $this->worker->id,
                ]
            )
            ->set(
                'originalWorkerIds',
                []
            )
            ->call('saveWorkers')
            ->assertHasNoErrors();

        $assignment = ProjectWorker::query()
            ->where(
                'project_id',
                $this->project->id
            )
            ->where(
                'worker_id',
                $this->worker->id
            )
            ->sole();

        $this->assertSame(
            'active',
            $assignment->status
        );

        $this->assertSame(
            $this->owner->id,
            $assignment->assigned_by
        );

        $this->assertSame(
            '2026-09-21',
            $assignment->joined_at
                ->format('Y-m-d')
        );

        $this->assertNull(
            $assignment->ended_at
        );
    }

    public function test_non_worker_user_cannot_be_assigned(): void
    {
        $this->manageWorkersComponent()
            ->set(
                'selectedWorkerIds',
                [
                    $this->mandor->id,
                ]
            )
            ->set(
                'originalWorkerIds',
                []
            )
            ->call('saveWorkers')
            ->assertHasErrors([
                'workers',
            ]);

        $this->assertSame(
            0,
            ProjectWorker::query()->count()
        );
    }

    public function test_inactive_worker_cannot_be_newly_assigned(): void
    {
        $this->worker->update([
            'status' => 'inactive',
        ]);

        $this->manageWorkersComponent()
            ->set(
                'selectedWorkerIds',
                [
                    $this->worker->id,
                ]
            )
            ->set(
                'originalWorkerIds',
                []
            )
            ->call('saveWorkers')
            ->assertHasErrors([
                'workers',
            ]);

        $this->assertSame(
            0,
            ProjectWorker::query()->count()
        );
    }

    public function test_worker_cannot_be_active_on_two_projects(): void
    {
        $otherProject = $this->createProject(
            'on_progress',
            2
        );

        $this->createAssignment(
            $otherProject,
            $this->worker
        );

        $this->manageWorkersComponent()
            ->set(
                'selectedWorkerIds',
                [
                    $this->worker->id,
                ]
            )
            ->set(
                'originalWorkerIds',
                []
            )
            ->call('saveWorkers')
            ->assertHasErrors([
                'workers',
            ]);

        $this->assertDatabaseMissing(
            'project_workers',
            [
                'project_id' => $this->project->id,
                'worker_id' => $this->worker->id,
            ]
        );
    }

    public function test_worker_with_active_task_cannot_be_removed(): void
    {
        $this->createAssignment(
            $this->project,
            $this->worker
        );

        $this->createTask(
            $this->project,
            $this->worker,
            'assigned',
            1
        );

        $this->manageWorkersComponent()
            ->set(
                'selectedWorkerIds',
                []
            )
            ->set(
                'originalWorkerIds',
                [
                    $this->worker->id,
                ]
            )
            ->call('saveWorkers')
            ->assertHasErrors([
                'workers',
            ]);

        $this->assertDatabaseHas(
            'project_workers',
            [
                'project_id' => $this->project->id,
                'worker_id' => $this->worker->id,
                'status' => 'active',
            ]
        );
    }

    public function test_worker_can_be_removed_after_tasks_are_completed(): void
    {
        $this->createAssignment(
            $this->project,
            $this->worker
        );

        $this->createTask(
            $this->project,
            $this->worker,
            'completed',
            2
        );

        $this->manageWorkersComponent()
            ->set(
                'selectedWorkerIds',
                []
            )
            ->set(
                'originalWorkerIds',
                [
                    $this->worker->id,
                ]
            )
            ->call('saveWorkers')
            ->assertHasNoErrors();

        $assignment = ProjectWorker::query()
            ->where(
                'project_id',
                $this->project->id
            )
            ->where(
                'worker_id',
                $this->worker->id
            )
            ->sole();

        $this->assertSame(
            'inactive',
            $assignment->status
        );

        $this->assertSame(
            '2026-09-21',
            $assignment->ended_at
                ->format('Y-m-d')
        );
    }

    public function test_worker_can_be_removed_after_tasks_are_cancelled(): void
    {
        $this->createAssignment(
            $this->project,
            $this->worker
        );

        $this->createTask(
            $this->project,
            $this->worker,
            'cancelled',
            3
        );

        $this->manageWorkersComponent()
            ->set(
                'selectedWorkerIds',
                []
            )
            ->set(
                'originalWorkerIds',
                [
                    $this->worker->id,
                ]
            )
            ->call('saveWorkers')
            ->assertHasNoErrors();

        $this->assertDatabaseHas(
            'project_workers',
            [
                'project_id' => $this->project->id,
                'worker_id' => $this->worker->id,
                'status' => 'inactive',
            ]
        );
    }

    public function test_inactive_assignment_can_be_reactivated(): void
    {
        ProjectWorker::query()->create([
            'project_id' => $this->project->id,
            'worker_id' => $this->worker->id,
            'assigned_by' => $this->owner->id,
            'status' => 'inactive',
            'joined_at' => '2026-09-01',
            'ended_at' => '2026-09-10',
        ]);

        $this->manageWorkersComponent()
            ->set(
                'selectedWorkerIds',
                [
                    $this->worker->id,
                ]
            )
            ->set(
                'originalWorkerIds',
                []
            )
            ->call('saveWorkers')
            ->assertHasNoErrors();

        $assignment = ProjectWorker::query()
            ->where(
                'project_id',
                $this->project->id
            )
            ->where(
                'worker_id',
                $this->worker->id
            )
            ->sole();

        $this->assertSame(
            'active',
            $assignment->status
        );

        $this->assertSame(
            $this->owner->id,
            $assignment->assigned_by
        );

        $this->assertSame(
            '2026-09-21',
            $assignment->joined_at
                ->format('Y-m-d')
        );

        $this->assertNull(
            $assignment->ended_at
        );
    }

    public function test_completed_and_cancelled_projects_cannot_manage_workers(): void
    {
        foreach (
            [
                'completed',
                'cancelled',
            ] as $index => $status
        ) {
            $project = $this->createProject(
                $status,
                $index + 10
            );

            Livewire::actingAs($this->owner)
                ->test(
                    ManageWorkers::class,
                    [
                        'project' => $project,
                    ]
                )
                ->set(
                    'selectedWorkerIds',
                    [
                        $this->worker->id,
                    ]
                )
                ->set(
                    'originalWorkerIds',
                    []
                )
                ->call('saveWorkers')
                ->assertHasErrors([
                    'workers',
                ]);
        }

        $this->assertSame(
            0,
            ProjectWorker::query()->count()
        );
    }

    public function test_saving_without_changes_is_rejected(): void
    {
        $this->createAssignment(
            $this->project,
            $this->worker
        );

        $this->manageWorkersComponent()
            ->set(
                'selectedWorkerIds',
                [
                    $this->worker->id,
                ]
            )
            ->set(
                'originalWorkerIds',
                [
                    $this->worker->id,
                ]
            )
            ->call('saveWorkers')
            ->assertHasErrors([
                'workers',
            ]);

        $this->assertSame(
            1,
            ProjectWorker::query()->count()
        );
    }

    public function test_user_without_assign_workers_permission_cannot_manage_workers(): void
    {
        $user = User::factory()->create([
            'status' => 'active',
        ]);

        Livewire::actingAs($user)
            ->test(
                ManageWorkers::class,
                [
                    'project' => $this->project,
                ]
            )
            ->set(
                'selectedWorkerIds',
                [
                    $this->worker->id,
                ]
            )
            ->set(
                'originalWorkerIds',
                []
            )
            ->call('saveWorkers')
            ->assertForbidden();

        $this->assertSame(
            0,
            ProjectWorker::query()->count()
        );
    }

    private function manageWorkersComponent()
    {
        return Livewire::actingAs(
            $this->owner
        )->test(
            ManageWorkers::class,
            [
                'project' => $this->project,
            ]
        );
    }

    private function createProject(
        string $status,
        int $sequence
    ): Project {
        return Project::query()->create([
            'client_id' => $this->client->id,
            'mandor_id' => $this->mandor->id,
            'project_code' => sprintf(
                'PRJ-WORKER-%03d',
                $sequence
            ),
            'project_name' => 'Project Penempatan '.$sequence,
            'location' => 'Jakarta Selatan',
            'description' => 'Project untuk pengujian penempatan.',
            'start_date' => '2026-09-21',
            'end_date' => '2026-10-21',
            'progress' => $status === 'completed'
                    ? 100
                    : 0,
            'status' => $status,
        ]);
    }

    private function createAssignment(
        Project $project,
        User $worker
    ): ProjectWorker {
        return ProjectWorker::query()->create([
            'project_id' => $project->id,
            'worker_id' => $worker->id,
            'assigned_by' => $this->owner->id,
            'status' => 'active',
            'joined_at' => '2026-09-21',
        ]);
    }

    private function createTask(
        Project $project,
        User $worker,
        string $status,
        int $sequence
    ): Task {
        return Task::query()->create([
            'project_id' => $project->id,
            'mandor_id' => $this->mandor->id,
            'worker_id' => $worker->id,
            'task_code' => sprintf(
                'TSK-WORKER-%03d',
                $sequence
            ),
            'title' => 'Task Penempatan '.$sequence,
            'priority' => 'medium',
            'status' => $status,
            'start_at' => '2026-09-21 08:00:00',
            'due_at' => '2026-09-30 17:00:00',
            'completed_at' => $status === 'completed'
                    ? now()
                    : null,
            'progress' => $status === 'completed'
                    ? 100
                    : 0,
            'weight' => 10,
        ]);
    }
}
