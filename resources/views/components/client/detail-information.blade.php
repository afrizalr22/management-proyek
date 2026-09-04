@props([
    'client',
])

@php
    $statusColor = match ($client->status) {
        'active' => 'green',
        'lead' => 'yellow',
        'inactive' => 'red',
        default => 'gray',
    };

    $statusText = match ($client->status) {
        'active' => 'Aktif',
        'lead' => 'Lead',
        'inactive' => 'Nonaktif',
        default => 'Tidak diketahui',
    };

    $totalProjectValue = (float) (
        $client->projects_sum_contract_value ?? 0
    );
@endphp

<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

    {{-- Informasi utama --}}
    <div class="xl:col-span-2">
        <x-ui.info-card>
            <div class="p-8">

                <div class="flex items-start gap-5">
                    <div
                        class="flex h-16 w-16 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-3xl text-white"
                    >
                        🏢
                    </div>

                    <div class="min-w-0">
                        <h2 class="break-words text-2xl font-bold text-gray-900">
                            {{ $client->company_name }}
                        </h2>

                        <div class="mt-2">
                            <x-ui.badge :color="$statusColor">
                                {{ $statusText }}
                            </x-ui.badge>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">

                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">
                            Nama Client
                        </p>

                        <p class="mt-2 break-words text-lg text-gray-900">
                            {{ $client->contact_person }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">
                            Nomor Telepon
                        </p>

                        <p class="mt-2 text-lg text-gray-900">
                            {{ $client->phone ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">
                            Email
                        </p>

                        <p class="mt-2 break-all text-lg text-gray-900">
                            {{ $client->email ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">
                            Kota
                        </p>

                        <p class="mt-2 text-lg text-gray-900">
                            {{ $client->city ?: '-' }}
                        </p>
                    </div>

                </div>

                <div class="mt-8">
                    <p class="text-xs font-semibold uppercase text-gray-500">
                        Alamat Lengkap
                    </p>

                    <p class="mt-2 whitespace-pre-line text-lg leading-8 text-gray-900">{{ $client->address ?: '-' }}</p>
                </div>

            </div>
        </x-ui.info-card>
    </div>

    {{-- Ringkasan --}}
    <div class="space-y-6">

        <x-ui.summary-card>
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-800">
                    Ringkasan Project
                </h3>

                <div class="mt-6 space-y-5">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">
                            Total Project
                        </span>

                        <span class="text-xl font-bold text-gray-900">
                            {{ $client->projects_count }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">
                            Project Aktif
                        </span>

                        <span class="font-semibold text-blue-600">
                            {{ $client->active_projects_count }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">
                            Project Selesai
                        </span>

                        <span class="font-semibold text-green-600">
                            {{ $client->completed_projects_count }}
                        </span>
                    </div>
                </div>
            </div>
        </x-ui.summary-card>

        <x-ui.summary-card>
            <div class="rounded-2xl bg-gray-900 p-6 text-white">
                <p class="text-sm uppercase tracking-wide text-gray-300">
                    Total Nilai Project
                </p>

                <h2 class="mt-4 break-words text-2xl font-bold sm:text-3xl">
                    Rp {{ number_format(
                        $totalProjectValue,
                        0,
                        ',',
                        '.'
                    ) }}
                </h2>

                <p class="mt-2 text-sm text-gray-400">
                    Akumulasi nilai kontrak seluruh Project Client.
                </p>
            </div>
        </x-ui.summary-card>

    </div>
</div>