@props([
    'report',
])

@php
    $reportDate = $report->report_date
        ? $report->report_date
            ->locale('id')
            ->translatedFormat('d F Y')
        : 'Tidak tersedia';

    $submittedAt = $report->submitted_at
        ? $report->submitted_at
            ->locale('id')
            ->translatedFormat('d F Y, H.i')
            . ' WIB'
        : 'Tidak tersedia';

    $reviewedAt = $report->reviewed_at
        ? $report->reviewed_at
            ->locale('id')
            ->translatedFormat('d F Y, H.i')
            . ' WIB'
        : null;

    $workStatus = $report->work_status === 'completed'
        ? 'Pekerjaan Selesai'
        : 'Sedang Berjalan';
@endphp

<x-ui.info-card class="overflow-hidden">
    <div class="border-b border-gray-200 px-6 py-5">
        <h2 class="text-lg font-bold text-gray-900">
            Informasi Laporan
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Identitas, progress, dan waktu pengiriman laporan.
        </p>
    </div>

    <dl class="grid grid-cols-1 gap-x-6 gap-y-5 p-6 sm:grid-cols-2 xl:grid-cols-4">
        <div>
            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Nomor Laporan
            </dt>

            <dd class="mt-2 font-semibold text-gray-900">
                {{ $report->report_number ?? 'Laporan #' . $report->id }}
            </dd>
        </div>

        <div>
            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Project
            </dt>

            <dd class="mt-2 font-semibold text-gray-900">
                {{ $report->project?->project_name ?? 'Tidak tersedia' }}
            </dd>

            <dd class="mt-1 text-xs font-medium text-blue-600">
                {{ $report->project?->project_code }}
            </dd>
        </div>

        <div>
            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Task
            </dt>

            <dd class="mt-2 font-semibold text-gray-900">
                {{ $report->task?->title ?? 'Tidak tersedia' }}
            </dd>

            <dd class="mt-1 text-xs font-medium text-blue-600">
                {{ $report->task?->task_code }}
            </dd>
        </div>

        <div>
            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Dilaporkan Oleh
            </dt>

            <dd class="mt-2 font-semibold text-gray-900">
                {{ $report->user?->name ?? 'Pekerja tidak tersedia' }}
            </dd>

            <dd class="mt-1 truncate text-xs text-gray-500">
                {{ $report->user?->email }}
            </dd>
        </div>

        <div>
            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Tanggal Laporan
            </dt>

            <dd class="mt-2 font-semibold text-gray-900">
                {{ $reportDate }}
            </dd>
        </div>

        <div>
            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Waktu Pengiriman
            </dt>

            <dd class="mt-2 font-semibold text-gray-900">
                {{ $submittedAt }}
            </dd>
        </div>

        <div>
            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Progress Dilaporkan
            </dt>

            <dd class="mt-2 text-2xl font-bold text-blue-600">
                {{ max(0, min(100, (int) $report->reported_progress)) }}%
            </dd>
        </div>

        <div>
            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Status Pekerjaan
            </dt>

            <dd class="mt-2 font-semibold text-gray-900">
                {{ $workStatus }}
            </dd>

            @if ($reviewedAt)
                <dd class="mt-1 text-xs text-gray-500">
                    Diperiksa {{ $reviewedAt }}
                </dd>
            @endif
        </div>
    </dl>
</x-ui.info-card>