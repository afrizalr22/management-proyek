@props([
    'user',
    'role' => '-',
])

@php
    $roleText = match ($role) {
        'owner' => 'Owner',
        'mandor' => 'Mandor',
        'pekerja' => 'Pekerja',
        default => '-',
    };

    $roleColor = match ($role) {
        'owner' => 'red',
        'mandor' => 'blue',
        'pekerja' => 'green',
        default => 'gray',
    };

    $statusText = $user->status === 'active'
        ? 'Aktif'
        : 'Tidak Aktif';

    $statusColor = $user->status === 'active'
        ? 'green'
        : 'red';
@endphp

<x-ui.info-card>
    <div class="p-6 sm:p-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">
                Informasi Pengguna
            </h2>

            <p class="mt-2 text-gray-500">
                Informasi lengkap mengenai akun pengguna.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <p class="mb-2 text-sm font-medium text-gray-500">
                    Nama Lengkap
                </p>

                <div class="break-words rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 font-medium text-gray-800">
                    {{ $user->name }}
                </div>
            </div>

            <div>
                <p class="mb-2 text-sm font-medium text-gray-500">
                    Email
                </p>

                <div class="break-all rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-800">
                    {{ $user->email }}
                </div>
            </div>

            <div>
                <p class="mb-2 text-sm font-medium text-gray-500">
                    Nomor Telepon
                </p>

                <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-800">
                    {{ $user->phone ?: '-' }}
                </div>
            </div>

            <div>
                <p class="mb-2 text-sm font-medium text-gray-500">
                    Role
                </p>

                <div class="flex min-h-12 items-center rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">
                    <x-ui.badge :color="$roleColor">
                        {{ $roleText }}
                    </x-ui.badge>
                </div>
            </div>

            <div>
                <p class="mb-2 text-sm font-medium text-gray-500">
                    Status Akun
                </p>

                <div class="flex min-h-12 items-center rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">
                    <x-ui.badge :color="$statusColor">
                        {{ $statusText }}
                    </x-ui.badge>
                </div>
            </div>

            <div>
                <p class="mb-2 text-sm font-medium text-gray-500">
                    Tanggal Bergabung
                </p>

                <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-800">
                    {{ $user->created_at?->translatedFormat('d F Y, H:i') ?? '-' }}
                </div>
            </div>
        </div>
    </div>
</x-ui.info-card>