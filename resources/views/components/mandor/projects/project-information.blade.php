@props([
    'project',
])

@php
    $budget = 'Rp'.number_format(
        (float) (
            $project->project_budget
            ?? 0
        ),
        0,
        ',',
        '.'
    );

    $contractValue = 'Rp'.number_format(
        (float) (
            $project->contract_value
            ?? 0
        ),
        0,
        ',',
        '.'
    );
@endphp

<x-ui.info-card class="overflow-hidden">
    {{-- Header --}}
    <div class="border-b border-gray-200 px-5 py-5 sm:px-6">
        <h2 class="text-base font-bold text-gray-900">
            Informasi Project
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Informasi umum dan kontrak Project.
        </p>
    </div>

    <div class="space-y-5 p-5 sm:p-6">
        {{-- Client --}}
        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                Client
            </p>

            <p class="mt-1 font-semibold text-gray-900">
                {{ $project->client?->company_name
                    ?? 'Client tidak tersedia' }}
            </p>

            @if ($project->client?->contact_person)
                <p class="mt-1 text-sm text-gray-500">
                    {{ $project->client->contact_person }}
                </p>
            @endif
        </div>

        {{-- Kontak Client --}}
        @if (
            $project->client?->phone
            || $project->client?->email
        )
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-1">
                @if ($project->client?->phone)
                    <div class="rounded-xl bg-gray-50 p-3">
                        <p class="text-xs text-gray-400">
                            Telepon
                        </p>

                        <p class="mt-1 break-all text-sm font-semibold text-gray-700">
                            {{ $project->client->phone }}
                        </p>
                    </div>
                @endif

                @if ($project->client?->email)
                    <div class="rounded-xl bg-gray-50 p-3">
                        <p class="text-xs text-gray-400">
                            Email
                        </p>

                        <p class="mt-1 break-all text-sm font-semibold text-gray-700">
                            {{ $project->client->email }}
                        </p>
                    </div>
                @endif
            </div>
        @endif

        {{-- Lokasi --}}
        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                Lokasi Project
            </p>

            <div class="mt-2 flex items-start gap-2">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="mt-0.5 h-5 w-5 shrink-0 text-blue-600"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"
                    />
                </svg>

                <p class="text-sm leading-6 text-gray-700">
                    {{ $project->location
                        ?: 'Lokasi belum ditentukan' }}
                </p>
            </div>
        </div>

        {{-- Nomor kontrak --}}
        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                Nomor Kontrak
            </p>

            <p class="mt-1 break-words font-semibold text-gray-900">
                {{ $project->contract_number
                    ?: 'Belum tersedia' }}
            </p>

            @if ($project->contract_date)
                <p class="mt-1 text-sm text-gray-500">
                    Tanggal kontrak:
                    {{ $project->contract_date
                        ->translatedFormat('d F Y') }}
                </p>
            @endif
        </div>

        {{-- Periode --}}
        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                Periode Project
            </p>

            <div class="mt-2 grid grid-cols-2 gap-3">
                <div class="rounded-xl bg-gray-50 p-3">
                    <p class="text-xs text-gray-400">
                        Tanggal Mulai
                    </p>

                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        {{ $project->start_date
                            ?->translatedFormat(
                                'd M Y'
                            ) ?? '-' }}
                    </p>
                </div>

                <div class="rounded-xl bg-gray-50 p-3">
                    <p class="text-xs text-gray-400">
                        Target Selesai
                    </p>

                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        {{ $project->end_date
                            ?->translatedFormat(
                                'd M Y'
                            ) ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Deskripsi --}}
        @if ($project->description)
            <div class="border-t border-gray-200 pt-5">
                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Deskripsi
                </p>

                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-600">{{ $project->description }}</p>
            </div>
        @endif

        {{-- Keuangan --}}
        <div class="border-t border-gray-200 pt-5">
            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                Informasi Keuangan
            </p>

            <dl class="mt-3 space-y-3">
                <div class="flex items-start justify-between gap-4">
                    <dt class="text-sm text-gray-500">
                        Anggaran
                    </dt>

                    <dd class="break-words text-right text-sm font-semibold text-gray-900">
                        {{ $budget }}
                    </dd>
                </div>

                <div class="flex items-start justify-between gap-4">
                    <dt class="text-sm text-gray-500">
                        Nilai Kontrak
                    </dt>

                    <dd class="break-words text-right text-sm font-bold text-blue-600">
                        {{ $contractValue }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</x-ui.info-card>