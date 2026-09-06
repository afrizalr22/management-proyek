@props([
    'project',
    'sourceQuotation' => null,
    'statusText' => 'Tidak Diketahui',
    'statusColor' => 'gray',
])

@php
    $statusDotColor = match ($project->status) {
        'planning' => 'bg-yellow-400',
        'on_progress' => 'bg-blue-500',
        'completed' => 'bg-green-500',
        'cancelled' => 'bg-red-500',
        default => 'bg-gray-400',
    };

    $clientName =
        $project->client?->company_name
        ?? 'Client tidak tersedia';

    $contactPerson =
        $project->client?->contact_person
        ?? $sourceQuotation?->client_contact_person
        ?? '-';

    $mandorName =
        $project->mandor?->name
        ?? 'Belum ditentukan';

    $mandorEmail =
        $project->mandor?->email
        ?? '-';
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">
        {{-- Header --}}
        <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex min-w-0 items-start gap-4 sm:gap-5">
                <div
                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-md sm:h-16 sm:w-16"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.7"
                        stroke="currentColor"
                        class="h-8 w-8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 21h16.5M4.5 3h15l-.75 18H5.25L4.5 3Zm3 4.5h9m-9 4.5h9m-9 4.5h5.25"
                        />
                    </svg>
                </div>

                <div class="min-w-0">
                    <h2 class="break-words text-xl font-bold text-gray-900 sm:text-2xl">
                        {{ $project->project_name }}
                    </h2>

                    <p class="mt-1 break-words text-sm text-gray-500 sm:text-base">
                        {{ $project->location ?: 'Lokasi belum ditentukan' }}
                    </p>

                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <x-ui.badge :color="$statusColor">
                            <span
                                class="mr-2 inline-block h-2 w-2 rounded-full {{ $statusDotColor }}"
                            ></span>

                            {{ $statusText }}
                        </x-ui.badge>

                        <span
                            class="rounded-lg bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600"
                        >
                            {{ $project->project_code }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-6 border-gray-200 sm:my-8">

        {{-- Informasi utama --}}
        <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Client
                </dt>

                <dd class="mt-2 break-words font-semibold text-gray-900">
                    {{ $clientName }}
                </dd>

                <p class="mt-1 text-sm text-gray-500">
                    Kontak: {{ $contactPerson }}
                </p>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Mandor
                </dt>

                <dd class="mt-2 break-words font-semibold text-gray-900">
                    {{ $mandorName }}
                </dd>

                <p class="mt-1 break-all text-sm text-gray-500">
                    {{ $mandorEmail }}
                </p>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Tanggal Mulai
                </dt>

                <dd class="mt-2 font-semibold text-gray-900">
                    {{ $project->start_date
                        ? $project->start_date->translatedFormat('d F Y')
                        : 'Belum ditentukan' }}
                </dd>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Target Selesai
                </dt>

                <dd class="mt-2 font-semibold text-gray-900">
                    {{ $project->end_date
                        ? $project->end_date->translatedFormat('d F Y')
                        : 'Belum ditentukan' }}
                </dd>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Nomor Kontrak
                </dt>

                <dd class="mt-2 break-words font-semibold text-gray-900">
                    {{ $project->contract_number ?: '-' }}
                </dd>
            </div>

            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Tanggal Kontrak
                </dt>

                <dd class="mt-2 font-semibold text-gray-900">
                    {{ $project->contract_date
                        ? $project->contract_date->translatedFormat('d F Y')
                        : '-' }}
                </dd>
            </div>
        </dl>

        <hr class="my-6 border-gray-200 sm:my-8">

        {{-- Lokasi --}}
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                Lokasi Project
            </p>

            <p class="mt-3 whitespace-pre-line break-words leading-7 text-gray-700">
                {{ $project->location ?: 'Lokasi Project belum ditentukan.' }}
            </p>
        </div>

        {{-- Quotation sumber --}}
        @if ($sourceQuotation)
            <div class="mt-6 rounded-2xl border border-green-200 bg-green-50 p-4">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-green-700">
                            Quotation Sumber
                        </p>

                        <p class="mt-1 font-semibold text-green-900">
                            {{ $sourceQuotation->quotation_number }}
                        </p>

                        <p class="mt-1 text-sm text-green-700">
                            Disetujui
                            {{ $sourceQuotation->approved_at
                                ? 'pada '.$sourceQuotation->approved_at
                                    ->translatedFormat('d F Y, H:i')
                                : '' }}
                        </p>
                    </div>

                    <a
                        href="{{ route('owner.quotations.show', [
                            'quotation' => $sourceQuotation->id,
                        ]) }}"
                        wire:navigate
                        class="inline-flex min-h-10 items-center justify-center rounded-xl border border-green-300 bg-white px-4 py-2 text-sm font-semibold text-green-700 transition hover:bg-green-100"
                    >
                        Lihat Quotation
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-ui.info-card>