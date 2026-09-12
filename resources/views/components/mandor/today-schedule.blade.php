@props([
    'tasks' => collect(),
])

@php
    $statusConfiguration = [
        'pending' => [
            'text' => 'Belum Dimulai',
            'badge' => 'bg-gray-100 text-gray-600',
            'progress' => 'bg-gray-400',
        ],

        'todo' => [
            'text' => 'Belum Dimulai',
            'badge' => 'bg-gray-100 text-gray-600',
            'progress' => 'bg-gray-400',
        ],

        'in_progress' => [
            'text' => 'Sedang Dikerjakan',
            'badge' => 'bg-blue-50 text-blue-700',
            'progress' => 'bg-blue-600',
        ],

        'submitted' => [
            'text' => 'Menunggu Pemeriksaan',
            'badge' => 'bg-amber-50 text-amber-700',
            'progress' => 'bg-amber-500',
        ],

        'completed' => [
            'text' => 'Selesai',
            'badge' => 'bg-green-50 text-green-700',
            'progress' => 'bg-green-500',
        ],

        'approved' => [
            'text' => 'Disetujui',
            'badge' => 'bg-green-50 text-green-700',
            'progress' => 'bg-green-500',
        ],

        'cancelled' => [
            'text' => 'Dibatalkan',
            'badge' => 'bg-red-50 text-red-700',
            'progress' => 'bg-red-500',
        ],
    ];

    $priorityConfiguration = [
        'low' => [
            'text' => 'Rendah',
            'class' => 'text-gray-500',
        ],

        'medium' => [
            'text' => 'Sedang',
            'class' => 'text-blue-600',
        ],

        'high' => [
            'text' => 'Tinggi',
            'class' => 'text-orange-600',
        ],

        'urgent' => [
            'text' => 'Mendesak',
            'class' => 'text-red-600',
        ],
    ];
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Jadwal Hari Ini
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Task yang dijadwalkan pada
                    {{ today()->translatedFormat(
                        'd F Y'
                    ) }}.
                </p>
            </div>

            <span class="inline-flex w-fit items-center rounded-full bg-blue-50 px-3 py-1.5 text-sm font-semibold text-blue-600">
                {{ $tasks->count() }}
                Task
            </span>
        </div>

        @if ($tasks->isNotEmpty())
            {{-- Daftar Task --}}
            <div class="mt-6 space-y-3">
                @foreach ($tasks as $task)
                    @php
                        $status = $statusConfiguration[
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
                            'progress' =>
                                'bg-gray-400',
                        ];

                        $priority = $priorityConfiguration[
                            $task->priority
                        ] ?? [
                            'text' => ucfirst(
                                $task->priority
                                ?: 'Normal'
                            ),
                            'class' =>
                                'text-gray-500',
                        ];

                        $progress = min(
                            max(
                                (int) $task->progress,
                                0
                            ),
                            100
                        );

                        $startTime = $task->start_at
                            ?->format('H:i');

                        $dueTime = $task->due_at
                            ?->format('H:i');

                        $scheduleTime = match (true) {
                            $startTime && $dueTime =>
                                $startTime.' – '.$dueTime,

                            $startTime !== null =>
                                'Mulai '.$startTime,

                            $dueTime !== null =>
                                'Selesai '.$dueTime,

                            default =>
                                'Waktu fleksibel',
                        };
                    @endphp

                    <article
                        wire:key="mandor-today-task-{{ $task->id }}"
                        class="rounded-xl border border-gray-200 bg-white p-4 transition hover:border-blue-200 hover:bg-blue-50/30"
                    >
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center">
                            {{-- Waktu --}}
                            <div class="shrink-0 lg:w-32">
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $scheduleTime }}
                                </p>

                                <p class="mt-1 truncate text-xs text-gray-400">
                                    {{ $task->task_code }}
                                </p>
                            </div>

                            {{-- Informasi Task --}}
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                    <div class="min-w-0">
                                        <a
                                            href="{{ route(
                                                'mandor.projects.show',
                                                [
                                                    'project' =>
                                                        $task->project_id,
                                                ]
                                            ) }}"
                                            wire:navigate
                                            class="block break-words font-semibold text-gray-900 transition hover:text-blue-600"
                                        >
                                            {{ $task->title }}
                                        </a>

                                        <p class="mt-1 truncate text-sm text-blue-600">
                                            {{ $task->project?->project_name
                                                ?? 'Project tidak ditemukan' }}
                                        </p>
                                    </div>

                                    <span class="inline-flex w-fit shrink-0 rounded-full px-3 py-1 text-xs font-semibold {{ $status['badge'] }}">
                                        {{ $status['text'] }}
                                    </span>
                                </div>

                                {{-- Detail --}}
                                <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-gray-500">
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.8"
                                            stroke="currentColor"
                                            class="h-4 w-4 text-gray-400"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"
                                            />
                                        </svg>

                                        {{ $task->location
                                            ?: $task->project?->location
                                            ?: 'Lokasi belum ditentukan' }}
                                    </span>

                                    <span class="inline-flex items-center gap-1.5">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.8"
                                            stroke="currentColor"
                                            class="h-4 w-4 text-gray-400"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
                                            />
                                        </svg>

                                        {{ $task->worker?->name
                                            ?? 'Pekerja belum ditentukan' }}
                                    </span>

                                    <span class="font-medium {{ $priority['class'] }}">
                                        Prioritas:
                                        {{ $priority['text'] }}
                                    </span>
                                </div>

                                {{-- Progress --}}
                                <div class="mt-4">
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-xs font-medium text-gray-500">
                                            Progress
                                        </span>

                                        <span class="text-xs font-semibold text-gray-700">
                                            {{ $progress }}%
                                        </span>
                                    </div>

                                    <div class="mt-2 h-2 overflow-hidden rounded-full bg-gray-100">
                                        <div
                                            x-data="{
                                                progress: @js($progress)
                                            }"
                                            x-bind:style="{
                                                width: progress + '%'
                                            }"
                                            class="h-full rounded-full transition-all duration-500 {{ $status['progress'] }}"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            {{-- Kondisi kosong --}}
            <div class="mt-6 rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-white text-gray-400 shadow-sm">
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
                            d="M6.75 3v2.25m10.5-2.25v2.25M3.75 9.75h16.5m-15-4.5h13.5A1.5 1.5 0 0 1 20.25 6.75v12a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-12a1.5 1.5 0 0 1 1.5-1.5Z"
                        />
                    </svg>
                </div>

                <p class="mt-4 font-semibold text-gray-700">
                    Tidak ada Task hari ini
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Belum ada Task yang dijadwalkan untuk hari ini.
                </p>

                <a
                    href="{{ route('mandor.projects.index') }}"
                    wire:navigate
                    class="mt-5 inline-flex min-h-10 items-center justify-center rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
                >
                    Lihat Project Saya
                </a>
            </div>
        @endif
    </div>
</x-ui.info-card>