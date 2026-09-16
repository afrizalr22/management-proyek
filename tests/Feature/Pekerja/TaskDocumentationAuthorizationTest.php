<?php

namespace Tests\Feature\Pekerja;

use App\Livewire\Pekerja\Documentation\Create;
use App\Livewire\Pekerja\Documentation\Index as DocumentationIndex;
use App\Livewire\Pekerja\Tasks\Index as TaskIndex;
use App\Models\Client;
use App\Models\Documentation;
use App\Models\Project;
use App\Models\ProjectWorker;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class TaskDocumentationAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private User $mandor;

    private Project $project;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        foreach (
            [
                'mandor',
                'pekerja',
            ] as $role
        ) {
            Role::findOrCreate(
                $role,
                'web'
            );
        }

        $this->mandor = User::factory()->create([
            'name' => 'Mandor Dokumentasi',
            'status' => 'active',
        ]);

        $this->mandor->assignRole('mandor');

        $client = Client::query()->create([
            'company_name' =>
                'PT Dokumentasi Pengujian',
            'contact_person' =>
                'Kontak Dokumentasi',
        ]);

        $this->project = Project::query()->create([
            'client_id' => $client->id,
            'mandor_id' => $this->mandor->id,
            'project_code' => 'PRJ-DOC-001',
            'project_name' =>
                'Proyek Dokumentasi Pengujian',
            'location' => 'Jakarta',
            'start_date' => '2026-09-01',
            'status' => 'on_progress',
        ]);
    }

    private function createWorker(
        string $email
    ): User {
        $worker = User::factory()->create([
            'email' => $email,
            'status' => 'active',
        ]);

        $worker->assignRole('pekerja');

        ProjectWorker::query()->create([
            'project_id' => $this->project->id,
            'worker_id' => $worker->id,
            'assigned_by' => $this->mandor->id,
            'status' => 'active',
            'joined_at' => '2026-09-01',
        ]);

        return $worker;
    }

    private function createTask(
        User $worker,
        string $code,
        string $title,
        string $status = 'in_progress'
    ): Task {
        return Task::query()->create([
            'project_id' => $this->project->id,
            'mandor_id' => $this->mandor->id,
            'worker_id' => $worker->id,
            'task_code' => $code,
            'title' => $title,
            'location' => 'Jakarta',
            'priority' => 'medium',
            'status' => $status,
            'start_at' => '2026-09-01 08:00:00',
            'due_at' => '2026-09-30 17:00:00',
            'progress' => 25,
            'weight' => 1,
        ]);
    }

    private function createDocumentation(
        User $worker,
        Task $task,
        string $title,
        string $photo
    ): Documentation {
        return Documentation::query()->create([
            'project_id' => $this->project->id,
            'task_id' => $task->id,
            'daily_report_id' => null,
            'user_id' => $worker->id,
            'title' => $title,
            'category' => 'progress',
            'photo' => $photo,
            'original_name' => basename($photo),
            'mime_type' => 'image/jpeg',
            'file_size' => 1024,
            'description' =>
                'Dokumentasi '.$title,
            'documentation_date' =>
                '2026-09-16',
            'taken_at' =>
                '2026-09-16 08:00:00',
        ]);
    }

    public function test_worker_only_sees_own_tasks(): void
    {
        $worker = $this->createWorker(
            'task-worker@example.com'
        );

        $otherWorker = $this->createWorker(
            'other-task-worker@example.com'
        );

        $this->createTask(
            $worker,
            'TSK-OWN-001',
            'Task Milik Sendiri'
        );

        $this->createTask(
            $otherWorker,
            'TSK-OTHER-001',
            'Task Milik Pekerja Lain'
        );

        Livewire::actingAs($worker)
            ->test(TaskIndex::class)
            ->assertSee('Task Milik Sendiri')
            ->assertSee('TSK-OWN-001')
            ->assertDontSee(
                'Task Milik Pekerja Lain'
            )
            ->assertDontSee('TSK-OTHER-001');
    }

    public function test_worker_can_start_own_assigned_task(): void
    {
        $worker = $this->createWorker(
            'start-task-worker@example.com'
        );

        $task = $this->createTask(
            $worker,
            'TSK-START-001',
            'Task Akan Dimulai',
            'assigned'
        );

        Livewire::actingAs($worker)
            ->test(TaskIndex::class)
            ->call(
                'startTask',
                $task->id
            )
            ->assertHasNoErrors();

        $this->assertDatabaseHas(
            'tasks',
            [
                'id' => $task->id,
                'worker_id' => $worker->id,
                'status' => 'in_progress',
            ]
        );

        $this->assertNotNull(
            $task->fresh()->started_at
        );
    }

    public function test_worker_cannot_start_another_workers_task(): void
    {
        $worker = $this->createWorker(
            'unauthorized-task-worker@example.com'
        );

        $otherWorker = $this->createWorker(
            'task-owner@example.com'
        );

        $task = $this->createTask(
            $otherWorker,
            'TSK-FORBIDDEN-001',
            'Task Pekerja Lain',
            'assigned'
        );

        try {
            Livewire::actingAs($worker)
                ->test(TaskIndex::class)
                ->call(
                    'startTask',
                    $task->id
                );

            $this->fail(
                'Task milik pekerja lain seharusnya tidak dapat dimulai.'
            );
        } catch (ModelNotFoundException) {
            $this->assertTrue(true);
        }

        $this->assertDatabaseHas(
            'tasks',
            [
                'id' => $task->id,
                'worker_id' => $otherWorker->id,
                'status' => 'assigned',
            ]
        );
    }

    public function test_worker_only_sees_own_documentations(): void
    {
        $worker = $this->createWorker(
            'documentation-worker@example.com'
        );

        $otherWorker = $this->createWorker(
            'other-documentation-worker@example.com'
        );

        $ownTask = $this->createTask(
            $worker,
            'TSK-DOC-OWN',
            'Task Dokumentasi Sendiri'
        );

        $otherTask = $this->createTask(
            $otherWorker,
            'TSK-DOC-OTHER',
            'Task Dokumentasi Pekerja Lain'
        );

        $this->createDocumentation(
            $worker,
            $ownTask,
            'Dokumentasi Milik Sendiri',
            'documentations/own.jpg'
        );

        $this->createDocumentation(
            $otherWorker,
            $otherTask,
            'Dokumentasi Milik Pekerja Lain',
            'documentations/other.jpg'
        );

        Livewire::actingAs($worker)
            ->test(DocumentationIndex::class)
            ->assertSee(
                'Dokumentasi Milik Sendiri'
            )
            ->assertDontSee(
                'Dokumentasi Milik Pekerja Lain'
            );
    }

    public function test_worker_can_upload_documentation_for_own_task(): void
    {
        $disk = Storage::fake('public');

        $worker = $this->createWorker(
            'upload-documentation@example.com'
        );

        $task = $this->createTask(
            $worker,
            'TSK-UPLOAD-001',
            'Task Upload Sendiri'
        );

        $photo = UploadedFile::fake()->image(
            'progress.jpg',
            800,
            600
        )->size(500);

        Livewire::actingAs($worker)
            ->test(Create::class)
            ->set(
                'taskId',
                (string) $task->id
            )
            ->set(
                'category',
                'progress'
            )
            ->set(
                'description',
                'Progress pekerjaan hari ini.'
            )
            ->set(
                'photos',
                [
                    $photo,
                ]
            )
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'pekerja.documentation.index'
                )
            );

        $documentation = Documentation::query()
            ->where('user_id', $worker->id)
            ->where('task_id', $task->id)
            ->firstOrFail();

        $this->assertSame(
            $this->project->id,
            $documentation->project_id
        );

        $disk->assertExists(
            $documentation->photo
        );
    }

    public function test_worker_cannot_upload_to_another_workers_task(): void
    {
        $disk = Storage::fake('public');

        $worker = $this->createWorker(
            'manipulation-worker@example.com'
        );

        $otherWorker = $this->createWorker(
            'manipulation-target@example.com'
        );

        $otherTask = $this->createTask(
            $otherWorker,
            'TSK-MANIPULATED-001',
            'Task Target Manipulasi'
        );

        $photo = UploadedFile::fake()->image(
            'manipulated.jpg',
            800,
            600
        )->size(500);

        Livewire::actingAs($worker)
            ->test(Create::class)
            ->set(
                'taskId',
                (string) $otherTask->id
            )
            ->set(
                'category',
                'progress'
            )
            ->set(
                'description',
                'Percobaan manipulasi task.'
            )
            ->set(
                'photos',
                [
                    $photo,
                ]
            )
            ->call('save')
            ->assertHasErrors([
                'taskId',
            ]);

        $this->assertDatabaseMissing(
            'documentations',
            [
                'user_id' => $worker->id,
                'task_id' => $otherTask->id,
            ]
        );

        $this->assertSame(
            [],
            $disk->allFiles()
        );
    }
}