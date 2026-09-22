<?php

namespace Tests\Feature\Pekerja;

use App\Livewire\Pekerja\Report\Create;
use App\Models\Client;
use App\Models\DailyReport;
use App\Models\Documentation;
use App\Models\Project;
use App\Models\ProjectWorker;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ReportCreationTest extends TestCase
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
            'name' => 'Mandor Laporan',
            'status' => 'active',
        ]);

        $this->mandor->assignRole('mandor');

        $client = Client::query()->create([
            'company_name' => 'PT Laporan',
            'contact_person' => 'Kontak Laporan',
        ]);

        $this->project = Project::query()->create([
            'client_id' => $client->id,
            'mandor_id' => $this->mandor->id,
            'project_code' => 'PRJ-REPORT-001',
            'project_name' => 'Proyek Laporan',
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
        int $progress = 25
    ): Task {
        return Task::query()->create([
            'project_id' => $this->project->id,
            'mandor_id' => $this->mandor->id,
            'worker_id' => $worker->id,
            'task_code' => $code,
            'title' => 'Task '.$code,
            'location' => 'Jakarta',
            'priority' => 'medium',
            'status' => 'in_progress',
            'start_at' => '2026-09-01 08:00:00',
            'started_at' => '2026-09-01 08:00:00',
            'due_at' => '2026-09-30 17:00:00',
            'progress' => $progress,
            'weight' => 1,
        ]);
    }

    private function validReportData(
        Task $task
    ): array {
        return [
            'taskId' => (string) $task->id,
            'reportDate' => now('Asia/Jakarta')
                ->toDateString(),
            'activities' => 'Melaksanakan pekerjaan sesuai rencana proyek.',
            'workStatus' => 'in_progress',
            'reportedProgress' => 50,
            'obstacles' => '',
            'notes' => '',
        ];
    }

    public function test_worker_can_submit_report_for_own_task(): void
    {
        $disk = Storage::fake('public');

        $worker = $this->createWorker(
            'report-worker@example.com'
        );

        $task = $this->createTask(
            $worker,
            'TSK-REPORT-001'
        );

        $photo = UploadedFile::fake()->image(
            'report-progress.jpg',
            800,
            600
        )->size(500);

        $component = Livewire::actingAs($worker)
            ->test(Create::class);

        foreach (
            $this->validReportData($task) as $property => $value
        ) {
            $component->set(
                $property,
                $value
            );
        }

        $component
            ->set('photos', [$photo])
            ->call('submitReport')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('pekerja.report.index')
            );

        $report = DailyReport::query()
            ->where('user_id', $worker->id)
            ->where('task_id', $task->id)
            ->firstOrFail();

        $this->assertSame(
            'submitted',
            $report->status
        );

        $this->assertSame(
            50,
            $report->reported_progress
        );

        $this->assertNotNull(
            $report->report_number
        );

        $this->assertDatabaseHas(
            'tasks',
            [
                'id' => $task->id,
                'status' => 'submitted',
            ]
        );

        $documentation = Documentation::query()
            ->where(
                'daily_report_id',
                $report->id
            )
            ->firstOrFail();

        $this->assertSame(
            $worker->id,
            $documentation->user_id
        );

        $this->assertSame(
            $task->id,
            $documentation->task_id
        );

        $disk->assertExists(
            $documentation->photo
        );
    }

    public function test_worker_cannot_submit_report_for_another_workers_task(): void
    {
        $disk = Storage::fake('public');

        $worker = $this->createWorker(
            'manipulation-report@example.com'
        );

        $otherWorker = $this->createWorker(
            'target-report@example.com'
        );

        $otherTask = $this->createTask(
            $otherWorker,
            'TSK-REPORT-OTHER'
        );

        $photo = UploadedFile::fake()->image(
            'unauthorized-report.jpg'
        );

        $component = Livewire::actingAs($worker)
            ->test(Create::class);

        foreach (
            $this->validReportData($otherTask) as $property => $value
        ) {
            $component->set(
                $property,
                $value
            );
        }

        $component
            ->set('photos', [$photo])
            ->call('submitReport')
            ->assertHasErrors([
                'taskId',
            ]);

        $this->assertDatabaseMissing(
            'daily_reports',
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

    public function test_duplicate_daily_report_is_rejected(): void
    {
        $worker = $this->createWorker(
            'duplicate-report@example.com'
        );

        $task = $this->createTask(
            $worker,
            'TSK-DUPLICATE-001'
        );

        $reportDate = now('Asia/Jakarta')
            ->toDateString();

        DailyReport::query()->create([
            'report_number' => 'RPT-DUPLICATE-001',
            'project_id' => $this->project->id,
            'task_id' => $task->id,
            'user_id' => $worker->id,
            'report_date' => $reportDate,
            'reported_progress' => 30,
            'work_status' => 'in_progress',
            'activities' => 'Laporan yang sudah tersedia.',
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        $component = Livewire::actingAs($worker)
            ->test(Create::class);

        foreach (
            $this->validReportData($task) as $property => $value
        ) {
            $component->set(
                $property,
                $value
            );
        }

        $component
            ->call('submitReport')
            ->assertHasErrors([
                'submit',
            ]);

        $this->assertSame(
            1,
            DailyReport::query()
                ->where('user_id', $worker->id)
                ->where('task_id', $task->id)
                ->whereDate(
                    'report_date',
                    $reportDate
                )
                ->count()
        );

        $this->assertSame(
            'in_progress',
            $task->fresh()->status
        );
    }

    public function test_report_progress_cannot_be_lower_than_task_progress(): void
    {
        $worker = $this->createWorker(
            'progress-report@example.com'
        );

        $task = $this->createTask(
            $worker,
            'TSK-PROGRESS-001',
            60
        );

        $component = Livewire::actingAs($worker)
            ->test(Create::class);

        foreach (
            $this->validReportData($task) as $property => $value
        ) {
            $component->set(
                $property,
                $value
            );
        }

        $component
            ->set('reportedProgress', 50)
            ->call('submitReport')
            ->assertHasErrors([
                'submit',
            ]);

        $this->assertDatabaseMissing(
            'daily_reports',
            [
                'user_id' => $worker->id,
                'task_id' => $task->id,
            ]
        );

        $this->assertSame(
            'in_progress',
            $task->fresh()->status
        );
    }

    public function test_completed_work_requires_one_hundred_percent_progress(): void
    {
        $worker = $this->createWorker(
            'completed-report@example.com'
        );

        $task = $this->createTask(
            $worker,
            'TSK-COMPLETED-001'
        );

        $component = Livewire::actingAs($worker)
            ->test(Create::class);

        foreach (
            $this->validReportData($task) as $property => $value
        ) {
            $component->set(
                $property,
                $value
            );
        }

        $component
            ->set('workStatus', 'completed')
            ->set('reportedProgress', 99)
            ->call('submitReport')
            ->assertHasErrors([
                'reportedProgress',
            ]);

        $this->assertDatabaseMissing(
            'daily_reports',
            [
                'user_id' => $worker->id,
                'task_id' => $task->id,
            ]
        );
    }

    public function test_in_progress_work_cannot_use_one_hundred_percent_progress(): void
    {
        $worker = $this->createWorker(
            'in-progress-report@example.com'
        );

        $task = $this->createTask(
            $worker,
            'TSK-IN-PROGRESS-001'
        );

        $component = Livewire::actingAs($worker)
            ->test(Create::class);

        foreach (
            $this->validReportData($task) as $property => $value
        ) {
            $component->set(
                $property,
                $value
            );
        }

        $component
            ->set('workStatus', 'in_progress')
            ->set('reportedProgress', 100)
            ->call('submitReport')
            ->assertHasErrors([
                'reportedProgress',
            ]);

        $this->assertDatabaseMissing(
            'daily_reports',
            [
                'user_id' => $worker->id,
                'task_id' => $task->id,
            ]
        );
    }

    public function test_worker_cannot_submit_report_after_project_is_cancelled(): void
    {
        $disk = Storage::fake('public');

        $worker = $this->createWorker(
            'cancelled-project-report@example.com'
        );

        $task = $this->createTask(
            $worker,
            'TSK-CANCELLED-REPORT-001'
        );

        $photo = UploadedFile::fake()->image(
            'cancelled-project-report.jpg',
            800,
            600
        )->size(500);

        /*
         * Form laporan dibuka ketika Project
         * masih aktif.
         */
        $component = Livewire::actingAs($worker)
            ->test(Create::class);

        foreach (
            $this->validReportData($task) as $property => $value
        ) {
            $component->set(
                $property,
                $value
            );
        }

        $component->set(
            'photos',
            [
                $photo,
            ]
        );

        /*
         * Simulasikan Project dibatalkan setelah
         * form laporan sudah dibuka.
         *
         * Task sengaja tetap in_progress agar test
         * benar-benar menguji lifecycle Project.
         */
        $this->project->update([
            'status' => 'cancelled',
        ]);

        $component
            ->call('submitReport')
            ->assertHasErrors([
                'submit' => 'Project sudah selesai atau dibatalkan. Laporan tidak dapat dikirim lagi.',
            ]);

        $this->assertDatabaseMissing(
            'daily_reports',
            [
                'user_id' => $worker->id,
                'task_id' => $task->id,
            ]
        );

        $task->refresh();

        $this->assertSame(
            'in_progress',
            $task->status
        );

        $this->assertNull(
            $task->submitted_at
        );

        $this->assertSame(
            [],
            $disk->allFiles()
        );
    }
}
