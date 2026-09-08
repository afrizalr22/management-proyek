@props([
    'role' => '',
    'status' => 'active',
    'isSelf' => false,
])

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">
        {{-- Header --}}
        <div class="flex items-center gap-4">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-purple-100 text-purple-600">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-6 w-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Akses dan Role
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Tentukan hak akses dan status akun pengguna.
                </p>
            </div>
        </div>

        <hr class="my-6 border-gray-200 sm:my-8">

        @if ($isSelf)
            <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3">
                <div class="flex items-start gap-3">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="mt-0.5 h-5 w-5 shrink-0 text-amber-600"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v3.75m9-0.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 4.5h.008v.008H12V16.5Z"
                        />
                    </svg>

                    <div>
                        <p class="text-sm font-semibold text-amber-800">
                            Akun sedang digunakan
                        </p>

                        <p class="mt-1 text-xs leading-5 text-amber-700">
                            Role dan status akun Anda sendiri tidak dapat diubah.
                            Informasi identitas dan password tetap dapat diperbarui.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Pilihan role --}}
        <fieldset @disabled($isSelf)>
            <legend class="mb-3 text-sm font-semibold text-gray-700">
                Role Pengguna
                <span class="text-red-500">*</span>
            </legend>

            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                @foreach ([
                    'owner' => [
                        'label' => 'Owner',
                        'description' => 'Mengelola seluruh sistem.',
                        'selected' => 'border-red-400 bg-red-50 ring-2 ring-red-100',
                        'radio' => 'text-red-600 focus:ring-red-500',
                    ],
                    'mandor' => [
                        'label' => 'Mandor',
                        'description' => 'Mengelola Project dan pekerjaan.',
                        'selected' => 'border-blue-400 bg-blue-50 ring-2 ring-blue-100',
                        'radio' => 'text-blue-600 focus:ring-blue-500',
                    ],
                    'pekerja' => [
                        'label' => 'Pekerja',
                        'description' => 'Menjalankan tugas dan laporan.',
                        'selected' => 'border-green-400 bg-green-50 ring-2 ring-green-100',
                        'radio' => 'text-green-600 focus:ring-green-500',
                    ],
                ] as $roleValue => $roleOption)
                    <label
                        wire:key="user-role-{{ $roleValue }}"
                        @class([
                            'rounded-xl border p-4 transition',
                            $roleOption['selected'] => $role === $roleValue,
                            'border-gray-200 bg-white hover:border-blue-300' =>
                                $role !== $roleValue && !$isSelf,
                            'cursor-pointer' => !$isSelf,
                            'cursor-not-allowed opacity-60' => $isSelf,
                        ])
                    >
                        <div class="flex items-start gap-3">
                            <input
                                type="radio"
                                wire:model.live="role"
                                value="{{ $roleValue }}"
                                @disabled($isSelf)
                                class="mt-1 border-gray-300 disabled:cursor-not-allowed {{ $roleOption['radio'] }}"
                            >

                            <div>
                                <p class="font-semibold text-gray-900">
                                    {{ $roleOption['label'] }}
                                </p>

                                <p class="mt-1 text-xs leading-5 text-gray-500">
                                    {{ $roleOption['description'] }}
                                </p>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>

            @error('role')
                <p class="mt-2 text-sm font-medium text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </fieldset>

        {{-- Status --}}
        <fieldset
            class="mt-6"
            @disabled($isSelf)
        >
            <legend class="mb-3 text-sm font-semibold text-gray-700">
                Status Akun
                <span class="text-red-500">*</span>
            </legend>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                {{-- Aktif --}}
                <label
                    @class([
                        'rounded-xl border p-4 transition',
                        'border-green-400 bg-green-50 ring-2 ring-green-100' =>
                            $status === 'active',
                        'border-gray-200 bg-white hover:border-green-300' =>
                            $status !== 'active' && !$isSelf,
                        'cursor-pointer' => !$isSelf,
                        'cursor-not-allowed opacity-60' => $isSelf,
                    ])
                >
                    <div class="flex items-start gap-3">
                        <input
                            type="radio"
                            wire:model.live="status"
                            value="active"
                            @disabled($isSelf)
                            class="mt-1 border-gray-300 text-green-600 focus:ring-green-500 disabled:cursor-not-allowed"
                        >

                        <div>
                            <p class="font-semibold text-gray-900">
                                Aktif
                            </p>

                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                Akun ditandai aktif dan memperoleh akses sesuai role.
                            </p>
                        </div>
                    </div>
                </label>

                {{-- Tidak aktif --}}
                <label
                    @class([
                        'rounded-xl border p-4 transition',
                        'border-red-400 bg-red-50 ring-2 ring-red-100' =>
                            $status === 'inactive',
                        'border-gray-200 bg-white hover:border-red-300' =>
                            $status !== 'inactive' && !$isSelf,
                        'cursor-pointer' => !$isSelf,
                        'cursor-not-allowed opacity-60' => $isSelf,
                    ])
                >
                    <div class="flex items-start gap-3">
                        <input
                            type="radio"
                            wire:model.live="status"
                            value="inactive"
                            @disabled($isSelf)
                            class="mt-1 border-gray-300 text-red-600 focus:ring-red-500 disabled:cursor-not-allowed"
                        >

                        <div>
                            <p class="font-semibold text-gray-900">
                                Tidak Aktif
                            </p>

                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                Akun ditandai tidak aktif dalam sistem.
                            </p>
                        </div>
                    </div>
                </label>
            </div>

            @error('status')
                <p class="mt-2 text-sm font-medium text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </fieldset>

        {{-- Informasi role --}}
        <div class="mt-6 rounded-xl border border-blue-200 bg-blue-50 p-4">
            <p class="text-sm font-semibold text-blue-800">
                Ketentuan perubahan role
            </p>

            <ul class="mt-2 list-inside list-disc space-y-1 text-xs leading-5 text-blue-700">
                <li>
                    Mandor dengan Project aktif tidak dapat diganti role.
                </li>

                <li>
                    Pekerja dengan penugasan aktif tidak dapat diganti role.
                </li>

                <li>
                    Owner aktif terakhir tidak dapat diturunkan role atau dinonaktifkan.
                </li>
            </ul>
        </div>
    </div>
</x-ui.info-card>