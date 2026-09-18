<?php

namespace Tests\Feature\Owner;

use App\Livewire\Owner\Quotations\Create;
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

class QuotationCreationTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(
            '2026-09-18 10:00:00'
        );

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $permission = Permission::findOrCreate(
            'create quotations',
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
            'name' => 'Owner Quotation',
            'status' => 'active',
        ]);

        $this->owner->assignRole(
            $ownerRole
        );

        $this->client = Client::query()->create([
            'company_name' =>
                'PT UAT Integrasi Nusantara',

            'contact_person' =>
                'Ahmad UAT',

            'phone' =>
                '+6281234567890',

            'email' =>
                'uat.integrasi@example.com',

            'city' =>
                'Jakarta Selatan',

            'status' =>
                'active',

            'address' =>
                'Jl. UAT Integrasi No. 22',

            'notes' =>
                'Client untuk pengujian Quotation.',
        ]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_owner_can_open_quotation_create_page(): void
    {
        $this->actingAs($this->owner)
            ->get(
                route('owner.quotations.create')
            )
            ->assertOk()
            ->assertSee(
                'Buat Quotation'
            )
            ->assertSee(
                'PT UAT Integrasi Nusantara'
            );
    }

    public function test_non_owner_cannot_open_quotation_create_page(): void
    {
        $mandor = User::factory()->create([
            'name' => 'Mandor Quotation',
            'status' => 'active',
        ]);

        $mandor->assignRole('mandor');

        $this->actingAs($mandor)
            ->get(
                route('owner.quotations.create')
            )
            ->assertForbidden();
    }

    public function test_owner_can_create_quotation_with_items(): void
    {
        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->set(
                'clientId',
                $this->client->id
            )
            ->set(
                'quotationDate',
                '2026-09-18'
            )
            ->set(
                'validUntil',
                '2026-09-25'
            )
            ->set(
                'projectName',
                'Renovasi Gedung UAT'
            )
            ->set(
                'projectLocation',
                'Jakarta Selatan'
            )
            ->set(
                'notes',
                'Harga berlaku selama tujuh hari.'
            )
            ->set('items', [
                [
                    'item_name' =>
                        'Pekerjaan Persiapan',

                    'description' =>
                        'Persiapan area dan mobilisasi.',

                    'qty' =>
                        2,

                    'unit' =>
                        'lot',

                    'price' =>
                        1000000,
                ],
                [
                    'item_name' =>
                        'Pekerjaan Finishing',

                    'description' =>
                        'Penyelesaian pekerjaan akhir.',

                    'qty' =>
                        3,

                    'unit' =>
                        'unit',

                    'price' =>
                        500000,
                ],
            ])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('owner.quotations.index')
            );

        $quotation = Quotation::query()
            ->with('items')
            ->sole();

        $this->assertSame(
            $this->client->id,
            $quotation->client_id
        );

        $this->assertSame(
            $this->owner->id,
            $quotation->created_by
        );

        $this->assertNull(
            $quotation->project_id
        );

        $this->assertSame(
            'QT-2026-0001',
            $quotation->quotation_number
        );

        $this->assertSame(
            'draft',
            $quotation->status
        );

        $this->assertSame(
            'PT UAT Integrasi Nusantara',
            $quotation->client_name
        );

        $this->assertSame(
            'Ahmad UAT',
            $quotation->client_contact_person
        );

        $this->assertSame(
            'Renovasi Gedung UAT',
            $quotation->project_name
        );

        $this->assertSame(
            '3500000.00',
            $quotation->subtotal
        );

        $this->assertSame(
            '3500000.00',
            $quotation->grand_total
        );

        $this->assertCount(
            2,
            $quotation->items
        );

        $this->assertSame(
            'Pekerjaan Persiapan',
            $quotation->items[0]->item_name
        );

        $this->assertSame(
            '2000000.00',
            $quotation->items[0]->total
        );

        $this->assertSame(
            1,
            $quotation->items[0]->sort_order
        );

        $this->assertSame(
            2,
            $quotation->items[1]->sort_order
        );
    }

    public function test_quotation_uses_client_snapshot_data(): void
    {
        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->set(
                'clientId',
                $this->client->id
            )
            ->set(
                'quotationDate',
                '2026-09-18'
            )
            ->set(
                'validUntil',
                '2026-09-25'
            )
            ->set(
                'projectName',
                'Project Snapshot'
            )
            ->set('items', [
                [
                    'item_name' =>
                        'Pekerjaan Snapshot',

                    'description' =>
                        '',

                    'qty' =>
                        1,

                    'unit' =>
                        'lot',

                    'price' =>
                        750000,
                ],
            ])
            ->call('save')
            ->assertHasNoErrors();

        $quotation = Quotation::query()->sole();

        $this->client->update([
            'company_name' =>
                'PT Nama Client Berubah',

            'contact_person' =>
                'Kontak Baru',
        ]);

        $quotation->refresh();

        $this->assertSame(
            'PT UAT Integrasi Nusantara',
            $quotation->client_name
        );

        $this->assertSame(
            'Ahmad UAT',
            $quotation->client_contact_person
        );
    }

    public function test_inactive_client_cannot_be_used_for_quotation(): void
    {
        $this->client->update([
            'status' => 'inactive',
        ]);

        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->set(
                'clientId',
                $this->client->id
            )
            ->set(
                'quotationDate',
                '2026-09-18'
            )
            ->set(
                'validUntil',
                '2026-09-25'
            )
            ->set(
                'projectName',
                'Project Tidak Valid'
            )
            ->set('items', [
                [
                    'item_name' =>
                        'Item Tidak Valid',

                    'description' =>
                        '',

                    'qty' =>
                        1,

                    'unit' =>
                        'unit',

                    'price' =>
                        100000,
                ],
            ])
            ->call('save')
            ->assertHasErrors([
                'clientId',
            ]);

        $this->assertDatabaseCount(
            'quotations',
            0
        );
    }

    public function test_valid_until_cannot_be_before_quotation_date(): void
    {
        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->set(
                'clientId',
                $this->client->id
            )
            ->set(
                'quotationDate',
                '2026-09-18'
            )
            ->set(
                'validUntil',
                '2026-09-17'
            )
            ->set(
                'projectName',
                'Project Tanggal'
            )
            ->set('items', [
                [
                    'item_name' =>
                        'Item Pengujian',

                    'description' =>
                        '',

                    'qty' =>
                        1,

                    'unit' =>
                        'unit',

                    'price' =>
                        100000,
                ],
            ])
            ->call('save')
            ->assertHasErrors([
                'validUntil' =>
                    'after_or_equal',
            ]);

        $this->assertDatabaseCount(
            'quotations',
            0
        );
    }

    public function test_item_quantity_must_be_greater_than_zero(): void
    {
        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->set(
                'clientId',
                $this->client->id
            )
            ->set(
                'quotationDate',
                '2026-09-18'
            )
            ->set(
                'validUntil',
                '2026-09-25'
            )
            ->set(
                'projectName',
                'Project Quantity'
            )
            ->set('items', [
                [
                    'item_name' =>
                        'Item Quantity',

                    'description' =>
                        '',

                    'qty' =>
                        0,

                    'unit' =>
                        'unit',

                    'price' =>
                        100000,
                ],
            ])
            ->call('save')
            ->assertHasErrors([
                'items.0.qty' => 'gt',
            ]);

        $this->assertDatabaseCount(
            'quotations',
            0
        );
    }

    public function test_last_quotation_item_cannot_be_removed(): void
    {
        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->call(
                'removeItem',
                0
            )
            ->assertHasErrors([
                'items',
            ])
            ->assertCount(
                'items',
                1
            );
    }

    public function test_quotation_numbers_are_sequential(): void
    {
        foreach (
            [
                'Project Pertama',
                'Project Kedua',
            ] as $projectName
        ) {
            Livewire::actingAs($this->owner)
                ->test(Create::class)
                ->set(
                    'clientId',
                    $this->client->id
                )
                ->set(
                    'quotationDate',
                    '2026-09-18'
                )
                ->set(
                    'validUntil',
                    '2026-09-25'
                )
                ->set(
                    'projectName',
                    $projectName
                )
                ->set('items', [
                    [
                        'item_name' =>
                            'Item '.$projectName,

                        'description' =>
                            '',

                        'qty' =>
                            1,

                        'unit' =>
                            'unit',

                        'price' =>
                            100000,
                    ],
                ])
                ->call('save')
                ->assertHasNoErrors();
        }

        $this->assertSame(
            [
                'QT-2026-0001',
                'QT-2026-0002',
            ],
            Quotation::query()
                ->orderBy('id')
                ->pluck('quotation_number')
                ->all()
        );
    }
}