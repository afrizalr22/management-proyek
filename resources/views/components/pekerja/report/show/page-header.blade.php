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
        'approved' => 'border-emerald-200 bg-emerald-50 text-emerald-600',
        'revision' => 'border-red-200 bg-red-50 text-red-600',
        'draft' => 'border-slate-200 bg-slate-100 text-slate-600',
        default => 'border-amber-200 bg-amber-50 text-amber-600',
    };

    $statusDot = match ($report->status) {
        'approved' => 'bg-emerald-500',
        'revision' => 'bg-red-500',
        'draft' => 'bg-slate-400',
        default => 'bg-amber-500',
    };

    $reportDate = $report->report_date
        ? $report->report_date
            ->locale('id')
            ->translatedFormat('d F Y')
        : '-';
@endphp

<header class="border-b border-slate-200 pb-6">
    <a
        href="{{ route('pekerja.report.index') }}"
        wire:navigate
        class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-blue-600"
    >
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
                d="m15 18-6-6 6-6"
            />
        </svg>

        Kembali ke Daftar Laporan
    </a>

    <div
        class="mt-4 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between"
    >
        <div>
            <p class="text-sm font-semibold text-blue-600">
                Detail Laporan Pekerjaan
            </p>

            <h1
                class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"
            >
                {{ $report->report_number ?? 'Nomor laporan belum tersedia' }}
            </h1>

            <div class="mt-3 flex flex-wrap items-center gap-3">
                <span
                    class="inline-flex items-center gap-2 text-sm text-slate-500"
                >
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
                            d="M6.75 3v2.25M17.25 3v2.25M3.75 9.75h16.5M5.25 5.25h13.5A1.5 1.5 0 0 1 20.25 6.75v12a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-12a1.5 1.5 0 0 1 1.5-1.5Z"
                        />
                    </svg>

                    {{ $reportDate }}
                </span>

                <span
                    class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $statusClass }}"
                >
                    <span
                        class="h-2 w-2 rounded-full {{ $statusDot }}"
                    ></span>

                    {{ $statusLabel }}
                </span>
            </div>
        </div>

        <div
    class="flex flex-col items-start gap-3 sm:flex-row sm:items-center"
>
    @if ($report->status === 'revision')
        <a
            href="{{ route('pekerja.report.edit', ['report' => $report->id]) }}"
            wire:navigate
            class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-100 sm:w-auto"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-5 w-5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487ZM16.862 4.487 19.5 7.125"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M18 14.25v4.125A2.625 2.625 0 0 1 15.375 21H5.625A2.625 2.625 0 0 1 3 18.375V8.625A2.625 2.625 0 0 1 5.625 6H9.75"
                />
            </svg>

            Perbaiki Laporan
        </a>
    @endif

            <div
                class="inline-flex w-fit items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm"
            >
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                        />
                    </svg>
                </div>

                <div>
                    <p class="text-xs text-slate-400">
                        Mode akses
                    </p>

                    <p class="text-sm font-semibold text-slate-700">
                        Lihat laporan
                    </p>
                </div>
            </div>
        </div>
    </div>
</header>