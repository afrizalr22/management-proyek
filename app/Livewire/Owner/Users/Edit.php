<?php

namespace App\Livewire\Owner\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Throwable;

class Edit extends Component
{
    public User $user;

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $role = '';

    public string $status = 'active';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $isSelf = false;

    public function mount(User $user): void
    {
        Gate::authorize('update users');

        $user->load('roles:id,name');

        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->role = $user->roles->first()?->name ?? '';
        $this->status = $user->status;
        $this->isSelf = Auth::id() === $user->id;
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
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($this->user->id),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
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
                'nullable',
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
                'Email wajib diisi.',

            'email.email' =>
                'Format email tidak valid.',

            'email.unique' =>
                'Email sudah digunakan pengguna lain.',

            'phone.regex' =>
                'Format nomor telepon tidak valid.',

            'phone.max' =>
                'Nomor telepon maksimal 20 karakter.',

            'role.required' =>
                'Role pengguna wajib dipilih.',

            'role.in' =>
                'Role pengguna tidak valid.',

            'status.required' =>
                'Status akun wajib dipilih.',

            'status.in' =>
                'Status akun tidak valid.',

            'password.confirmed' =>
                'Konfirmasi password tidak sesuai.',

            'password.min' =>
                'Password minimal 8 karakter.',
        ];
    }

    public function updateUser(): void
{
    Gate::authorize('update users');

    $validated = $this->validate();

    $currentRole = $this->user
        ->roles()
        ->value('name');

    $isCurrentUser = Auth::id() === $this->user->id;

    /*
     * Perlindungan akun yang sedang digunakan.
     */
    if ($isCurrentUser) {
        if ($validated['role'] !== $currentRole) {
            $this->addError(
                'role',
                'Anda tidak dapat mengubah role akun sendiri.'
            );

            return;
        }

        if ($validated['status'] !== 'active') {
            $this->addError(
                'status',
                'Anda tidak dapat menonaktifkan akun sendiri.'
            );

            return;
        }
    }

    /*
     * Pemeriksaan Project dan penugasan aktif.
     */
    $hasActiveManagedProjects =
        $currentRole === 'mandor'
        && $this->hasActiveManagedProjects();

    $hasActiveWorkerAssignment =
        $currentRole === 'pekerja'
        && $this->hasActiveWorkerAssignment();

    /*
     * Mandor yang masih mengelola Project aktif
     * tidak dapat dinonaktifkan.
     */
    if (
        $hasActiveManagedProjects
        && $validated['status'] === 'inactive'
    ) {
        $this->addError(
            'status',
            'Akun Mandor tidak dapat dinonaktifkan karena masih mengelola Project aktif.'
        );

        return;
    }

    /*
     * Pekerja yang masih memiliki penugasan aktif
     * tidak dapat dinonaktifkan.
     */
    if (
        $hasActiveWorkerAssignment
        && $validated['status'] === 'inactive'
    ) {
        $this->addError(
            'status',
            'Akun Pekerja tidak dapat dinonaktifkan karena masih memiliki penugasan aktif.'
        );

        return;
    }

    /*
     * Mandor dengan Project aktif tidak dapat
     * dipindahkan ke role lain.
     */
    if (
        $hasActiveManagedProjects
        && $validated['role'] !== 'mandor'
    ) {
        $this->addError(
            'role',
            'Role Mandor tidak dapat diubah karena masih mengelola Project aktif.'
        );

        return;
    }

    /*
     * Pekerja dengan penugasan aktif tidak dapat
     * dipindahkan ke role lain.
     */
    if (
        $hasActiveWorkerAssignment
        && $validated['role'] !== 'pekerja'
    ) {
        $this->addError(
            'role',
            'Role Pekerja tidak dapat diubah karena masih memiliki penugasan aktif.'
        );

        return;
    }

    /*
     * Sistem harus selalu memiliki minimal
     * satu Owner aktif.
     */
    if (
        $currentRole === 'owner'
        && (
            $validated['role'] !== 'owner'
            || $validated['status'] !== 'active'
        )
        && !$this->hasAnotherActiveOwner()
    ) {
        $errorField = $validated['role'] !== 'owner'
            ? 'role'
            : 'status';

        $this->addError(
            $errorField,
            'Owner terakhir yang aktif tidak dapat diubah role atau dinonaktifkan.'
        );

        return;
    }

    try {
        DB::transaction(function () use ($validated): void {
            $data = [
                'name' => trim($validated['name']),

                'email' => mb_strtolower(
                    trim($validated['email'])
                ),

                'phone' => filled($validated['phone'] ?? null)
                    ? trim($validated['phone'])
                    : null,

                'status' => $validated['status'],
            ];

            /*
             * Password hanya diperbarui jika diisi.
             */
            if (filled($validated['password'] ?? null)) {
                $data['password'] = $validated['password'];
            }

            $this->user->update($data);

            $this->user->syncRoles([
                $validated['role'],
            ]);
        });

        session()->flash('notification', [
            'type' => 'success',
            'message' => 'Data pengguna berhasil diperbarui.',
        ]);

        $this->redirectRoute(
            'owner.users.show',
            [
                'user' => $this->user->id,
            ],
            navigate: true
        );
    } catch (Throwable $exception) {
        report($exception);

        $this->addError(
            'save',
            'Data pengguna gagal diperbarui. Silakan coba kembali.'
        );
    }
}

    private function hasActiveManagedProjects(): bool
    {
        return $this->user
            ->managedProjects()
            ->whereIn('status', [
                'planning',
                'on_progress',
            ])
            ->exists();
    }

    private function hasActiveWorkerAssignment(): bool
    {
        return $this->user
            ->projectAssignments()
            ->where('status', 'active')
            ->exists();
    }

    private function hasAnotherActiveOwner(): bool
    {
        return User::query()
            ->role('owner')
            ->where('status', 'active')
            ->whereKeyNot($this->user->id)
            ->exists();
    }

    public function render()
    {
        return view('livewire.owner.users.edit');
    }
}