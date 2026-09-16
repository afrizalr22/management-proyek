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