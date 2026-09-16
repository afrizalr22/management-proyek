<?php

namespace Tests\Feature\Pekerja;

use App\Livewire\Pekerja\Profile\Index;
use App\Models\EmergencyContact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectWorker;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        Role::findOrCreate(
            'pekerja',
            'web'
        );

        Role::findOrCreate(
            'owner',
            'web'
        );

        Role::findOrCreate(
            'mandor',
            'web'
        );
    }

    private function createWorker(
        array $attributes = []
    ): User {
        $worker = User::factory()->create(
            array_merge(
                [
                    'status' => 'active',
                    'password' => Hash::make('password'),
                ],
                $attributes
            )
        );

        $worker->assignRole('pekerja');

        return $worker;
    }

    private function createProject(
    User $mandor,
    string $code,
    string $name,
    string $status = 'on_progress'
    ): Project {
        $client = Client::query()->create([
            'company_name' =>
                'PT Pengujian '.$code,
            'contact_person' =>
                'Kontak '.$code,
        ]);

        return Project::query()->create([
            'client_id' => $client->id,
            'mandor_id' => $mandor->id,
            'project_code' => $code,
            'project_name' => $name,
            'location' => 'Jakarta Pusat',
            'start_date' => '2026-09-01',
            'status' => $status,
        ]);
    }

    public function test_guest_cannot_access_worker_profile(): void
    {
        $response = $this->get(
            route('pekerja.profile.index')
        );

        $response->assertRedirect(
            route('login')
        );
    }

    public function test_worker_can_access_profile_page(): void
    {
        $worker = $this->createWorker();

        $response = $this
            ->actingAs($worker)
            ->get(
                route('pekerja.profile.index')
            );

        $response->assertOk();
        $response->assertSee($worker->name);
    }

    public function test_non_worker_cannot_access_worker_profile(): void
    {
        $owner = User::factory()->create([
            'status' => 'active',
        ]);

        $owner->assignRole('owner');

        $response = $this
            ->actingAs($owner)
            ->get(
                route('pekerja.profile.index')
            );

        $response->assertForbidden();
    }

    public function test_worker_can_update_account_information(): void
    {
        $worker = $this->createWorker([
            'email' => 'worker@example.com',
        ]);

        Livewire::actingAs($worker)
            ->test(Index::class)
            ->set('name', 'Pekerja Diperbarui')
            ->set('email', 'UPDATED@example.com')
            ->set('phone', '0812-3456-7890')
            ->call('updateProfile')
            ->assertHasNoErrors()
            ->assertSet(
                'profileSuccess',
                'Informasi profil berhasil diperbarui.'
            );

        $this->assertDatabaseHas(
            'users',
            [
                'id' => $worker->id,
                'name' => 'Pekerja Diperbarui',
                'email' => 'updated@example.com',
                'phone' => '0812-3456-7890',
            ]
        );
    }

    public function test_worker_can_update_worker_information(): void
    {
        $worker = $this->createWorker();

        Livewire::actingAs($worker)
            ->test(Index::class)
            ->set(
                'specialization',
                'Teknisi Instalasi Listrik'
            )
            ->set(
                'address',
                'Jakarta Selatan'
            )
            ->call('updateWorkerProfile')
            ->assertHasNoErrors()
            ->assertSet(
                'workerProfileSuccess',
                'Informasi pekerjaan berhasil diperbarui.'
            );

        $this->assertDatabaseHas(
            'user_profiles',
            [
                'user_id' => $worker->id,
                'specialization' =>
                    'Teknisi Instalasi Listrik',
                'address' =>
                    'Jakarta Selatan',
            ]
        );
    }

    public function test_primary_emergency_contact_is_required(): void
    {
        $worker = $this->createWorker();

        Livewire::actingAs($worker)
            ->test(Index::class)
            ->set('primaryName', '')
            ->set('primaryRelationship', '')
            ->set('primaryPhone', '')
            ->call('updateEmergencyContacts')
            ->assertHasErrors([
                'primaryName' => 'required',
                'primaryRelationship' => 'required',
                'primaryPhone' => 'required',
            ]);
    }

    public function test_worker_can_save_emergency_contacts(): void
    {
        $worker = $this->createWorker();

        Livewire::actingAs($worker)
            ->test(Index::class)
            ->set('primaryName', 'Siti Aminah')
            ->set('primaryRelationship', 'Ibu')
            ->set('primaryPhone', '081234567890')
            ->set('secondaryName', 'Andi Santoso')
            ->set('secondaryRelationship', 'Saudara')
            ->set('secondaryPhone', '081298765432')
            ->call('updateEmergencyContacts')
            ->assertHasNoErrors()
            ->assertSet(
                'emergencyContactSuccess',
                'Kontak darurat berhasil diperbarui.'
            );

        $this->assertDatabaseHas(
            'emergency_contacts',
            [
                'user_id' => $worker->id,
                'priority' => 1,
                'name' => 'Siti Aminah',
                'relationship' => 'Ibu',
                'phone' => '081234567890',
            ]
        );

        $this->assertDatabaseHas(
            'emergency_contacts',
            [
                'user_id' => $worker->id,
                'priority' => 2,
                'name' => 'Andi Santoso',
                'relationship' => 'Saudara',
                'phone' => '081298765432',
            ]
        );
    }

    public function test_empty_secondary_contact_is_deleted(): void
    {
        $worker = $this->createWorker();

        EmergencyContact::query()->create([
            'user_id' => $worker->id,
            'priority' => 2,
            'name' => 'Andi Santoso',
            'relationship' => 'Saudara',
            'phone' => '081298765432',
        ]);

        Livewire::actingAs($worker)
            ->test(Index::class)
            ->set('primaryName', 'Siti Aminah')
            ->set('primaryRelationship', 'Ibu')
            ->set('primaryPhone', '081234567890')
            ->set('secondaryName', '')
            ->set('secondaryRelationship', '')
            ->set('secondaryPhone', '')
            ->call('updateEmergencyContacts')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing(
            'emergency_contacts',
            [
                'user_id' => $worker->id,
                'priority' => 2,
            ]
        );

        $this->assertDatabaseHas(
            'emergency_contacts',
            [
                'user_id' => $worker->id,
                'priority' => 1,
            ]
        );
    }

    public function test_worker_can_update_password(): void
    {
        $worker = $this->createWorker();

        Livewire::actingAs($worker)
            ->test(Index::class)
            ->set('currentPassword', 'password')
            ->set('newPassword', 'password123')
            ->set(
                'newPasswordConfirmation',
                'password123'
            )
            ->call('updatePassword')
            ->assertHasNoErrors()
            ->assertSet(
                'passwordSuccess',
                'Password berhasil diperbarui.'
            );

        $this->assertTrue(
            Hash::check(
                'password123',
                $worker->fresh()->password
            )
        );
    }

    public function test_current_password_must_be_correct(): void
    {
        $worker = $this->createWorker();

        Livewire::actingAs($worker)
            ->test(Index::class)
            ->set(
                'currentPassword',
                'password-salah'
            )
            ->set(
                'newPassword',
                'password123'
            )
            ->set(
                'newPasswordConfirmation',
                'password123'
            )
            ->call('updatePassword')
            ->assertHasErrors([
                'currentPassword' =>
                    'current_password',
            ]);

        $this->assertTrue(
            Hash::check(
                'password',
                $worker->fresh()->password
            )
        );
    }

    public function test_worker_can_upload_profile_photo(): void
    {
        $disk = Storage::fake('public');

        $worker = $this->createWorker();

        $photo = UploadedFile::fake()->image(
            'profile-photo.jpg',
            500,
            500
        )->size(500);

        Livewire::actingAs($worker)
            ->test(Index::class)
            ->set('photo', $photo)
            ->call('updatePhoto')
            ->assertHasNoErrors()
            ->assertSet(
                'photoSuccess',
                'Foto profil berhasil diperbarui.'
            );

        $photoPath = $worker->fresh()->photo;

        $this->assertNotNull($photoPath);

        $disk->assertExists($photoPath);
    }

    public function test_worker_can_remove_profile_photo(): void
    {
        $disk = Storage::fake('public');

        $worker = $this->createWorker([
            'photo' =>
                'profile-photos/worker-photo.jpg',
        ]);

        $disk->put(
            'profile-photos/worker-photo.jpg',
            'fake-image-content'
        );

        Livewire::actingAs($worker)
            ->test(Index::class)
            ->call('removePhoto')
            ->assertHasNoErrors()
            ->assertSet(
                'photoSuccess',
                'Foto profil berhasil dihapus.'
            );

        $this->assertNull(
            $worker->fresh()->photo
        );

        $disk->assertMissing(
            'profile-photos/worker-photo.jpg'
        );
    }

    public function test_profile_displays_active_project_assignment(): void
    {
        $worker = $this->createWorker();

        $mandor = User::factory()->create([
            'name' => 'Mandor Pengujian',
            'status' => 'active',
        ]);

        $mandor->assignRole('mandor');

        $project = $this->createProject(
            $mandor,
            'PRJ-PROFILE-001',
            'Proyek Profil Aktif'
        );

        ProjectWorker::query()->create([
            'project_id' => $project->id,
            'worker_id' => $worker->id,
            'assigned_by' => $mandor->id,
            'status' => 'active',
            'joined_at' => '2026-09-04',
        ]);

        Livewire::actingAs($worker)
            ->test(Index::class)
            ->assertSee('Proyek Profil Aktif')
            ->assertSee('PRJ-PROFILE-001')
            ->assertSee('Jakarta Pusat')
            ->assertSee('Mandor Pengujian')
            ->assertSee('Sedang Bertugas');
    }

    public function test_profile_only_displays_eligible_active_project(): void
    {
        $worker = $this->createWorker();

        $otherWorker = $this->createWorker([
            'email' => 'other-worker@example.com',
        ]);

        $mandor = User::factory()->create([
            'name' => 'Mandor Filter',
            'status' => 'active',
        ]);

        $mandor->assignRole('mandor');

        $inactiveProject = $this->createProject(
            $mandor,
            'PRJ-INACTIVE-001',
            'Proyek Penugasan Tidak Aktif'
        );

        $completedProject = $this->createProject(
            $mandor,
            'PRJ-COMPLETED-001',
            'Proyek Sudah Selesai',
            'completed'
        );

        $otherWorkerProject = $this->createProject(
            $mandor,
            'PRJ-OTHER-001',
            'Proyek Pekerja Lain'
        );

        ProjectWorker::query()->create([
            'project_id' => $inactiveProject->id,
            'worker_id' => $worker->id,
            'assigned_by' => $mandor->id,
            'status' => 'inactive',
            'joined_at' => '2026-09-01',
            'ended_at' => '2026-09-05',
        ]);

        ProjectWorker::query()->create([
            'project_id' => $completedProject->id,
            'worker_id' => $worker->id,
            'assigned_by' => $mandor->id,
            'status' => 'active',
            'joined_at' => '2026-09-01',
        ]);

        ProjectWorker::query()->create([
            'project_id' => $otherWorkerProject->id,
            'worker_id' => $otherWorker->id,
            'assigned_by' => $mandor->id,
            'status' => 'active',
            'joined_at' => '2026-09-01',
        ]);

        Livewire::actingAs($worker)
            ->test(Index::class)
            ->assertSee('Belum Ada Proyek Aktif')
            ->assertDontSee(
                'Proyek Penugasan Tidak Aktif'
            )
            ->assertDontSee(
                'Proyek Sudah Selesai'
            )
            ->assertDontSee(
                'Proyek Pekerja Lain'
            );
    }
}