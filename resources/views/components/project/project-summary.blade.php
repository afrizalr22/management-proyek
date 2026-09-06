@props([
    'project',
    'sourceQuotation' => null,
    'statusText' => 'Tidak Diketahui',
    'statusColor' => 'gray',
])

@php
    $progress = min(
        100,
        max(0, (int) $project->progress)
    );

    $statusDescription = match ($project->status) {
        'planning' =>
            'Project berada dalam tahap perencanaan dan persiapan pelaksanaan.',

        'on_progress' =>
            'Project sedang dilaksanakan oleh Mandor dan tim pekerja.',

        'completed' =>
            'Seluruh pekerjaan Project telah diselesaikan dan divalidasi.',

        'cancelled' =>
            'Pelaksanaan Project telah dibatalkan.',

        default =>
            'Status Project belum dapat dikenali.',
    };

    $durationDays = (
        $project->start_date
        && $project->end_date
    )
        ? (int) $project->start_date->diffInDays(
            $project->end_date
        )
        : null;

    $contractValue = number_format(
        (float) $project->contract_value,
        0,
        ',',
        '.'
    );

    $projectBudget = number_format(
        (float) $project->project_budget,
        0,
        ',',
        '.'
    );
@endphp

<div class="space-y-6">
    {{-- Status Project --}}
    <x-ui.summary-card>
        <div class="p-5 sm:p-6">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h3 class="text-lg font-bold text-gray-900">
                    Status Project
                </h3>

                <x-ui.badge :color="$statusColor">
                    {{ $statusText }}
                </x-ui.badge>
            </div>

            <p class="mt-4 text-sm leading-6 text-gray-500">
                {{ $statusDescription }}
            </p>
        </div>
    </x-ui.summary-card>

    {{-- Progres --}}
    <x-ui.summary-card>
        <div class="p-5 sm:p-6">
            <div class="flex items-center justify-between gap-4">
                <h3 class="text-lg font-bold text-gray-900">
                    Progres Project
                </h3>

                <span class="text-2xl font-bold text-blue-600">
                    {{ $progress }}%
                </span>
            </div>

            <div class="mt-5">
                <progress
                    value="{{ $progress }}"
                    max="100"
                    aria-label="Progres Project {{ $progress }} persen"
                    @class([
                        'block h-2.5 w-full appearance-none overflow-hidden rounded-full bg-gray-200',
                        '[&::-webkit-progress-bar]:rounded-full',
                        '[&::-webkit-progress-bar]:bg-gray-200',
                        '[&::-webkit-progress-value]:rounded-full',
                        '[&::-moz-progress-bar]:rounded-full',

                        '[&::-webkit-progress-value]:bg-yellow-500 [&::-moz-progress-bar]:bg-yellow-500' =>
                            $project->status === 'planning',

                        '[&::-webkit-progress-value]:bg-blue-600 [&::-moz-progress-bar]:bg-blue-600' =>
                            $project->status === 'on_progress',

                        '[&::-webkit-progress-value]:bg-green-600 [&::-moz-progress-bar]:bg-green-600' =>
                            $project->status === 'completed',

                        '[&::-webkit-progress-value]:bg-red-500 [&::-moz-progress-bar]:bg-red-500' =>
                            $project->status === 'cancelled',

                        '[&::-webkit-progress-value]:bg-gray-500 [&::-moz-progress-bar]:bg-gray-500' =>
                            !in_array(
                                $project->status,
                                [
                                    'planning',
                                    'on_progress',
                                    'completed',
                                    'cancelled',
                                ],
                                true
                            ),
                    ])
                >
                    {{ $progress }}%
                </progress>
            </div>

            <p class="mt-4 text-sm leading-6 text-gray-500">
                Berdasarkan pekerjaan dan laporan yang telah divalidasi Mandor.
            </p>
        </div>
    </x-ui.summary-card>

    {{-- Ringkasan Project --}}
    <x-ui.summary-card>
        <div class="p-5 sm:p-6">
            <h3 class="text-lg font-bold text-gray-900">
                Ringkasan Project
            </h3>

            <dl class="mt-6 space-y-5">
                <div class="flex items-start justify-between gap-4">
                    <dt class="text-sm text-gray-500">
                        Nilai Kontrak
                    </dt>

                    <dd class="break-words text-right text-sm font-bold text-gray-900">
                        Rp{{ $contractValue }}
                    </dd>
                </div>

                <div class="flex items-start justify-between gap-4">
                    <dt class="text-sm text-gray-500">
                        Anggaran Internal
                    </dt>

                    <dd class="break-words text-right text-sm font-semibold text-gray-900">
                        Rp{{ $projectBudget }}
                    </dd>
                </div>

                <div class="flex items-start justify-between gap-4">
                    <dt class="text-sm text-gray-500">
                        Target
                    </dt>

                    <dd class="text-right text-sm font-semibold text-gray-900">
                        {{ $project->end_date
                            ? $project->end_date->translatedFormat('d M Y')
                            : '-' }}
                    </dd>
                </div>

                <div class="flex items-start justify-between gap-4">
                    <dt class="text-sm text-gray-500">
                        Durasi
                    </dt>

                    <dd class="text-right text-sm font-semibold text-gray-900">
                        {{ $durationDays !== null
                            ? $durationDays.' hari'
                            : '-' }}
                    </dd>
                </div>

                <div class="flex items-start justify-between gap-4">
                    <dt class="text-sm text-gray-500">
                        Mandor
                    </dt>

                    <dd class="break-words text-right text-sm font-semibold text-gray-900">
                        {{ $project->mandor?->name
                            ?? 'Belum ditentukan' }}
                    </dd>
                </div>
            </dl>
        </div>
    </x-ui.summary-card>

    {{-- Rekap operasional --}}
    <x-ui.summary-card>
        <div class="p-5 sm:p-6">
            <h3 class="text-lg font-bold text-gray-900">
                Rekap Operasional
            </h3>

            <div class="mt-5 grid grid-cols-2 gap-3">
                <div class="rounded-xl bg-blue-50 p-4 text-center">
                    <p class="text-2xl font-bold text-blue-700">
                        {{ $project->workers_count ?? 0 }}
                    </p>

                    <p class="mt-1 text-xs text-blue-600">
                        Pekerja
                    </p>
                </div>

                <div class="rounded-xl bg-purple-50 p-4 text-center">
                    <p class="text-2xl font-bold text-purple-700">
                        {{ $project->tasks_count ?? 0 }}
                    </p>

                    <p class="mt-1 text-xs text-purple-600">
                        Tugas
                    </p>
                </div>

                <div class="rounded-xl bg-green-50 p-4 text-center">
                    <p class="text-2xl font-bold text-green-700">
                        {{ $project->daily_reports_count ?? 0 }}
                    </p>

                    <p class="mt-1 text-xs text-green-600">
                        Laporan
                    </p>
                </div>

                <div class="rounded-xl bg-orange-50 p-4 text-center">
                    <p class="text-2xl font-bold text-orange-700">
                        {{ $project->documentations_count ?? 0 }}
                    </p>

                    <p class="mt-1 text-xs text-orange-600">
                        Dokumentasi
                    </p>
                </div>
            </div>
        </div>
    </x-ui.summary-card>

    {{-- Quotation sumber --}}
    @if ($sourceQuotation)
        <x-ui.summary-card>
            <div class="p-5 sm:p-6">
                <p class="text-sm text-gray-500">
                    Sumber Kontrak
                </p>

                <p class="mt-2 break-words font-bold text-gray-900">
                    {{ $sourceQuotation->quotation_number }}
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Rp{{ number_format(
                        (float) $sourceQuotation->grand_total,
                        0,
                        ',',
                        '.'
                    ) }}
                </p>

                <a
                    href="{{ route('owner.quotations.show', [
                        'quotation' => $sourceQuotation->id,
                    ]) }}"
                    wire:navigate
                    class="mt-4 inline-flex min-h-10 w-full items-center justify-center rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
                >
                    Lihat Quotation
                </a>
            </div>
        </x-ui.summary-card>
    @endif
</div>