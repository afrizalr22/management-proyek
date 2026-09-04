@props([
    'reportId',
    'status' => 'Menunggu Pemeriksaan',
])

@php
    $statusClass = match ($status) {
        'Diterima' => 'border-emerald-200 bg-emerald-50 text-emerald-600',
        'Perlu Revisi' => 'border-red-200 bg-red-50 text-red-600',
        default => 'border-amber-200 bg-amber-50 text-amber-600',
    };

    $statusDot = match ($status) {
        'Diterima' => 'bg-emerald-500',
        'Perlu Revisi' => 'bg-red-500',
        default => 'bg-amber-500',
    };
@endphp

<header class="border-b border-slate-200 pb-6">
    {{-- Navigasi kembali --}}
    <a
        href="{{ route('pekerja.reports.index') }}"
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
        {{-- Informasi laporan --}}
        <div>
            <p class="text-sm font-semibold text-blue-600">
                Detail Laporan Pekerjaan
            </p>

            <h1
                class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"
            >
                Laporan #LAP-2026-{{ str_pad($reportId, 4, '0', STR_PAD_LEFT) }}
            </h1>

            <div class="mt-3 flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center gap-2 text-sm text-slate-500">
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

                    30 Agustus 2026
                </span>

                <span
                    class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $statusClass }}"
                >
                    <span class="h-2 w-2 rounded-full {{ $statusDot }}"></span>

                    {{ $status }}
                </span>
            </div>
        </div>

        {{-- Informasi akses --}}
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
</header>