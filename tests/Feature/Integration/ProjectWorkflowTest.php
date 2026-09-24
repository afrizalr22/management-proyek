<?php

namespace Tests\Feature\Integration;

use App\Livewire\Mandor\DailyReports\Edit as MandorReportValidation;
use App\Livewire\Mandor\DailyReports\Show as MandorReportShow;
use App\Livewire\Mandor\Documentations\Index as MandorDocumentationsIndex;
use App\Livewire\Owner\Monitoring\Documentation as OwnerMonitoringDocumentation;
use App\Livewire\Owner\Monitoring\Index as OwnerMonitoring;
use App\Livewire\Owner\Monitoring\Show as OwnerMonitoringShow;
use App\Livewire\Pekerja\Report\Create as WorkerReportCreate;
use App\Livewire\Pekerja\Report\Edit as WorkerReportEdit;
use App\Models\Client;
use App\Models\DailyReport;
use App\Models\Documentation;
use App\Models\Project;
use App\Models\ProjectProgress;
use App\Models\ProjectWorker;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
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

        $this->assertNotNull(
            $assignment->ended_at
        );

        $this->assertFalse(
            $this->worker
                ->activeWorkerProjects()
                ->whereKey(
                    $this->project->id
                )
                ->exists()
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

    public function test_project_progress_history_appends_multiple_approved_reports(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Laporan pertama: 40%
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
                '2026-09-17'
            )
            ->set(
                'activities',
                'Pekerjaan tahap pertama telah mencapai empat puluh persen.'
            )
            ->set(
                'workStatus',
                'in_progress'
            )
            ->set(
                'reportedProgress',
                40
            )
            ->set(
                'obstacles',
                ''
            )
            ->set(
                'notes',
                'Progress tahap pertama.'
            )
            ->call('submitReport')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('pekerja.report.index')
            );

        $firstReport = DailyReport::query()
            ->where(
                'task_id',
                $this->task->id
            )
            ->whereDate(
                'report_date',
                '2026-09-17'
            )
            ->sole();

        $this->assertSame(
            'submitted',
            $firstReport->status
        );

        /*
        |--------------------------------------------------------------------------
        | Mandor approve laporan pertama
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->mandor)
            ->test(
                MandorReportValidation::class,
                [
                    'report' => $firstReport,
                ]
            )
            ->set(
                'reviewNotes',
                'Progress empat puluh persen disetujui.'
            )
            ->call('approveReport')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'mandor.daily-reports.show',
                    $firstReport->id
                )
            );

        $firstReport->refresh();
        $this->task->refresh();
        $this->project->refresh();

        $this->assertSame(
            'approved',
            $firstReport->status
        );

        $this->assertSame(
            40,
            $this->task->progress
        );

        $this->assertSame(
            40,
            $this->project->progress
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

        $firstHistory = ProjectProgress::query()
            ->where(
                'project_id',
                $this->project->id
            )
            ->orderBy('id')
            ->first();

        $this->assertNotNull(
            $firstHistory
        );

        $this->assertSame(
            40,
            $firstHistory->progress_percentage
        );

        /*
        |--------------------------------------------------------------------------
        | Laporan kedua: 70%
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
                'Pekerjaan tahap berikutnya telah mencapai tujuh puluh persen.'
            )
            ->set(
                'workStatus',
                'in_progress'
            )
            ->set(
                'reportedProgress',
                70
            )
            ->set(
                'obstacles',
                ''
            )
            ->set(
                'notes',
                'Progress tahap berikutnya.'
            )
            ->call('submitReport')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('pekerja.report.index')
            );

        $secondReport = DailyReport::query()
            ->where(
                'task_id',
                $this->task->id
            )
            ->whereDate(
                'report_date',
                '2026-09-18'
            )
            ->sole();

        $this->assertSame(
            'submitted',
            $secondReport->status
        );

        /*
        |--------------------------------------------------------------------------
        | Mandor approve laporan kedua
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->mandor)
            ->test(
                MandorReportValidation::class,
                [
                    'report' => $secondReport,
                ]
            )
            ->set(
                'reviewNotes',
                'Progress tujuh puluh persen disetujui.'
            )
            ->call('approveReport')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'mandor.daily-reports.show',
                    $secondReport->id
                )
            );

        $secondReport->refresh();
        $this->task->refresh();
        $this->project->refresh();

        $this->assertSame(
            'approved',
            $secondReport->status
        );

        $this->assertSame(
            70,
            $this->task->progress
        );

        $this->assertSame(
            70,
            $this->project->progress
        );

        /*
        |--------------------------------------------------------------------------
        | History harus bertambah, bukan overwrite
        |--------------------------------------------------------------------------
        */

        $histories = ProjectProgress::query()
            ->where(
                'project_id',
                $this->project->id
            )
            ->orderBy('id')
            ->get();

        $this->assertCount(
            2,
            $histories
        );

        $this->assertSame(
            40,
            $histories[0]->progress_percentage
        );

        $this->assertSame(
            70,
            $histories[1]->progress_percentage
        );

        $this->assertSame(
            $this->mandor->id,
            $histories[0]->user_id
        );

        $this->assertSame(
            $this->mandor->id,
            $histories[1]->user_id
        );

        $this->assertStringContainsString(
            '40%',
            $histories[0]->description
        );

        $this->assertStringContainsString(
            '70%',
            $histories[1]->description
        );

        /*
        |--------------------------------------------------------------------------
        | Record pertama harus tetap tersimpan
        |--------------------------------------------------------------------------
        */

        $this->assertDatabaseHas(
            'project_progress',
            [
                'id' => $firstHistory->id,
                'project_id' => $this->project->id,
                'progress_percentage' => 40,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Latest history harus 70%
        |--------------------------------------------------------------------------
        */

        $latestHistory = ProjectProgress::query()
            ->where(
                'project_id',
                $this->project->id
            )
            ->latest('id')
            ->first();

        $this->assertNotNull(
            $latestHistory
        );

        $this->assertSame(
            70,
            $latestHistory->progress_percentage
        );

        /*
        |--------------------------------------------------------------------------
        | Owner Monitoring harus membaca progress terbaru
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
                        && $project->progress === 70
                        && $project->approved_reports_count === 2;
                }
            )
            ->assertViewHas(
                'currentTask',
                fn (?Task $task): bool => $task?->id === $this->task->id
                    && $task->status === 'in_progress'
                    && $task->progress === 70
            );
    }

    public function test_report_documentation_flows_from_worker_to_mandor_and_owner(): void
    {
        Storage::fake('public');

        /*
        |--------------------------------------------------------------------------
        | Pekerja mengirim laporan + foto dokumentasi
        |--------------------------------------------------------------------------
        */

        $photo = UploadedFile::fake()->image(
            'progress-integration.jpg',
            800,
            600
        )->size(500);

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
                'Pekerjaan lapangan dan dokumentasi telah mencapai enam puluh persen.'
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
                'Dokumentasi pekerjaan dilampirkan.'
            )
            ->set(
                'photos',
                [
                    $photo,
                ]
            )
            ->call('submitReport')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('pekerja.report.index')
            );

        /*
        |--------------------------------------------------------------------------
        | Daily Report harus terbentuk
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Documentation harus terhubung penuh
        |--------------------------------------------------------------------------
        */

        $documentation = Documentation::query()
            ->where(
                'daily_report_id',
                $report->id
            )
            ->sole();

        $this->assertSame(
            $this->project->id,
            $documentation->project_id
        );

        $this->assertSame(
            $this->task->id,
            $documentation->task_id
        );

        $this->assertSame(
            $report->id,
            $documentation->daily_report_id
        );

        $this->assertSame(
            $this->worker->id,
            $documentation->user_id
        );

        $this->assertSame(
            'progress',
            $documentation->category
        );

        $this->assertSame(
            'progress-integration.jpg',
            $documentation->original_name
        );

        $this->assertSame(
            '2026-09-18',
            $documentation->documentation_date
                ->toDateString()
        );

        /*
        |--------------------------------------------------------------------------
        | File harus benar-benar tersimpan
        |--------------------------------------------------------------------------
        */

        $this->assertTrue(
            Storage::disk('public')->exists(
                $documentation->photo
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Mandor melihat dokumentasi pada Daily Report
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->mandor)
            ->test(
                MandorReportShow::class,
                [
                    'report' => $report,
                ]
            )
            ->assertViewHas(
                'report',
                function (DailyReport $reportData) use (
                    $documentation,
                    $report
                ): bool {
                    $reportDocumentation =
                        $reportData
                            ->documentations
                            ->firstWhere(
                                'id',
                                $documentation->id
                            );

                    return $reportData->id
                            === $report->id
                        && $reportDocumentation !== null
                        && $reportDocumentation
                            ->project_id
                            === $this->project->id
                        && $reportDocumentation
                            ->task_id
                            === $this->task->id
                        && $reportDocumentation
                            ->user_id
                            === $this->worker->id
                        && $reportDocumentation
                            ->getAttribute(
                                'photo_exists'
                            ) === true
                        && filled(
                            $reportDocumentation
                                ->getAttribute(
                                    'photo_url'
                                )
                        );
                }
            );

        /*
        |--------------------------------------------------------------------------
        | Owner melihat dokumentasi Project
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->owner)
            ->test(
                OwnerMonitoringDocumentation::class,
                [
                    'project' => $this->project,
                ]
            )
            ->assertSee(
                $documentation->title
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
            )
            ->assertViewHas(
                'documentations',
                function ($documentations) use (
                    $documentation,
                    $report
                ): bool {
                    $item = $documentations
                        ->getCollection()
                        ->firstWhere(
                            'id',
                            $documentation->id
                        );

                    return $item !== null
                        && $item->project_id
                            === $this->project->id
                        && $item->task_id
                            === $this->task->id
                        && $item->daily_report_id
                            === $report->id
                        && $item->user_id
                            === $this->worker->id;
                }
            );
    }

    public function test_mandor_global_documentation_gallery_filters_and_protects_project_scope(): void
    {
        Storage::fake('public');

        /*
        |--------------------------------------------------------------------------
        | Dokumentasi dari laporan Project utama
        |--------------------------------------------------------------------------
        */

        $mainReport = DailyReport::query()->create([
            'project_id' => $this->project->id,
            'task_id' => $this->task->id,
            'user_id' => $this->worker->id,
            'report_number' => 'RPT-GALLERY-001',
            'report_date' => '2026-09-18',
            'activities' => 'Dokumentasi Project utama.',
            'work_status' => 'in_progress',
            'reported_progress' => 40,
            'obstacles' => null,
            'notes' => 'Foto untuk pengujian gallery.',
            'submitted_at' => now(),
            'status' => 'approved',
        ]);

        $mainPhotoPath = 'documentations/testing/gallery-main.jpg';

        Storage::disk('public')->put(
            $mainPhotoPath,
            'fake-main-image'
        );

        $mainDocumentation = Documentation::query()->create([
            'project_id' => $this->project->id,
            'task_id' => $this->task->id,
            'daily_report_id' => $mainReport->id,
            'user_id' => $this->worker->id,
            'title' => 'Foto Gallery Project Utama',
            'category' => 'progress',
            'photo' => $mainPhotoPath,
            'original_name' => 'gallery-main.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 1024,
            'description' => 'Dokumentasi dari laporan harian.',
            'documentation_date' => '2026-09-18',
            'taken_at' => '2026-09-18 09:00:00',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Dokumentasi standalone tidak boleh muncul
        |--------------------------------------------------------------------------
        */

        $standalonePhotoPath =
            'documentations/testing/gallery-standalone.jpg';

        Storage::disk('public')->put(
            $standalonePhotoPath,
            'fake-standalone-image'
        );

        $standaloneDocumentation = Documentation::query()->create([
            'project_id' => $this->project->id,
            'task_id' => $this->task->id,
            'daily_report_id' => null,
            'user_id' => $this->worker->id,
            'title' => 'Foto Standalone Tidak Boleh Tampil',
            'category' => 'progress',
            'photo' => $standalonePhotoPath,
            'original_name' => 'gallery-standalone.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 1024,
            'description' => 'Dokumentasi tanpa laporan harian.',
            'documentation_date' => '2026-09-18',
            'taken_at' => '2026-09-18 09:05:00',
        ]);

        /*
|--------------------------------------------------------------------------
| Dokumentasi laporan submitted tidak boleh tampil
|--------------------------------------------------------------------------
*/

        $submittedReport = DailyReport::query()->create([
            'project_id' => $this->project->id,
            'task_id' => $this->task->id,
            'user_id' => $this->worker->id,
            'report_number' => 'RPT-GALLERY-SUBMITTED',
            'report_date' => '2026-09-18',
            'activities' => 'Dokumentasi masih menunggu validasi.',
            'work_status' => 'in_progress',
            'reported_progress' => 45,
            'obstacles' => null,
            'notes' => 'Belum disetujui Mandor.',
            'submitted_at' => now(),
            'status' => 'submitted',
        ]);

        $submittedPhotoPath =
            'documentations/testing/gallery-submitted.jpg';

        Storage::disk('public')->put(
            $submittedPhotoPath,
            'fake-submitted-image'
        );

        $submittedDocumentation = Documentation::query()->create([
            'project_id' => $this->project->id,
            'task_id' => $this->task->id,
            'daily_report_id' => $submittedReport->id,
            'user_id' => $this->worker->id,
            'title' => 'Foto Submitted Tidak Boleh Tampil',
            'category' => 'progress',
            'photo' => $submittedPhotoPath,
            'original_name' => 'gallery-submitted.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 1024,
            'description' => 'Dokumentasi masih menunggu validasi.',
            'documentation_date' => '2026-09-18',
            'taken_at' => '2026-09-18 09:10:00',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Dokumentasi laporan revision tidak boleh tampil
        |--------------------------------------------------------------------------
        */

        $revisionReport = DailyReport::query()->create([
            'project_id' => $this->project->id,
            'task_id' => $this->task->id,
            'user_id' => $this->worker->id,
            'report_number' => 'RPT-GALLERY-REVISION',
            'report_date' => '2026-09-18',
            'activities' => 'Dokumentasi sedang direvisi.',
            'work_status' => 'in_progress',
            'reported_progress' => 50,
            'obstacles' => null,
            'notes' => 'Perlu revisi dokumentasi.',
            'submitted_at' => now(),
            'status' => 'revision',
        ]);

        $revisionPhotoPath =
            'documentations/testing/gallery-revision.jpg';

        Storage::disk('public')->put(
            $revisionPhotoPath,
            'fake-revision-image'
        );

        $revisionDocumentation = Documentation::query()->create([
            'project_id' => $this->project->id,
            'task_id' => $this->task->id,
            'daily_report_id' => $revisionReport->id,
            'user_id' => $this->worker->id,
            'title' => 'Foto Revision Tidak Boleh Tampil',
            'category' => 'progress',
            'photo' => $revisionPhotoPath,
            'original_name' => 'gallery-revision.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 1024,
            'description' => 'Dokumentasi yang sedang direvisi.',
            'documentation_date' => '2026-09-18',
            'taken_at' => '2026-09-18 09:15:00',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Project kedua milik Mandor yang sama
        |--------------------------------------------------------------------------
        */

        $secondProject = Project::query()->create([
            'client_id' => $this->project->client_id,
            'mandor_id' => $this->mandor->id,
            'project_code' => 'PRJ-GALLERY-002',
            'project_name' => 'Project Gallery Kedua',
            'location' => 'Jakarta Pusat',
            'description' => 'Project kedua untuk filter gallery.',
            'start_date' => '2026-09-01',
            'end_date' => '2026-12-31',
            'progress' => 0,
            'status' => 'planning',
        ]);

        $secondTask = Task::query()->create([
            'project_id' => $secondProject->id,
            'mandor_id' => $this->mandor->id,
            'worker_id' => $this->worker->id,
            'task_code' => 'TSK-GALLERY-002',
            'title' => 'Task Gallery Kedua',
            'description' => 'Task kedua untuk pengujian filter.',
            'location' => 'Jakarta Pusat',
            'priority' => 'medium',
            'status' => 'in_progress',
            'start_at' => '2026-09-01 08:00:00',
            'due_at' => '2026-09-30 17:00:00',
            'started_at' => '2026-09-01 08:00:00',
            'progress' => 10,
            'weight' => 1,
        ]);

        $secondReport = DailyReport::query()->create([
            'project_id' => $secondProject->id,
            'task_id' => $secondTask->id,
            'user_id' => $this->worker->id,
            'report_number' => 'RPT-GALLERY-002',
            'report_date' => '2026-09-18',
            'activities' => 'Dokumentasi Project kedua.',
            'work_status' => 'in_progress',
            'reported_progress' => 20,
            'obstacles' => null,
            'notes' => 'Foto Project kedua.',
            'submitted_at' => now(),
            'status' => 'approved',
        ]);

        $secondPhotoPath =
            'documentations/testing/gallery-second.jpg';

        Storage::disk('public')->put(
            $secondPhotoPath,
            'fake-second-image'
        );

        $secondDocumentation = Documentation::query()->create([
            'project_id' => $secondProject->id,
            'task_id' => $secondTask->id,
            'daily_report_id' => $secondReport->id,
            'user_id' => $this->worker->id,
            'title' => 'Foto Gallery Project Kedua',
            'category' => 'progress',
            'photo' => $secondPhotoPath,
            'original_name' => 'gallery-second.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 2048,
            'description' => 'Dokumentasi Project kedua.',
            'documentation_date' => '2026-09-18',
            'taken_at' => '2026-09-18 10:00:00',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Dokumentasi Project Mandor lain tidak boleh bocor
        |--------------------------------------------------------------------------
        */

        $otherMandor = User::factory()->create([
            'name' => 'Mandor Lain',
            'status' => 'active',
        ]);

        $otherMandor->assignRole('mandor');

        $otherProject = Project::query()->create([
            'client_id' => $this->project->client_id,
            'mandor_id' => $otherMandor->id,
            'project_code' => 'PRJ-OTHER-001',
            'project_name' => 'Project Mandor Lain',
            'location' => 'Jakarta Barat',
            'description' => 'Project milik Mandor lain.',
            'start_date' => '2026-09-01',
            'end_date' => '2026-12-31',
            'progress' => 0,
            'status' => 'planning',
        ]);

        $otherTask = Task::query()->create([
            'project_id' => $otherProject->id,
            'mandor_id' => $otherMandor->id,
            'worker_id' => $this->worker->id,
            'task_code' => 'TSK-OTHER-001',
            'title' => 'Task Mandor Lain',
            'description' => 'Task yang tidak boleh terlihat.',
            'location' => 'Jakarta Barat',
            'priority' => 'low',
            'status' => 'in_progress',
            'start_at' => '2026-09-01 08:00:00',
            'due_at' => '2026-09-30 17:00:00',
            'started_at' => '2026-09-01 08:00:00',
            'progress' => 10,
            'weight' => 1,
        ]);

        $otherReport = DailyReport::query()->create([
            'project_id' => $otherProject->id,
            'task_id' => $otherTask->id,
            'user_id' => $this->worker->id,
            'report_number' => 'RPT-OTHER-001',
            'report_date' => '2026-09-18',
            'activities' => 'Dokumentasi Project Mandor lain.',
            'work_status' => 'in_progress',
            'reported_progress' => 10,
            'obstacles' => null,
            'notes' => null,
            'submitted_at' => now(),
            'status' => 'submitted',
        ]);

        $otherPhotoPath =
            'documentations/testing/gallery-other.jpg';

        Storage::disk('public')->put(
            $otherPhotoPath,
            'fake-other-image'
        );

        $otherDocumentation = Documentation::query()->create([
            'project_id' => $otherProject->id,
            'task_id' => $otherTask->id,
            'daily_report_id' => $otherReport->id,
            'user_id' => $this->worker->id,
            'title' => 'Foto Mandor Lain Tidak Boleh Tampil',
            'category' => 'progress',
            'photo' => $otherPhotoPath,
            'original_name' => 'gallery-other.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 1024,
            'description' => 'Tidak boleh terlihat oleh Mandor utama.',
            'documentation_date' => '2026-09-18',
            'taken_at' => '2026-09-18 11:00:00',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Route global dapat dibuka
        |--------------------------------------------------------------------------
        */

        $this->actingAs($this->mandor)
            ->get(
                route('mandor.documentations.index')
            )
            ->assertOk();

        /*
        |--------------------------------------------------------------------------
        | Gallery global
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->mandor)
            ->test(MandorDocumentationsIndex::class)
            ->assertSee(
                $mainDocumentation->title
            )
            ->assertSee(
                $secondDocumentation->title
            )
            ->assertDontSee(
                $standaloneDocumentation->title
            )

            ->assertDontSee(
                $submittedDocumentation->title
            )
            ->assertDontSee(
                $revisionDocumentation->title
            )
            ->assertDontSee(
                $otherDocumentation->title
            )
            ->assertSee(
                $this->project->project_name
            )
            ->assertSee(
                $this->project->project_code
            )
            ->assertSee(
                $this->task->title
            )
            ->assertSee(
                $this->task->task_code
            )
            ->assertViewHas(
                'totalDocumentations',
                2
            );

        /*
        |--------------------------------------------------------------------------
        | Filter Project
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->mandor)
            ->test(MandorDocumentationsIndex::class)
            ->set(
                'projectFilter',
                (string) $this->project->id
            )
            ->assertSee(
                $mainDocumentation->title
            )
            ->assertDontSee(
                $secondDocumentation->title
            )
            ->assertViewHas(
                'filteredDocumentations',
                1
            );

        /*
        |--------------------------------------------------------------------------
        | Filter Task
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->mandor)
            ->test(MandorDocumentationsIndex::class)
            ->set(
                'projectFilter',
                (string) $secondProject->id
            )
            ->set(
                'taskFilter',
                (string) $secondTask->id
            )
            ->assertSee(
                $secondDocumentation->title
            )
            ->assertDontSee(
                $mainDocumentation->title
            )
            ->assertViewHas(
                'filteredDocumentations',
                1
            );

        /*
        |--------------------------------------------------------------------------
        | Route lama tetap memilih Project dari URL
        |--------------------------------------------------------------------------
        */

        Livewire::actingAs($this->mandor)
            ->test(
                MandorDocumentationsIndex::class,
                [
                    'project' => $this->project,
                ]
            )
            ->assertSet(
                'projectFilter',
                (string) $this->project->id
            )
            ->assertSee(
                $mainDocumentation->title
            )
            ->assertDontSee(
                $secondDocumentation->title
            );
    }
}
