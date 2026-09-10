<?php

namespace App\Livewire\Owner;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Throwable;

class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public ?TemporaryUploadedFile $photo = null;

    public string $currentPassword = '';

    public string $newPassword = '';

    public string $newPasswordConfirmation = '';

    public string $profileSuccess = '';

    public string $photoSuccess = '';

    public string $passwordSuccess = '';

    public function mount(): void
    {
        $user = $this->authenticatedUser();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
    }

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
                    $this->authenticatedUser()->id
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
        ];
    }

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

    public function updateProfile(): void
    {
        $validated = $this->validate(
            $this->profileRules()
        );

        $this->resetSuccessMessages();
        $this->resetValidation('profile');

        try {
            $user = $this->authenticatedUser();

            $normalizedEmail = strtolower(
                trim($validated['email'])
            );

            $emailChanged =
                $user->email !== $normalizedEmail;

            $user->update([
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
                        : $user->email_verified_at,
            ]);

            $user->refresh();

            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone ?? '';

            $this->profileSuccess =
                'Informasi profil berhasil diperbarui.';

            $this->dispatchProfileUpdated($user);
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'profile',
                'Informasi profil gagal diperbarui. Silakan coba kembali.'
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
            $user = $this->authenticatedUser();
            $oldPhotoPath = $user->photo;

            $newPhotoPath = $validated['photo']
                ->store(
                    'profile-photos',
                    'public'
                );

            $user->update([
                'photo' => $newPhotoPath,
            ]);

            if (
                filled($oldPhotoPath)
                && $oldPhotoPath !== $newPhotoPath
            ) {
                Storage::disk('public')
                    ->delete($oldPhotoPath);
            }

            $user->refresh();

            $this->reset('photo');

            $this->photoSuccess =
                'Foto profil berhasil diperbarui.';

            $this->dispatchProfileUpdated($user);
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
            $user = $this->authenticatedUser();
            $oldPhotoPath = $user->photo;

            if (! filled($oldPhotoPath)) {
                $this->addError(
                    'photoSave',
                    'Foto profil belum tersedia.'
                );

                return;
            }

            $user->update([
                'photo' => null,
            ]);

            Storage::disk('public')
                ->delete($oldPhotoPath);

            $user->refresh();

            $this->reset('photo');

            $this->photoSuccess =
                'Foto profil berhasil dihapus.';

            $this->dispatchProfileUpdated($user);
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'photoSave',
                'Foto profil gagal dihapus. Silakan coba kembali.'
            );
        }
    }

    public function updatePassword(): void
    {
        $validated = $this->validate(
            $this->passwordRules()
        );

        $this->resetSuccessMessages();
        $this->resetValidation('passwordSave');

        try {
            $user = $this->authenticatedUser();

            $user->update([
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

    private function resetSuccessMessages(): void
    {
        $this->profileSuccess = '';
        $this->photoSuccess = '';
        $this->passwordSuccess = '';
    }

    private function dispatchProfileUpdated(
        User $user
    ): void {
        $this->dispatch(
            'profile-updated',
            name: $user->name,
            photoUrl: filled($user->photo)
                ? Storage::url($user->photo)
                : null
        );
    }

    private function authenticatedUser(): User
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User,
            403
        );

        return $user;
    }

    public function render()
    {
        return view(
            'livewire.owner.profile',
            [
                'user' =>
                    $this->authenticatedUser()
                        ->fresh(),
            ]
        );
    }
}