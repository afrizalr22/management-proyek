<?php

namespace App\Livewire\Owner\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Throwable;

class Create extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $role = '';

    public string $status = 'active';

    public string $password = '';

    public string $password_confirmation = '';

    public function mount(): void
    {
        $this->authorizeCreateUser();
    }

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:25',
                'regex:/^[0-9+\-\s()]+$/',
            ],

            'role' => [
                'required',
                Rule::in([
                    'owner',
                    'mandor',
                    'pekerja',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers(),
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' =>
                'Nama pengguna wajib diisi.',

            'name.min' =>
                'Nama pengguna minimal 3 karakter.',

            'name.max' =>
                'Nama pengguna maksimal 100 karakter.',

            'email.required' =>
                'Alamat email wajib diisi.',

            'email.email' =>
                'Format alamat email tidak valid.',

            'email.unique' =>
                'Alamat email sudah digunakan.',

            'phone.max' =>
                'Nomor telepon maksimal 25 karakter.',

            'phone.regex' =>
                'Format nomor telepon tidak valid.',

            'role.required' =>
                'Role pengguna wajib dipilih.',

            'role.in' =>
                'Role pengguna tidak valid.',

            'status.required' =>
                'Status akun wajib dipilih.',

            'status.in' =>
                'Status akun tidak valid.',

            'password.required' =>
                'Password wajib diisi.',

            'password.confirmed' =>
                'Konfirmasi password tidak sesuai.',
        ];
    }

    public function createUser()
    {
        $this->authorizeCreateUser();

        $validated = $this->validate();

        try {
            $user = DB::transaction(
                function () use ($validated): User {
                    $user = User::create([
                        'name' => trim(
                            $validated['name']
                        ),

                        'email' => strtolower(
                            trim($validated['email'])
                        ),

                        'phone' => filled(
                            $validated['phone']
                        )
                            ? trim(
                                $validated['phone']
                            )
                            : null,

                        'status' =>
                            $validated['status'],

                        'password' =>
                            $validated['password'],
                    ]);

                    $user->syncRoles([
                        $validated['role'],
                    ]);

                    return $user;
                }
            );

            session()->flash('notification', [
                'type' => 'success',
                'message' => sprintf(
                    'Pengguna %s berhasil ditambahkan.',
                    $user->name
                ),
            ]);

            return $this->redirectRoute(
                'owner.users.index',
                navigate: true
            );
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'save',
                'Pengguna gagal disimpan. Silakan coba kembali.'
            );

            return null;
        }
    }

    private function authorizeCreateUser(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('create users'),
            403
        );
    }

    public function render()
    {
        return view(
            'livewire.owner.users.create'
        );
    }
}