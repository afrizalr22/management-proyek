<?php

namespace App\Livewire\Pekerja\Profile;

use App\Models\ProjectWorker;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Throwable;

class Index extends Component
{
    use WithFileUploads;

    /*
    |--------------------------------------------------------------------------
    | Informasi akun
    |--------------------------------------------------------------------------
    */

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public ?TemporaryUploadedFile $photo = null;

    /*
    |--------------------------------------------------------------------------
    | Informasi khusus pekerja
    |--------------------------------------------------------------------------
    */

    public string $specialization = '';

    public string $address = '';

    /*
    |--------------------------------------------------------------------------
    | Kontak darurat utama
    |--------------------------------------------------------------------------
    */

    public string $primaryName = '';

    public string $primaryRelationship = '';

    public string $primaryPhone = '';

    /*
    |--------------------------------------------------------------------------
    | Kontak darurat tambahan
    |--------------------------------------------------------------------------
    */

    public string $secondaryName = '';

    public string $secondaryRelationship = '';

    public string $secondaryPhone = '';

    /*
    |--------------------------------------------------------------------------
    | Kata sandi
    |--------------------------------------------------------------------------
    */

    public string $currentPassword = '';

    public string $newPassword = '';

    public string $newPasswordConfirmation = '';

    /*
    |--------------------------------------------------------------------------
    | Pesan berhasil
    |--------------------------------------------------------------------------
    */

    public string $profileSuccess = '';

    public string $photoSuccess = '';

    public string $workerProfileSuccess = '';

    public string $emergencyContactSuccess = '';

    public string $passwordSuccess = '';

    public function mount(): void
    {
        $worker = $this->authenticatedWorker()
            ->load([
                'profile',
                'emergencyContacts',
            ]);

        $this->name = $worker->name;
        $this->email = $worker->email;
        $this->phone = $worker->phone ?? '';

        $this->specialization =
            $worker->profile?->specialization ?? '';

        $this->address =
            $worker->profile?->address ?? '';

        $primaryContact = $worker
            ->emergencyContacts
            ->firstWhere('priority', 1);

        $secondaryContact = $worker
            ->emergencyContacts
            ->firstWhere('priority', 2);

        $this->primaryName =
            $primaryContact?->name ?? '';

        $this->primaryRelationship =
            $primaryContact?->relationship ?? '';

        $this->primaryPhone =
            $primaryContact?->phone ?? '';

        $this->secondaryName =
            $secondaryContact?->name ?? '';

        $this->secondaryRelationship =
            $secondaryContact?->relationship ?? '';

        $this->secondaryPhone =
            $secondaryContact?->phone ?? '';
    }

    /*
    |--------------------------------------------------------------------------
    | Aturan validasi
    |--------------------------------------------------------------------------
    */

    protected function profileRules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',

                Rule::unique(
                    'users',
                    'email'
                )->ignore(
                    $this->authenticatedWorker()->id
                ),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s()]+$/',
            ],
        ];
    }

    protected function workerProfileRules(): array
    {
        return [
            'specialization' => [
                'nullable',
                'string',
                'max:255',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    protected function emergencyContactRules(): array
    {
        return [
            'primaryName' => [
            'required',
            'string',
            'max:255',
            ],

            'primaryRelationship' => [
                'required',
                'string',
                'max:100',
            ],

            'primaryPhone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s()]+$/',
            ],

            'secondaryName' => [
                'nullable',
                'string',
                'max:255',
                'required_with:secondaryRelationship,secondaryPhone',
            ],

            'secondaryRelationship' => [
                'nullable',
                'string',
                'max:100',
                'required_with:secondaryName,secondaryPhone',
            ],

            'secondaryPhone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s()]+$/',
                'required_with:secondaryName,secondaryRelationship',
            ],
        ];
    }

    protected function photoRules(): array
    {
        return [
            'photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];
    }

    protected function passwordRules(): array
    {
        return [
            'currentPassword' => [
                'required',
                'string',
                'current_password',
            ],

            'newPassword' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*[0-9]).+$/',
            ],

            'newPasswordConfirmation' => [
                'required',
                'string',
                'same:newPassword',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' =>
                'Nama wajib diisi.',

            'name.max' =>
                'Nama maksimal 255 karakter.',

            'email.required' =>
                'Email wajib diisi.',

            'email.email' =>
                'Format email tidak valid.',

            'email.unique' =>
                'Email sudah digunakan oleh pengguna lain.',

            'email.max' =>
                'Email maksimal 255 karakter.',

            'phone.max' =>
                'Nomor telepon maksimal 20 karakter.',

            'phone.regex' =>
                'Format nomor telepon tidak valid.',

            'specialization.max' =>
                'Bidang pekerjaan maksimal 255 karakter.',

            'address.max' =>
                'Alamat maksimal 1.000 karakter.',

            'primaryName.required_with' =>
                'Nama kontak utama wajib dilengkapi.',

            'primaryRelationship.required_with' =>
                'Hubungan kontak utama wajib dilengkapi.',

            'primaryPhone.required_with' =>
                'Nomor telepon kontak utama wajib dilengkapi.',

            'primaryPhone.regex' =>
                'Format nomor telepon kontak utama tidak valid.',

            'primaryPhone.max' =>
                'Nomor telepon kontak utama maksimal 20 karakter.',

            'secondaryName.required_with' =>
                'Nama kontak tambahan wajib dilengkapi.',

            'secondaryRelationship.required_with' =>
                'Hubungan kontak tambahan wajib dilengkapi.',

            'secondaryPhone.required_with' =>
                'Nomor telepon kontak tambahan wajib dilengkapi.',

            'secondaryPhone.regex' =>
                'Format nomor telepon kontak tambahan tidak valid.',

            'secondaryPhone.max' =>
                'Nomor telepon kontak tambahan maksimal 20 karakter.',

            'photo.required' =>
                'Pilih foto yang akan digunakan.',

            'photo.image' =>
                'File harus berupa gambar.',

            'photo.mimes' =>
                'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',

            'photo.max' =>
                'Ukuran foto maksimal 2 MB.',

            'currentPassword.required' =>
                'Password saat ini wajib diisi.',

            'currentPassword.current_password' =>
                'Password saat ini tidak sesuai.',

            'newPassword.required' =>
                'Password baru wajib diisi.',

            'newPassword.min' =>
                'Password baru minimal 8 karakter.',

            'newPassword.regex' =>
                'Password baru harus mengandung huruf dan angka.',

            'newPasswordConfirmation.required' =>
                'Konfirmasi password baru wajib diisi.',

            'newPasswordConfirmation.same' =>
                'Konfirmasi password baru tidak sesuai.',

            'primaryName.required' =>
                'Nama kontak utama wajib diisi.',

            'primaryRelationship.required' =>
                'Hubungan kontak utama wajib diisi.',

            'primaryPhone.required' =>
                'Nomor telepon kontak utama wajib diisi.',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Pembaruan profil akun
    |--------------------------------------------------------------------------
    */

    public function updateProfile(): void
    {
        $validated = $this->validate(
            $this->profileRules()
        );

        $this->resetSuccessMessages();
        $this->resetValidation('profile');

        try {
            $worker = $this->authenticatedWorker();

            $normalizedEmail = strtolower(
                trim($validated['email'])
            );

            $emailChanged =
                $worker->email !== $normalizedEmail;

            $worker->update([
                'name' =>
                    trim($validated['name']),

                'email' =>
                    $normalizedEmail,

                'phone' =>
                    filled($validated['phone'] ?? null)
                        ? trim($validated['phone'])
                        : null,

                'email_verified_at' =>
                    $emailChanged
                        ? null
                        : $worker->email_verified_at,
            ]);

            $worker->refresh();

            $this->name = $worker->name;
            $this->email = $worker->email;
            $this->phone = $worker->phone ?? '';

            $this->profileSuccess =
                'Informasi profil berhasil diperbarui.';

            $this->dispatchProfileUpdated($worker);
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'profile',
                'Informasi profil gagal diperbarui. Silakan coba kembali.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Pembaruan informasi khusus pekerja
    |--------------------------------------------------------------------------
    */

    public function updateWorkerProfile(): void
    {
        $validated = $this->validate(
            $this->workerProfileRules()
        );

        $this->resetSuccessMessages();
        $this->resetValidation('workerProfile');

        try {
            $worker = $this->authenticatedWorker();

            $worker->profile()->updateOrCreate(
                [
                    'user_id' => $worker->id,
                ],
                [
                    'specialization' =>
                        filled($validated['specialization'] ?? null)
                            ? trim($validated['specialization'])
                            : null,

                    'address' =>
                        filled($validated['address'] ?? null)
                            ? trim($validated['address'])
                            : null,
                ]
            );

            $worker->load('profile');

            $this->specialization =
                $worker->profile?->specialization ?? '';

            $this->address =
                $worker->profile?->address ?? '';

            $this->workerProfileSuccess =
                'Informasi pekerjaan berhasil diperbarui.';
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'workerProfile',
                'Informasi pekerjaan gagal diperbarui. Silakan coba kembali.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Pembaruan kontak darurat
    |--------------------------------------------------------------------------
    */

    public function updateEmergencyContacts(): void
    {
        $validated = $this->validate(
            $this->emergencyContactRules()
        );

        $this->resetSuccessMessages();
        $this->resetValidation('emergencyContacts');

        try {
            $worker = $this->authenticatedWorker();

            DB::transaction(function () use (
                $worker,
                $validated
            ): void {
                $this->saveEmergencyContact(
                    $worker,
                    1,
                    $validated['primaryName'] ?? '',
                    $validated['primaryRelationship'] ?? '',
                    $validated['primaryPhone'] ?? ''
                );

                $this->saveEmergencyContact(
                    $worker,
                    2,
                    $validated['secondaryName'] ?? '',
                    $validated['secondaryRelationship'] ?? '',
                    $validated['secondaryPhone'] ?? ''
                );
            });

            $this->emergencyContactSuccess =
                'Kontak darurat berhasil diperbarui.';
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'emergencyContacts',
                'Kontak darurat gagal diperbarui. Silakan coba kembali.'
            );
        }
    }

    private function saveEmergencyContact(
        User $worker,
        int $priority,
        string $name,
        string $relationship,
        string $phone
    ): void {
        $name = trim($name);
        $relationship = trim($relationship);
        $phone = trim($phone);

        if (
            blank($name)
            && blank($relationship)
            && blank($phone)
        ) {
            $worker->emergencyContacts()
                ->where('priority', $priority)
                ->delete();

            return;
        }

        $worker->emergencyContacts()->updateOrCreate(
            [
                'priority' => $priority,
            ],
            [
                'name' => $name,
                'relationship' => $relationship,
                'phone' => $phone,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Foto profil
    |--------------------------------------------------------------------------
    */

    public function updatedPhoto(): void
    {
        $this->resetValidation([
            'photo',
            'photoSave',
        ]);

        $this->photoSuccess = '';

        if ($this->photo !== null) {
            $this->validate(
                $this->photoRules()
            );
        }
    }

    public function updatePhoto(): void
    {
        $validated = $this->validate(
            $this->photoRules()
        );

        $this->resetSuccessMessages();
        $this->resetValidation('photoSave');

        $newPhotoPath = null;

        try {
            $worker = $this->authenticatedWorker();
            $oldPhotoPath = $worker->photo;

            $newPhotoPath = $validated['photo']
                ->store(
                    'profile-photos',
                    'public'
                );

            $worker->update([
                'photo' => $newPhotoPath,
            ]);

            if (
                filled($oldPhotoPath)
                && $oldPhotoPath !== $newPhotoPath
            ) {
                Storage::disk('public')
                    ->delete($oldPhotoPath);
            }

            $worker->refresh();

            $this->reset('photo');

            $this->photoSuccess =
                'Foto profil berhasil diperbarui.';

            $this->dispatchProfileUpdated($worker);
        } catch (Throwable $exception) {
            if (filled($newPhotoPath)) {
                Storage::disk('public')
                    ->delete($newPhotoPath);
            }

            report($exception);

            $this->addError(
                'photoSave',
                'Foto profil gagal diperbarui. Silakan coba kembali.'
            );
        }
    }

    public function removePhoto(): void
    {
        $this->resetSuccessMessages();

        $this->resetValidation([
            'photo',
            'photoSave',
        ]);

        try {
            $worker = $this->authenticatedWorker();
            $oldPhotoPath = $worker->photo;

            if (! filled($oldPhotoPath)) {
                $this->addError(
                    'photoSave',
                    'Foto profil belum tersedia.'
                );

                return;
            }

            $worker->update([
                'photo' => null,
            ]);

            Storage::disk('public')
                ->delete($oldPhotoPath);

            $worker->refresh();

            $this->reset('photo');

            $this->photoSuccess =
                'Foto profil berhasil dihapus.';

            $this->dispatchProfileUpdated($worker);
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'photoSave',
                'Foto profil gagal dihapus. Silakan coba kembali.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Kata sandi
    |--------------------------------------------------------------------------
    */

    public function updatePassword(): void
    {
        $validated = $this->validate(
            $this->passwordRules()
        );

        $this->resetSuccessMessages();
        $this->resetValidation('passwordSave');

        try {
            $worker = $this->authenticatedWorker();

            $worker->update([
                'password' => Hash::make(
                    $validated['newPassword']
                ),
            ]);

            $this->reset([
                'currentPassword',
                'newPassword',
                'newPasswordConfirmation',
            ]);

            $this->resetValidation([
                'currentPassword',
                'newPassword',
                'newPasswordConfirmation',
            ]);

            $this->passwordSuccess =
                'Password berhasil diperbarui.';
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'passwordSave',
                'Password gagal diperbarui. Silakan coba kembali.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Helper
    |--------------------------------------------------------------------------
    */

    private function resetSuccessMessages(): void
    {
        $this->profileSuccess = '';
        $this->photoSuccess = '';
        $this->workerProfileSuccess = '';
        $this->emergencyContactSuccess = '';
        $this->passwordSuccess = '';
    }

    private function dispatchProfileUpdated(
        User $worker
    ): void {
        $this->dispatch(
            'profile-updated',
            name: $worker->name,
            photoUrl: filled($worker->photo)
                ? asset(
                    'storage/'.ltrim(
                        $worker->photo,
                        '/'
                    )
                )
                : null
        );
    }

    private function authenticatedWorker(): User
    {
        $worker = Auth::user();

        abort_unless(
            $worker instanceof User
                && $worker->hasRole('pekerja')
                && $worker->isActive(),
            403
        );

        return $worker;
    }

    private function activeAssignments(
        User $worker
    ): Collection {
        return ProjectWorker::query()
            ->where(
                'worker_id',
                $worker->id
            )
            ->where(
                'status',
                'active'
            )
            ->whereHas(
                'project',
                function ($query): void {
                    $query->whereIn(
                        'status',
                        [
                            'planning',
                            'on_progress',
                        ]
                    );
                }
            )
            ->with([
                'project:id,mandor_id,project_code,project_name,location,status',
                'project.mandor:id,name',
            ])
            ->orderByDesc('joined_at')
            ->orderByDesc('id')
            ->get();
    }

    public function render()
    {
        $worker = $this
            ->authenticatedWorker()
            ->fresh([
                'profile',
                'emergencyContacts' => function ($query): void {
                    $query->orderBy('priority');
                },
            ]);

        $activeAssignments =
            $this->activeAssignments($worker);

        $workerCode = sprintf(
            'PKR-%s-%06d',
            $worker->created_at
                ->timezone('Asia/Jakarta')
                ->format('Y'),
            $worker->id
        );

        return view(
            'livewire.pekerja.profile.index',
            [
                /*
                 * Variabel $user diperlukan oleh komponen profil
                 * bersama milik Owner dan Mandor.
                 */
                'user' => $worker,

                /*
                 * Variabel berikut dipertahankan untuk komponen
                 * khusus halaman profil Pekerja.
                 */
                'worker' => $worker,
                'workerProfile' => $worker->profile,
                'emergencyContacts' =>
                    $worker->emergencyContacts,
                'activeAssignments' =>
                    $activeAssignments,
                'primaryAssignment' =>
                    $activeAssignments->first(),
                'workerCode' => $workerCode,
            ]
        );
    }
}