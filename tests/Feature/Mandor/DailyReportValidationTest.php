<?php

namespace Tests\Feature\Mandor;

use App\Livewire\Mandor\DailyReports\Edit;
use App\Models\Client;
use App\Models\DailyReport;
use App\Models\Project;
use App\Models\ProjectProgress;
use App\Models\ProjectWorker;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class DailyReportValidationTest extends TestCase
{
    use RefreshDatabase;

    private User $mandor;

    private User $worker;

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
            'name' => 'Mandor Utama',
            'status' => 'active',
        ]);

        $this->mandor->assignRole('mandor');

        $this->worker = User::factory()->create([
            'name' => 'Pekerja Laporan',
            'status' => 'active',
        ]);

        $this->worker->assignRole('pekerja');

        $client = Client::query()->create([
            'company_name' => 'PT Validasi',
            'contact_person' => 'Kontak Validasi',
        ]);

        $this->project = Project::query()->create([
            'client_id' => $client->id,
            'mandor_id' => $this->mandor->id,
            'project_code' => 'PRJ-VALIDATION-001',
            'project_name' => 'Proyek Validasi',
            'location' => 'Jakarta',
            'start_date' => '2026-09-01',
            'progress' => 0,
            'status' => 'planning',
        ]);

        ProjectWorker::query()->create([
            'project_id' => $this->project->id,
            'worker_id' => $this->worker->id,
            'assigned_by' => $this->mandor->id,
            'status' => 'active',
            'joined_at' => '2026-09-01',
        ]);
    }

    private function createTask(
        string $code,
        int $progress = 20,
        float $weight = 1
    ): Task {
        return Task::query()->create([
            'project_id' => $this->project->id,
            'mandor_id' => $this->mandor->id,
            'worker_id' => $this->worker->id,
            'task_code' => $code,
            'title' => 'Task '.$code,
            'location' => 'Jakarta',
            'priority' => 'medium',
            'status' => 'submitted',
            'start_at' => '2026-09-01 08:00:00',
            'started_at' => '2026-09-01 08:00:00',
            'submitted_at' => now(),
            'due_at' => '2026-09-30 17:00:00',
            'progress' => $progress,
            'weight' => $weight,
        ]);
    }

    private function createReport(
        Task $task,
        string $number,
        int $progress = 60,
        string $workStatus = 'in_progress',
        string $status = 'submitted'
    ): DailyReport {
        return DailyReport::query()->create([
            'report_number' => $number,
            'project_id' => $this->project->id,
            'task_id' => $task->id,
            'user_id' => $this->worker->id,
            'report_date' => '2026-09-16',
            'reported_progress' => $progress,
            'work_status' => $workStatus,
            'activities' => 'Aktivitas pengujian validasi laporan.',
            'status' => $status,
            'submitted_at' => now(),
        ]);
    }

    public function test_project_mandor_can_open_submitted_report_validation(): void
    {
        $task = $this->createTask(
            'TSK-OPEN-001'
        );

        $report = $this->createReport(
            $task,
            'RPT-OPEN-001'
        );

        $this->actingAs($this->mandor)
            ->get(
                route(
                    'mandor.daily-reports.validate',
                    [
                        'report' => $report->id,
                    ]
                )
            )
            ->assertOk()
            ->assertSee('RPT-OPEN-001');
    }

    public function test_other_mandor_cannot_validate_report(): void
    {
        $task = $this->createTask(
            'TSK-OTHER-MANDOR'
        );

        $report = $this->createReport(
            $task,
            'RPT-OTHER-MANDOR'
        );

        $otherMandor = User::factory()->create([
            'status' => 'active',
        ]);

        $otherMandor->assignRole('mandor');

        $this->actingAs($otherMandor)
            ->get(
                route(
                    'mandor.daily-reports.validate',
                    [
                        'report' => $report->id,
                    ]
                )
            )
            ->assertForbidden();
    }

    public function test_mandor_can_approve_report_and_synchronize_progress(): void
    {
        $task = $this->createTask(
            'TSK-APPROVE-001',
            20
        );

        $report = $this->createReport(
            $task,
            'RPT-APPROVE-001',
            60
        );

        Livewire::actingAs($this->mandor)
            ->test(
                Edit::class,
                [
                    'report' => $report,
                ]
            )
            ->set(
                'reviewNotes',
                'Pekerjaan telah diperiksa.'
            )
            ->call('approveReport')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'mandor.daily-reports.show',
                    $report->id
                )
            );

        $report->refresh();
        $task->refresh();
        $this->project->refresh();

        $this->assertSame(
            'approved',
            $report->status
        );

        $this->assertSame(
            $this->mandor->id,
            $report->reviewed_by
        );

        $this->assertNotNull(
            $report->reviewed_at
        );

        $this->assertSame(
            60,
            $task->progress
        );

        $this->assertSame(
            'in_progress',
            $task->status
        );

        $this->assertSame(
            60,
            $this->project->progress
        );

        $this->assertSame(
            'on_progress',
            $this->project->status
        );

        $this->assertDatabaseHas(
            'project_progress',
            [
                'project_id' => $this->project->id,
                'user_id' => $this->mandor->id,
                'progress_percentage' => 60,
            ]
        );

        $this->assertSame(
            1,
            ProjectProgress::query()
                ->where(
                    'project_id',
                    $this->project->id
                )
                ->count()
        );
    }

    public function test_project_progress_is_calculated_from_multiple_task_weights(): void
    {
        /*
        * Task A:
        * Weight   = 60
        * Progress awal = 20
        * Setelah laporan disetujui = 50
        *
        * Task B:
        * Weight   = 40
        * Progress = 100
        *
        * Expected:
        * ((50 × 60) + (100 × 40)) / 100
        * = 70
        */

        $taskA = $this->createTask(
            'TSK-WEIGHT-A',
            20,
            60
        );

        $taskB = $this->createTask(
            'TSK-WEIGHT-B',
            100,
            40
        );

        $taskB->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        $report = $this->createReport(
            $taskA,
            'RPT-WEIGHT-001',
            50
        );

        Livewire::actingAs($this->mandor)
            ->test(
                Edit::class,
                [
                    'report' => $report,
                ]
            )
            ->set(
                'reviewNotes',
                'Progress Task A telah diperiksa.'
            )
            ->call('approveReport')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'mandor.daily-reports.show',
                    $report->id
                )
            );

        $report->refresh();
        $taskA->refresh();
        $taskB->refresh();
        $this->project->refresh();

        $this->assertSame(
            'approved',
            $report->status
        );

        $this->assertSame(
            50,
            $taskA->progress
        );

        $this->assertSame(
            'in_progress',
            $taskA->status
        );

        $this->assertSame(
            100,
            $taskB->progress
        );

        $this->assertSame(
            'completed',
            $taskB->status
        );

        $this->assertSame(
            70,
            $this->project->progress
        );

        $this->assertSame(
            'on_progress',
            $this->project->status
        );

        $this->assertDatabaseHas(
            'project_progress',
            [
                'project_id' => $this->project->id,
                'user_id' => $this->mandor->id,
                'progress_percentage' => 70,
            ]
        );

        $progressHistory = ProjectProgress::query()
            ->where(
                'project_id',
                $this->project->id
            )
            ->latest('id')
            ->first();

        $this->assertNotNull(
            $progressHistory
        );

        $this->assertSame(
            70,
            $progressHistory->progress_percentage
        );
    }

    public function test_completed_report_completes_task(): void
    {
        $task = $this->createTask(
            'TSK-COMPLETE-001',
            80
        );

        $report = $this->createReport(
            $task,
            'RPT-COMPLETE-001',
            100,
            'completed'
        );

        Livewire::actingAs($this->mandor)
            ->test(
                Edit::class,
                [
                    'report' => $report,
                ]
            )
            ->call('approveReport')
            ->assertHasNoErrors();

        $task->refresh();
        $this->project->refresh();

        $this->assertSame(
            'completed',
            $task->status
        );

        $this->assertSame(
            100,
            $task->progress
        );

        $this->assertNotNull(
            $task->completed_at
        );

        $this->assertSame(
            100,
            $this->project->progress
        );
    }

    public function test_invalid_completed_report_cannot_be_approved(): void
    {
        $task = $this->createTask(
            'TSK-INVALID-COMPLETE',
            50
        );

        $report = $this->createReport(
            $task,
            'RPT-INVALID-COMPLETE',
            90,
            'completed'
        );

        Livewire::actingAs($this->mandor)
            ->test(
                Edit::class,
                [
                    'report' => $report,
                ]
            )
            ->call('approveReport')
            ->assertHasErrors([
                'decision',
            ]);

        $this->assertSame(
            'submitted',
            $report->fresh()->status
        );

        $this->assertSame(
            'submitted',
            $task->fresh()->status
        );
    }

    public function test_mandor_can_request_revision(): void
    {
        $task = $this->createTask(
            'TSK-REVISION-001',
            40
        );

        $report = $this->createReport(
            $task,
            'RPT-REVISION-001',
            50
        );

        Livewire::actingAs($this->mandor)
            ->test(
                Edit::class,
                [
                    'report' => $report,
                ]
            )
            ->set(
                'reviewNotes',
                'Mohon perbaiki uraian hasil pekerjaan.'
            )
            ->call('requestRevision')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'mandor.daily-reports.show',
                    $report->id
                )
            );

        $report->refresh();
        $task->refresh();

        $this->assertSame(
            'revision',
            $report->status
        );

        $this->assertSame(
            'revision',
            $task->status
        );

        $this->assertSame(
            $this->mandor->id,
            $report->reviewed_by
        );

        $this->assertSame(
            'Mohon perbaiki uraian hasil pekerjaan.',
            $report->review_notes
        );
    }

    public function test_revision_requires_sufficient_notes(): void
    {
        $task = $this->createTask(
            'TSK-NOTES-001'
        );

        $report = $this->createReport(
            $task,
            'RPT-NOTES-001'
        );

        Livewire::actingAs($this->mandor)
            ->test(
                Edit::class,
                [
                    'report' => $report,
                ]
            )
            ->set(
                'reviewNotes',
                'Singkat'
            )
            ->call('requestRevision')
            ->assertHasErrors([
                'reviewNotes' => 'min',
            ]);

        $this->assertSame(
            'submitted',
            $report->fresh()->status
        );

        $this->assertSame(
            'submitted',
            $task->fresh()->status
        );
    }

    public function test_processed_report_cannot_be_validated_again(): void
    {
        $task = $this->createTask(
            'TSK-PROCESSED-001',
            100
        );

        $report = $this->createReport(
            $task,
            'RPT-PROCESSED-001',
            100,
            'completed',
            'approved'
        );

        $this->actingAs($this->mandor)
            ->get(
                route(
                    'mandor.daily-reports.validate',
                    [
                        'report' => $report->id,
                    ]
                )
            )
            ->assertStatus(409);
    }
}
