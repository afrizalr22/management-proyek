@props([
    'report',
])

<div>
    <nav
        class="flex flex-wrap items-center gap-2 text-sm text-gray-500"
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

        <a
            href="{{ route('mandor.daily-reports.show', $report) }}"
            wire:navigate
            class="font-medium text-gray-500 transition hover:text-blue-600"
        >
            {{ $report->report_number ?? 'Laporan #' . $report->id }}
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

        <span class="font-medium text-gray-700">
            Validasi
        </span>
    </nav>

    <div class="mt-4 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold text-blue-600">
                Pemeriksaan Mandor
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                Validasi Laporan Harian
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                Periksa seluruh isi laporan sebelum memberikan
                persetujuan atau meminta revisi kepada Pekerja.
            </p>
        </div>

        <span class="inline-flex w-fit items-center gap-2 rounded-full bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">
            <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>

            Menunggu Validasi
        </span>
    </div>
</div>