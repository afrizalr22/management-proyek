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
            <div class="p-6 sm:p-8">
                {{-- Identitas Client --}}
                <div class="flex items-start gap-5">
                    <div
                        class="flex h-16 w-16 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-3xl text-white"
                    >
                        🏢
                    </div>

                    <div class="min-w-0">
                        <h2
                            class="break-words text-2xl font-bold text-gray-900"
                        >
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

                {{-- Informasi kontak --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <p
                            class="text-xs font-semibold uppercase tracking-wide text-gray-500"
                        >
                            Nama Client
                        </p>

                        <p
                            class="mt-2 break-words text-lg text-gray-900"
                        >
                            {{ $client->contact_person ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p
                            class="text-xs font-semibold uppercase tracking-wide text-gray-500"
                        >
                            Nomor Telepon
                        </p>

                        <p
                            class="mt-2 break-words text-lg text-gray-900"
                        >
                            {{ $client->phone ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p
                            class="text-xs font-semibold uppercase tracking-wide text-gray-500"
                        >
                            Email
                        </p>

                        <p
                            class="mt-2 break-all text-lg text-gray-900"
                        >
                            {{ $client->email ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p
                            class="text-xs font-semibold uppercase tracking-wide text-gray-500"
                        >
                            Kota
                        </p>

                        <p
                            class="mt-2 break-words text-lg text-gray-900"
                        >
                            {{ $client->city ?: '-' }}
                        </p>
                    </div>
                </div>

                {{-- Alamat dan Catatan --}}
                <div
                    class="mt-8 grid grid-cols-1 gap-5 border-t border-gray-200 pt-8 md:grid-cols-2"
                >
                    <div
                        class="rounded-xl border border-gray-200 bg-gray-50 p-5"
                    >
                        <div class="flex items-center gap-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-5 w-5 shrink-0 text-blue-600"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M11.25 10.5a.75.75 0 1 1 1.5 0 .75.75 0 0 1-1.5 0Z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"
                                />
                            </svg>

                            <p
                                class="text-xs font-semibold uppercase tracking-wide text-gray-500"
                            >
                                Alamat Lengkap
                            </p>
                        </div>

                        <p
                            class="mt-3 break-words whitespace-pre-line text-base leading-7 text-gray-900"
                        >{{ filled($client->address) ? $client->address : '-' }}</p>
                    </div>

                    <div
                        class="rounded-xl border border-gray-200 bg-gray-50 p-5"
                    >
                        <div class="flex items-center gap-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-5 w-5 shrink-0 text-blue-600"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m0 12.75h7.5m-7.5 3h4.5m-7.125 3.75h12.75a1.875 1.875 0 0 0 1.875-1.875V11.625a9.375 9.375 0 0 0-9.375-9.375h-5.25A1.875 1.875 0 0 0 3.75 4.125v15.75a1.875 1.875 0 0 0 1.875 1.875Z"
                                />
                            </svg>

                            <p
                                class="text-xs font-semibold uppercase tracking-wide text-gray-500"
                            >
                                Catatan
                            </p>
                        </div>

                        <p
                            class="mt-3 break-words whitespace-pre-line text-base leading-7 text-gray-900"
                        >{{ filled($client->notes) ? $client->notes : '-' }}</p>
                    </div>
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
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-gray-500">
                            Total Project
                        </span>

                        <span class="text-xl font-bold text-gray-900">
                            {{ $client->projects_count }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <span class="text-gray-500">
                            Project Aktif
                        </span>

                        <span class="font-semibold text-blue-600">
                            {{ $client->active_projects_count }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between gap-4">
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

                <h2
                    class="mt-4 break-words text-2xl font-bold sm:text-3xl"
                >
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