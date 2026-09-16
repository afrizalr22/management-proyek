@props([
    'report',
])

@php
    $statusLabel = match ($report->status) {
        'approved' => 'Diterima',
        'revision' => 'Perlu Revisi',
        'draft' => 'Draft',
        default => 'Menunggu Pemeriksaan',
    };

    $statusClass = match ($report->status) {
        'approved' => 'bg-emerald-50 text-emerald-600',
        'revision' => 'bg-red-50 text-red-600',
        'draft' => 'bg-slate-100 text-slate-600',
        default => 'bg-amber-50 text-amber-600',
    };

    $statusDot = match ($report->status) {
        'approved' => 'bg-emerald-500',
        'revision' => 'bg-red-500',
        'draft' => 'bg-slate-400',
        default => 'bg-amber-500',
    };

    $taskName = $report->task
        ? $report->task->task_code . ' — ' . $report->task->title
        : 'Task tidak tersedia';

    $projectName = $report->project?->project_name
        ?? 'Proyek tidak tersedia';

    $location = $report->task?->location
        ?: (
            $report->project?->location
            ?: 'Lokasi belum tersedia'
        );

    $reportDate = $report->report_date
        ? $report->report_date
            ->locale('id')
            ->translatedFormat('d F Y')
        : '-';
@endphp

<article
    {{ $attributes->class([
        'grid grid-cols-1 gap-4 border-b border-slate-200 px-5 py-5 transition last:border-b-0 hover:bg-slate-50/70',
        'lg:grid-cols-[150px_minmax(180px,1.5fr)_minmax(190px,1.5fr)_150px_170px_100px]',
        'lg:items-center lg:gap-5 lg:px-6',
    ]) }}
>
    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Nomor Laporan
        </p>

        <p class="text-sm font-bold text-slate-900">
            {{ $report->report_number ?? 'Belum tersedia' }}
        </p>
    </div>

    <div class="min-w-0">
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Task
        </p>

        <p
            class="truncate text-sm font-semibold text-slate-900"
            title="{{ $taskName }}"
        >
            {{ $taskName }}
        </p>

        <p class="mt-1 text-xs font-medium text-blue-600">
            Progres dilaporkan: {{ $report->reported_progress }}%
        </p>
    </div>

    <div class="min-w-0">
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Proyek dan Lokasi
        </p>

        <p
            class="truncate text-sm font-medium text-slate-700"
            title="{{ $projectName }}"
        >
            {{ $projectName }}
        </p>

        <div class="mt-1 flex items-start gap-1.5 text-xs text-slate-500">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="mt-0.5 h-3.5 w-3.5 shrink-0"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 21s6-4.35 6-10.5a6 6 0 1 0-12 0C6 16.65 12 21 12 21Z"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 12.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z"
                />
            </svg>

            <span>{{ $location }}</span>
        </div>
    </div>

    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Tanggal
        </p>

        <p class="text-sm text-slate-700">
            {{ $reportDate }}
        </p>
    </div>

    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Status
        </p>

        <span
            class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClass }}"
        >
            <span class="h-2 w-2 rounded-full {{ $statusDot }}"></span>

            {{ $statusLabel }}
        </span>
    </div>

    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Aksi
        </p>

        <a
            href="{{ route('pekerja.report.show', ['report' => $report->id]) }}"
            wire:navigate
            class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
        >
            Detail

            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-4 w-4"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m9 18 6-6-6-6"
                />
            </svg>
        </a>
    </div>
</article>