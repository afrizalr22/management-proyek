<?php

namespace Tests\Feature\Mandor;

use App\Livewire\Mandor\WorkProgress\Index;
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
            ->assertSee($this->project->project_name)
            ->assertSee('Buat Task');
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
                'workerId',
                $this->worker->id
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
                'priority',
                'high'
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
                'weight',
                '25.00'
            )
            ->set(
                'mandorNotes',
                'Gunakan perlengkapan keselamatan.'
            )
            ->call('createTask')
            ->assertHasNoErrors();

        $task = Task::query()->sole();

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
            '25.00',
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
            ->assertHasErrors([
                'workerId',
            ]);

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
            ->assertHasErrors([
                'workerId',
            ]);

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
            ->assertHasErrors([
                'workerId',
            ]);

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
                ->assertHasErrors([
                    'task',
                ]);
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

    public function test_total_active_task_weight_cannot_exceed_one_hundred(): void
    {
        Task::query()->create([
            'project_id' => $this->project->id,
            'mandor_id' => $this->mandor->id,
            'worker_id' => $this->worker->id,
            'task_code' => 'TSK-WEIGHT-EXISTING',
            'title' => 'Task Bobot Awal',
            'priority' => 'medium',
            'status' => 'assigned',
            'start_at' => '2026-09-20 08:00:00',
            'due_at' => '2026-09-25 17:00:00',
            'progress' => 0,
            'weight' => 80,
        ]);

        $this->taskForm(
            $this->worker,
            weight: '20.01'
        )
            ->call('createTask')
            ->assertHasErrors([
                'weight',
            ]);

        $this->assertSame(
            1,
            Task::query()->count()
        );
    }

    public function test_cancelled_task_weight_does_not_count_toward_active_weight(): void
    {
        Task::query()->create([
            'project_id' => $this->project->id,
            'mandor_id' => $this->mandor->id,
            'worker_id' => $this->worker->id,
            'task_code' => 'TSK-WEIGHT-CANCELLED',
            'title' => 'Task Dibatalkan',
            'priority' => 'medium',
            'status' => 'cancelled',
            'start_at' => '2026-09-20 08:00:00',
            'due_at' => '2026-09-25 17:00:00',
            'progress' => 0,
            'weight' => 90,
        ]);

        $this->taskForm(
            $this->worker,
            weight: '100.00'
        )
            ->call('createTask')
            ->assertHasNoErrors();

        $this->assertSame(
            2,
            Task::query()->count()
        );
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

    private function taskForm(
        User $worker,
        ?Project $project = null,
        string $weight = '10.00'
    ) {
        return Livewire::actingAs(
            $this->mandor
        )
            ->test(
                Index::class,
                [
                    'project' => $project ?? $this->project,
                ]
            )
            ->set(
                'workerId',
                $worker->id
            )
            ->set(
                'title',
                'Pekerjaan Pengujian'
            )
            ->set(
                'description',
                'Deskripsi pekerjaan pengujian.'
            )
            ->set(
                'location',
                'Lokasi Pengujian'
            )
            ->set(
                'priority',
                'medium'
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
                'weight',
                $weight
            )
            ->set(
                'mandorNotes',
                'Catatan pengujian.'
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
