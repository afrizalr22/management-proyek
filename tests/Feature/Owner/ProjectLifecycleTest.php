<?php

namespace Tests\Feature\Owner;

use App\Livewire\Mandor\DailyReports\Edit as ReportValidation;
use App\Livewire\Owner\Projects\Cancel;
use App\Livewire\Owner\Projects\Delete;
use App\Livewire\Owner\Projects\Delete as ProjectDelete;
use App\Livewire\Owner\Projects\Edit;
use App\Models\Client;
use App\Models\DailyReport;
use App\Models\Project;
use App\Models\ProjectWorker;
use App\Models\Quotation;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ProjectLifecycleTest extends TestCase
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
                'view projects',
                'update projects',
                'delete projects',
                'cancel projects',
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
            'view projects',
            'update projects',
            'delete projects',
            'cancel projects',
        ]);

        $this->owner = User::factory()->create([
            'name' => 'Owner Lifecycle',
            'status' => 'active',
        ]);

        $this->owner->assignRole('owner');

        $this->mandor = User::factory()->create([
            'name' => 'Mandor Lifecycle',
            'status' => 'active',
        ]);

        $this->mandor->assignRole('mandor');

        $this->worker = User::factory()->create([
            'name' => 'Pekerja Lifecycle',
            'status' => 'active',
        ]);

        $this->worker->assignRole('pekerja');

        $this->client = Client::query()->create([
            'company_name' => 'PT Lifecycle',
            'contact_person' => 'Kontak Lifecycle',
            'phone' => '0211234567',
            'email' => 'lifecycle@example.com',
            'city' => 'Jakarta',
            'status' => 'active',
            'address' => 'Jakarta Selatan',
        ]);

        $this->project = $this->createProject();

        ProjectWorker::query()->create([
            'project_id' => $this->project->id,
            'worker_id' => $this->worker->id,
            'assigned_by' => $this->owner->id,
            'status' => 'active',
            'joined_at' => '2026-09-01',
        ]);
    }

    public function test_project_is_completed_when_all_active_tasks_are_completed(): void
    {
        $task = $this->createTask(
            'TSK-LIFECYCLE-COMPLETE'
        );

        $report = $this->createReport(
            $task,
            'RPT-LIFECYCLE-COMPLETE',
            100,
            'completed'
        );

        $this->approveReport($report);

        $task->refresh();
        $this->project->refresh();

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
            'completed',
            $task->status
        );

        $this->assertSame(
            100,
            $this->project->progress
        );

        $this->assertSame(
            'completed',
            $this->project->status
        );

        /*
         * Ketika Project selesai, assignment Pekerja
         * harus otomatis ditutup agar Pekerja dapat
         * digunakan kembali pada Project lain.
         */
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
    }

    public function test_project_remains_in_progress_when_an_active_task_is_unfinished(): void
    {
        $completedTask = $this->createTask(
            'TSK-LIFECYCLE-FIRST',
            50
        );

        $unfinishedTask = $this->createTask(
            'TSK-LIFECYCLE-SECOND',
            50,
            'in_progress'
        );

        $report = $this->createReport(
            $completedTask,
            'RPT-LIFECYCLE-FIRST',
            100,
            'completed'
        );

        $this->approveReport($report);

        $this->project->refresh();
        $unfinishedTask->refresh();

        $this->assertSame(
            'in_progress',
            $unfinishedTask->status
        );

        $this->assertSame(
            75,
            $this->project->progress
        );

        $this->assertSame(
            'on_progress',
            $this->project->status
        );
    }

    public function test_cancelled_task_does_not_block_project_completion(): void
    {
        $task = $this->createTask(
            'TSK-LIFECYCLE-ACTIVE'
        );

        $this->createTask(
            'TSK-LIFECYCLE-CANCELLED',
            0,
            'cancelled'
        );

        $report = $this->createReport(
            $task,
            'RPT-LIFECYCLE-ACTIVE',
            100,
            'completed'
        );

        $this->approveReport($report);

        $this->project->refresh();

        $this->assertSame(
            100,
            $this->project->progress
        );

        $this->assertSame(
            'completed',
            $this->project->status
        );
    }

    public function test_owner_can_change_mandor_before_operational_data_exists(): void
    {
        $project = $this->createProject(
            'PRJ-MANDOR-CHANGE'
        );

        $newMandor = User::factory()->create([
            'name' => 'Mandor Pengganti',
            'status' => 'active',
        ]);

        $newMandor->assignRole('mandor');

        $this->updateProjectComponent(
            $project
        )
            ->set(
                'mandorId',
                $newMandor->id
            )
            ->call('updateProject')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.projects.show',
                    $project
                )
            );

        $this->assertSame(
            $newMandor->id,
            $project->fresh()->mandor_id
        );
    }

    public function test_owner_cannot_change_mandor_after_task_exists(): void
    {
        $newMandor = User::factory()->create([
            'name' => 'Mandor Tidak Diizinkan',
            'status' => 'active',
        ]);

        $newMandor->assignRole('mandor');

        $this->createTask(
            'TSK-MANDOR-LOCK'
        );

        $this->updateProjectComponent(
            $this->project
        )
            ->set(
                'mandorId',
                $newMandor->id
            )
            ->call('updateProject')
            ->assertHasErrors([
                'mandorId',
            ]);

        $this->assertSame(
            $this->mandor->id,
            $this->project
                ->fresh()
                ->mandor_id
        );
    }

    public function test_on_progress_project_information_can_still_be_updated(): void
    {
        $this->project->update([
            'status' => 'on_progress',
            'progress' => 40,
        ]);

        $this->updateProjectComponent(
            $this->project->fresh()
        )
            ->set(
                'projectName',
                'Project Lifecycle Diperbarui'
            )
            ->set(
                'location',
                'Jakarta Barat'
            )
            ->call('updateProject')
            ->assertHasNoErrors();

        $this->project->refresh();

        $this->assertSame(
            'Project Lifecycle Diperbarui',
            $this->project->project_name
        );

        $this->assertSame(
            'Jakarta Barat',
            $this->project->location
        );

        $this->assertSame(
            'on_progress',
            $this->project->status
        );

        $this->assertSame(
            40,
            $this->project->progress
        );
    }

    public function test_completed_and_cancelled_projects_cannot_be_edited(): void
    {
        foreach (
            [
                'completed',
                'cancelled',
            ] as $status
        ) {
            $project = $this->createProject(
                'PRJ-LOCK-'.strtoupper($status),
                $status
            );

            Livewire::actingAs($this->owner)
                ->test(
                    Edit::class,
                    [
                        'project' => $project,
                    ]
                )
                ->assertForbidden();
        }
    }

    public function test_owner_can_cancel_project_and_close_operational_data(): void
    {
        $this->project->update([
            'status' => 'on_progress',
            'progress' => 55,
        ]);

        $activeTask = $this->createTask(
            'TSK-CANCEL-ACTIVE',
            55,
            'in_progress'
        );

        $completedTask = $this->createTask(
            'TSK-CANCEL-COMPLETED',
            100,
            'completed'
        );

        $completedTask->update([
            'completed_at' => now(),
        ]);

        $alreadyCancelledTask = $this->createTask(
            'TSK-CANCEL-EXISTING',
            20,
            'cancelled'
        );

        $assignment = ProjectWorker::query()
            ->updateOrCreate(
                [
                    'project_id' => $this->project->id,

                    'worker_id' => $this->worker->id,
                ],
                [
                    'assigned_by' => $this->owner->id,

                    'status' => 'active',

                    'joined_at' => '2026-09-01',

                    'ended_at' => null,
                ]
            );

        Livewire::actingAs($this->owner)
            ->test(
                Cancel::class,
                [
                    'project' => $this->project,
                ]
            )
            ->set(
                'cancellationReason',
                'Project dibatalkan berdasarkan keputusan operasional dari pihak client.'
            )
            ->call('cancelProject')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.projects.show',
                    [
                        'project' => $this->project->id,
                    ]
                )
            );

        $this->project->refresh();
        $activeTask->refresh();
        $completedTask->refresh();
        $alreadyCancelledTask->refresh();
        $assignment->refresh();

        $this->assertSame(
            'cancelled',
            $this->project->status
        );

        /*
         * Progress terakhir Project harus tetap disimpan.
         */
        $this->assertSame(
            55,
            $this->project->progress
        );

        $this->assertSame(
            $this->owner->id,
            $this->project->cancelled_by
        );

        $this->assertNotNull(
            $this->project->cancelled_at
        );

        $this->assertSame(
            'Project dibatalkan berdasarkan keputusan operasional dari pihak client.',
            $this->project->cancellation_reason
        );

        /*
         * Task aktif dihentikan.
         */
        $this->assertSame(
            'cancelled',
            $activeTask->status
        );

        /*
         * Task yang sudah selesai tidak boleh diubah.
         */
        $this->assertSame(
            'completed',
            $completedTask->status
        );

        $this->assertSame(
            100,
            $completedTask->progress
        );

        $this->assertNotNull(
            $completedTask->completed_at
        );

        /*
         * Task yang memang sudah cancelled tetap cancelled.
         */
        $this->assertSame(
            'cancelled',
            $alreadyCancelledTask->status
        );

        /*
         * Assignment aktif harus ditutup.
         */
        $this->assertSame(
            'inactive',
            $assignment->status
        );

        $this->assertNotNull(
            $assignment->ended_at
        );

        $this->actingAs($this->owner)
            ->get(
                route(
                    'owner.projects.show',
                    [
                        'project' => $this->project->id,
                    ]
                )
            )
            ->assertOk()
            ->assertSee('Dibatalkan')
            ->assertSee('Informasi Pembatalan')
            ->assertSee(
                'Project dibatalkan berdasarkan keputusan operasional dari pihak client.'
            )
            ->assertSee(
                $this->owner->name
            )
            ->assertDontSee(
                'Batalkan Project'
            );
    }

    public function test_owner_can_open_project_cancellation_page(): void
    {
        $this->actingAs($this->owner)
            ->get(
                route(
                    'owner.projects.cancel',
                    [
                        'project' => $this->project->id,
                    ]
                )
            )
            ->assertOk()
            ->assertSee(
                'Batalkan Project'
            )
            ->assertSee(
                $this->project->project_code
            )
            ->assertSee(
                'Alasan Pembatalan'
            );
    }

    public function test_project_cancellation_requires_valid_reason(): void
    {
        Livewire::actingAs($this->owner)
            ->test(
                Cancel::class,
                [
                    'project' => $this->project,
                ]
            )
            ->set(
                'cancellationReason',
                'Pendek'
            )
            ->call('cancelProject')
            ->assertHasErrors([
                'cancellationReason',
            ]);

        $this->project->refresh();

        $this->assertSame(
            'planning',
            $this->project->status
        );

        $this->assertNull(
            $this->project->cancelled_at
        );

        $this->assertNull(
            $this->project->cancelled_by
        );

        $this->assertNull(
            $this->project->cancellation_reason
        );
    }

    public function test_completed_and_cancelled_projects_cannot_be_cancelled(): void
    {
        foreach (
            [
                'completed',
                'cancelled',
            ] as $status
        ) {
            $project = $this->createProject(
                'PRJ-CANCEL-'.strtoupper(
                    $status
                ),
                $status
            );

            Livewire::actingAs($this->owner)
                ->test(
                    Cancel::class,
                    [
                        'project' => $project,
                    ]
                )
                ->assertStatus(409);
        }
    }

    public function test_user_without_permission_cannot_cancel_project(): void
    {
        $unauthorizedUser =
            User::factory()->create([
                'status' => 'active',
            ]);

        $unauthorizedUser->assignRole(
            'mandor'
        );

        Livewire::actingAs(
            $unauthorizedUser
        )
            ->test(
                Cancel::class,
                [
                    'project' => $this->project,
                ]
            )
            ->assertForbidden();

        $this->project->refresh();

        $this->assertSame(
            'planning',
            $this->project->status
        );
    }

    public function test_clean_planning_project_can_be_deleted_and_quotation_is_released(): void
    {
        $project = $this->createProject(
            'PRJ-DELETE-CLEAN'
        );

        $quotation = $this->createQuotation(
            $project
        );

        Livewire::actingAs($this->owner)
            ->test(Delete::class)
            ->call(
                'openDeleteModal',
                $project->id
            )
            ->assertSet('showModal', true)
            ->call('deleteProject')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('owner.projects.index')
            );

        $this->assertDatabaseMissing(
            'projects',
            [
                'id' => $project->id,
            ]
        );

        $this->assertDatabaseHas(
            'quotations',
            [
                'id' => $quotation->id,
                'project_id' => null,
            ]
        );
    }

    public function test_planning_project_with_inactive_worker_assignment_can_be_deleted_and_quotation_is_released(): void
    {
        $project = $this->createProject(
            'PRJ-INACTIVE-WORKER-DELETE'
        );

        $quotation = $this->createQuotation(
            $project
        );

        /*
         * Project pernah mempunyai Pekerja aktif.
         */
        $assignment = ProjectWorker::query()->create([
            'project_id' => $project->id,
            'worker_id' => $this->worker->id,
            'assigned_by' => $this->owner->id,
            'status' => 'active',
            'joined_at' => now(),
        ]);

        $this->assertDatabaseHas(
            'project_workers',
            [
                'id' => $assignment->id,
                'project_id' => $project->id,
                'worker_id' => $this->worker->id,
                'status' => 'active',
            ]
        );

        /*
         * Pekerja kemudian dilepas dari Project.
         * Assignment tetap menjadi histori tetapi inactive.
         */
        $assignment->update([
            'status' => 'inactive',
            'ended_at' => now(),
        ]);

        $this->assertDatabaseHas(
            'project_workers',
            [
                'id' => $assignment->id,
                'project_id' => $project->id,
                'worker_id' => $this->worker->id,
                'status' => 'inactive',
            ]
        );

        /*
         * Project planning tanpa data operasional
         * harus tetap dapat dihapus walaupun pernah
         * mempunyai histori assignment Pekerja.
         */
        Livewire::actingAs($this->owner)
            ->test(ProjectDelete::class)
            ->call(
                'openDeleteModal',
                $project->id
            )
            ->call('deleteProject')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('owner.projects.index')
            );

        /*
         * Project benar-benar terhapus.
         */
        $this->assertDatabaseMissing(
            'projects',
            [
                'id' => $project->id,
            ]
        );

        /*
         * Histori assignment inactive ikut dibersihkan
         * karena Project sudah dihapus permanen.
         */
        $this->assertDatabaseMissing(
            'project_workers',
            [
                'id' => $assignment->id,
            ]
        );

        /*
         * Quotation tidak ikut dihapus dan hubungan
         * dengan Project lama harus dilepas.
         */
        $quotation->refresh();

        $this->assertNull(
            $quotation->project_id
        );

        $this->assertDatabaseHas(
            'quotations',
            [
                'id' => $quotation->id,
                'status' => 'approved',
                'project_id' => null,
            ]
        );
    }

    public function test_project_with_operational_data_cannot_be_deleted(): void
    {
        $this->createTask(
            'TSK-DELETE-BLOCK'
        );

        Livewire::actingAs($this->owner)
            ->test(Delete::class)
            ->call(
                'openDeleteModal',
                $this->project->id
            )
            ->call('deleteProject')
            ->assertHasErrors([
                'delete',
            ]);

        $this->assertDatabaseHas(
            'projects',
            [
                'id' => $this->project->id,
            ]
        );
    }

    public function test_non_planning_project_cannot_be_deleted(): void
    {
        $project = $this->createProject(
            'PRJ-DELETE-RUNNING',
            'on_progress'
        );

        Livewire::actingAs($this->owner)
            ->test(Delete::class)
            ->call(
                'openDeleteModal',
                $project->id
            )
            ->call('deleteProject')
            ->assertHasErrors([
                'delete',
            ]);

        $this->assertDatabaseHas(
            'projects',
            [
                'id' => $project->id,
            ]
        );
    }

    public function test_user_without_permissions_cannot_edit_or_delete_project(): void
    {
        $unauthorizedUser = User::factory()->create([
            'status' => 'active',
        ]);

        $unauthorizedUser->assignRole('mandor');

        Livewire::actingAs($unauthorizedUser)
            ->test(
                Edit::class,
                [
                    'project' => $this->project,
                ]
            )
            ->assertForbidden();

        Livewire::actingAs($unauthorizedUser)
            ->test(Delete::class)
            ->call(
                'openDeleteModal',
                $this->project->id
            )
            ->assertForbidden();
    }

    private function approveReport(
        DailyReport $report
    ): void {
        Livewire::actingAs($this->mandor)
            ->test(
                ReportValidation::class,
                [
                    'report' => $report,
                ]
            )
            ->call('approveReport')
            ->assertHasNoErrors();
    }

    private function updateProjectComponent(
        Project $project
    ) {
        return Livewire::actingAs($this->owner)
            ->test(
                Edit::class,
                [
                    'project' => $project,
                ]
            );
    }

    private function createProject(
        string $code = 'PRJ-LIFECYCLE-001',
        string $status = 'planning'
    ): Project {
        return Project::query()->create([
            'client_id' => $this->client->id,
            'mandor_id' => $this->mandor->id,
            'project_code' => $code,
            'project_name' => 'Project Lifecycle',
            'location' => 'Jakarta Selatan',
            'description' => 'Project untuk pengujian lifecycle.',
            'contract_number' => 'SPK-LIFECYCLE',
            'contract_date' => '2026-09-01',
            'project_budget' => 800000,
            'contract_value' => 1000000,
            'start_date' => '2026-09-01',
            'end_date' => '2026-12-31',
            'progress' => $status === 'completed'
                    ? 100
                    : 0,
            'status' => $status,
        ]);
    }

    private function createTask(
        string $code,
        int $progress = 20,
        string $status = 'submitted'
    ): Task {
        return Task::query()->create([
            'project_id' => $this->project->id,
            'mandor_id' => $this->mandor->id,
            'worker_id' => $this->worker->id,
            'task_code' => $code,
            'title' => 'Task '.$code,
            'location' => 'Jakarta',
            'priority' => 'medium',
            'status' => $status,
            'start_at' => '2026-09-01 08:00:00',
            'started_at' => $status === 'cancelled'
                    ? null
                    : '2026-09-01 08:00:00',
            'submitted_at' => $status === 'submitted'
                    ? now()
                    : null,
            'due_at' => '2026-09-30 17:00:00',
            'progress' => $progress,
            'weight' => 1,
        ]);
    }

    private function createReport(
        Task $task,
        string $number,
        int $progress,
        string $workStatus
    ): DailyReport {
        return DailyReport::query()->create([
            'report_number' => $number,
            'project_id' => $this->project->id,
            'task_id' => $task->id,
            'user_id' => $this->worker->id,
            'report_date' => '2026-09-21',
            'reported_progress' => $progress,
            'work_status' => $workStatus,
            'activities' => 'Aktivitas pengujian lifecycle Project.',
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);
    }

    private function createQuotation(
        Project $project
    ): Quotation {
        return Quotation::query()->create([
            'client_id' => $this->client->id,
            'project_id' => $project->id,
            'created_by' => $this->owner->id,
            'quotation_number' => 'QT-LIFECYCLE-'.$project->id,
            'quotation_date' => '2026-09-01',
            'valid_until' => '2026-09-30',
            'client_name' => $this->client->company_name,
            'client_contact_person' => $this->client->contact_person,
            'client_phone' => $this->client->phone,
            'client_email' => $this->client->email,
            'client_address' => $this->client->address,
            'project_name' => $project->project_name,
            'project_location' => $project->location,
            'subtotal' => 1000000,
            'grand_total' => 1000000,
            'status' => 'approved',
            'sent_at' => now()->subDay(),
            'approved_at' => now(),
        ]);
    }

    public function test_project_cannot_be_cancelled_if_status_changes_after_cancel_page_is_opened(): void
    {
        $component = Livewire::actingAs($this->owner)
            ->test(Cancel::class, [
                'project' => $this->project,
            ]);

        $this->project->update([
            'status' => 'completed',
            'progress' => 100,
        ]);

        $component
            ->set(
                'cancellationReason',
                'Project tidak jadi dilanjutkan oleh pihak client.'
            )
            ->call('cancelProject')
            ->assertHasErrors([
                'cancel',
            ]);

        $this->project->refresh();

        $this->assertSame(
            'completed',
            $this->project->status
        );

        $this->assertSame(
            100,
            $this->project->progress
        );

        $this->assertNull(
            $this->project->cancelled_at
        );

        $this->assertNull(
            $this->project->cancelled_by
        );

        $this->assertNull(
            $this->project->cancellation_reason
        );
    }

    public function test_project_cannot_be_updated_if_cancelled_after_edit_page_is_opened(): void
    {
        $component = Livewire::actingAs($this->owner)
            ->test(Edit::class, [
                'project' => $this->project,
            ]);

        $this->project->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancelled_by' => $this->owner->id,
            'cancellation_reason' => 'Project dibatalkan saat halaman edit masih terbuka.',
        ]);

        $component
            ->set(
                'projectName',
                'Project Seharusnya Tidak Berubah'
            )
            ->call('updateProject')
            ->assertStatus(409);

        $this->project->refresh();

        $this->assertSame(
            'cancelled',
            $this->project->status
        );

        $this->assertNotSame(
            'Project Seharusnya Tidak Berubah',
            $this->project->project_name
        );

        $this->assertNotNull(
            $this->project->cancelled_at
        );

        $this->assertSame(
            $this->owner->id,
            $this->project->cancelled_by
        );
    }
}
