@props([
    'reportId',
    'reportNumber',
    'task',
    'project',
    'location',
    'date',
    'status',
])

@php
    $statusClass = match ($status) {
        'Diterima' => 'bg-emerald-50 text-emerald-600',
        'Perlu Revisi' => 'bg-red-50 text-red-600',
        default => 'bg-amber-50 text-amber-600',
    };

    $statusDot = match ($status) {
        'Diterima' => 'bg-emerald-500',
        'Perlu Revisi' => 'bg-red-500',
        default => 'bg-amber-500',
    };
@endphp

<article
    {{ $attributes->class([
        'grid grid-cols-1 gap-4 border-b border-slate-200 px-5 py-5 transition last:border-b-0 hover:bg-slate-50/70',
        'lg:grid-cols-[140px_minmax(180px,1.5fr)_minmax(190px,1.5fr)_150px_160px_100px]',
        'lg:items-center lg:gap-5 lg:px-6',
    ]) }}
>
    {{-- Nomor laporan --}}
    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Nomor Laporan
        </p>

        <p class="text-sm font-bold text-slate-900">
            {{ $reportNumber }}
        </p>
    </div>

    {{-- Tugas --}}
    <div class="min-w-0">
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Tugas
        </p>

        <p class="text-sm font-semibold text-slate-900">
            {{ $task }}
        </p>
    </div>

    {{-- Proyek dan lokasi --}}
    <div class="min-w-0">
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Proyek dan Lokasi
        </p>

        <p class="text-sm font-medium text-slate-700">
            {{ $project }}
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

    {{-- Tanggal --}}
    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Tanggal
        </p>

        <p class="text-sm text-slate-700">
            {{ $date }}
        </p>
    </div>

    {{-- Status --}}
    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Status
        </p>

        <span
            class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClass }}"
        >
            <span class="h-2 w-2 rounded-full {{ $statusDot }}"></span>

            {{ $status }}
        </span>
    </div>

    {{-- Aksi --}}
    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Aksi
        </p>

       <a
            href="{{ route('pekerja.reports.show', ['report' => $reportId]) }}"
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