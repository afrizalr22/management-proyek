@props([
    'name' => '',
    'email' => '',
    'phone' => '',
    'role' => '',
    'status' => 'active',
])

@php
    $displayName = trim($name) !== ''
        ? $name
        : 'Nama Pengguna';

    $displayEmail = trim($email) !== ''
        ? $email
        : 'email@example.com';

    $displayPhone = trim($phone) !== ''
        ? $phone
        : '-';

    $initials = collect(
        preg_split(
            '/\s+/',
            trim($displayName)
        )
    )
        ->filter()
        ->take(2)
        ->map(
            fn (string $word): string =>
                mb_strtoupper(
                    mb_substr($word, 0, 1)
                )
        )
        ->implode('');

    $roleText = match ($role) {
        'owner' => 'Owner',
        'mandor' => 'Mandor',
        'pekerja' => 'Pekerja',
        default => 'Belum Dipilih',
    };

    $roleClasses = match ($role) {
        'owner' =>
            'bg-red-100 text-red-700',

        'mandor' =>
            'bg-blue-100 text-blue-700',

        'pekerja' =>
            'bg-green-100 text-green-700',

        default =>
            'bg-gray-100 text-gray-600',
    };

    $statusText = $status === 'active'
        ? 'Aktif'
        : 'Tidak Aktif';

    $statusClasses = $status === 'active'
        ? 'bg-green-100 text-green-700'
        : 'bg-red-100 text-red-700';
@endphp

<x-ui.info-card>
    <div>
        <div class="rounded-t-2xl bg-gradient-to-r from-blue-600 to-sky-500 p-6">
            <h2 class="text-xl font-bold text-white">
                Preview Pengguna
            </h2>

            <p class="mt-1 text-sm text-blue-100">
                Informasi akun yang akan dibuat
            </p>
        </div>

        <div class="p-6">
            <div class="flex flex-col items-center text-center">
                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-blue-100 text-3xl font-bold text-blue-700">
                    {{ $initials ?: 'NP' }}
                </div>

                <h3 class="mt-5 break-words text-xl font-bold text-gray-900">
                    {{ $displayName }}
                </h3>

                <p class="mt-1 break-all text-sm text-gray-500">
                    {{ $displayEmail }}
                </p>

                <div class="mt-5 flex flex-wrap justify-center gap-2">
                    <span class="rounded-full px-4 py-1.5 text-sm font-semibold {{ $roleClasses }}">
                        {{ $roleText }}
                    </span>

                    <span class="rounded-full px-4 py-1.5 text-sm font-semibold {{ $statusClasses }}">
                        {{ $statusText }}
                    </span>
                </div>
            </div>

            <dl class="mt-7 space-y-4 border-t border-gray-200 pt-6 text-sm">
                <div class="flex items-start justify-between gap-4">
                    <dt class="text-gray-500">
                        Telepon
                    </dt>

                    <dd class="break-all text-right font-medium text-gray-800">
                        {{ $displayPhone }}
                    </dd>
                </div>

                <div class="flex items-start justify-between gap-4">
                    <dt class="text-gray-500">
                        Role
                    </dt>

                    <dd class="font-medium text-gray-800">
                        {{ $roleText }}
                    </dd>
                </div>

                <div class="flex items-start justify-between gap-4">
                    <dt class="text-gray-500">
                        Status
                    </dt>

                    <dd
                        @class([
                            'font-semibold',
                            'text-green-600' =>
                                $status === 'active',
                            'text-red-600' =>
                                $status === 'inactive',
                        ])
                    >
                        {{ $statusText }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</x-ui.info-card>