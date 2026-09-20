<?php

namespace Tests\Feature\Owner;

use App\Livewire\Owner\Users\Create;
use App\Livewire\Owner\Users\Delete;
use App\Livewire\Owner\Users\Edit;
use App\Livewire\Owner\Users\Index;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectWorker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class UserManagementTest extends TestCase
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

        $permissions = [
            'view-any users',
            'view users',
            'create users',
            'update users',
            'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate(
                $permission,
                'web'
            );
        }

        Role::findByName(
            'owner',
            'web'
        )->syncPermissions($permissions);

        $this->owner = $this->createUser(
            'Owner Utama',
            'owner@example.com',
            'owner'
        );
    }

    public function test_owner_can_access_user_management_pages(): void
    {
        $worker = $this->createUser(
            'Pekerja Akses',
            'pekerja.akses@example.com',
            'pekerja'
        );

        $this->actingAs($this->owner)
            ->get(route('owner.users.index'))
            ->assertOk();

        $this->actingAs($this->owner)
            ->get(route('owner.users.create'))
            ->assertOk();

        $this->actingAs($this->owner)
            ->get(
                route(
                    'owner.users.show',
                    $worker
                )
            )
            ->assertOk()
            ->assertSee('Pekerja Akses');

        $this->actingAs($this->owner)
            ->get(
                route(
                    'owner.users.edit',
                    $worker
                )
            )
            ->assertOk();
    }

    public function test_non_owner_cannot_access_owner_user_routes(): void
    {
        $worker = $this->createUser(
            'Pekerja Ditolak',
            'pekerja.ditolak@example.com',
            'pekerja'
        );

        foreach (
            [
                route('owner.users.index'),
                route('owner.users.create'),
                route(
                    'owner.users.show',
                    $worker
                ),
                route(
                    'owner.users.edit',
                    $worker
                ),
            ] as $url
        ) {
            $this->actingAs($worker)
                ->get($url)
                ->assertForbidden();
        }
    }

    public function test_owner_can_create_mandor_account(): void
    {
        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->set('name', '  Mandor Baru  ')
            ->set(
                'email',
                'MANDOR.BARU@EXAMPLE.COM'
            )
            ->set('phone', '0812 3456 7890')
            ->set('role', 'mandor')
            ->set('status', 'active')
            ->set('password', 'Mandor123')
            ->set(
                'password_confirmation',
                'Mandor123'
            )
            ->call('createUser')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('owner.users.index')
            );

        $mandor = User::query()
            ->where(
                'email',
                'mandor.baru@example.com'
            )
            ->sole();

        $this->assertSame(
            'Mandor Baru',
            $mandor->name
        );

        $this->assertSame(
            '0812 3456 7890',
            $mandor->phone
        );

        $this->assertSame(
            'active',
            $mandor->status
        );

        $this->assertTrue(
            $mandor->hasRole('mandor')
        );

        $this->assertTrue(
            Hash::check(
                'Mandor123',
                $mandor->password
            )
        );
    }

    public function test_duplicate_email_and_invalid_password_are_rejected(): void
    {
        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->set('name', 'Pengguna Duplikat')
            ->set(
                'email',
                $this->owner->email
            )
            ->set('role', 'pekerja')
            ->set('status', 'active')
            ->set('password', 'pendek')
            ->set(
                'password_confirmation',
                'berbeda'
            )
            ->call('createUser')
            ->assertHasErrors([
                'email' => 'unique',
                'password',
            ]);

        $this->assertDatabaseMissing(
            'users',
            [
                'name' => 'Pengguna Duplikat',
            ]
        );
    }

    public function test_owner_can_update_user_without_changing_password(): void
    {
        $worker = $this->createUser(
            'Pekerja Lama',
            'pekerja.lama@example.com',
            'pekerja',
            'active',
            'Password123'
        );

        $oldPassword = $worker->password;

        Livewire::actingAs($this->owner)
            ->test(
                Edit::class,
                [
                    'user' => $worker,
                ]
            )
            ->set('name', 'Pekerja Diperbarui')
            ->set(
                'email',
                'PEKERJA.BARU@EXAMPLE.COM'
            )
            ->set('phone', '081234567890')
            ->set('role', 'mandor')
            ->set('status', 'active')
            ->set('password', '')
            ->set(
                'password_confirmation',
                ''
            )
            ->call('updateUser')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.users.show',
                    $worker
                )
            );

        $worker->refresh();

        $this->assertSame(
            'Pekerja Diperbarui',
            $worker->name
        );

        $this->assertSame(
            'pekerja.baru@example.com',
            $worker->email
        );

        $this->assertSame(
            $oldPassword,
            $worker->password
        );

        $this->assertTrue(
            $worker->hasRole('mandor')
        );

        $this->assertFalse(
            $worker->hasRole('pekerja')
        );
    }

    public function test_owner_cannot_change_own_role_or_deactivate_own_account(): void
    {
        Livewire::actingAs($this->owner)
            ->test(
                Edit::class,
                [
                    'user' => $this->owner,
                ]
            )
            ->set('role', 'mandor')
            ->call('updateUser')
            ->assertHasErrors([
                'role',
            ]);

        Livewire::actingAs($this->owner)
            ->test(
                Edit::class,
                [
                    'user' => $this->owner,
                ]
            )
            ->set('status', 'inactive')
            ->call('updateUser')
            ->assertHasErrors([
                'status',
            ]);

        $this->owner->refresh();

        $this->assertSame(
            'active',
            $this->owner->status
        );

        $this->assertTrue(
            $this->owner->hasRole('owner')
        );
    }

    public function test_last_active_owner_cannot_be_changed_by_authorized_operator(): void
    {
        $operator = $this->createUser(
            'Operator User',
            'operator@example.com',
            'mandor'
        );

        $operator->givePermissionTo(
            'update users'
        );

        Livewire::actingAs($operator)
            ->test(
                Edit::class,
                [
                    'user' => $this->owner,
                ]
            )
            ->set('role', 'pekerja')
            ->call('updateUser')
            ->assertHasErrors([
                'role',
            ]);

        Livewire::actingAs($operator)
            ->test(
                Edit::class,
                [
                    'user' => $this->owner,
                ]
            )
            ->set('status', 'inactive')
            ->call('updateUser')
            ->assertHasErrors([
                'status',
            ]);
    }

    public function test_mandor_with_active_project_cannot_be_deactivated_or_change_role(): void
    {
        $mandor = $this->createUser(
            'Mandor Aktif',
            'mandor.aktif@example.com',
            'mandor'
        );

        $this->createProject($mandor);

        Livewire::actingAs($this->owner)
            ->test(
                Edit::class,
                [
                    'user' => $mandor,
                ]
            )
            ->set('status', 'inactive')
            ->call('updateUser')
            ->assertHasErrors([
                'status',
            ]);

        Livewire::actingAs($this->owner)
            ->test(
                Edit::class,
                [
                    'user' => $mandor,
                ]
            )
            ->set('role', 'pekerja')
            ->call('updateUser')
            ->assertHasErrors([
                'role',
            ]);
    }

    public function test_worker_with_active_assignment_cannot_be_deactivated_or_change_role(): void
    {
        $mandor = $this->createUser(
            'Mandor Project',
            'mandor.project@example.com',
            'mandor'
        );

        $worker = $this->createUser(
            'Pekerja Aktif',
            'pekerja.aktif@example.com',
            'pekerja'
        );

        $project = $this->createProject(
            $mandor
        );

        ProjectWorker::query()->create([
            'project_id' => $project->id,
            'worker_id' => $worker->id,
            'assigned_by' => $this->owner->id,
            'status' => 'active',
            'joined_at' => '2026-09-21',
        ]);

        Livewire::actingAs($this->owner)
            ->test(
                Edit::class,
                [
                    'user' => $worker,
                ]
            )
            ->set('status', 'inactive')
            ->call('updateUser')
            ->assertHasErrors([
                'status',
            ]);

        Livewire::actingAs($this->owner)
            ->test(
                Edit::class,
                [
                    'user' => $worker,
                ]
            )
            ->set('role', 'mandor')
            ->call('updateUser')
            ->assertHasErrors([
                'role',
            ]);
    }

    public function test_unrelated_user_can_be_deleted(): void
    {
        $worker = $this->createUser(
            'Pekerja Hapus',
            'pekerja.hapus@example.com',
            'pekerja'
        );

        Livewire::actingAs($this->owner)
            ->test(Delete::class)
            ->call(
                'openModal',
                $worker->id
            )
            ->assertSet('showModal', true)
            ->assertSet('blockers', [])
            ->call('deleteUser')
            ->assertHasNoErrors()
            ->assertRedirect(
                route('owner.users.index')
            );

        $this->assertDatabaseMissing(
            'users',
            [
                'id' => $worker->id,
            ]
        );
    }

    public function test_current_account_and_last_owner_cannot_be_deleted(): void
    {
        Livewire::actingAs($this->owner)
            ->test(Delete::class)
            ->call(
                'openModal',
                $this->owner->id
            )
            ->assertSet('showModal', true)
            ->assertSet(
                'blockers',
                fn (array $blockers): bool => count($blockers) >= 2
            )
            ->call('deleteUser')
            ->assertHasErrors([
                'delete',
            ]);

        $this->assertDatabaseHas(
            'users',
            [
                'id' => $this->owner->id,
            ]
        );
    }

    public function test_user_with_project_history_cannot_be_deleted(): void
    {
        $mandor = $this->createUser(
            'Mandor Riwayat',
            'mandor.riwayat@example.com',
            'mandor'
        );

        $this->createProject(
            $mandor,
            'completed'
        );

        Livewire::actingAs($this->owner)
            ->test(Delete::class)
            ->call(
                'openModal',
                $mandor->id
            )
            ->assertSet(
                'blockers',
                fn (array $blockers): bool => collect($blockers)
                    ->contains(
                        fn (array $blocker): bool => $blocker['label']
                            === 'Project yang dikelola'
                    )
            )
            ->call('deleteUser')
            ->assertHasErrors([
                'delete',
            ]);

        $this->assertDatabaseHas(
            'users',
            [
                'id' => $mandor->id,
            ]
        );
    }

    public function test_user_list_can_search_and_filter_users(): void
    {
        $visibleWorker = $this->createUser(
            'Pekerja Dicari',
            'dicari@example.com',
            'pekerja',
            'active'
        );

        $hiddenMandor = $this->createUser(
            'Mandor Tersembunyi',
            'tersembunyi@example.com',
            'mandor',
            'inactive'
        );

        Livewire::actingAs($this->owner)
            ->test(Index::class)
            ->set('search', 'Pekerja Dicari')
            ->assertSee($visibleWorker->name)
            ->assertDontSee($hiddenMandor->name)
            ->set('search', '')
            ->set('role', 'mandor')
            ->set('status', 'inactive')
            ->assertSee($hiddenMandor->name)
            ->assertDontSee($visibleWorker->name);
    }

    public function test_user_without_required_permission_is_forbidden(): void
    {
        $operator = $this->createUser(
            'Operator Tanpa Izin',
            'tanpa.izin@example.com',
            'mandor'
        );

        Livewire::actingAs($operator)
            ->test(Create::class)
            ->assertForbidden();

        Livewire::actingAs($operator)
            ->test(
                Edit::class,
                [
                    'user' => $this->owner,
                ]
            )
            ->assertForbidden();

        Livewire::actingAs($operator)
            ->test(Delete::class)
            ->call(
                'openModal',
                $this->owner->id
            )
            ->assertForbidden();
    }

    private function createUser(
        string $name,
        string $email,
        string $role,
        string $status = 'active',
        string $password = 'Password123'
    ): User {
        $user = User::factory()->create([
            'name' => $name,
            'email' => $email,
            'status' => $status,
            'password' => $password,
        ]);

        $user->assignRole($role);

        return $user;
    }

    private function createProject(
        User $mandor,
        string $status = 'planning'
    ): Project {
        $client = Client::query()->create([
            'company_name' => 'PT User Management '
                .fake()->unique()->numberBetween(
                    1000,
                    9999
                ),
            'contact_person' => 'Kontak Pengujian',
        ]);

        return Project::query()->create([
            'client_id' => $client->id,
            'mandor_id' => $mandor->id,
            'project_code' => 'PRJ-USER-'
                .fake()->unique()->numberBetween(
                    1000,
                    9999
                ),
            'project_name' => 'Project User Management',
            'location' => 'Jakarta',
            'start_date' => '2026-09-01',
            'end_date' => '2026-12-31',
            'progress' => $status === 'completed'
                    ? 100
                    : 0,
            'status' => $status,
        ]);
    }
}
