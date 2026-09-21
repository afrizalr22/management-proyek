<?php

namespace Tests\Feature\Integration;

use App\Livewire\Mandor\DailyReports\Edit as MandorReportValidation;
use App\Livewire\Owner\Monitoring\Index as OwnerMonitoring;
use App\Livewire\Owner\Monitoring\Show as OwnerMonitoringShow;
use App\Livewire\Pekerja\Report\Create as WorkerReportCreate;
use App\Livewire\Pekerja\Report\Edit as WorkerReportEdit;
use App\Models\Client;
use App\Models\DailyReport;
use App\Models\Project;
use App\Models\ProjectProgress;
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

class ProjectWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;

    private User $mandor;

    private User $worker;

    private Project $project;

    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse(
                '2026-09-18 09:00:00',
                'Asia/Jakarta'
            )
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
            'name' => 'Owner Integrasi',
            'status' => 'active',
        ]);

        $this->owner->assignRole('owner');

        $this->mandor = User::factory()->create([
            'name' => 'Mandor Integrasi',
            'status' => 'active',
        ]);

        $this->mandor->assignRole('mandor');

        $this->worker = User::factory()->create([
            'name' => 'Pekerja Integrasi',
            'status' => 'active',
        ]);

        $this->worker->assignRole('pekerja');

        $client = Client::query()->create([
            'company_name' => 'PT Integrasi Sistem',
            'contact_person' => 'Kontak Integrasi',
            'phone' => '0211234567',
            'email' => 'integrasi@example.com',
            'address' => 'Jakarta Selatan',
        ]);

        $this->project = Project::query()->create([
            'client_id' => $client->id,
            'mandor_id' => $this->mandor->id,
            'project_code' => 'PRJ-INTEGRATION-001',
            'project_name' => 'Proyek Integrasi Sistem',
            'location' => 'Jakarta Selatan',
            'description' => 'Project pengujian alur lintas peran.',
            'start_date' => '2026-09-01',
            'end_date' => '2026-12-31',
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

        $this->task = Task::query()->create([
            'project_id' => $this->project->id,
            'mandor_id' => $this->mandor->id,
            'worker_id' => $this->worker->id,
            'task_code' => 'TSK-INTEGRATION-001',
            'title' => 'Pekerjaan Integrasi Sistem',
            'description' => 'Task untuk pengujian alur sistem.',
            'location' => 'Jakarta Selatan',
            'priority' => 'high',
            'status' => 'in_progress',
            'start_at' => '2026-09-01 08:00:00',
            'due_at' => '2026-09-30 17:00:00',
            'started_at' => '2026-09-01 08:00:00',
            'progress' => 20,
            'weight' => 1,
        ]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_complete_project_reporting_workflow_across_roles(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Pekerja mengirim laporan
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->worker)
            ->test(WorkerReportCreate::class)
            ->set(
                'taskId',
                (string) $this->task->id
            )
            ->set(
                'reportDate',
                '2026-09-18'
            )
            ->set(
                'activities',
                'Pekerjaan lapangan telah mencapai progres enam puluh persen.'
            )
            ->set(
                'workStatus',
                'in_progress'
            )
            ->set(
                'reportedProgress',
                60
            )
            ->set(
                'obstacles',
                ''
            )
            ->set(
                'notes',
                'Pekerjaan berjalan sesuai rencana.'
            )
            ->call('submitReport')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('pekerja.report.index')
            );

        $report = DailyReport::query()
            ->where(
                'task_id',
                $this->task->id
            )
            ->where(
                'user_id',
                $this->worker->id
            )
            ->sole();

        $this->assertSame(
            'submitted',
            $report->status
        );

        $this->assertSame(
            60,
            $report->reported_progress
        );

        $this->assertNotNull(
            $report->report_number
        );

        $this->assertSame(
            'submitted',
            $this->task->fresh()->status
        );

        /*
        |--------------------------------------------------------------------------
        | Mandor menyetujui laporan
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->mandor)
            ->test(
                MandorReportValidation::class,
                [
                    'report' => $report,
                ]
            )
            ->set(
                'reviewNotes',
                'Laporan telah diperiksa dan disetujui.'
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
        $this->task->refresh();
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
            'Laporan telah diperiksa dan disetujui.',
            $report->review_notes
        );

        $this->assertSame(
            'in_progress',
            $this->task->status
        );

        $this->assertSame(
            60,
            $this->task->progress
        );

        $this->assertSame(
            'on_progress',
            $this->project->status
        );

        $this->assertSame(
            60,
            $this->project->progress
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
            $this->mandor->id,
            $progressHistory->user_id
        );

        $this->assertSame(
            60,
            $progressHistory->progress_percentage
        );

        $this->assertStringContainsString(
            '60%',
            $progressHistory->description
        );

        /*
        |--------------------------------------------------------------------------
        | Owner melihat hasil sinkronisasi
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->owner)
            ->test(OwnerMonitoring::class)
            ->assertSee(
                $this->project->project_name
            )
            ->assertViewHas(
                'statistics',
                fn (array $statistics): bool => $statistics['total'] === 1
                    && $statistics['in_progress'] === 1
                    && $statistics['completed'] === 0
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
                        && $project->status
                            === 'on_progress'
                        && $project->progress === 60;
                }
            );

        Livewire::actingAs($this->owner)
            ->test(
                OwnerMonitoringShow::class,
                [
                    'project' => $this->project,
                ]
            )
            ->assertSee(
                $this->project->project_code
            )
            ->assertSee(
                $this->task->title
            )
            ->assertViewHas(
                'projectData',
                function (Project $project): bool {
                    return $project->status
                            === 'on_progress'
                        && $project->progress === 60
                        && $project->approved_reports_count
                            === 1;
                }
            )
            ->assertViewHas(
                'currentTask',
                fn (?Task $task): bool => $task?->id === $this->task->id
                    && $task->status
                        === 'in_progress'
                    && $task->progress === 60
            );
    }

    public function test_project_is_completed_end_to_end_when_worker_finishes_all_work(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Pekerja menyelesaikan Task 100%
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->worker)
            ->test(WorkerReportCreate::class)
            ->set(
                'taskId',
                (string) $this->task->id
            )
            ->set(
                'reportDate',
                '2026-09-18'
            )
            ->set(
                'activities',
                'Seluruh pekerjaan pada Task telah diselesaikan.'
            )
            ->set(
                'workStatus',
                'completed'
            )
            ->set(
                'reportedProgress',
                100
            )
            ->set(
                'obstacles',
                ''
            )
            ->set(
                'notes',
                'Pekerjaan telah selesai seluruhnya.'
            )
            ->call('submitReport')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('pekerja.report.index')
            );

        $report = DailyReport::query()
            ->where(
                'task_id',
                $this->task->id
            )
            ->where(
                'user_id',
                $this->worker->id
            )
            ->sole();

        $this->assertSame(
            'submitted',
            $report->status
        );

        $this->assertSame(
            'completed',
            $report->work_status
        );

        $this->assertSame(
            100,
            $report->reported_progress
        );

        $this->assertSame(
            'submitted',
            $this->task->fresh()->status
        );

        /*
        |--------------------------------------------------------------------------
        | Mandor menyetujui laporan selesai
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->mandor)
            ->test(
                MandorReportValidation::class,
                [
                    'report' => $report,
                ]
            )
            ->set(
                'reviewNotes',
                'Pekerjaan telah diperiksa dan dinyatakan selesai.'
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
        $this->task->refresh();
        $this->project->refresh();

        /*
        |--------------------------------------------------------------------------
        | Laporan harus selesai diproses
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Task harus selesai
        |--------------------------------------------------------------------------
        */

        $this->assertSame(
            'completed',
            $this->task->status
        );

        $this->assertSame(
            100,
            $this->task->progress
        );

        $this->assertNotNull(
            $this->task->completed_at
        );

        /*
        |--------------------------------------------------------------------------
        | Project harus otomatis selesai
        |--------------------------------------------------------------------------
        */

        $this->assertSame(
            'completed',
            $this->project->status
        );

        $this->assertSame(
            100,
            $this->project->progress
        );

        /*
        |--------------------------------------------------------------------------
        | Histori progress 100% harus tercatat
        |--------------------------------------------------------------------------
        */

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
            $this->mandor->id,
            $progressHistory->user_id
        );

        $this->assertSame(
            100,
            $progressHistory->progress_percentage
        );

        $this->assertStringContainsString(
            '100%',
            $progressHistory->description
        );

        /*
        |--------------------------------------------------------------------------
        | Owner Monitoring harus membaca Project sebagai completed
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->owner)
            ->test(OwnerMonitoring::class)
            ->assertSee(
                $this->project->project_name
            )
            ->assertViewHas(
                'statistics',
                fn (array $statistics): bool => $statistics['total'] === 1
                    && $statistics['in_progress'] === 0
                    && $statistics['completed'] === 1
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
                        && $project->status === 'completed'
                        && $project->progress === 100;
                }
            );

        /*
        |--------------------------------------------------------------------------
        | Detail Monitoring Owner harus membaca kondisi terakhir
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->owner)
            ->test(
                OwnerMonitoringShow::class,
                [
                    'project' => $this->project,
                ]
            )
            ->assertSee(
                $this->project->project_code
            )
            ->assertSee(
                $this->task->title
            )
            ->assertViewHas(
                'projectData',
                function (Project $project): bool {
                    return $project->status === 'completed'
                        && $project->progress === 100
                        && $project->approved_reports_count === 1;
                }
            );
    }

    public function test_report_revision_can_be_resubmitted_and_approved_end_to_end(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Pekerja mengirim laporan awal 60%
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->worker)
            ->test(WorkerReportCreate::class)
            ->set(
                'taskId',
                (string) $this->task->id
            )
            ->set(
                'reportDate',
                '2026-09-18'
            )
            ->set(
                'activities',
                'Pekerjaan tahap awal telah mencapai enam puluh persen.'
            )
            ->set(
                'workStatus',
                'in_progress'
            )
            ->set(
                'reportedProgress',
                60
            )
            ->set(
                'obstacles',
                ''
            )
            ->set(
                'notes',
                'Laporan awal pekerjaan.'
            )
            ->call('submitReport')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('pekerja.report.index')
            );

        $report = DailyReport::query()
            ->where(
                'task_id',
                $this->task->id
            )
            ->where(
                'user_id',
                $this->worker->id
            )
            ->sole();

        $this->assertSame(
            'submitted',
            $report->status
        );

        $this->assertSame(
            'submitted',
            $this->task->fresh()->status
        );

        /*
        |--------------------------------------------------------------------------
        | Mandor meminta revisi
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->mandor)
            ->test(
                MandorReportValidation::class,
                [
                    'report' => $report,
                ]
            )
            ->set(
                'reviewNotes',
                'Mohon lengkapi hasil pekerjaan dan perbarui progress laporan.'
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
        $this->task->refresh();

        $this->assertSame(
            'revision',
            $report->status
        );

        $this->assertSame(
            'revision',
            $this->task->status
        );

        $this->assertSame(
            $this->mandor->id,
            $report->reviewed_by
        );

        $this->assertNotNull(
            $report->reviewed_at
        );

        $this->assertSame(
            'Mohon lengkapi hasil pekerjaan dan perbarui progress laporan.',
            $report->review_notes
        );

        /*
        |--------------------------------------------------------------------------
        | Revisi belum boleh menghasilkan histori progress Project
        |--------------------------------------------------------------------------
        */

        $this->assertDatabaseCount(
            'project_progress',
            0
        );

        /*
        |--------------------------------------------------------------------------
        | Pekerja memperbaiki laporan menjadi 80%
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->worker)
            ->test(
                WorkerReportEdit::class,
                [
                    'report' => $report->id,
                ]
            )
            ->assertSet(
                'reportedProgress',
                60
            )
            ->assertSet(
                'reviewNotes',
                'Mohon lengkapi hasil pekerjaan dan perbarui progress laporan.'
            )
            ->set(
                'activities',
                'Pekerjaan telah diperbaiki dan progress terbaru mencapai delapan puluh persen.'
            )
            ->set(
                'workStatus',
                'in_progress'
            )
            ->set(
                'reportedProgress',
                80
            )
            ->set(
                'obstacles',
                ''
            )
            ->set(
                'notes',
                'Perbaikan laporan telah dilakukan sesuai arahan Mandor.'
            )
            ->call('resubmitReport')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('pekerja.report.index')
            );

        $report->refresh();
        $this->task->refresh();

        /*
        |--------------------------------------------------------------------------
        | Setelah resubmit laporan kembali menunggu Mandor
        |--------------------------------------------------------------------------
        */

        $this->assertSame(
            'submitted',
            $report->status
        );

        $this->assertSame(
            80,
            $report->reported_progress
        );

        $this->assertSame(
            'in_progress',
            $report->work_status
        );

        $this->assertSame(
            'submitted',
            $this->task->status
        );

        /*
         * Progress Task belum berubah sebelum
         * laporan revisi disetujui Mandor.
         */
        $this->assertSame(
            20,
            $this->task->progress
        );

        /*
         * Metadata review lama harus dibersihkan
         * ketika laporan dikirim ulang.
         */
        $this->assertNull(
            $report->reviewed_by
        );

        $this->assertNull(
            $report->reviewed_at
        );

        $this->assertNull(
            $report->review_notes
        );

        /*
        |--------------------------------------------------------------------------
        | Mandor menyetujui laporan hasil revisi
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->mandor)
            ->test(
                MandorReportValidation::class,
                [
                    'report' => $report,
                ]
            )
            ->set(
                'reviewNotes',
                'Perbaikan laporan sudah sesuai dan disetujui.'
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
        $this->task->refresh();
        $this->project->refresh();

        /*
        |--------------------------------------------------------------------------
        | Hasil akhir setelah approval
        |--------------------------------------------------------------------------
        */

        $this->assertSame(
            'approved',
            $report->status
        );

        $this->assertSame(
            $this->mandor->id,
            $report->reviewed_by
        );

        $this->assertSame(
            'Perbaikan laporan sudah sesuai dan disetujui.',
            $report->review_notes
        );

        $this->assertSame(
            'in_progress',
            $this->task->status
        );

        $this->assertSame(
            80,
            $this->task->progress
        );

        $this->assertSame(
            'on_progress',
            $this->project->status
        );

        $this->assertSame(
            80,
            $this->project->progress
        );

        /*
        |--------------------------------------------------------------------------
        | Approval hasil revisi menghasilkan histori ProjectProgress
        |--------------------------------------------------------------------------
        */

        $this->assertDatabaseHas(
            'project_progress',
            [
                'project_id' => $this->project->id,
                'user_id' => $this->mandor->id,
                'progress_percentage' => 80,
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
            80,
            $progressHistory->progress_percentage
        );

        /*
        |--------------------------------------------------------------------------
        | Owner Monitoring membaca hasil akhir revisi
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->owner)
            ->test(
                OwnerMonitoringShow::class,
                [
                    'project' => $this->project,
                ]
            )
            ->assertViewHas(
                'projectData',
                function (Project $project): bool {
                    return $project->status === 'on_progress'
                        && $project->progress === 80
                        && $project->approved_reports_count === 1;
                }
            )
            ->assertViewHas(
                'currentTask',
                fn (?Task $task): bool => $task?->id === $this->task->id
                    && $task->status === 'in_progress'
                    && $task->progress === 80
            );
    }
}
