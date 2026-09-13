@props([
    'report',
])

@php
    $statusConfiguration = match ($report->status) {
        'submitted' => [
            'label' => 'Menunggu Validasi',
            'badge' => 'bg-amber-50 text-amber-700',
            'dot' => 'bg-amber-500',
            'border' => 'border-amber-200',
        ],

        'revision' => [
            'label' => 'Perlu Revisi',
            'badge' => 'bg-red-50 text-red-700',
            'dot' => 'bg-red-500',
            'border' => 'border-red-200',
        ],

        'approved' => [
            'label' => 'Disetujui',
            'badge' => 'bg-emerald-50 text-emerald-700',
            'dot' => 'bg-emerald-500',
            'border' => 'border-emerald-200',
        ],

        default => [
            'label' => 'Tidak Diketahui',
            'badge' => 'bg-gray-100 text-gray-600',
            'dot' => 'bg-gray-400',
            'border' => 'border-gray-200',
        ],
    };

    $hasObstacle = filled($report->obstacles);

    $progress = max(
        0,
        min(100, (int) $report->reported_progress)
    );

    $reportDate = $report->report_date
        ? $report->report_date
            ->locale('id')
            ->translatedFormat('d F Y')
        : 'Tanggal tidak tersedia';

    $submittedAt = $report->submitted_at
        ? $report->submitted_at
            ->locale('id')
            ->translatedFormat('d M Y, H.i')
            . ' WIB'
        : 'Waktu pengiriman tidak tersedia';

    $workStatusLabel = $report->work_status === 'completed'
        ? 'Pekerjaan Selesai'
        : 'Sedang Berjalan';
@endphp

<article
    class="overflow-hidden rounded-2xl border bg-white shadow-sm transition hover:shadow-md {{ $statusConfiguration['border'] }}"
>
    <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-4 lg:flex-row lg:items-center lg:justify-between">

        <div class="flex min-w-0 items-center gap-3">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <rect
                        x="4"
                        y="3"
                        width="16"
                        height="18"
                        rx="2"
                    />

                    <path d="M8 7h8M8 11h8M8 15h5" />
                </svg>
            </span>

            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <h3 class="font-bold text-gray-900">
                        {{ $report->report_number ?? 'Laporan #' . $report->id }}
                    </h3>

                    <span class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ $statusConfiguration['badge'] }}">
                        {{ $statusConfiguration['label'] }}
                    </span>
                </div>

                <p class="mt-1 truncate text-sm text-gray-500">
                    {{ $report->project?->project_name ?? 'Project tidak tersedia' }}
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-gray-500">
            <span class="font-semibold text-gray-700">
                {{ $reportDate }}
            </span>

            <span class="hidden h-1 w-1 rounded-full bg-gray-300 sm:block"></span>

            <span>
                Dikirim {{ $submittedAt }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 p-5 lg:grid-cols-12">

        <div class="lg:col-span-5">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Aktivitas Pekerjaan
            </p>

            <p class="mt-2 line-clamp-3 text-sm leading-6 text-gray-700">
                {{ $report->activities ?: 'Aktivitas tidak tersedia.' }}
            </p>
        </div>

        <div class="lg:col-span-3">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Task
            </p>

            <p class="mt-2 truncate text-sm font-semibold text-gray-700">
                {{ $report->task?->title ?? 'Task tidak tersedia' }}
            </p>

            @if ($report->task?->task_code)
                <p class="mt-1 text-xs font-medium text-blue-600">
                    {{ $report->task->task_code }}
                </p>
            @endif

            <p class="mt-3 text-xs text-gray-500">
                {{ $workStatusLabel }}
            </p>
        </div>

        <div
            x-data="{ progress: @js($progress) }"
            class="lg:col-span-4"
        >
            <div class="flex items-center justify-between gap-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                    Progress Dilaporkan
                </p>

                <span class="text-sm font-bold text-blue-600">
                    {{ $progress }}%
                </span>
            </div>

            <div class="mt-3 h-2.5 overflow-hidden rounded-full bg-gray-100">
                <div
                    class="h-full rounded-full bg-blue-600 transition-all duration-500"
                    x-bind:style="{ width: progress + '%' }"
                ></div>
            </div>

            <div class="mt-4 flex items-center gap-2">
                <span
                    @class([
                        'h-2.5 w-2.5 shrink-0 rounded-full',
                        'bg-red-500' => $hasObstacle,
                        'bg-emerald-500' => ! $hasObstacle,
                    ])
                ></span>

                <p
                    @class([
                        'text-xs font-semibold',
                        'text-red-600' => $hasObstacle,
                        'text-emerald-600' => ! $hasObstacle,
                    ])
                >
                    {{ $hasObstacle ? 'Terdapat kendala' : 'Tanpa kendala' }}
                </p>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-3 border-t border-gray-100 bg-gray-50 px-5 py-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex min-w-0 items-center gap-3">
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700">
                {{ str($report->user?->name ?? '?')->substr(0, 1)->upper() }}
            </span>

            <div class="min-w-0">
                <p class="truncate text-xs font-semibold text-gray-700">
                    {{ $report->user?->name ?? 'Pekerja tidak tersedia' }}
                </p>

                <p class="text-[11px] text-gray-400">
                    {{ $report->documentations_count }}
                    dokumentasi
                </p>
            </div>
        </div>

        <a
            href="{{ route('mandor.daily-reports.show', $report) }}"
            wire:navigate
            class="inline-flex min-h-9 items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 text-sm font-semibold text-blue-600 transition hover:border-blue-200 hover:bg-blue-50"
        >
            @if ($report->status === 'submitted')
                Periksa Laporan
            @else
                Lihat Detail
            @endif

            <svg
                class="h-4 w-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 18l6-6-6-6"
                />
            </svg>
        </a>
    </div>
</article>