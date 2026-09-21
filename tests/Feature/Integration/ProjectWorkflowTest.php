<?php

namespace Tests\Feature\Integration;

use App\Livewire\Mandor\DailyReports\Edit as MandorReportValidation;
use App\Livewire\Owner\Monitoring\Index as OwnerMonitoring;
use App\Livewire\Owner\Monitoring\Show as OwnerMonitoringShow;
use App\Livewire\Pekerja\Report\Create as WorkerReportCreate;
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
}
