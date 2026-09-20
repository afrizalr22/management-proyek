<?php

namespace Tests\Feature\Owner;

use App\Livewire\Owner\Invoices\Create;
use App\Models\Client;
use App\Models\Invoice;
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

class InvoiceCreationFromProjectTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(
            '2026-09-19 10:00:00'
        );

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $permission = Permission::findOrCreate(
            'create invoices',
            'web'
        );

        $ownerRole = Role::findOrCreate(
            'owner',
            'web'
        );

        Role::findOrCreate(
            'mandor',
            'web'
        );

        $ownerRole->givePermissionTo(
            $permission
        );

        $this->owner = User::factory()->create([
            'name' => 'Owner Invoice',
            'status' => 'active',
        ]);

        $this->owner->assignRole(
            $ownerRole
        );

        $this->client = Client::query()->create([
            'company_name' =>
                'PT Pembayaran Project',

            'contact_person' =>
                'Budi Finance',

            'phone' =>
                '+628123456789',

            'email' =>
                'finance@example.com',

            'city' =>
                'Jakarta Selatan',

            'status' =>
                'active',

            'address' =>
                'Jl. Project No. 10',

            'notes' =>
                'Client pengujian Invoice.',
        ]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_owner_can_open_invoice_create_page(): void
    {
        $project = $this->createProject(
            'planning',
            1
        );

        $quotation = $this->createQuotation(
            $project,
            1
        );

        $this->actingAs($this->owner)
            ->get(
                route('owner.invoices.create')
            )
            ->assertOk()
            ->assertSee('Buat Invoice Baru')
            ->assertSee(
                $quotation->quotation_number
            )
            ->assertSee(
                $project->project_name
            );
    }

    public function test_invoice_can_be_created_for_active_project_statuses(): void
    {
        foreach (
            [
                'planning',
                'on_progress',
                'completed',
            ] as $index => $status
        ) {
            $sequence = $index + 1;

            $project = $this->createProject(
                $status,
                $sequence
            );

            $quotation = $this->createQuotation(
                $project,
                $sequence
            );

            Livewire::actingAs($this->owner)
                ->test(Create::class)
                ->set(
                    'quotationId',
                    $quotation->id
                )
                ->set(
                    'invoiceDate',
                    '2026-09-19'
                )
                ->set(
                    'dueDate',
                    '2026-10-03'
                )
                ->set(
                    'notes',
                    'Invoice untuk Project '.$status
                )
                ->call('createInvoice')
                ->assertHasNoErrors()
                ->assertRedirect(
                    route('owner.invoices.index')
                );

            $invoice = Invoice::query()
                ->where(
                    'quotation_id',
                    $quotation->id
                )
                ->sole();

            $this->assertSame(
                $project->id,
                $invoice->project_id
            );

            $this->assertSame(
                $this->owner->id,
                $invoice->created_by
            );

            $this->assertSame(
                'draft',
                $invoice->status
            );

            $this->assertSame(
                'unpaid',
                $invoice->payment_status
            );

            $this->assertSame(
                '3000000.00',
                $invoice->grand_total
            );
        }
    }

    public function test_invoice_copies_snapshot_and_items_from_quotation(): void
    {
        $project = $this->createProject(
            'planning',
            10
        );

        $quotation = $this->createQuotation(
            $project,
            10
        );

        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->set(
                'quotationId',
                $quotation->id
            )
            ->set(
                'clientName',
                'Client Manipulasi'
            )
            ->set(
                'projectName',
                'Project Manipulasi'
            )
            ->set(
                'subtotal',
                1
            )
            ->set(
                'grandTotal',
                1
            )
            ->set(
                'items',
                [
                    [
                        'item_name' =>
                            'Item Manipulasi',

                        'description' =>
                            'Tidak boleh tersimpan.',

                        'qty' => 1,

                        'unit' => 'unit',

                        'price' => 1,

                        'total' => 1,
                    ],
                ]
            )
            ->set(
                'invoiceDate',
                '2026-09-19'
            )
            ->set(
                'dueDate',
                '2026-10-03'
            )
            ->call('createInvoice')
            ->assertHasNoErrors();

        $invoice = Invoice::query()
            ->with('items')
            ->where(
                'quotation_id',
                $quotation->id
            )
            ->sole();

        $this->assertSame(
            'PT Pembayaran Project',
            $invoice->client_name
        );

        $this->assertSame(
            $project->id,
            $invoice->project_id
        );

        $this->assertSame(
            '3000000.00',
            $invoice->subtotal
        );

        $this->assertSame(
            '3000000.00',
            $invoice->grand_total
        );

        $this->assertCount(
            2,
            $invoice->items
        );

        $this->assertSame(
            'Pekerjaan Utama',
            $invoice->items[0]->item_name
        );

        $this->assertSame(
            '2000000.00',
            $invoice->items[0]->total
        );

        $this->assertSame(
            'Pekerjaan Tambahan',
            $invoice->items[1]->item_name
        );

        $this->assertSame(
            '1000000.00',
            $invoice->items[1]->total
        );
    }

    public function test_quotation_without_project_cannot_create_invoice(): void
    {
        $quotation = $this->createQuotation(
            null,
            20
        );

        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->set(
                'quotationId',
                $quotation->id
            )
            ->assertSet(
                'quotationId',
                null
            )
            ->assertHasErrors([
                'quotationId',
            ]);

        $this->assertDatabaseMissing(
            'invoices',
            [
                'quotation_id' =>
                    $quotation->id,
            ]
        );
    }

    public function test_cancelled_project_cannot_create_invoice(): void
    {
        $project = $this->createProject(
            'cancelled',
            30
        );

        $quotation = $this->createQuotation(
            $project,
            30
        );

        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->set(
                'quotationId',
                $quotation->id
            )
            ->assertSet(
                'quotationId',
                null
            )
            ->assertHasErrors([
                'quotationId',
            ]);

        $this->assertDatabaseMissing(
            'invoices',
            [
                'quotation_id' =>
                    $quotation->id,
            ]
        );
    }

    public function test_quotation_cannot_create_more_than_one_invoice(): void
    {
        $project = $this->createProject(
            'on_progress',
            40
        );

        $quotation = $this->createQuotation(
            $project,
            40
        );

        $this->createExistingInvoice(
            $project,
            $quotation,
            40
        );

        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->set(
                'quotationId',
                $quotation->id
            )
            ->assertSet(
                'quotationId',
                null
            )
            ->assertHasErrors([
                'quotationId',
            ]);

        $this->assertSame(
            1,
            Invoice::query()
                ->where(
                    'quotation_id',
                    $quotation->id
                )
                ->count()
        );
    }

    public function test_unapproved_quotation_cannot_create_invoice(): void
    {
        foreach (
            [
                'draft',
                'sent',
                'rejected',
                'expired',
            ] as $index => $status
        ) {
            $sequence = 50 + $index;

            /*
            * Setiap Quotation mempunyai Project sendiri karena
            * relasi Quotation dan Project bersifat satu-ke-satu.
            */
            $project = $this->createProject(
                'planning',
                $sequence
            );

            $quotation = $this->createQuotation(
                $project,
                $sequence,
                $status
            );

            Livewire::actingAs($this->owner)
                ->test(Create::class)
                ->set(
                    'quotationId',
                    $quotation->id
                )
                ->assertSet(
                    'quotationId',
                    null
                )
                ->assertHasErrors([
                    'quotationId',
                ]);
        }

        $this->assertDatabaseCount(
            'invoices',
            0
        );
    }

    public function test_due_date_cannot_be_before_invoice_date(): void
    {
        $project = $this->createProject(
            'planning',
            60
        );

        $quotation = $this->createQuotation(
            $project,
            60
        );

        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->set(
                'quotationId',
                $quotation->id
            )
            ->set(
                'invoiceDate',
                '2026-09-19'
            )
            ->set(
                'dueDate',
                '2026-09-18'
            )
            ->call('createInvoice')
            ->assertHasErrors([
                'dueDate' =>
                    'after_or_equal',
            ]);

        $this->assertDatabaseCount(
            'invoices',
            0
        );
    }

    public function test_user_without_permission_cannot_create_invoice(): void
    {
        $mandor = User::factory()->create([
            'name' => 'Mandor Invoice',
            'status' => 'active',
        ]);

        $mandor->assignRole('mandor');

        $this->actingAs($mandor)
            ->get(
                route('owner.invoices.create')
            )
            ->assertForbidden();
    }

    private function createProject(
        string $status,
        int $sequence
    ): Project {
        return Project::query()->create([
            'client_id' =>
                $this->client->id,

            'mandor_id' =>
                null,

            'project_code' =>
                sprintf(
                    'PRJ-2026-%04d',
                    $sequence
                ),

            'project_name' =>
                'Project Pembayaran '.$sequence,

            'location' =>
                'Jakarta Selatan',

            'description' =>
                'Project untuk pengujian Invoice.',

            'contract_number' =>
                'SPK/'.$sequence.'/IX/2026',

            'contract_date' =>
                '2026-09-18',

            'project_budget' =>
                2500000,

            'contract_value' =>
                3000000,

            'start_date' =>
                '2026-09-19',

            'end_date' =>
                '2026-10-19',

            'progress' =>
                match ($status) {
                    'planning' => 0,
                    'on_progress' => 50,
                    'completed' => 100,
                    default => 0,
                },

            'status' =>
                $status,
        ]);
    }

    private function createQuotation(
        ?Project $project,
        int $sequence,
        string $status = 'approved'
    ): Quotation {
        $quotation = Quotation::query()->create([
            'client_id' =>
                $this->client->id,

            'project_id' =>
                $project?->id,

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
                '2026-09-30',

            'client_name' =>
                'PT Pembayaran Project',

            'client_contact_person' =>
                'Budi Finance',

            'client_phone' =>
                '+628123456789',

            'client_email' =>
                'finance@example.com',

            'client_address' =>
                'Jl. Project No. 10',

            'project_name' =>
                'Project Pembayaran '.$sequence,

            'project_location' =>
                'Jakarta Selatan',

            'subtotal' =>
                3000000,

            'grand_total' =>
                3000000,

            'status' =>
                $status,

            'sent_at' =>
                $status === 'draft'
                    ? null
                    : now(),

            'approved_at' =>
                $status === 'approved'
                    ? now()
                    : null,

            'rejected_at' =>
                $status === 'rejected'
                    ? now()
                    : null,

            'notes' =>
                'Quotation pengujian Invoice.',
        ]);

        $quotation->items()->createMany([
            [
                'item_name' =>
                    'Pekerjaan Utama',

                'description' =>
                    'Pelaksanaan pekerjaan utama.',

                'qty' => 2,

                'unit' => 'lot',

                'price' => 1000000,

                'total' => 2000000,

                'sort_order' => 1,
            ],
            [
                'item_name' =>
                    'Pekerjaan Tambahan',

                'description' =>
                    'Pelaksanaan pekerjaan tambahan.',

                'qty' => 1,

                'unit' => 'lot',

                'price' => 1000000,

                'total' => 1000000,

                'sort_order' => 2,
            ],
        ]);

        return $quotation->refresh();
    }

    private function createExistingInvoice(
        Project $project,
        Quotation $quotation,
        int $sequence
    ): Invoice {
        return Invoice::query()->create([
            'project_id' =>
                $project->id,

            'quotation_id' =>
                $quotation->id,

            'created_by' =>
                $this->owner->id,

            'invoice_number' =>
                sprintf(
                    'INV-2026-%04d',
                    $sequence
                ),

            'invoice_date' =>
                '2026-09-19',

            'due_date' =>
                '2026-10-03',

            'status' =>
                'draft',

            'client_name' =>
                $quotation->client_name,

            'client_contact_person' =>
                $quotation->client_contact_person,

            'client_phone' =>
                $quotation->client_phone,

            'client_email' =>
                $quotation->client_email,

            'client_address' =>
                $quotation->client_address,

            'subtotal' =>
                3000000,

            'tax_amount' =>
                0,

            'discount_amount' =>
                0,

            'grand_total' =>
                3000000,

            'paid_amount' =>
                0,

            'payment_status' =>
                'unpaid',

            'notes' =>
                null,
        ]);
    }
}