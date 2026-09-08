@props([
    'mode' => 'create',
])

@php
    $isEdit = $mode === 'edit';
@endphp

<x-ui.info-card>
    <div
        x-data="{
            showPassword: false,
            showConfirmation: false
        }"
        class="p-6 sm:p-8"
    >
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-100">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="h-6 w-6 text-blue-600"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-10 0v1H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $isEdit ? 'Ubah Password' : 'Password' }}
                </h2>

                <p class="mt-1 text-gray-500">
                    {{ $isEdit
                        ? 'Kosongkan apabila password tidak ingin diubah.'
                        : 'Buat password untuk akun pengguna.' }}
                </p>
            </div>
        </div>

        <div class="my-8 border-t border-gray-200"></div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label
                    for="user-password"
                    class="mb-2 block font-medium text-gray-700"
                >
                    Password
                    @if (!$isEdit)
                        <span class="text-red-500">*</span>
                    @endif
                </label>

                <div class="relative">
                    <input
                        id="user-password"
                        :type="showPassword ? 'text' : 'password'"
                        wire:model="password"
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                        class="w-full rounded-xl border-gray-300 pr-16 focus:border-blue-500 focus:ring-blue-500"
                    >

                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 px-4 text-xs font-semibold text-blue-600"
                    >
                        <span x-text="showPassword ? 'Tutup' : 'Lihat'"></span>
                    </button>
                </div>

                @error('password')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label
                    for="user-password-confirmation"
                    class="mb-2 block font-medium text-gray-700"
                >
                    Konfirmasi Password
                    @if (!$isEdit)
                        <span class="text-red-500">*</span>
                    @endif
                </label>

                <div class="relative">
                    <input
                        id="user-password-confirmation"
                        :type="showConfirmation ? 'text' : 'password'"
                        wire:model="password_confirmation"
                        autocomplete="new-password"
                        placeholder="Ulangi password"
                        class="w-full rounded-xl border-gray-300 pr-16 focus:border-blue-500 focus:ring-blue-500"
                    >

                    <button
                        type="button"
                        @click="showConfirmation = !showConfirmation"
                        class="absolute inset-y-0 right-0 px-4 text-xs font-semibold text-blue-600"
                    >
                        <span x-text="showConfirmation ? 'Tutup' : 'Lihat'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-ui.info-card>