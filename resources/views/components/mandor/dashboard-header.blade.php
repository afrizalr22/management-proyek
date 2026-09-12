@props([
    'mandor',
    'statistics' => [],
])

@php
    $activeProjects = (int) (
        $statistics['active_projects']
        ?? 0
    );

    $reportsAwaitingReview = (int) (
        $statistics['reports_awaiting_review']
        ?? 0
    );
@endphp

<div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
    {{-- Informasi Mandor --}}
    <div class="min-w-0">
        <p class="text-sm font-semibold text-blue-600">
            Ringkasan Pekerjaan
        </p>

        <h1 class="mt-1 break-words text-3xl font-bold text-gray-900">
            Dashboard Mandor
        </h1>

        <p class="mt-2 text-gray-500">
            Selamat datang,
            <span class="font-medium text-gray-700">
                {{ $mandor->name }}
            </span>
        </p>

        <p class="mt-1 text-sm text-gray-400">
            @if ($activeProjects > 0)
                Anda sedang mengelola
                {{ $activeProjects }}
                Project aktif.
            @else
                Belum ada Project aktif yang ditugaskan.
            @endif
        </p>
    </div>

    {{-- Tanggal dan laporan --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-stretch">
        {{-- Tanggal --}}
        <div class="flex min-w-56 items-center gap-3 rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
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
                        d="M6.75 3v2.25m10.5-2.25v2.25M3.75 9.75h16.5m-15-4.5h13.5A1.5 1.5 0 0 1 20.25 6.75v12a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-12a1.5 1.5 0 0 1 1.5-1.5Z"
                    />
                </svg>
            </div>

            <div class="min-w-0">
                <p class="text-xs font-medium text-gray-400">
                    Hari ini
                </p>

                <p class="mt-0.5 whitespace-nowrap text-sm font-semibold text-gray-700">
                    {{ now()->translatedFormat(
                        'l, d F Y'
                    ) }}
                </p>
            </div>
        </div>

        {{-- Laporan menunggu pemeriksaan --}}
        <a
            href="{{ route('mandor.daily-reports.index') }}"
            wire:navigate
            @class([
                'flex min-w-56 items-center gap-3 rounded-xl border px-4 py-3 shadow-sm transition',
                'border-amber-200 bg-amber-50 hover:bg-amber-100' =>
                    $reportsAwaitingReview > 0,
                'border-green-200 bg-green-50 hover:bg-green-100' =>
                    $reportsAwaitingReview === 0,
            ])
        >
            <div
                @class([
                    'flex h-10 w-10 shrink-0 items-center justify-center rounded-lg',
                    'bg-amber-100 text-amber-600' =>
                        $reportsAwaitingReview > 0,
                    'bg-green-100 text-green-600' =>
                        $reportsAwaitingReview === 0,
                ])
            >
                @if ($reportsAwaitingReview > 0)
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
                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 4.5h.008v.008H12V16.5Z"
                        />
                    </svg>
                @else
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
                            d="m4.5 12.75 6 6 9-13.5"
                        />
                    </svg>
                @endif
            </div>

            <div class="min-w-0">
                <p
                    @class([
                        'text-xs font-medium',
                        'text-amber-600' =>
                            $reportsAwaitingReview > 0,
                        'text-green-600' =>
                            $reportsAwaitingReview === 0,
                    ])
                >
                    Pemeriksaan Laporan
                </p>

                <p
                    @class([
                        'mt-0.5 text-sm font-semibold',
                        'text-amber-800' =>
                            $reportsAwaitingReview > 0,
                        'text-green-800' =>
                            $reportsAwaitingReview === 0,
                    ])
                >
                    @if ($reportsAwaitingReview > 0)
                        {{ $reportsAwaitingReview }}
                        laporan menunggu
                    @else
                        Tidak ada antrean
                    @endif
                </p>
            </div>
        </a>
    </div>
</div>