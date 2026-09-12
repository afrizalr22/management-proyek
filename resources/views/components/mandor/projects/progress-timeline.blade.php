@props([
    'project',
    'tasks' => collect(),
    'progresses' => collect(),
])

@php
    $statusConfiguration = [
        'pending' => [
            'text' => 'Belum Dimulai',
            'badge' => 'bg-gray-100 text-gray-600',
            'dot' => 'bg-gray-300 ring-gray-100',
            'title' => 'text-gray-700',
        ],

        'todo' => [
            'text' => 'Belum Dimulai',
            'badge' => 'bg-gray-100 text-gray-600',
            'dot' => 'bg-gray-300 ring-gray-100',
            'title' => 'text-gray-700',
        ],

        'in_progress' => [
            'text' => 'Sedang Dikerjakan',
            'badge' => 'bg-blue-50 text-blue-700',
            'dot' => 'bg-blue-600 ring-blue-100',
            'title' => 'text-gray-900',
        ],

        'submitted' => [
            'text' => 'Menunggu Pemeriksaan',
            'badge' => 'bg-amber-50 text-amber-700',
            'dot' => 'bg-amber-500 ring-amber-100',
            'title' => 'text-gray-900',
        ],

        'completed' => [
            'text' => 'Selesai',
            'badge' => 'bg-green-50 text-green-700',
            'dot' => 'bg-green-500 ring-green-100',
            'title' => 'text-gray-900',
        ],

        'approved' => [
            'text' => 'Disetujui',
            'badge' => 'bg-green-50 text-green-700',
            'dot' => 'bg-green-500 ring-green-100',
            'title' => 'text-gray-900',
        ],

        'cancelled' => [
            'text' => 'Dibatalkan',
            'badge' => 'bg-red-50 text-red-700',
            'dot' => 'bg-red-500 ring-red-100',
            'title' => 'text-gray-500',
        ],
    ];

    $latestProgress = $progresses->first();
@endphp

<x-ui.info-card class="overflow-hidden">
    {{-- Header --}}
    <div class="flex flex-col gap-4 border-b border-gray-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div>
            <h2 class="text-base font-bold text-gray-900">
                Timeline Pekerjaan
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Tahapan Task dan perkembangan Project.
            </p>
        </div>

        <a
            href="{{ route(
                'mandor.projects.work-progress.index',
                [
                    'project' => $project->id,
                ]
            ) }}"
            wire:navigate
            class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
        >
            Lihat Semua Progress

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

    @if ($tasks->isNotEmpty())
        {{-- Timeline --}}
        <div class="px-5 py-6 sm:px-6">
            <div>
                @foreach ($tasks as $task)
                    @php
                        $configuration =
                            $statusConfiguration[
                                $task->status
                            ] ?? [
                                'text' => ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $task->status
                                    )
                                ),
                                'badge' =>
                                    'bg-gray-100 text-gray-600',
                                'dot' =>
                                    'bg-gray-400 ring-gray-100',
                                'title' =>
                                    'text-gray-800',
                            ];

                        $progress = min(
                            100,
                            max(
                                0,
                                (int) $task->progress
                            )
                        );

                        $startDate = $task->start_at
                            ?->translatedFormat(
                                'd M Y'
                            );

                        $dueDate = $task->due_at
                            ?->translatedFormat(
                                'd M Y'
                            );

                        $period = match (true) {
                            $startDate && $dueDate =>
                                $startDate.' – '.$dueDate,

                            $startDate !== null =>
                                'Mulai '.$startDate,

                            $dueDate !== null =>
                                'Target '.$dueDate,

                            default =>
                                'Jadwal belum ditentukan',
                        };
                    @endphp

                    <article
                        wire:key="mandor-project-task-{{ $task->id }}"
                        @class([
                            'relative flex gap-4',
                            'pb-7' => !$loop->last,
                        ])
                    >
                        {{-- Garis --}}
                        @unless ($loop->last)
                            <div class="absolute left-2 top-5 h-full w-px bg-gray-200"></div>
                        @endunless

                        {{-- Titik --}}
                        <div class="relative mt-1 flex h-4 w-4 shrink-0 items-center justify-center rounded-full ring-4 {{ $configuration['dot'] }}">
                            @if (
                                in_array(
                                    $task->status,
                                    [
                                        'completed',
                                        'approved',
                                    ],
                                    true
                                )
                            )
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="h-2.5 w-2.5 text-white"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M16.704 5.293a1 1 0 0 1 0 1.414l-8 8a1 1 0 0 1-1.414 0l-4-4a1 1 0 0 1 1.414-1.414L8 12.586l7.293-7.293a1 1 0 0 1 1.411 0Z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            @endif
                        </div>

                        {{-- Isi --}}
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="break-words font-semibold {{ $configuration['title'] }}">
                                            {{ $task->title }}
                                        </h3>

                                        <span class="rounded-md px-2 py-1 text-[10px] font-bold uppercase {{ $configuration['badge'] }}">
                                            {{ $configuration['text'] }}
                                        </span>
                                    </div>

                                    <p class="mt-1 text-xs font-medium text-blue-600">
                                        {{ $task->task_code }}
                                    </p>

                                    @if ($task->description)
                                        <p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-500">
                                            {{ $task->description }}
                                        </p>
                                    @endif
                                </div>

                                <span class="w-fit shrink-0 rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-600">
                                    {{ $period }}
                                </span>
                            </div>

                            <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-gray-500">
                                <span>
                                    Pekerja:
                                    <strong class="font-semibold text-gray-700">
                                        {{ $task->worker?->name
                                            ?? 'Belum ditentukan' }}
                                    </strong>
                                </span>

                                <span>
                                    Lokasi:
                                    <strong class="font-semibold text-gray-700">
                                        {{ $task->location
                                            ?: $project->location
                                            ?: '-' }}
                                    </strong>
                                </span>

                                <span>
                                    Progres:
                                    <strong class="font-semibold text-gray-700">
                                        {{ $progress }}%
                                    </strong>
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($latestProgress)
                {{-- Pembaruan Progress terakhir --}}
                <div class="mt-6 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">
                                Pembaruan Progress Terakhir
                            </p>

                            <p class="mt-1 text-sm font-medium text-blue-900">
                                {{ $latestProgress->description
                                    ?: 'Progress Project diperbarui.' }}
                            </p>

                            <p class="mt-1 text-xs text-blue-600">
                                Oleh
                                {{ $latestProgress->user?->name
                                    ?? 'Pengguna' }}
                            </p>
                        </div>

                        <div class="shrink-0 text-left sm:text-right">
                            <p class="text-lg font-bold text-blue-700">
                                {{ min(
                                    100,
                                    max(
                                        0,
                                        (int) $latestProgress
                                            ->progress_percentage
                                    )
                                ) }}%
                            </p>

                            <p class="text-xs text-blue-500">
                                {{ $latestProgress->created_at
                                    ?->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @else
        {{-- Kondisi kosong --}}
        <div class="px-6 py-10 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-6 w-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                    />
                </svg>
            </div>

            <p class="mt-4 font-semibold text-gray-700">
                Belum ada Task
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Timeline akan muncul setelah Task dibuat untuk Project ini.
            </p>
        </div>
    @endif
</x-ui.info-card>