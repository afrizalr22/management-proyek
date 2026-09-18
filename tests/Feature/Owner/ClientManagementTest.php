<?php

namespace Tests\Feature\Owner;

use App\Livewire\Owner\Clients\Create as CreateClient;
use App\Livewire\Owner\Clients\Edit as EditClient;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ClientManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        foreach (
            [
                'create clients',
                'update clients',
            ] as $permission
        ) {
            Permission::findOrCreate(
                $permission,
                'web'
            );
        }

        $ownerRole = Role::findOrCreate(
            'owner',
            'web'
        );

        Role::findOrCreate(
            'mandor',
            'web'
        );

        $ownerRole->givePermissionTo([
            'create clients',
            'update clients',
        ]);

        $this->owner = User::factory()->create([
            'name' => 'Owner Pengujian',
            'status' => 'active',
        ]);

        $this->owner->assignRole(
            $ownerRole
        );
    }

    private function createClient(
        array $attributes = []
    ): Client {
        return Client::query()->create(
            array_merge([
                'company_name' =>
                    'PT Client Pengujian',

                'contact_person' =>
                    'Client Pengujian',

                'phone' =>
                    '+6281234567890',

                'email' =>
                    'client@example.com',

                'city' =>
                    'Jakarta Selatan',

                'status' =>
                    'active',

                'address' =>
                    'Jl. Pengujian No. 10',

                'notes' =>
                    'Catatan awal Client.',
            ], $attributes)
        );
    }

    public function test_owner_can_open_client_create_page(): void
    {
        $this->actingAs($this->owner)
            ->get(
                route('owner.clients.create')
            )
            ->assertOk();
    }

    public function test_non_owner_cannot_open_client_create_page(): void
    {
        $mandor = User::factory()->create([
            'name' => 'Mandor Pengujian',
            'status' => 'active',
        ]);

        $mandor->assignRole('mandor');

        $this->actingAs($mandor)
            ->get(
                route('owner.clients.create')
            )
            ->assertForbidden();
    }

    public function test_owner_can_create_client_with_complete_information(): void
    {
        Livewire::actingAs($this->owner)
            ->test(CreateClient::class)
            ->set(
                'name',
                'Ahmad UAT'
            )
            ->set(
                'company',
                'PT UAT Integrasi Nusantara'
            )
            ->set(
                'email',
                'UAT.INTEGRASI@EXAMPLE.COM'
            )
            ->set(
                'phone',
                '081234567890'
            )
            ->set(
                'city',
                'Jakarta Selatan'
            )
            ->set(
                'address',
                'Jl. UAT Integrasi No. 22'
            )
            ->set(
                'notes',
                'Client dibuat untuk pengujian otomatis.'
            )
            ->set(
                'status',
                'lead'
            )
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('owner.clients.index')
            );

        $this->assertDatabaseHas('clients', [
            'company_name' =>
                'PT UAT Integrasi Nusantara',

            'contact_person' =>
                'Ahmad UAT',

            'email' =>
                'uat.integrasi@example.com',

            'phone' =>
                '+6281234567890',

            'city' =>
                'Jakarta Selatan',

            'address' =>
                'Jl. UAT Integrasi No. 22',

            'notes' =>
                'Client dibuat untuk pengujian otomatis.',

            'status' =>
                'lead',
        ]);
    }

    public function test_owner_can_create_client_without_address_and_notes(): void
    {
        Livewire::actingAs($this->owner)
            ->test(CreateClient::class)
            ->set(
                'name',
                'Client Tanpa Catatan'
            )
            ->set(
                'company',
                'PT Client Minimal'
            )
            ->set(
                'email',
                'minimal@example.com'
            )
            ->set(
                'phone',
                '081298765432'
            )
            ->set(
                'city',
                'Jakarta Barat'
            )
            ->set(
                'address',
                ''
            )
            ->set(
                'notes',
                ''
            )
            ->set(
                'status',
                'active'
            )
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('clients', [
            'company_name' =>
                'PT Client Minimal',

            'address' =>
                null,

            'notes' =>
                null,
        ]);
    }

    public function test_duplicate_client_email_is_rejected(): void
    {
        $this->createClient([
            'email' =>
                'duplicate@example.com',
        ]);

        Livewire::actingAs($this->owner)
            ->test(CreateClient::class)
            ->set(
                'name',
                'Client Duplikat'
            )
            ->set(
                'company',
                'PT Client Duplikat'
            )
            ->set(
                'email',
                'duplicate@example.com'
            )
            ->set(
                'phone',
                '081211112222'
            )
            ->set(
                'city',
                'Jakarta Timur'
            )
            ->set(
                'status',
                'active'
            )
            ->call('save')
            ->assertHasErrors([
                'email' => 'unique',
            ]);

        $this->assertDatabaseCount(
            'clients',
            1
        );
    }

    public function test_edit_form_loads_existing_client_information(): void
    {
        $client = $this->createClient();

        Livewire::actingAs($this->owner)
            ->test(
                EditClient::class,
                [
                    'client' => $client,
                ]
            )
            ->assertSet(
                'name',
                'Client Pengujian'
            )
            ->assertSet(
                'company',
                'PT Client Pengujian'
            )
            ->assertSet(
                'phone',
                '81234567890'
            )
            ->assertSet(
                'city',
                'Jakarta Selatan'
            )
            ->assertSet(
                'notes',
                'Catatan awal Client.'
            )
            ->assertSet(
                'status',
                'active'
            );
    }

    public function test_owner_can_update_only_client_notes(): void
    {
        $client = $this->createClient();

        Livewire::actingAs($this->owner)
            ->test(
                EditClient::class,
                [
                    'client' => $client,
                ]
            )
            ->set(
                'notes',
                'Catatan Client telah diperbarui.'
            )
            ->call('update')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('owner.clients.index')
            );

        $this->assertDatabaseHas('clients', [
            'id' =>
                $client->id,

            'notes' =>
                'Catatan Client telah diperbarui.',
        ]);
    }

    public function test_owner_can_change_client_status_to_lead(): void
    {
        $client = $this->createClient();

        Livewire::actingAs($this->owner)
            ->test(
                EditClient::class,
                [
                    'client' => $client,
                ]
            )
            ->set(
                'status',
                'lead'
            )
            ->call('update')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('clients', [
            'id' =>
                $client->id,

            'status' =>
                'lead',
        ]);
    }

    public function test_owner_can_clear_client_address_and_notes(): void
    {
        $client = $this->createClient();

        Livewire::actingAs($this->owner)
            ->test(
                EditClient::class,
                [
                    'client' => $client,
                ]
            )
            ->set(
                'address',
                ''
            )
            ->set(
                'notes',
                ''
            )
            ->call('update')
            ->assertHasNoErrors();

        $client->refresh();

        $this->assertNull(
            $client->address
        );

        $this->assertNull(
            $client->notes
        );
    }

    public function test_client_notes_cannot_exceed_two_thousand_characters(): void
    {
        Livewire::actingAs($this->owner)
            ->test(CreateClient::class)
            ->set(
                'name',
                'Client Catatan Panjang'
            )
            ->set(
                'company',
                'PT Catatan Panjang'
            )
            ->set(
                'email',
                'catatan.panjang@example.com'
            )
            ->set(
                'phone',
                '081233344455'
            )
            ->set(
                'city',
                'Jakarta Pusat'
            )
            ->set(
                'notes',
                str_repeat(
                    'A',
                    2001
                )
            )
            ->set(
                'status',
                'active'
            )
            ->call('save')
            ->assertHasErrors([
                'notes' => 'max',
            ]);

        $this->assertDatabaseMissing('clients', [
            'email' =>
                'catatan.panjang@example.com',
        ]);
    }
}