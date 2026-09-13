@props([
    'report',
])

@php
    $statusConfiguration = match ($report->status) {
        'submitted' => [
            'label' => 'Menunggu Validasi',
            'class' => 'bg-amber-50 text-amber-700',
            'dot' => 'bg-amber-500',
        ],
        'revision' => [
            'label' => 'Perlu Revisi',
            'class' => 'bg-red-50 text-red-700',
            'dot' => 'bg-red-500',
        ],
        'approved' => [
            'label' => 'Disetujui',
            'class' => 'bg-emerald-50 text-emerald-700',
            'dot' => 'bg-emerald-500',
        ],
        default => [
            'label' => 'Tidak Diketahui',
            'class' => 'bg-gray-100 text-gray-600',
            'dot' => 'bg-gray-400',
        ],
    };

    $reportDate = $report->report_date
        ? $report->report_date
            ->locale('id')
            ->translatedFormat('d F Y')
        : 'Tanggal tidak tersedia';
@endphp

<header class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
    <div>
        <nav
            class="flex flex-wrap items-center gap-2 text-sm"
            aria-label="Breadcrumb"
        >
            <a
                href="{{ route('mandor.daily-reports.index') }}"
                wire:navigate
                class="font-medium text-blue-600 transition hover:text-blue-700"
            >
                Laporan Harian
            </a>

            <svg
                class="h-4 w-4 text-gray-400"
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

            <span class="font-medium text-gray-500">
                {{ $report->report_number ?? 'Laporan #' . $report->id }}
            </span>
        </nav>

        <h1 class="mt-3 text-2xl font-bold text-gray-900 sm:text-3xl">
            Detail Laporan Harian
        </h1>

        <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-gray-500">
            <span class="font-semibold text-gray-700">
                {{ $report->project?->project_name ?? 'Project tidak tersedia' }}
            </span>

            <span>•</span>

            <span>{{ $reportDate }}</span>

            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold {{ $statusConfiguration['class'] }}">
                <span class="h-2 w-2 rounded-full {{ $statusConfiguration['dot'] }}"></span>

                {{ $statusConfiguration['label'] }}
            </span>
        </div>
    </div>

    @if ($report->status === 'submitted')
        <a
            href="{{ route('mandor.daily-reports.validate', $report) }}"
            wire:navigate
            class="inline-flex min-h-11 w-fit items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
        >
            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 12l2 2 4-4"
                />

                <circle cx="12" cy="12" r="9" />
            </svg>

            Validasi Laporan
        </a>
    @elseif ($report->status === 'approved')
        <div class="inline-flex min-h-11 w-fit items-center gap-2 rounded-xl bg-emerald-50 px-4 text-sm font-semibold text-emerald-700">
            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5 13l4 4L19 7"
                />
            </svg>

            Divalidasi oleh {{ $report->reviewer?->name ?? 'Mandor' }}
        </div>
    @else
        <div class="inline-flex min-h-11 w-fit items-center gap-2 rounded-xl bg-red-50 px-4 text-sm font-semibold text-red-700">
            Menunggu perbaikan dari Pekerja
        </div>
    @endif
</header>