<?php

namespace Tests\Feature\Owner;

use App\Livewire\Owner\Projects\Create;
use App\Models\Client;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ProjectCreationFromQuotationTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;

    private User $mandor;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::create(
                2026,
                9,
                18,
                22,
                30,
                0,
                'Asia/Jakarta'
            )
        );

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $createProjects = Permission::findOrCreate(
            'create projects',
            'web'
        );

        $viewProjects = Permission::findOrCreate(
            'view projects',
            'web'
        );

        $ownerRole = Role::findOrCreate(
            'owner',
            'web'
        );

        $mandorRole = Role::findOrCreate(
            'mandor',
            'web'
        );

        $ownerRole->syncPermissions([
            $createProjects,
            $viewProjects,
        ]);

        $this->owner = User::factory()->create([
            'name' => 'Owner Project',
            'status' => 'active',
        ]);

        $this->owner->assignRole(
            $ownerRole
        );

        $this->mandor = User::factory()->create([
            'name' => 'Mandor Project',
            'status' => 'active',
        ]);

        $this->mandor->assignRole(
            $mandorRole
        );

        $this->client = Client::query()->create([
            'company_name' =>
                'PT Project Integrasi',

            'contact_person' =>
                'Ahmad Project',

            'phone' =>
                '+6281234567890',

            'email' =>
                'project.integrasi@example.com',

            'city' =>
                'Jakarta Selatan',

            'status' =>
                'active',

            'address' =>
                'Jl. Project Integrasi No. 18',

            'notes' =>
                'Client pengujian Project.',
        ]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_owner_can_open_project_create_page_from_approved_quotation(): void
    {
        $quotation = $this->createQuotation();

        $this->actingAs($this->owner)
            ->get(
                route(
                    'owner.projects.create-from-quotation',
                    [
                        'quotation' =>
                            $quotation->id,
                    ]
                )
            )
            ->assertOk()
            ->assertSee(
                'Buat Project dari Quotation'
            )
            ->assertSee(
                $quotation->quotation_number
            )
            ->assertSee(
                $quotation->project_name
            )
            ->assertSee(
                $this->client->company_name
            );
    }

    public function test_project_form_uses_quotation_data_as_initial_values(): void
    {
        $quotation = $this->createQuotation([
            'project_name' =>
                'Renovasi Kantor Integrasi',

            'project_location' =>
                'Jakarta Selatan',

            'grand_total' =>
                3500000,

            'notes' =>
                'Catatan awal Project.',
        ]);

        Livewire::actingAs($this->owner)
            ->test(Create::class, [
                'quotation' => $quotation,
            ])
            ->assertSet(
                'quotationId',
                $quotation->id
            )
            ->assertSet(
                'clientId',
                $this->client->id
            )
            ->assertSet(
                'projectName',
                'Renovasi Kantor Integrasi'
            )
            ->assertSet(
                'location',
                'Jakarta Selatan'
            )
            ->assertSet(
                'description',
                'Catatan awal Project.'
            )
            ->assertSet(
                'contractValue',
                3500000.0
            );
    }

    public function test_owner_can_create_project_from_approved_quotation(): void
    {
        $quotation = $this->createQuotation([
            'grand_total' => 5000000,
        ]);

        $component = Livewire::actingAs(
            $this->owner
        )
            ->test(Create::class, [
                'quotation' => $quotation,
            ])
            ->set(
                'mandorId',
                $this->mandor->id
            )
            ->set(
                'projectName',
                'Project Implementasi'
            )
            ->set(
                'location',
                'Jakarta Selatan'
            )
            ->set(
                'description',
                'Pelaksanaan Project integrasi.'
            )
            ->set(
                'contractNumber',
                'SPK/001/IX/2026'
            )
            ->set(
                'contractDate',
                '2026-09-18'
            )
            ->set(
                'projectBudget',
                4000000
            )
            ->set(
                'startDate',
                '2026-09-20'
            )
            ->set(
                'endDate',
                '2026-10-20'
            )
            ->call('save')
            ->assertHasNoErrors();

        $project = Project::query()->sole();

        $component->assertRedirect(
            route('owner.projects.show', [
                'project' => $project->id,
            ])
        );

        $this->assertSame(
            $this->client->id,
            $project->client_id
        );

        $this->assertSame(
            $this->mandor->id,
            $project->mandor_id
        );

        $this->assertSame(
            'PRJ-2026-0001',
            $project->project_code
        );

        $this->assertSame(
            'Project Implementasi',
            $project->project_name
        );

        $this->assertSame(
            '5000000.00',
            $project->contract_value
        );

        $this->assertSame(
            '4000000.00',
            $project->project_budget
        );

        $this->assertSame(
            'planning',
            $project->status
        );

        $this->assertSame(
            0,
            $project->progress
        );

        $quotation->refresh();

        $this->assertSame(
            $project->id,
            $quotation->project_id
        );

        $this->assertTrue(
            $project->quotation->is(
                $quotation
            )
        );
    }

    public function test_client_and_contract_value_cannot_be_manipulated(): void
    {
        $otherClient = Client::query()->create([
            'company_name' =>
                'PT Client Manipulasi',

            'contact_person' =>
                'Client Lain',

            'phone' =>
                '+6289999999999',

            'email' =>
                'client.lain@example.com',

            'city' =>
                'Bandung',

            'status' =>
                'active',

            'address' =>
                'Bandung',

            'notes' =>
                null,
        ]);

        $quotation = $this->createQuotation([
            'grand_total' => 7500000,
        ]);

        Livewire::actingAs($this->owner)
            ->test(Create::class, [
                'quotation' => $quotation,
            ])
            ->set(
                'clientId',
                $otherClient->id
            )
            ->set(
                'contractValue',
                1000
            )
            ->set(
                'mandorId',
                $this->mandor->id
            )
            ->set(
                'projectName',
                'Project Aman'
            )
            ->set(
                'location',
                'Jakarta Selatan'
            )
            ->set(
                'projectBudget',
                5000000
            )
            ->set(
                'startDate',
                '2026-09-20'
            )
            ->set(
                'endDate',
                '2026-10-20'
            )
            ->call('save')
            ->assertHasNoErrors();

        $project = Project::query()->sole();

        $this->assertSame(
            $this->client->id,
            $project->client_id
        );

        $this->assertSame(
            '7500000.00',
            $project->contract_value
        );
    }

    public function test_unapproved_quotation_cannot_create_project(): void
    {
        foreach (
            [
                'draft',
                'sent',
                'rejected',
                'expired',
            ] as $status
        ) {
            $quotation = $this->createQuotation([
                'quotation_number' =>
                    'QT-2026-'.strtoupper($status),

                'status' => $status,
            ]);

            Livewire::actingAs($this->owner)
                ->test(Create::class, [
                    'quotation' => $quotation,
                ])
                ->assertForbidden();
        }

        $this->assertDatabaseCount(
            'projects',
            0
        );
    }

    public function test_non_mandor_user_cannot_be_assigned_as_mandor(): void
    {
        $regularUser = User::factory()->create([
            'name' => 'User Bukan Mandor',
            'status' => 'active',
        ]);

        $quotation = $this->createQuotation();

        Livewire::actingAs($this->owner)
            ->test(Create::class, [
                'quotation' => $quotation,
            ])
            ->set(
                'mandorId',
                $regularUser->id
            )
            ->set(
                'projectName',
                'Project Mandor Tidak Valid'
            )
            ->set(
                'location',
                'Jakarta Selatan'
            )
            ->set(
                'projectBudget',
                1000000
            )
            ->set(
                'startDate',
                '2026-09-20'
            )
            ->set(
                'endDate',
                '2026-10-20'
            )
            ->call('save')
            ->assertHasErrors([
                'mandorId',
            ]);

        $this->assertDatabaseCount(
            'projects',
            0
        );
    }

    public function test_quotation_cannot_create_more_than_one_project(): void
    {
        $quotation = $this->createQuotation();

        $component = Livewire::actingAs(
            $this->owner
        )
            ->test(Create::class, [
                'quotation' => $quotation,
            ]);

        $existingProject = Project::query()->create([
            'client_id' =>
                $this->client->id,

            'mandor_id' =>
                $this->mandor->id,

            'project_code' =>
                'PRJ-2026-0001',

            'project_name' =>
                'Project Pertama',

            'location' =>
                'Jakarta Selatan',

            'description' =>
                null,

            'contract_number' =>
                null,

            'contract_date' =>
                null,

            'project_budget' =>
                1000000,

            'contract_value' =>
                1500000,

            'start_date' =>
                '2026-09-20',

            'end_date' =>
                '2026-10-20',

            'progress' =>
                0,

            'status' =>
                'planning',
        ]);

        $quotation->update([
            'project_id' =>
                $existingProject->id,
        ]);

        $component
            ->set(
                'projectCode',
                'PRJ-2026-9999'
            )
            ->set(
                'mandorId',
                $this->mandor->id
            )
            ->set(
                'projectName',
                'Project Kedua'
            )
            ->set(
                'location',
                'Jakarta Selatan'
            )
            ->set(
                'projectBudget',
                1000000
            )
            ->set(
                'startDate',
                '2026-09-20'
            )
            ->set(
                'endDate',
                '2026-10-20'
            )
            ->call('save')
            ->assertHasErrors([
                'save',
            ]);

        $this->assertDatabaseCount(
            'projects',
            1
        );

        $quotation->refresh();

        $this->assertSame(
            $existingProject->id,
            $quotation->project_id
        );
    }

    public function test_end_date_cannot_be_before_start_date(): void
    {
        $quotation = $this->createQuotation();

        Livewire::actingAs($this->owner)
            ->test(Create::class, [
                'quotation' => $quotation,
            ])
            ->set(
                'mandorId',
                $this->mandor->id
            )
            ->set(
                'projectName',
                'Project Tanggal'
            )
            ->set(
                'location',
                'Jakarta Selatan'
            )
            ->set(
                'projectBudget',
                1000000
            )
            ->set(
                'startDate',
                '2026-09-20'
            )
            ->set(
                'endDate',
                '2026-09-19'
            )
            ->call('save')
            ->assertHasErrors([
                'endDate' =>
                    'after_or_equal',
            ]);

        $this->assertDatabaseCount(
            'projects',
            0
        );
    }

    public function test_user_without_create_permission_cannot_create_project(): void
    {
        $viewer = User::factory()->create([
            'name' => 'Viewer Project',
            'status' => 'active',
        ]);

        $quotation = $this->createQuotation();

        Livewire::actingAs($viewer)
            ->test(Create::class, [
                'quotation' => $quotation,
            ])
            ->assertForbidden();

        $this->assertDatabaseCount(
            'projects',
            0
        );
    }

    public function test_used_quotation_redirects_to_existing_project(): void
    {
        $quotation = $this->createQuotation();

        $project = Project::query()->create([
            'client_id' =>
                $this->client->id,

            'mandor_id' =>
                $this->mandor->id,

            'project_code' =>
                'PRJ-2026-0001',

            'project_name' =>
                'Project Existing',

            'location' =>
                'Jakarta Selatan',

            'description' =>
                null,

            'contract_number' =>
                null,

            'contract_date' =>
                null,

            'project_budget' =>
                1000000,

            'contract_value' =>
                5000000,

            'start_date' =>
                '2026-09-20',

            'end_date' =>
                '2026-10-20',

            'progress' =>
                0,

            'status' =>
                'planning',
        ]);

        $quotation->update([
            'project_id' =>
                $project->id,
        ]);

        Livewire::actingAs($this->owner)
            ->test(Create::class, [
                'quotation' => $quotation->fresh(),
            ])
            ->assertRedirect(
                route('owner.projects.show', [
                    'project' => $project->id,
                ])
            );

        $this->assertDatabaseCount(
            'projects',
            1
        );
    }

    private function createQuotation(
        array $attributes = []
    ): Quotation {
        $sequence =
            Quotation::query()->count() + 1;

        return Quotation::query()->create(
            array_merge([
                'client_id' =>
                    $this->client->id,

                'project_id' =>
                    null,

                'created_by' =>
                    $this->owner->id,

                'quotation_number' =>
                    sprintf(
                        'QT-2026-%04d',
                        $sequence
                    ),

                'quotation_date' =>
                    '2026-09-18',

                'valid_until' =>
                    '2026-09-25',

                'client_name' =>
                    $this->client->company_name,

                'client_contact_person' =>
                    $this->client->contact_person,

                'client_phone' =>
                    $this->client->phone,

                'client_email' =>
                    $this->client->email,

                'client_address' =>
                    $this->client->address,

                'project_name' =>
                    'Project dari Quotation',

                'project_location' =>
                    'Jakarta Selatan',

                'subtotal' =>
                    5000000,

                'grand_total' =>
                    5000000,

                'status' =>
                    'approved',

                'sent_at' =>
                    now()->subDay(),

                'approved_at' =>
                    now(),

                'rejected_at' =>
                    null,

                'notes' =>
                    'Catatan sumber Project.',
            ], $attributes)
        );
    }
}