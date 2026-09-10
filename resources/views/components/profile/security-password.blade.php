@props([
    'passwordSuccess' => '',
])

<form
    wire:submit="updatePassword"
    novalidate
    x-data="{
        showCurrentPassword: false,
        showNewPassword: false,
        showConfirmation: false
    }"
>
    <x-ui.info-card>
        <div class="border-b border-gray-200 px-6 py-5">
            <h2 class="text-xl font-bold text-gray-900">
                Keamanan dan Password
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Perbarui password untuk menjaga keamanan akun.
            </p>
        </div>

        <div class="space-y-6 p-6">
            @error('passwordSave')
                <div
                    class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                    role="alert"
                >
                    {{ $message }}
                </div>
            @enderror

            @if ($passwordSuccess)
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 4000)"
                    x-show="show"
                    x-transition.opacity
                    class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
                    role="status"
                >
                    {{ $passwordSuccess }}
                </div>
            @endif

            <div>
                <label
                    for="owner-current-password"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Password Saat Ini

                    <span class="text-red-500">*</span>
                </label>

                <div class="relative">
                    <input
                        id="owner-current-password"
                        x-bind:type="showCurrentPassword
                            ? 'text'
                            : 'password'"
                        wire:model="currentPassword"
                        autocomplete="current-password"
                        placeholder="Masukkan password saat ini"
                        @class([
                            'w-full rounded-xl py-3 pl-4 pr-12 text-sm focus:border-blue-500 focus:ring-blue-500',
                            'border-red-300' => $errors->has('currentPassword'),
                            'border-gray-300' => ! $errors->has('currentPassword'),
                        ])
                    >

                    <button
                        type="button"
                        x-on:click="
                            showCurrentPassword =
                                ! showCurrentPassword
                        "
                        class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-gray-400 transition hover:text-gray-600"
                        aria-label="Tampilkan atau sembunyikan password saat ini"
                    >
                        <span
                            class="text-xs font-semibold"
                            x-text="showCurrentPassword
                                ? 'Tutup'
                                : 'Lihat'"
                        ></span>
                    </button>
                </div>

                @error('currentPassword')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label
                        for="owner-new-password"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Password Baru

                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <input
                            id="owner-new-password"
                            x-bind:type="showNewPassword
                                ? 'text'
                                : 'password'"
                            wire:model="newPassword"
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            @class([
                                'w-full rounded-xl py-3 pl-4 pr-12 text-sm focus:border-blue-500 focus:ring-blue-500',
                                'border-red-300' => $errors->has('newPassword'),
                                'border-gray-300' => ! $errors->has('newPassword'),
                            ])
                        >

                        <button
                            type="button"
                            x-on:click="
                                showNewPassword =
                                    ! showNewPassword
                            "
                            class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-gray-400 transition hover:text-gray-600"
                            aria-label="Tampilkan atau sembunyikan password baru"
                        >
                            <span
                                class="text-xs font-semibold"
                                x-text="showNewPassword
                                    ? 'Tutup'
                                    : 'Lihat'"
                            ></span>
                        </button>
                    </div>

                    @error('newPassword')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="owner-new-password-confirmation"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Konfirmasi Password

                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <input
                            id="owner-new-password-confirmation"
                            x-bind:type="showConfirmation
                                ? 'text'
                                : 'password'"
                            wire:model="newPasswordConfirmation"
                            autocomplete="new-password"
                            placeholder="Ulangi password baru"
                            @class([
                                'w-full rounded-xl py-3 pl-4 pr-12 text-sm focus:border-blue-500 focus:ring-blue-500',
                                'border-red-300' => $errors->has('newPasswordConfirmation'),
                                'border-gray-300' => ! $errors->has('newPasswordConfirmation'),
                            ])
                        >

                        <button
                            type="button"
                            x-on:click="
                                showConfirmation =
                                    ! showConfirmation
                            "
                            class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-gray-400 transition hover:text-gray-600"
                            aria-label="Tampilkan atau sembunyikan konfirmasi password"
                        >
                            <span
                                class="text-xs font-semibold"
                                x-text="showConfirmation
                                    ? 'Tutup'
                                    : 'Lihat'"
                            ></span>
                        </button>
                    </div>

                    @error('newPasswordConfirmation')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="rounded-xl border border-blue-100 bg-blue-50 p-4">
                <div class="flex items-start gap-3">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mt-0.5 h-5 w-5 shrink-0 text-blue-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"
                        />
                    </svg>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">
                            Ketentuan Password
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-gray-600">
                            Gunakan minimal 8 karakter yang mengandung huruf dan angka. Hindari menggunakan password lama atau informasi pribadi.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-gray-500">
                Anda tetap masuk setelah password diperbarui.
            </p>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="updatePassword"
                class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span
                    wire:loading.remove
                    wire:target="updatePassword"
                >
                    Perbarui Password
                </span>

                <span
                    wire:loading
                    wire:target="updatePassword"
                >
                    Memperbarui...
                </span>
            </button>
        </div>
    </x-ui.info-card>
</form>