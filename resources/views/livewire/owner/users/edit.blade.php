<form
    wire:submit.prevent="updateUser"
    class="space-y-6"
    novalidate
>
    <x-user.user-edit-header
        :user="$user"
    />

    @error('save')
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
            role="alert"
        >
            {{ $message }}
        </div>
    @enderror

    @if ($errors->any())
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-5 py-4"
            role="alert"
        >
            <p class="font-semibold text-red-700">
                Periksa kembali data pengguna
            </p>

            <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="space-y-6 xl:col-span-2">
            <x-user.user-identity-form />

            <x-user.user-role-form
                :role="$role"
                :status="$status"
                :is-self="$isSelf"
            />

            <x-user.user-password-form
                mode="edit"
            />
        </div>

        <aside class="space-y-6">
            <x-user.user-profile-preview
                :name="$name"
                :email="$email"
                :phone="$phone"
                :role="$role"
                :status="$status"
            />

            <x-user.user-security-action
                :user="$user"
                :is-self="$isSelf"
            />
        </aside>
    </div>

    <div class="flex flex-col-reverse gap-4 rounded-2xl border border-gray-200 bg-white p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
        <p class="text-sm text-gray-500">
            Password tidak berubah apabila dikosongkan.
        </p>

        <div class="flex flex-col-reverse gap-3 sm:flex-row">
            <a
                href="{{ route('owner.users.show', [
                    'user' => $user->id,
                ]) }}"
                wire:navigate
                wire:loading.class="pointer-events-none opacity-60"
                wire:target="updateUser"
                class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
            >
                Batal
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="updateUser"
                class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span
                    wire:loading.remove
                    wire:target="updateUser"
                >
                    Simpan Perubahan
                </span>

                <span
                    wire:loading
                    wire:target="updateUser"
                >
                    Menyimpan...
                </span>
            </button>
        </div>
    </div>
</form>