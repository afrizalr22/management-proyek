<?php

namespace Tests\Feature\Owner;

use App\Livewire\Owner\Quotations\Index;
use App\Livewire\Owner\Quotations\Show;
use App\Models\Client;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class QuotationStatusWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::create(
                2026,
                9,
                18,
                21,
                52,
                0,
                'Asia/Jakarta'
            )
        );

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $permissions = collect([
            'view-any quotations',
            'view quotations',
            'update quotations',
            'delete quotations',
        ])->map(
            fn (string $permission): Permission => Permission::findOrCreate(
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
            'name' => 'Owner Quotation Workflow',
            'status' => 'active',
        ]);

        $this->owner->assignRole(
            $ownerRole
        );

        $this->client = Client::query()->create([
            'company_name' => 'PT Workflow Quotation',

            'contact_person' => 'Ahmad Workflow',

            'phone' => '+6281234567890',

            'email' => 'workflow.quotation@example.com',

            'city' => 'Jakarta Selatan',

            'status' => 'active',

            'address' => 'Jl. Workflow No. 18',

            'notes' => 'Client pengujian alur status Quotation.',
        ]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_owner_can_send_draft_quotation(): void
    {
        $quotation = $this->createQuotation();

        Livewire::actingAs($this->owner)
            ->test(Show::class, [
                'quotation' => $quotation,
            ])
            ->call('sendQuotation')
            ->assertHasNoErrors()
            ->assertSee('Dikirim');

        $quotation->refresh();

        $this->assertSame(
            'sent',
            $quotation->status
        );

        $this->assertNotNull(
            $quotation->sent_at
        );

        $this->assertTrue(
            $quotation->sent_at->equalTo(now())
        );

        $this->assertNull(
            $quotation->approved_at
        );

        $this->assertNull(
            $quotation->rejected_at
        );
    }

    public function test_expired_draft_quotation_cannot_be_sent(): void
    {
        $quotation = $this->createQuotation([
            'valid_until' => '2026-09-17',
        ]);

        Livewire::actingAs($this->owner)
            ->test(Show::class, [
                'quotation' => $quotation,
            ])
            ->call('sendQuotation')
            ->assertHasErrors([
                'statusAction',
            ]);

        $quotation->refresh();

        $this->assertSame(
            'draft',
            $quotation->status
        );

        $this->assertNull(
            $quotation->sent_at
        );
    }

    public function test_expired_filter_only_displays_expired_draft_quotations(): void
    {
        $expiredQuotation = $this->createQuotation([
            'valid_until' => '2026-09-17',
        ]);

        $activeDraftQuotation = $this->createQuotation([
            'valid_until' => '2026-09-25',
        ]);

        $sentQuotation = $this->createQuotation([
            'status' => 'sent',
            'valid_until' => '2026-09-17',
            'sent_at' => now()->subDay(),
        ]);

        Livewire::actingAs($this->owner)
            ->test(Index::class)
            ->set('status', 'expired')
            ->assertSee(
                $expiredQuotation->quotation_number
            )
            ->assertDontSee(
                $activeDraftQuotation->quotation_number
            )
            ->assertDontSee(
                $sentQuotation->quotation_number
            );

        $expiredQuotation->refresh();

        $this->assertSame(
            'draft',
            $expiredQuotation->status
        );
    }

    public function test_draft_filter_excludes_expired_draft_quotations(): void
    {
        $expiredQuotation = $this->createQuotation([
            'valid_until' => '2026-09-17',
        ]);

        $activeDraftQuotation = $this->createQuotation([
            'valid_until' => '2026-09-25',
        ]);

        $draftWithoutExpiration = $this->createQuotation([
            'valid_until' => null,
        ]);

        Livewire::actingAs($this->owner)
            ->test(Index::class)
            ->set('status', 'draft')
            ->assertDontSee(
                $expiredQuotation->quotation_number
            )
            ->assertSee(
                $activeDraftQuotation->quotation_number
            )
            ->assertSee(
                $draftWithoutExpiration->quotation_number
            );
    }

    public function test_expired_quotation_is_displayed_as_derived_status_while_persisted_as_draft(): void
    {
        $quotation = $this->createQuotation([
            'valid_until' => '2026-09-17',
        ]);

        Livewire::actingAs($this->owner)
            ->test(Show::class, [
                'quotation' => $quotation,
            ])
            ->assertSee('Kedaluwarsa')
            ->assertSee('Masa Berlaku Berakhir')
            ->assertDontSee('Tandai Sudah Dikirim');

        $quotation->refresh();

        $this->assertSame(
            'draft',
            $quotation->status
        );

        $this->assertNull(
            $quotation->sent_at
        );
    }

    public function test_sent_quotation_cannot_be_sent_again(): void
    {
        $originalSentAt = now()
            ->subHour();

        $quotation = $this->createQuotation([
            'status' => 'sent',
            'sent_at' => $originalSentAt,
        ]);

        Livewire::actingAs($this->owner)
            ->test(Show::class, [
                'quotation' => $quotation,
            ])
            ->call('sendQuotation')
            ->assertHasErrors([
                'statusAction',
            ]);

        $quotation->refresh();

        $this->assertSame(
            'sent',
            $quotation->status
        );

        $this->assertTrue(
            $quotation->sent_at->equalTo(
                $originalSentAt
            )
        );
    }

    public function test_owner_can_approve_sent_quotation(): void
    {
        $quotation = $this->createQuotation([
            'status' => 'sent',
            'sent_at' => now()->subHour(),
        ]);

        Livewire::actingAs($this->owner)
            ->test(Show::class, [
                'quotation' => $quotation,
            ])
            ->call('approveQuotation')
            ->assertHasNoErrors()
            ->assertSee('Disetujui')
            ->assertSee('Buat Project');

        $quotation->refresh();

        $this->assertSame(
            'approved',
            $quotation->status
        );

        $this->assertNotNull(
            $quotation->approved_at
        );

        $this->assertTrue(
            $quotation->approved_at->equalTo(now())
        );

        $this->assertNull(
            $quotation->rejected_at
        );
    }

    public function test_owner_can_reject_sent_quotation(): void
    {
        $quotation = $this->createQuotation([
            'status' => 'sent',
            'sent_at' => now()->subHour(),
        ]);

        Livewire::actingAs($this->owner)
            ->test(Show::class, [
                'quotation' => $quotation,
            ])
            ->call('rejectQuotation')
            ->assertHasNoErrors()
            ->assertSee('Ditolak')
            ->assertDontSee('Buat Project');

        $quotation->refresh();

        $this->assertSame(
            'rejected',
            $quotation->status
        );

        $this->assertNotNull(
            $quotation->rejected_at
        );

        $this->assertTrue(
            $quotation->rejected_at->equalTo(now())
        );

        $this->assertNull(
            $quotation->approved_at
        );
    }

    public function test_draft_quotation_cannot_be_approved_directly(): void
    {
        $quotation = $this->createQuotation();

        Livewire::actingAs($this->owner)
            ->test(Show::class, [
                'quotation' => $quotation,
            ])
            ->call('approveQuotation')
            ->assertHasErrors([
                'statusAction',
            ]);

        $quotation->refresh();

        $this->assertSame(
            'draft',
            $quotation->status
        );

        $this->assertNull(
            $quotation->approved_at
        );
    }

    public function test_draft_quotation_cannot_be_rejected_directly(): void
    {
        $quotation = $this->createQuotation();

        Livewire::actingAs($this->owner)
            ->test(Show::class, [
                'quotation' => $quotation,
            ])
            ->call('rejectQuotation')
            ->assertHasErrors([
                'statusAction',
            ]);

        $quotation->refresh();

        $this->assertSame(
            'draft',
            $quotation->status
        );

        $this->assertNull(
            $quotation->rejected_at
        );
    }

    public function test_approved_quotation_cannot_be_changed_again(): void
    {
        $approvedAt = now()
            ->subMinutes(30);

        $quotation = $this->createQuotation([
            'status' => 'approved',
            'sent_at' => now()->subHour(),
            'approved_at' => $approvedAt,
        ]);

        Livewire::actingAs($this->owner)
            ->test(Show::class, [
                'quotation' => $quotation,
            ])
            ->call('rejectQuotation')
            ->assertHasErrors([
                'statusAction',
            ]);

        $quotation->refresh();

        $this->assertSame(
            'approved',
            $quotation->status
        );

        $this->assertTrue(
            $quotation->approved_at->equalTo(
                $approvedAt
            )
        );

        $this->assertNull(
            $quotation->rejected_at
        );
    }

    public function test_rejected_quotation_cannot_be_changed_again(): void
    {
        $rejectedAt = now()
            ->subMinutes(30);

        $quotation = $this->createQuotation([
            'status' => 'rejected',
            'sent_at' => now()->subHour(),
            'rejected_at' => $rejectedAt,
        ]);

        Livewire::actingAs($this->owner)
            ->test(Show::class, [
                'quotation' => $quotation,
            ])
            ->call('approveQuotation')
            ->assertHasErrors([
                'statusAction',
            ]);

        $quotation->refresh();

        $this->assertSame(
            'rejected',
            $quotation->status
        );

        $this->assertTrue(
            $quotation->rejected_at->equalTo(
                $rejectedAt
            )
        );

        $this->assertNull(
            $quotation->approved_at
        );
    }

    public function test_user_without_update_permission_cannot_change_status(): void
    {
        $viewer = User::factory()->create([
            'name' => 'Viewer Quotation',
            'status' => 'active',
        ]);

        $viewer->givePermissionTo(
            Permission::findOrCreate(
                'view quotations',
                'web'
            )
        );

        $quotation = $this->createQuotation();

        Livewire::actingAs($viewer)
            ->test(Show::class, [
                'quotation' => $quotation,
            ])
            ->call('sendQuotation')
            ->assertForbidden();

        $quotation->refresh();

        $this->assertSame(
            'draft',
            $quotation->status
        );

        $this->assertNull(
            $quotation->sent_at
        );
    }

    private function createQuotation(
        array $attributes = []
    ): Quotation {
        $sequence =
            Quotation::query()->count() + 1;

        return Quotation::query()->create(
            array_merge([
                'client_id' => $this->client->id,

                'project_id' => null,

                'created_by' => $this->owner->id,

                'quotation_number' => sprintf(
                    'QT-2026-%04d',
                    $sequence
                ),

                'quotation_date' => '2026-09-18',

                'valid_until' => '2026-09-25',

                'client_name' => $this->client->company_name,

                'client_contact_person' => $this->client->contact_person,

                'client_phone' => $this->client->phone,

                'client_email' => $this->client->email,

                'client_address' => $this->client->address,

                'project_name' => 'Project Workflow Quotation',

                'project_location' => 'Jakarta Selatan',

                'subtotal' => 1000000,

                'grand_total' => 1000000,

                'status' => 'draft',

                'sent_at' => null,

                'approved_at' => null,

                'rejected_at' => null,

                'notes' => 'Pengujian alur status Quotation.',
            ], $attributes)
        );
    }
}
