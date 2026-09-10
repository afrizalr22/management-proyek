@props([
    'user',
    'profileSuccess' => '',
])

<form
    wire:submit="updateProfile"
    novalidate
>
    <x-ui.info-card>
        <div class="border-b border-gray-200 px-6 py-5">
            <h2 class="text-xl font-bold text-gray-900">
                Informasi Pribadi
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Informasi yang digunakan pada akun Owner.
            </p>
        </div>

        <div class="space-y-6 p-6">
            @error('profile')
                <div
                    class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                    role="alert"
                >
                    {{ $message }}
                </div>
            @enderror

            @if ($profileSuccess)
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 4000)"
                    x-show="show"
                    x-transition.opacity
                    class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
                    role="status"
                >
                    {{ $profileSuccess }}
                </div>
            @endif

            <div>
                <label
                    for="owner-profile-name"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Nama Lengkap

                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="owner-profile-name"
                    type="text"
                    wire:model="name"
                    autocomplete="name"
                    maxlength="255"
                    placeholder="Masukkan nama lengkap"
                    @class([
                        'w-full rounded-xl px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500',
                        'border-red-300' => $errors->has('name'),
                        'border-gray-300' => ! $errors->has('name'),
                    ])
                >

                @error('name')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label
                    for="owner-profile-email"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Alamat Email

                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="owner-profile-email"
                    type="email"
                    wire:model="email"
                    autocomplete="email"
                    maxlength="255"
                    placeholder="nama@example.com"
                    @class([
                        'w-full rounded-xl px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500',
                        'border-red-300' => $errors->has('email'),
                        'border-gray-300' => ! $errors->has('email'),
                    ])
                >

                @error('email')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

                <p class="mt-2 text-xs leading-5 text-gray-500">
                    Jika email diubah, status verifikasi email akan diatur ulang.
                </p>
            </div>

            <div>
                <label
                    for="owner-profile-phone"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Nomor Telepon
                </label>

                <input
                    id="owner-profile-phone"
                    type="tel"
                    wire:model="phone"
                    autocomplete="tel"
                    maxlength="20"
                    placeholder="Contoh: 081234567890"
                    @class([
                        'w-full rounded-xl px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500',
                        'border-red-300' => $errors->has('phone'),
                        'border-gray-300' => ! $errors->has('phone'),
                    ])
                >

                @error('phone')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label
                    for="owner-profile-role"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Jenis Akun
                </label>

                <input
                    id="owner-profile-role"
                    type="text"
                    value="Owner"
                    disabled
                    class="w-full cursor-not-allowed rounded-xl border-gray-200 bg-gray-100 px-4 py-3 text-sm text-gray-500"
                >

                <p class="mt-2 text-xs text-gray-500">
                    Jenis akun tidak dapat diubah melalui halaman Profil.
                </p>
            </div>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-gray-500">
                Pastikan informasi akun sudah benar.
            </p>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="updateProfile"
                class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span
                    wire:loading.remove
                    wire:target="updateProfile"
                >
                    Simpan Informasi
                </span>

                <span
                    wire:loading
                    wire:target="updateProfile"
                >
                    Menyimpan...
                </span>
            </button>
        </div>
    </x-ui.info-card>
</form>