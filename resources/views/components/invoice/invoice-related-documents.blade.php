@props([
    'invoice',
])

@php
    $quotationStatus = match ($invoice->quotation?->status) {
        'approved' => [
            'label' => 'Disetujui',
            'color' => 'green',
        ],
        'sent' => [
            'label' => 'Dikirim',
            'color' => 'blue',
        ],
        'rejected' => [
            'label' => 'Ditolak',
            'color' => 'red',
        ],
        'draft' => [
            'label' => 'Draft',
            'color' => 'yellow',
        ],
        default => [
            'label' => 'Tidak Tersedia',
            'color' => 'gray',
        ],
    };

    $projectStatus = match ($invoice->project?->status) {
        'planning' => [
            'label' => 'Perencanaan',
            'color' => 'yellow',
        ],
        'on_progress' => [
            'label' => 'Berjalan',
            'color' => 'blue',
        ],
        'completed' => [
            'label' => 'Selesai',
            'color' => 'green',
        ],
        'cancelled' => [
            'label' => 'Dibatalkan',
            'color' => 'red',
        ],
        default => [
            'label' => 'Belum Dibuat',
            'color' => 'gray',
        ],
    };
@endphp

<x-ui.info-card>
    <div class="p-6 sm:p-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Dokumen Terkait
            </h2>

            <p class="mt-2 text-gray-500">
                Quotation dan proyek yang berkaitan dengan invoice.
            </p>
        </div>

        <hr class="my-8 border-gray-200">

        <div class="grid gap-6 md:grid-cols-2">
            <div class="rounded-2xl border border-gray-200 p-6">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">
                            Quotation
                        </p>

                        <h3 class="mt-2 break-words text-xl font-bold text-gray-900">
                            {{ $invoice->quotation?->quotation_number
                                ?: 'Tidak Tersedia' }}
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Dokumen penawaran yang menjadi dasar pembuatan
                            invoice ini.
                        </p>
                    </div>

                    <x-ui.badge :color="$quotationStatus['color']">
                        {{ $quotationStatus['label'] }}
                    </x-ui.badge>
                </div>

                <div class="mt-6">
                    @if ($invoice->quotation)
                        <a
                            href="{{ route(
                                'owner.quotations.show',
                                $invoice->quotation
                            ) }}"
                            wire:navigate
                        >
                            <x-ui.button variant="secondary">
                                Lihat Quotation
                            </x-ui.button>
                        </a>
                    @else
                        <x-ui.button
                            variant="secondary"
                            disabled
                        >
                            Tidak Tersedia
                        </x-ui.button>
                    @endif
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 p-6">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">
                            Proyek
                        </p>

                        <h3 class="mt-2 break-words text-xl font-bold text-gray-900">
                            {{ $invoice->project?->project_name
                                ?? $invoice->quotation?->project_name
                                ?? 'Belum Dibuat' }}
                        </h3>

                        @if ($invoice->project?->project_code)
                            <p class="mt-1 text-sm font-medium text-gray-600">
                                {{ $invoice->project->project_code }}
                            </p>
                        @endif

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            @if ($invoice->project)
                                Proyek yang terhubung dengan invoice ini.
                            @else
                                Invoice belum terhubung dengan data proyek.
                            @endif
                        </p>
                    </div>

                    <x-ui.badge :color="$projectStatus['color']">
                        {{ $projectStatus['label'] }}
                    </x-ui.badge>
                </div>

                <div class="mt-6">
                    @if ($invoice->project)
                        <a
                            href="{{ route(
                                'owner.projects.show',
                                $invoice->project
                            ) }}"
                            wire:navigate
                        >
                            <x-ui.button variant="secondary">
                                Lihat Proyek
                            </x-ui.button>
                        </a>
                    @else
                        <x-ui.button
                            variant="secondary"
                            disabled
                        >
                            Belum Tersedia
                        </x-ui.button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-ui.info-card>