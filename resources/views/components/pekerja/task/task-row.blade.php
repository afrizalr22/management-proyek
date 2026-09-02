@props([
    'title',
    'project',
    'location',
    'deadline',
    'priority',
    'status',
])

@php
    $priorityClass = match ($priority) {
        'Tinggi' => 'bg-red-50 text-red-600',
        'Sedang' => 'bg-amber-50 text-amber-600',
        default => 'bg-emerald-50 text-emerald-600',
    };

    $statusClass = match ($status) {
        'Sedang Dikerjakan' => 'bg-blue-50 text-blue-600',
        'Selesai' => 'bg-emerald-50 text-emerald-600',
        default => 'bg-slate-100 text-slate-600',
    };

    $actionLabel = match ($status) {
        'Sedang Dikerjakan' => 'Selesaikan',
        'Selesai' => 'Lihat Detail',
        default => 'Mulai Tugas',
    };

    $actionClass = match ($status) {
        'Sedang Dikerjakan' => 'border-blue-600 bg-blue-600 text-white hover:bg-blue-700',
        'Selesai' => 'border-slate-300 bg-white text-slate-700 hover:bg-slate-50',
        default => 'border-blue-600 bg-white text-blue-600 hover:bg-blue-50',
    };
@endphp

<article
    {{ $attributes->class([
        'grid grid-cols-1 gap-4 border-b border-slate-200 px-5 py-5 transition last:border-b-0 hover:bg-slate-50/70',
        'lg:grid-cols-[minmax(0,2fr)_minmax(150px,1.2fr)_minmax(130px,1fr)_110px_150px_130px]',
        'lg:items-center lg:gap-5 lg:px-6',
    ]) }}
>
    {{-- Detail tugas --}}
    <div class="min-w-0">
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Detail Tugas
        </p>

        <h3 class="font-semibold text-slate-900">
            {{ $title }}
        </h3>

        <p class="mt-1 text-sm text-slate-500">
            {{ $project }}
        </p>
    </div>

    {{-- Lokasi --}}
    <div class="min-w-0">
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Lokasi
        </p>

        <div class="flex items-start gap-2 text-sm text-slate-600">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="mt-0.5 h-4 w-4 shrink-0 text-slate-400"
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

    {{-- Tenggat waktu --}}
    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Tenggat Waktu
        </p>

        <p class="text-sm font-medium text-slate-700">
            {{ $deadline }}
        </p>
    </div>

    {{-- Prioritas --}}
    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Prioritas
        </p>

        <span
            class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $priorityClass }}"
        >
            {{ $priority }}
        </span>
    </div>

    {{-- Status --}}
    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Status
        </p>

        <span
            class="inline-flex rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClass }}"
        >
            {{ $status }}
        </span>
    </div>

    {{-- Aksi --}}
    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Aksi
        </p>

        <button
            type="button"
            class="inline-flex min-h-10 w-full items-center justify-center rounded-lg border px-4 py-2 text-sm font-semibold transition sm:w-auto lg:w-full {{ $actionClass }}"
        >
            @if ($status === 'Selesai')
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="mr-2 h-4 w-4"
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
            @endif

            {{ $actionLabel }}
        </button>
    </div>
</article>