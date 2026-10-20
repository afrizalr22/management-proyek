<?php

namespace Tests\Feature\Pekerja;

use App\Livewire\Pekerja\Report\Create;
use App\Livewire\Pekerja\Report\Edit as ReportEdit;
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
        $task = Task::query()->create([
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

        $task->workers()->attach($worker->id);

        return $task;
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

    private function reportForm(User $worker, Task $task)
    {
        $component = Livewire::actingAs($worker)
            ->test(Create::class);

        foreach ($this->validReportData($task) as $property => $value) {
            $component->set($property, $value);
        }
        return $component;
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
        $worker = $this->createWorker('duplicate-report@example.com');

        $task = $this->createTask(
            $worker,
            'TSK-DUPLICATE-001'
        );

        // Form sudah terisi sebelum laporan lain tersedia.
        $component = $this->reportForm($worker, $task);

        DailyReport::query()->create([
            'report_number' => 'RPT-DUPLICATE-001',
            'project_id' => $this->project->id,
            'task_id' => $task->id,
            'user_id' => $worker->id,
            'report_date' => now('Asia/Jakarta')->toDateString(),
            'reported_progress' => 30,
            'work_status' => 'in_progress',
            'activities' => 'Laporan yang sudah tersedia.',
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        // Task sengaja tetap in_progress untuk menguji pemeriksaan laporan.
        $component
            ->call('submitReport')
            ->assertHasErrors('submit');

        $this->assertDatabaseCount('daily_reports', 1);
        $this->assertSame('in_progress', $task->fresh()->status);
    }

    public function test_second_member_can_submit_report_and_photos(): void
    {
        $disk = Storage::fake('public');

        $firstWorker = $this->createWorker('report-first@example.com');
        $secondWorker = $this->createWorker('report-second@example.com');

        $task = $this->createTask($firstWorker, 'TSK-SHARED-REPORT');
        $task->workers()->attach($secondWorker->id);

        $this->reportForm($secondWorker, $task)
            ->set('photos', [
                UploadedFile::fake()->image('shared-progress.jpg'),
            ])
            ->call('submitReport')
            ->assertHasNoErrors()
            ->assertRedirect(route('pekerja.report.index'));

        $report = DailyReport::query()->sole();
        $documentation = Documentation::query()->sole();

        $this->assertSame($secondWorker->id, $report->user_id);
        $this->assertSame($task->id, $report->task_id);
        $this->assertSame('submitted', $report->status);

        $this->assertSame($secondWorker->id, $documentation->user_id);
        $this->assertSame($report->id, $documentation->daily_report_id);

        $this->assertSame('submitted', $task->fresh()->status);

        // Progres resmi belum berubah sebelum approval Mandor.
        $this->assertSame(25, $task->fresh()->progress);

        $disk->assertExists($documentation->photo);
    }

    public function test_another_member_cannot_submit_from_stale_form(): void
    {
        $disk = Storage::fake('public');

        $firstWorker = $this->createWorker('stale-first@example.com');
        $secondWorker = $this->createWorker('stale-second@example.com');

        $task = $this->createTask($firstWorker, 'TSK-STALE-REPORT');
        $task->workers()->attach($secondWorker->id);

        // Anggota kedua sudah membuka dan mengisi form.
        $secondForm = $this->reportForm($secondWorker, $task)
            ->set('photos', [
                UploadedFile::fake()->image('second-worker.jpg'),
            ]);

        $this->reportForm($firstWorker, $task)
            ->call('submitReport')
            ->assertHasNoErrors();

        $this->actingAs($secondWorker);

        $secondForm
            ->call('submitReport')
            ->assertHasErrors('submit');

        $report = DailyReport::query()->sole();

        $this->assertSame($firstWorker->id, $report->user_id);
        $this->assertSame('submitted', $task->fresh()->status);
        $this->assertDatabaseCount('documentations', 0);
        $this->assertSame([], $disk->allFiles());

        Livewire::actingAs($secondWorker)
            ->test(Create::class)
            ->assertViewHas(
                'availableTasks',
                fn ($tasks): bool => ! $tasks->contains('id', $task->id)
            );
    }

    public function test_approved_partial_report_allows_next_report_on_same_date(): void
    {
        $firstWorker = $this->createWorker('round-first@example.com');
        $secondWorker = $this->createWorker('round-second@example.com');

        $task = $this->createTask($firstWorker, 'TSK-NEXT-ROUND', 25);
        $task->workers()->attach($secondWorker->id);

        $this->reportForm($firstWorker, $task)
            ->set('reportedProgress', 40)
            ->call('submitReport')
            ->assertHasNoErrors();

        $firstReport = DailyReport::query()->sole();

        // Gunakan approval Mandor yang sebenarnya.
        Livewire::actingAs($this->mandor)
            ->test(\App\Livewire\Mandor\DailyReports\Edit::class, [
                'report' => $firstReport,
            ])
            ->call('approveReport')
            ->assertHasNoErrors();

        $this->assertSame('approved', $firstReport->fresh()->status);
        $this->assertSame('in_progress', $task->fresh()->status);
        $this->assertSame(40, $task->fresh()->progress);
        $this->assertNull($task->fresh()->completed_at);

        $this->reportForm($secondWorker, $task->fresh())
            ->set('reportedProgress', 70)
            ->call('submitReport')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('daily_reports', 2);

        $secondReport = DailyReport::query()
            ->whereKeyNot($firstReport->id)
            ->sole();

        $this->assertSame($secondWorker->id, $secondReport->user_id);
        $this->assertSame('submitted', $secondReport->status);
        $this->assertSame(
            $firstReport->report_date->toDateString(),
            $secondReport->report_date->toDateString()
        );

        // Pengiriman berikutnya belum mengubah progres resmi 40%.
        $this->assertSame(40, $task->fresh()->progress);
        $this->assertSame('submitted', $task->fresh()->status);
    }

    public function test_pending_report_blocks_new_report_for_every_member(): void
    {
        $firstWorker = $this->createWorker('pending-first@example.com');
        $secondWorker = $this->createWorker('pending-second@example.com');

        $task = $this->createTask($firstWorker, 'TSK-PENDING-REPORT');
        $task->workers()->attach($secondWorker->id);

        foreach (['draft', 'submitted', 'revision'] as $index => $status) {
            // Form disiapkan sebelum laporan penghalang dibuat.
            $component = $this->reportForm($secondWorker, $task);

            $existingReport = DailyReport::query()->create([
                'report_number' => 'RPT-PENDING-'.$index,
                'project_id' => $this->project->id,
                'task_id' => $task->id,
                'user_id' => $firstWorker->id,
                'report_date' => now('Asia/Jakarta')->toDateString(),
                'reported_progress' => 40,
                'work_status' => 'in_progress',
                'activities' => 'Laporan bersama yang belum selesai diproses.',
                'status' => $status,
            ]);

            Livewire::actingAs($secondWorker)
                ->test(Create::class)
                ->assertViewHas(
                    'availableTasks',
                    fn ($tasks): bool => ! $tasks->contains('id', $task->id)
                );

            $component
                ->call('submitReport')
                ->assertHasErrors('submit');

            $this->assertDatabaseCount('daily_reports', 1);
            $this->assertSame($status, $existingReport->fresh()->status);
            $this->assertSame($firstWorker->id, $existingReport->fresh()->user_id);

            // Bersihkan fixture untuk skenario status berikutnya.
            $existingReport->delete();
        }
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

    private function createRevisionReport(
    User $worker,
    Task $task
    ): DailyReport {
        $task->update([
            'status' => 'revision',
        ]);

        return DailyReport::query()->create([
            'report_number' => 'RPT-REVISION-'.$task->id,
            'project_id' => $task->project_id,
            'task_id' => $task->id,
            'user_id' => $worker->id,
            'report_date' => now('Asia/Jakarta')->toDateString(),
            'reported_progress' => 50,
            'work_status' => 'in_progress',
            'activities' => 'Pekerjaan awal yang perlu diperbaiki.',
            'status' => 'revision',
            'submitted_at' => now(),
            'reviewed_by' => $this->mandor->id,
            'reviewed_at' => now(),
            'review_notes' => 'Lengkapi keterangan dan foto pekerjaan.',
        ]);
    }

    private function createReportPhoto(
        DailyReport $report,
        User $worker,
        string $filename
    ): Documentation {
        $path = 'documentations/testing/'.$filename;

        Storage::disk('public')->put($path, 'fixture photo');

        return Documentation::query()->create([
            'project_id' => $report->project_id,
            'task_id' => $report->task_id,
            'daily_report_id' => $report->id,
            'user_id' => $worker->id,
            'title' => 'Foto pekerjaan',
            'category' => 'progress',
            'photo' => $path,
            'original_name' => $filename,
            'mime_type' => 'image/jpeg',
            'file_size' => 13,
            'description' => 'Dokumentasi pekerjaan awal.',
            'documentation_date' => $report->report_date->toDateString(),
            'taken_at' => now(),
        ]);
    }

    public function test_second_member_can_replace_revision_photo_without_creating_another_report(): void
    {
        $disk = Storage::fake('public');

        $firstWorker = $this->createWorker('revision-author@example.com');
        $secondWorker = $this->createWorker('revision-member@example.com');

        $task = $this->createTask($firstWorker, 'TSK-REV-PHOTO');
        $task->workers()->attach($secondWorker->id);

        $report = $this->createRevisionReport($firstWorker, $task);

        $oldPhoto = $this->createReportPhoto(
            $report,
            $firstWorker,
            'replace-old.jpg'
        );

        $keptPhoto = $this->createReportPhoto(
            $report,
            $firstWorker,
            'keep-existing.jpg'
        );

        $oldPhotoId = $oldPhoto->id;
        $oldPath = $oldPhoto->photo;

        Livewire::actingAs($secondWorker)
            ->test(ReportEdit::class, [
                'report' => $report->id,
            ])
            ->assertCount('existingDocumentations', 2)
            ->call('removeExistingDocumentation', $oldPhotoId)
            ->set('activities', 'Pekerjaan sudah diperbaiki sesuai arahan Mandor.')
            ->set('reportedProgress', 70)
            ->set('photos', [
                UploadedFile::fake()->image('replacement.jpg'),
            ])
            ->call('resubmitReport')
            ->assertHasNoErrors()
            ->assertRedirect(route('pekerja.report.index'));

        $report->refresh();
        $task->refresh();

        // Revisi memperbarui laporan yang sama.
        $this->assertDatabaseCount('daily_reports', 1);
        $this->assertSame($firstWorker->id, $report->user_id);
        $this->assertSame('submitted', $report->status);
        $this->assertSame(70, $report->reported_progress);
        $this->assertNull($report->reviewed_by);
        $this->assertNull($report->reviewed_at);
        $this->assertNull($report->review_notes);

        // Progres resmi menunggu persetujuan Mandor.
        $this->assertSame('submitted', $task->status);
        $this->assertSame(25, $task->progress);

        $this->assertDatabaseMissing('documentations', [
            'id' => $oldPhotoId,
        ]);

        $disk->assertMissing($oldPath);
        $disk->assertExists($keptPhoto->photo);

        $replacement = Documentation::query()
            ->where('daily_report_id', $report->id)
            ->where('id', '!=', $keptPhoto->id)
            ->sole();

        $this->assertSame($secondWorker->id, $replacement->user_id);
        $this->assertSame($task->id, $replacement->task_id);
        $this->assertSame('replacement.jpg', $replacement->original_name);

        $this->assertDatabaseCount('documentations', 2);
        $disk->assertExists($replacement->photo);
    }

    public function test_stale_revision_form_cannot_overwrite_another_members_resubmission(): void
    {
        $disk = Storage::fake('public');

        $firstWorker = $this->createWorker('revision-stale-first@example.com');
        $secondWorker = $this->createWorker('revision-stale-second@example.com');

        $task = $this->createTask($firstWorker, 'TSK-REV-STALE');
        $task->workers()->attach($secondWorker->id);

        $report = $this->createRevisionReport($firstWorker, $task);

        $oldPhoto = $this->createReportPhoto(
            $report,
            $firstWorker,
            'stale-existing.jpg'
        );

        // Anggota kedua membuka form sebelum anggota pertama mengirim.
        $staleForm = Livewire::actingAs($secondWorker)
            ->test(ReportEdit::class, [
                'report' => $report->id,
            ])
            ->set('activities', 'Perubahan dari form lama anggota kedua.')
            ->set('reportedProgress', 90)
            ->call('removeExistingDocumentation', $oldPhoto->id)
            ->set('photos', [
                UploadedFile::fake()->image('stale-replacement.jpg'),
            ]);

        Livewire::actingAs($firstWorker)
            ->test(ReportEdit::class, [
                'report' => $report->id,
            ])
            ->set('activities', 'Perbaikan resmi dari anggota pertama.')
            ->set('reportedProgress', 70)
            ->call('resubmitReport')
            ->assertHasNoErrors();

        $this->actingAs($secondWorker);

        $staleForm
            ->call('resubmitReport')
            ->assertHasErrors('submit');

        $report->refresh();

        $this->assertSame(70, $report->reported_progress);
        $this->assertSame(
            'Perbaikan resmi dari anggota pertama.',
            $report->activities
        );
        $this->assertSame('submitted', $report->status);
        $this->assertDatabaseCount('daily_reports', 1);
        $this->assertDatabaseCount('documentations', 1);

        $disk->assertExists($oldPhoto->photo);

        $this->assertSame(
            [$oldPhoto->photo],
            $disk->allFiles('documentations/testing')
        );

        $this->assertCount(1, $disk->allFiles('documentations'));
    }

    public function test_revision_rejects_photo_from_another_report_without_deleting_files(): void
    {
        $disk = Storage::fake('public');

        $worker = $this->createWorker('revision-photo-scope@example.com');

        $task = $this->createTask($worker, 'TSK-REV-SCOPE');
        $report = $this->createRevisionReport($worker, $task);

        $ownPhoto = $this->createReportPhoto(
            $report,
            $worker,
            'scope-own.jpg'
        );

        $otherTask = $this->createTask($worker, 'TSK-REV-OTHER');
        $otherReport = $this->createRevisionReport($worker, $otherTask);

        $otherPhoto = $this->createReportPhoto(
            $otherReport,
            $worker,
            'scope-other.jpg'
        );

        // Simulasikan manipulasi ID foto melalui properti Livewire.
        Livewire::actingAs($worker)
            ->test(ReportEdit::class, [
                'report' => $report->id,
            ])
            ->set('removedDocumentationIds', [$otherPhoto->id])
            ->set('photos', [
                UploadedFile::fake()->image('must-not-save.jpg'),
            ])
            ->call('resubmitReport')
            ->assertHasErrors('submit');

        $this->assertSame('revision', $report->fresh()->status);
        $this->assertSame('revision', $task->fresh()->status);
        $this->assertDatabaseCount('documentations', 2);

        $disk->assertExists($ownPhoto->photo);
        $disk->assertExists($otherPhoto->photo);

        $this->assertCount(2, $disk->allFiles('documentations'));
    }

    public function test_revision_cannot_be_resubmitted_after_project_is_cancelled(): void
    {
        $disk = Storage::fake('public');

        $worker = $this->createWorker('revision-cancelled@example.com');
        $task = $this->createTask($worker, 'TSK-REV-CANCELLED');
        $report = $this->createRevisionReport($worker, $task);

        $photo = $this->createReportPhoto(
            $report,
            $worker,
            'cancelled-existing.jpg'
        );

        $component = Livewire::actingAs($worker)
            ->test(ReportEdit::class, [
                'report' => $report->id,
            ])
            ->call('removeExistingDocumentation', $photo->id)
            ->set('photos', [
                UploadedFile::fake()->image('cancelled-new.jpg'),
            ]);

        $this->project->update([
            'status' => 'cancelled',
        ]);

        $component
            ->call('resubmitReport')
            ->assertHasErrors('submit');

        $this->assertSame('revision', $report->fresh()->status);
        $this->assertSame('revision', $task->fresh()->status);
        $this->assertDatabaseCount('documentations', 1);
        $disk->assertExists($photo->photo);

        $this->assertCount(1, $disk->allFiles('documentations'));
    }

    public function test_approved_report_cannot_be_overwritten_from_stale_revision_form(): void
    {
        $disk = Storage::fake('public');

        $worker = $this->createWorker('revision-approved@example.com');
        $task = $this->createTask($worker, 'TSK-REV-APPROVED');
        $report = $this->createRevisionReport($worker, $task);

        $photo = $this->createReportPhoto(
            $report,
            $worker,
            'approved-existing.jpg'
        );

        $component = Livewire::actingAs($worker)
            ->test(ReportEdit::class, [
                'report' => $report->id,
            ])
            ->set('reportedProgress', 80)
            ->call('removeExistingDocumentation', $photo->id)
            ->set('photos', [
                UploadedFile::fake()->image('approved-new.jpg'),
            ]);

        // Simulasikan perubahan status setelah form dibuka.
        $report->update([
            'status' => 'approved',
            'reviewed_by' => $this->mandor->id,
            'reviewed_at' => now(),
        ]);

        $task->update([
            'status' => 'in_progress',
            'progress' => 50,
        ]);

        $component
            ->call('resubmitReport')
            ->assertHasErrors('submit');

        $this->assertSame('approved', $report->fresh()->status);
        $this->assertSame(50, $report->fresh()->reported_progress);
        $this->assertSame(50, $task->fresh()->progress);
        $this->assertDatabaseCount('documentations', 1);
        $disk->assertExists($photo->photo);

        $this->assertCount(1, $disk->allFiles('documentations'));
    }
}
