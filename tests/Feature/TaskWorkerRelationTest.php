<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TaskWorkerRelationTest extends TestCase
{
    use RefreshDatabase;

    private Project $project;

    private User $worker;

    protected function setUp(): void
    {
        parent::setUp();

        $mandor = User::factory()->create();
        $this->worker = User::factory()->create();

        $client = Client::query()->create([
            'company_name' => 'Client Pengujian',
            'contact_person' => 'Kontak Pengujian',
        ]);

        $this->project = Project::query()->create([
            'client_id' => $client->id,
            'mandor_id' => $mandor->id,
            'project_code' => 'PRJ-MULTI-WORKER',
            'project_name' => 'Project Multi Worker',
            'start_date' => '2026-10-12',
            'end_date' => '2026-11-12',
            'status' => 'planning',
            'progress' => 0,
        ]);
    }

    public function test_task_can_have_one_worker(): void
    {
        $task = $this->createTask();

        $task->workers()->attach($this->worker->id);

        $this->assertSame(
            [$this->worker->id],
            $task->workers()->pluck('users.id')->all()
        );

        $this->assertDatabaseHas('task_workers', [
            'task_id' => $task->id,
            'worker_id' => $this->worker->id,
        ]);

        $assignment = DB::table('task_workers')
            ->where('task_id', $task->id)
            ->where('worker_id', $this->worker->id)
            ->first();

        $this->assertNotNull($assignment->created_at);
        $this->assertNotNull($assignment->updated_at);
    }

    public function test_task_can_have_multiple_workers(): void
    {
        $task = $this->createTask();
        $otherWorker = User::factory()->create();

        $task->workers()->attach([
            $this->worker->id,
            $otherWorker->id,
        ]);

        $this->assertEqualsCanonicalizing(
            [$this->worker->id, $otherWorker->id],
            $task->workers()->pluck('users.id')->all()
        );

        $this->assertSame(2, $task->workers()->count());

        // Relasi lama tetap tersedia selama transisi.
        $this->assertSame(
            $this->worker->id,
            $task->fresh()->worker_id
        );

        $this->assertTrue(
            $task->fresh()->worker->is($this->worker)
        );
    }

    public function test_user_tasks_only_returns_assigned_tasks(): void
    {
        $assignedTask = $this->createTask();
        $otherWorker = User::factory()->create();
        $otherTask = $this->createTask('assigned', $otherWorker);

        $assignedTask->workers()->attach($this->worker->id);
        $otherTask->workers()->attach($otherWorker->id);

        $this->assertSame(
            [$assignedTask->id],
            $this->worker->tasks()->pluck('tasks.id')->all()
        );

        $this->assertSame(
            [$otherTask->id],
            $otherWorker->tasks()->pluck('tasks.id')->all()
        );
    }

    public function test_duplicate_task_worker_is_rejected(): void
    {
        $task = $this->createTask();

        $task->workers()->attach($this->worker->id);

        $this->expectException(QueryException::class);

        $task->workers()->attach($this->worker->id);
    }

    public function test_migration_preserves_legacy_assignments_and_history(): void
    {
        $tasks = [];

        foreach (['assigned', 'completed', 'cancelled'] as $status) {
            $tasks[] = $this->createTask($status);
        }

        $migration = require database_path(
            'migrations/2026_10_12_200155_create_task_workers_table.php'
        );

        // Simulasikan database sebelum migration baru dijalankan.
        $migration->down();
        $migration->up();

        $this->assertDatabaseCount('task_workers', 3);

        foreach ($tasks as $task) {
            $this->assertDatabaseHas('task_workers', [
                'task_id' => $task->id,
                'worker_id' => $this->worker->id,
            ]);

            $this->assertDatabaseHas('tasks', [
                'id' => $task->id,
                'worker_id' => $this->worker->id,
                'status' => $task->status,
                'progress' => $task->progress,
            ]);

            $this->assertTrue(
                $task->fresh()->workers->contains(
                    'id',
                    $this->worker->id
                )
            );
        }
    }

    private function createTask(
        string $status = 'assigned',
        ?User $worker = null
    ): Task {
        $worker ??= $this->worker;

        return Task::query()->create([
            'project_id' => $this->project->id,
            'mandor_id' => $this->project->mandor_id,
            'worker_id' => $worker->id,
            'task_code' => 'TSK-RELATION-'.fake()->uuid(),
            'title' => 'Task Pengujian Relasi',
            'priority' => 'medium',
            'status' => $status,
            'progress' => $status === 'completed' ? 100 : 0,
            'completed_at' => $status === 'completed' ? now() : null,
            'weight' => 10,
        ]);
    }
}