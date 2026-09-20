<?php

namespace Tests\Feature\Owner;

use App\Livewire\Owner\Invoices\Edit;
use App\Livewire\Owner\Invoices\Show;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class InvoiceStatusPaymentWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(
            '2026-09-20 10:00:00'
        );

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $permissions = collect([
            'view invoices',
            'update invoices',
            'delete invoices',
        ])->map(
            fn (string $permission): Permission =>
                Permission::findOrCreate(
                    $permission,
                    'web'
                )
        );

        $ownerRole = Role::findOrCreate(
            'owner',
            'web'
        );

        $ownerRole->syncPermissions(
            $permissions
        );

        $this->owner = User::factory()->create([
            'name' => 'Owner Workflow Invoice',
            'status' => 'active',
        ]);

        $this->owner->assignRole(
            $ownerRole
        );
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_owner_can_open_invoice_detail(): void
    {
        $invoice = $this->createInvoice();

        $this->actingAs($this->owner)
            ->get(
                route(
                    'owner.invoices.show',
                    $invoice
                )
            )
            ->assertOk()
            ->assertSee($invoice->invoice_number)
            ->assertSee('Status Pembayaran')
            ->assertSee('Belum Dibayar');
    }

    public function test_draft_invoice_dates_and_notes_can_be_updated_without_changing_items(): void
    {
        $invoice = $this->createInvoice();

        $item = $invoice->items()->firstOrFail();

        Livewire::actingAs($this->owner)
            ->test(
                Edit::class,
                [
                    'invoice' => $invoice,
                ]
            )
            ->set(
                'invoiceDate',
                '2026-09-21'
            )
            ->set(
                'dueDate',
                '2026-10-05'
            )
            ->set(
                'notes',
                'Pembayaran dilakukan melalui transfer.'
            )
            ->call('updateInvoice')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.invoices.show',
                    $invoice
                )
            );

        $invoice->refresh();
        $item->refresh();

        $this->assertSame(
            '2026-09-21',
            $invoice->invoice_date->format('Y-m-d')
        );

        $this->assertSame(
            '2026-10-05',
            $invoice->due_date->format('Y-m-d')
        );

        $this->assertSame(
            'Pembayaran dilakukan melalui transfer.',
            $invoice->notes
        );

        $this->assertSame(
            'Item Pekerjaan Utama',
            $item->item_name
        );

        $this->assertSame(
            '2.00',
            $item->qty
        );

        $this->assertSame(
            '1000000.00',
            $item->price
        );

        $this->assertSame(
            '2000000.00',
            $item->total
        );

        $this->assertSame(
            '2000000.00',
            $invoice->subtotal
        );

        $this->assertSame(
            '2000000.00',
            $invoice->grand_total
        );
    }

    public function test_invoice_item_fields_are_not_rendered_as_editable_inputs(): void
    {
        $invoice = $this->createInvoice();

        Livewire::actingAs($this->owner)
            ->test(
                Edit::class,
                [
                    'invoice' => $invoice,
                ]
            )
            ->assertSee('Item Invoice')
            ->assertSee('Item Pekerjaan Utama')
            ->assertDontSee('Tambah Item')
            ->assertDontSee('Hapus item');
    }

    public function test_due_date_cannot_be_before_invoice_date(): void
    {
        $invoice = $this->createInvoice();

        Livewire::actingAs($this->owner)
            ->test(
                Edit::class,
                [
                    'invoice' => $invoice,
                ]
            )
            ->set(
                'invoiceDate',
                '2026-09-25'
            )
            ->set(
                'dueDate',
                '2026-09-24'
            )
            ->call('updateInvoice')
            ->assertHasErrors([
                'dueDate' => 'after_or_equal',
            ]);

        $this->assertSame(
            '2026-09-20',
            $invoice->fresh()
                ->invoice_date
                ->format('Y-m-d')
        );
    }

    public function test_non_draft_invoice_cannot_open_edit_page(): void
    {
        $invoice = $this->createInvoice(
            status: 'issued'
        );

        $this->actingAs($this->owner)
            ->get(
                route(
                    'owner.invoices.edit',
                    $invoice
                )
            )
            ->assertForbidden();
    }

    public function test_draft_invoice_can_be_issued(): void
    {
        $invoice = $this->createInvoice();

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'invoice' => $invoice,
                ]
            )
            ->call('issueInvoice')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.invoices.show',
                    $invoice
                )
            );

        $invoice->refresh();

        $this->assertSame(
            'issued',
            $invoice->status
        );

        $this->assertNotNull(
            $invoice->issued_at
        );

        $this->assertTrue(
            $invoice->issued_at->equalTo(now())
        );
    }

    public function test_issued_invoice_can_be_marked_as_sent(): void
    {
        $invoice = $this->createInvoice(
            status: 'issued'
        );

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'invoice' => $invoice,
                ]
            )
            ->call('markAsSent')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.invoices.show',
                    $invoice
                )
            );

        $invoice->refresh();

        $this->assertSame(
            'sent',
            $invoice->status
        );

        $this->assertNotNull(
            $invoice->sent_at
        );

        $this->assertTrue(
            $invoice->sent_at->equalTo(now())
        );
    }

    public function test_partial_payment_updates_invoice_balance(): void
    {
        $invoice = $this->createInvoice(
            status: 'issued'
        );

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'invoice' => $invoice,
                ]
            )
            ->set(
                'paymentAmount',
                '750000'
            )
            ->call('recordPayment')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.invoices.show',
                    $invoice
                )
            );

        $invoice->refresh();

        $this->assertSame(
            '750000.00',
            $invoice->paid_amount
        );

        $this->assertSame(
            'partial',
            $invoice->payment_status
        );

        $this->assertNull(
            $invoice->paid_at
        );
    }

    public function test_remaining_payment_marks_invoice_as_paid(): void
    {
        $invoice = $this->createInvoice(
            status: 'sent',
            paidAmount: 750000,
            paymentStatus: 'partial'
        );

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'invoice' => $invoice,
                ]
            )
            ->set(
                'paymentAmount',
                '1250000'
            )
            ->call('recordPayment')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.invoices.show',
                    $invoice
                )
            );

        $invoice->refresh();

        $this->assertSame(
            '2000000.00',
            $invoice->paid_amount
        );

        $this->assertSame(
            'paid',
            $invoice->payment_status
        );

        $this->assertNotNull(
            $invoice->paid_at
        );

        $this->assertTrue(
            $invoice->paid_at->equalTo(now())
        );
    }

    public function test_payment_cannot_exceed_remaining_balance(): void
    {
        $invoice = $this->createInvoice(
            status: 'issued',
            paidAmount: 500000,
            paymentStatus: 'partial'
        );

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'invoice' => $invoice,
                ]
            )
            ->set(
                'paymentAmount',
                '1600000'
            )
            ->call('recordPayment')
            ->assertHasErrors([
                'paymentAmount',
            ]);

        $invoice->refresh();

        $this->assertSame(
            '500000.00',
            $invoice->paid_amount
        );

        $this->assertSame(
            'partial',
            $invoice->payment_status
        );

        $this->assertNull(
            $invoice->paid_at
        );
    }

    public function test_invoice_with_payment_cannot_be_cancelled(): void
    {
        $invoice = $this->createInvoice(
            status: 'issued',
            paidAmount: 500000,
            paymentStatus: 'partial'
        );

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'invoice' => $invoice,
                ]
            )
            ->call('cancelInvoice')
            ->assertHasErrors([
                'action',
            ]);

        $this->assertSame(
            'issued',
            $invoice->fresh()->status
        );
    }

    public function test_unpaid_invoice_can_be_cancelled(): void
    {
        $invoice = $this->createInvoice(
            status: 'sent'
        );

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'invoice' => $invoice,
                ]
            )
            ->call('cancelInvoice')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.invoices.show',
                    $invoice
                )
            );

        $invoice->refresh();

        $this->assertSame(
            'cancelled',
            $invoice->status
        );

        $this->assertSame(
            'unpaid',
            $invoice->payment_status
        );
    }

    public function test_user_without_permission_cannot_run_invoice_actions(): void
    {
        $invoice = $this->createInvoice();

        $user = User::factory()->create([
            'status' => 'active',
        ]);

        Livewire::actingAs($user)
            ->test(
                Show::class,
                [
                    'invoice' => $invoice,
                ]
            )
            ->assertForbidden();
    }

    private function createInvoice(
        string $status = 'draft',
        float $paidAmount = 0,
        string $paymentStatus = 'unpaid'
    ): Invoice {
        $invoice = Invoice::query()->create([
            'project_id' => null,
            'quotation_id' => null,
            'created_by' => $this->owner->id,
            'invoice_number' => 'INV-2026-9001',
            'invoice_date' => '2026-09-20',
            'due_date' => '2026-10-04',
            'status' => $status,
            'client_name' => 'PT Workflow Invoice',
            'client_contact_person' => 'Budi Finance',
            'client_phone' => '+628123456789',
            'client_email' => 'finance@example.com',
            'client_address' => 'Jakarta Selatan',
            'subtotal' => 2000000,
            'tax_amount' => 0,
            'discount_amount' => 0,
            'grand_total' => 2000000,
            'paid_amount' => $paidAmount,
            'payment_status' => $paymentStatus,

            'issued_at' => in_array(
                $status,
                [
                    'issued',
                    'sent',
                ],
                true
            )
                ? now()->subHour()
                : null,

            'sent_at' => $status === 'sent'
                ? now()->subMinutes(30)
                : null,

            'paid_at' => $paymentStatus === 'paid'
                ? now()
                : null,

            'notes' => null,
        ]);

        $invoice->items()->create([
            'item_name' => 'Item Pekerjaan Utama',
            'description' => 'Snapshot item Quotation.',
            'qty' => 2,
            'unit' => 'lot',
            'price' => 1000000,
            'total' => 2000000,
            'sort_order' => 1,
        ]);

        return $invoice->fresh([
            'items',
        ]);
    }
}