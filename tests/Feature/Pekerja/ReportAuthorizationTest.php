<?php

namespace Tests\Feature\Pekerja;

use App\Models\Client;
use App\Models\DailyReport;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;
use App\Livewire\Pekerja\Report\Index as ReportIndex;
use App\Livewire\Pekerja\Report\Show as ReportShow;
use App\Models\Documentation;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

class ReportAuthorizationTest extends TestCase
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

        $this->mandor = User::factory()->create([
            'name' => 'Mandor Pengujian',
            'status' => 'active',
        ]);

        $this->mandor->assignRole('mandor');

        $client = Client::query()->create([
            'company_name' => 'PT Pengujian',
            'contact_person' => 'Kontak Pengujian',
        ]);

        $this->project = Project::query()->create([
            'client_id' => $client->id,
            'mandor_id' => $this->mandor->id,
            'project_code' => 'PRJ-AUTH-001',
            'project_name' => 'Proyek Otorisasi Laporan',
            'location' => 'Jakarta',
            'start_date' => '2026-09-01',
            'status' => 'on_progress',
        ]);
    }

    private function createWorker(
        array $attributes = []
    ): User {
        $worker = User::factory()->create(
            array_merge(
                [
                    'status' => 'active',
                ],
                $attributes
            )
        );

        $worker->assignRole('pekerja');

        return $worker;
    }

    private function createReport(
        User $worker,
        string $status,
        string $number
    ): DailyReport {
        return DailyReport::query()->create([
            'report_number' => $number,
            'project_id' => $this->project->id,
            'user_id' => $worker->id,
            'report_date' => '2026-09-16',
            'reported_progress' => 50,
            'work_status' => 'in_progress',
            'activities' =>
                'Aktivitas '.$number,
            'status' => $status,
        ]);
    }

    private function createSharedTask(
    User $author,
    User $member,
    string $code
    ): Task {
        $task = Task::query()->create([
            'project_id' => $this->project->id,
            'mandor_id' => $this->mandor->id,
            'worker_id' => $author->id,
            'task_code' => $code,
            'title' => 'Task Bersama '.$code,
            'priority' => 'medium',
            'status' => 'submitted',
            'start_at' => '2026-09-01 08:00:00',
            'due_at' => '2026-09-30 17:00:00',
            'progress' => 25,
            'weight' => 1,
        ]);

        $task->workers()->attach([
            $author->id,
            $member->id,
        ]);

        return $task;
    }

    public function test_task_member_can_view_shared_report_and_author_photos(): void
{
    $disk = Storage::fake('public');

    $author = $this->createWorker([
        'name' => 'Pembuat Laporan Bersama',
    ]);
    $member = $this->createWorker();

    $task = $this->createSharedTask(
        $author,
        $member,
        'TSK-SHARED-READ'
    );

    $report = $this->createReport(
        $author,
        'submitted',
        'RPT-SHARED-READ'
    );
    $report->update(['task_id' => $task->id]);

    $photoPath = 'documentations/shared-report.jpg';
    $disk->put($photoPath, 'test-photo');

    $documentation = Documentation::query()->create([
        'project_id' => $this->project->id,
        'task_id' => $task->id,
        'daily_report_id' => $report->id,
        'user_id' => $author->id,
        'title' => 'Foto Laporan Bersama',
        'category' => 'progress',
        'photo' => $photoPath,
        'original_name' => 'shared-report.jpg',
        'mime_type' => 'image/jpeg',
        'file_size' => 10,
        'documentation_date' => '2026-09-16',
        'taken_at' => '2026-09-16 08:00:00',
    ]);

    Livewire::actingAs($member)
        ->test(ReportShow::class, [
            'report' => $report->id,
        ])
        ->assertViewHas(
            'report',
            function (DailyReport $visibleReport) use (
                $author,
                $documentation
            ): bool {
                $photo = $visibleReport->documentations
                    ->firstWhere('id', $documentation->id);

                return $visibleReport->user_id === $author->id
                    && $visibleReport->user->name === $author->name
                    && $photo !== null
                    && $photo->user_id === $author->id
                    && $photo->getAttribute('photo_exists') === true;
            }
        );
}

public function test_non_member_cannot_view_report_even_on_same_project(): void
{
    $author = $this->createWorker();
    $member = $this->createWorker();
    $outsider = $this->createWorker();

    $task = $this->createSharedTask(
        $author,
        $member,
        'TSK-SHARED-PRIVATE'
    );

    $report = $this->createReport(
        $author,
        'submitted',
        'RPT-SHARED-PRIVATE'
    );
    $report->update(['task_id' => $task->id]);

    // Berada pada Project yang sama tidak otomatis menjadi anggota Task.
    \App\Models\ProjectWorker::query()->create([
        'project_id' => $this->project->id,
        'worker_id' => $outsider->id,
        'assigned_by' => $this->mandor->id,
        'status' => 'active',
        'joined_at' => '2026-09-01',
    ]);

    $this->actingAs($outsider)
        ->get(route('pekerja.report.show', [
            'report' => $report->id,
        ]))
        ->assertNotFound();

    Livewire::actingAs($outsider)
        ->test(ReportIndex::class)
        ->assertDontSee('RPT-SHARED-PRIVATE')
        ->assertViewHas(
            'statistics',
            fn (array $statistics): bool =>
                $statistics['total'] === 0
        );
}

public function test_shared_report_list_statistics_and_filters_remain_scoped(): void
{
    $author = $this->createWorker();
    $member = $this->createWorker();
    $outsider = $this->createWorker();

    $task = $this->createSharedTask(
        $author,
        $member,
        'TSK-SHARED-LIST'
    );

    $submitted = $this->createReport(
        $author,
        'submitted',
        'RPT-MEMBER-SUBMITTED'
    );
    $submitted->update(['task_id' => $task->id]);

    $approved = $this->createReport(
        $author,
        'approved',
        'RPT-MEMBER-APPROVED'
    );
    $approved->update(['task_id' => $task->id]);

    $this->createReport(
        $outsider,
        'submitted',
        'RPT-OUTSIDE-SECRET'
    );

    Livewire::actingAs($member)
        ->test(ReportIndex::class)
        ->assertSee('RPT-MEMBER-SUBMITTED')
        ->assertSee('RPT-MEMBER-APPROVED')
        ->assertDontSee('RPT-OUTSIDE-SECRET')
        ->assertViewHas(
            'statistics',
            fn (array $statistics): bool =>
                $statistics['total'] === 2
                && $statistics['submitted'] === 1
                && $statistics['approved'] === 1
        )
        ->set('status', 'approved')
        ->assertSee('RPT-MEMBER-APPROVED')
        ->assertDontSee('RPT-MEMBER-SUBMITTED')
        ->call('resetFilters')
        ->set('search', 'RPT-OUTSIDE-SECRET')
        ->assertDontSee('RPT-OUTSIDE-SECRET')
        ->assertViewHas(
            'reports',
            fn ($reports): bool => $reports->total() === 0
        );
}

    public function test_worker_can_view_own_report(): void
    {
        $worker = $this->createWorker();

        $report = $this->createReport(
            $worker,
            'submitted',
            'RPT-OWN-001'
        );

        $response = $this
            ->actingAs($worker)
            ->get(
                route(
                    'pekerja.report.show',
                    [
                        'report' => $report->id,
                    ]
                )
            );

        $response->assertOk();
        $response->assertSee('RPT-OWN-001');
        $response->assertSee(
            'Aktivitas RPT-OWN-001'
        );
    }

    public function test_worker_cannot_view_another_workers_report(): void
    {
        $worker = $this->createWorker();

        $otherWorker = $this->createWorker([
            'email' =>
                'other-view-worker@example.com',
        ]);

        $report = $this->createReport(
            $otherWorker,
            'submitted',
            'RPT-OTHER-001'
        );

        $response = $this
            ->actingAs($worker)
            ->get(
                route(
                    'pekerja.report.show',
                    [
                        'report' => $report->id,
                    ]
                )
            );

        $response->assertNotFound();
    }

    public function test_worker_can_edit_own_revision_report(): void
    {
        $worker = $this->createWorker();

        $report = $this->createReport(
            $worker,
            'revision',
            'RPT-REVISION-001'
        );

        $response = $this
            ->actingAs($worker)
            ->get(
                route(
                    'pekerja.report.edit',
                    [
                        'report' => $report->id,
                    ]
                )
            );

        $response->assertOk();
        $response->assertSee(
            'RPT-REVISION-001'
        );
    }

    public function test_worker_cannot_edit_another_workers_report(): void
    {
        $worker = $this->createWorker();

        $otherWorker = $this->createWorker([
            'email' =>
                'other-edit-worker@example.com',
        ]);

        $report = $this->createReport(
            $otherWorker,
            'revision',
            'RPT-OTHER-EDIT-001'
        );

        $response = $this
            ->actingAs($worker)
            ->get(
                route(
                    'pekerja.report.edit',
                    [
                        'report' => $report->id,
                    ]
                )
            );

        $response->assertNotFound();
    }

    public function test_non_revision_report_cannot_be_edited(): void
    {
        $worker = $this->createWorker();

        foreach (
            [
                'draft',
                'submitted',
                'approved',
            ] as $status
        ) {
            $report = $this->createReport(
                $worker,
                $status,
                'RPT-'.strtoupper($status).'-001'
            );

            $response = $this
                ->actingAs($worker)
                ->get(
                    route(
                        'pekerja.report.edit',
                        [
                            'report' => $report->id,
                        ]
                    )
                );

            $response->assertStatus(409);
        }
    }

    public function test_guest_cannot_open_report_routes(): void
    {
        $worker = $this->createWorker();

        $report = $this->createReport(
            $worker,
            'revision',
            'RPT-GUEST-001'
        );

        $this->get(
            route(
                'pekerja.report.show',
                [
                    'report' => $report->id,
                ]
            )
        )->assertRedirect(
            route('login')
        );

        $this->get(
            route(
                'pekerja.report.edit',
                [
                    'report' => $report->id,
                ]
            )
        )->assertRedirect(
            route('login')
        );
    }

    public function test_owner_and_mandor_cannot_open_worker_report_routes(): void
    {
        $worker = $this->createWorker();

        $report = $this->createReport(
            $worker,
            'revision',
            'RPT-ROLE-001'
        );

        $owner = User::factory()->create([
            'status' => 'active',
        ]);

        $owner->assignRole('owner');

        foreach (
            [
                $owner,
                $this->mandor,
            ] as $user
        ) {
            $this->actingAs($user)
                ->get(
                    route(
                        'pekerja.report.show',
                        [
                            'report' => $report->id,
                        ]
                    )
                )
                ->assertForbidden();

            $this->actingAs($user)
                ->get(
                    route(
                        'pekerja.report.edit',
                        [
                            'report' => $report->id,
                        ]
                    )
                )
                ->assertForbidden();
        }
    }
}