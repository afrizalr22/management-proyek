@props([
    'tasks',
])

@php
    $priorityConfiguration = [
        'urgent' => [
            'label' => 'Mendesak',
            'badge' => 'bg-red-100 text-red-700',
            'icon' => 'bg-red-50 text-red-600',
        ],

        'high' => [
            'label' => 'Tinggi',
            'badge' => 'bg-orange-100 text-orange-700',
            'icon' => 'bg-orange-50 text-orange-600',
        ],

        'medium' => [
            'label' => 'Sedang',
            'badge' => 'bg-amber-100 text-amber-700',
            'icon' => 'bg-amber-50 text-amber-600',
        ],

        'low' => [
            'label' => 'Rendah',
            'badge' => 'bg-slate-100 text-slate-600',
            'icon' => 'bg-blue-50 text-blue-600',
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
    ];
@endphp

<section class="h-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-start sm:justify-between sm:px-6">
        <div>
            <h2 class="text-lg font-bold text-slate-900">
                Task Prioritas
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Task aktif berdasarkan prioritas dan deadline terdekat.
            </p>
        </div>

        <a
            href="{{ route('pekerja.task.index') }}"
            wire:navigate
            class="inline-flex w-fit items-center gap-1.5 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
        >
            Lihat Semua

            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
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

    @if ($tasks->isEmpty())
        <div class="px-6 py-14 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.7"
                    stroke="currentColor"
                    class="h-7 w-7"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m4.5 12.75 6 6 9-13.5"
                    />
                </svg>
            </div>

            <h3 class="mt-4 font-semibold text-slate-900">
                Tidak Ada Task Aktif
            </h3>

            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                Task baru yang diberikan Mandor akan tampil pada bagian ini.
            </p>
        </div>
    @else
        <div class="divide-y divide-slate-100">
            @foreach ($tasks as $task)
                @php
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
                        && $task->due_at->isPast();

                    $deadlineLabel = match (true) {
                        !$task->due_at =>
                            'Deadline belum ditentukan',

                        $isOverdue =>
                            'Terlambat '
                            .$task->due_at
                                ->locale('id')
                                ->diffForHumans(),

                        $task->due_at->isToday() =>
                            'Deadline hari ini, '
                            .$task->due_at->format('H.i'),

                        $task->due_at->isTomorrow() =>
                            'Deadline besok, '
                            .$task->due_at->format('H.i'),

                        default =>
                            'Deadline '
                            .$task->due_at
                                ->locale('id')
                                ->translatedFormat(
                                    'd M Y, H.i'
                                ),
                    };
                @endphp

                <article
                    wire:key="dashboard-task-{{ $task->id }}"
                    class="p-5 transition hover:bg-slate-50/70 sm:p-6"
                >
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="flex min-w-0 items-start gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $priority['icon'] }}">
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
                            </div>

                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-xs font-semibold text-blue-600">
                                        {{ $task->task_code }}
                                    </span>

                                    <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $status['class'] }}">
                                        {{ $status['label'] }}
                                    </span>
                                </div>

                                <h3 class="mt-2 font-semibold leading-6 text-slate-900">
                                    {{ $task->title }}
                                </h3>

                                <p class="mt-1 truncate text-sm text-slate-500">
                                    {{ $task->project?->project_name ?? 'Proyek tidak tersedia' }}
                                </p>
                            </div>
                        </div>

                        <span class="inline-flex w-fit shrink-0 rounded-full px-3 py-1 text-xs font-semibold {{ $priority['badge'] }}">
                            Prioritas {{ $priority['label'] }}
                        </span>
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-2 text-sm text-slate-500 sm:grid-cols-2">
                        <div class="flex min-w-0 items-center gap-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-4 w-4 shrink-0"
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

                            <span class="truncate">
                                {{ $task->location
                                    ?: $task->project?->location
                                    ?: 'Lokasi belum ditentukan' }}
                            </span>
                        </div>

                        <div
                            @class([
                                'flex items-center gap-2 sm:justify-end',
                                'font-semibold text-red-600' => $isOverdue,
                            ])
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-4 w-4 shrink-0"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 6v6l4 2"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />
                            </svg>

                            <span>
                                {{ $deadlineLabel }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-xs font-medium text-slate-500">
                                Progres task
                            </span>

                            <span class="text-xs font-bold text-blue-600">
                                {{ $progress }}%
                            </span>
                        </div>

                        <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100">
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
                </article>
            @endforeach
        </div>
    @endif
</section>