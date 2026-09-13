@props([
    'task',
])

@php
    $priorityConfiguration = [
        'urgent' => [
            'label' => 'Mendesak',
            'class' => 'bg-red-100 text-red-700',
        ],

        'high' => [
            'label' => 'Tinggi',
            'class' => 'bg-orange-100 text-orange-700',
        ],

        'medium' => [
            'label' => 'Sedang',
            'class' => 'bg-amber-100 text-amber-700',
        ],

        'low' => [
            'label' => 'Rendah',
            'class' => 'bg-emerald-100 text-emerald-700',
        ],
    ];

    $statusConfiguration = [
        'assigned' => [
            'label' => 'Belum Dimulai',
            'class' => 'bg-slate-100 text-slate-600',
        ],

        'in_progress' => [
            'label' => 'Sedang Dikerjakan',
            'class' => 'bg-blue-100 text-blue-700',
        ],

        'submitted' => [
            'label' => 'Menunggu Pemeriksaan',
            'class' => 'bg-violet-100 text-violet-700',
        ],

        'revision' => [
            'label' => 'Perlu Revisi',
            'class' => 'bg-amber-100 text-amber-700',
        ],

        'completed' => [
            'label' => 'Selesai',
            'class' => 'bg-emerald-100 text-emerald-700',
        ],

        'cancelled' => [
            'label' => 'Dibatalkan',
            'class' => 'bg-red-100 text-red-700',
        ],
    ];

    $priority =
        $priorityConfiguration[$task->priority]
        ?? $priorityConfiguration['medium'];

    $status =
        $statusConfiguration[$task->status]
        ?? [
            'label' => ucfirst(
                str_replace(
                    '_',
                    ' ',
                    $task->status
                )
            ),
            'class' => 'bg-slate-100 text-slate-600',
        ];

    $progress = max(
        0,
        min(
            100,
            (int) $task->progress
        )
    );

    $isOverdue =
        $task->due_at
        && $task->due_at->isPast()
        && !in_array(
            $task->status,
            [
                'completed',
                'cancelled',
            ],
            true
        );

    $deadlineLabel = match (true) {
        !$task->due_at =>
            'Belum ditentukan',

        $task->status === 'completed'
            && $task->completed_at =>
            'Selesai '
            .$task->completed_at
                ->locale('id')
                ->translatedFormat('d M Y'),

        $isOverdue =>
            'Terlambat '
            .$task->due_at
                ->locale('id')
                ->diffForHumans(),

        $task->due_at->isToday() =>
            'Hari ini, '
            .$task->due_at->format('H.i'),

        $task->due_at->isTomorrow() =>
            'Besok, '
            .$task->due_at->format('H.i'),

        default =>
            $task->due_at
                ->locale('id')
                ->translatedFormat('d M Y, H.i'),
    };

    $revisionReport =
        $task->dailyReports
            ->firstWhere(
                'status',
                'revision'
            );

    $approvedReport =
        $task->dailyReports
            ->firstWhere(
                'status',
                'approved'
            );
@endphp

<article
    {{ $attributes->class([
        'grid grid-cols-1 gap-4 px-5 py-5 transition hover:bg-slate-50/70',
        'lg:grid-cols-[minmax(0,2fr)_minmax(140px,1fr)_minmax(145px,1fr)_115px_135px_150px]',
        'lg:items-center lg:gap-5 lg:px-6',
    ]) }}
>
    {{-- Detail --}}
    <div class="min-w-0">
        <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">
            {{ $task->task_code }}
        </p>

        <h3 class="mt-1 font-semibold leading-6 text-slate-900">
            {{ $task->title }}
        </h3>

        <p class="mt-1 truncate text-sm text-slate-500">
            {{ $task->project?->project_name
                ?? 'Proyek tidak tersedia' }}
        </p>

        <div class="mt-3">
            <div class="flex items-center justify-between gap-3">
                <span class="text-xs text-slate-400">
                    Progres
                </span>

                <span class="text-xs font-bold text-blue-600">
                    {{ $progress }}%
                </span>
            </div>

            <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-slate-100">
                <div
                    x-data
                    data-progress="{{ $progress }}"
                    x-bind:style="
                        'width: '
                        + $el.dataset.progress
                        + '%'
                    "
                    class="h-full rounded-full bg-blue-600 transition-all duration-300"
                ></div>
            </div>
        </div>
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

            <span>
                {{ $task->location
                    ?: $task->project?->location
                    ?: 'Belum ditentukan' }}
            </span>
        </div>
    </div>

    {{-- Deadline --}}
    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Deadline
        </p>

        <p
            @class([
                'text-sm font-medium',
                'text-red-600' => $isOverdue,
                'text-slate-700' => !$isOverdue,
            ])
        >
            {{ $deadlineLabel }}
        </p>
    </div>

    {{-- Prioritas --}}
    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Prioritas
        </p>

        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $priority['class'] }}">
            {{ $priority['label'] }}
        </span>
    </div>

    {{-- Status --}}
    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Status
        </p>

        <span class="inline-flex rounded-full px-3 py-1.5 text-xs font-semibold {{ $status['class'] }}">
            {{ $status['label'] }}
        </span>
    </div>

    {{-- Aksi --}}
    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400 lg:hidden">
            Aksi
        </p>

        @if ($task->status === 'assigned')
            <button
                type="button"
                wire:click="startTask({{ $task->id }})"
                wire:confirm="Mulai mengerjakan task ini?"
                wire:loading.attr="disabled"
                wire:target="startTask({{ $task->id }})"
                class="inline-flex min-h-10 w-full items-center justify-center rounded-lg border border-blue-600 bg-white px-4 py-2 text-sm font-semibold text-blue-600 transition hover:bg-blue-50 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span
                    wire:loading.remove
                    wire:target="startTask({{ $task->id }})"
                >
                    Mulai Task
                </span>

                <span
                    wire:loading
                    wire:target="startTask({{ $task->id }})"
                >
                    Memulai...
                </span>
            </button>
        @elseif ($task->status === 'in_progress')
            <a
                href="{{ route(
                    'pekerja.report.create',
                    [
                        'task' => $task->id,
                    ]
                ) }}"
                wire:navigate
                class="inline-flex min-h-10 w-full items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
            >
                Buat Laporan
            </a>
        @elseif ($task->status === 'revision' && $revisionReport)
            <a
                href="{{ route(
                    'pekerja.report.show',
                    [
                        'report' => $revisionReport->id,
                    ]
                ) }}"
                wire:navigate
                class="inline-flex min-h-10 w-full items-center justify-center rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-600"
            >
                Perbaiki Laporan
            </a>
        @elseif ($task->status === 'completed' && $approvedReport)
            <a
                href="{{ route(
                    'pekerja.report.show',
                    [
                        'report' => $approvedReport->id,
                    ]
                ) }}"
                wire:navigate
                class="inline-flex min-h-10 w-full items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
            >
                Lihat Laporan
            </a>
        @elseif ($task->status === 'submitted')
            <button
                type="button"
                disabled
                class="inline-flex min-h-10 w-full cursor-not-allowed items-center justify-center rounded-lg border border-violet-200 bg-violet-50 px-4 py-2 text-sm font-semibold text-violet-600 opacity-80"
            >
                Menunggu Mandor
            </button>
        @else
            <button
                type="button"
                disabled
                class="inline-flex min-h-10 w-full cursor-not-allowed items-center justify-center rounded-lg border border-slate-200 bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-400"
            >
                Tidak Tersedia
            </button>
        @endif
    </div>
</article>