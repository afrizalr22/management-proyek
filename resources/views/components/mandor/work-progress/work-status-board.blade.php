@props([
    'assignedTasks',
    'activeTasks',
    'completedTasks',
    'cancelledTasks',
])

@php
    $columns = [
        [
            'key' => 'assigned',
            'title' => 'Belum Dimulai',
            'tasks' => $assignedTasks,
            'dot' => 'bg-gray-400',
            'header' => 'border-gray-200 bg-gray-50/60',
            'titleColor' => 'text-gray-700',
            'count' => 'bg-gray-200 text-gray-700',
            'emptyIcon' => 'text-gray-300',
            'emptyText' => 'Belum ada Task yang menunggu untuk dimulai.',
        ],
        [
            'key' => 'active',
            'title' => 'Sedang Berjalan',
            'tasks' => $activeTasks,
            'dot' => 'bg-blue-600',
            'header' => 'border-blue-100 bg-blue-50/60',
            'titleColor' => 'text-blue-700',
            'count' => 'bg-blue-600 text-white',
            'emptyIcon' => 'text-blue-200',
            'emptyText' => 'Belum ada Task yang sedang dikerjakan.',
        ],
        [
            'key' => 'completed',
            'title' => 'Selesai',
            'tasks' => $completedTasks,
            'dot' => 'bg-emerald-600',
            'header' => 'border-emerald-100 bg-emerald-50/60',
            'titleColor' => 'text-emerald-700',
            'count' => 'bg-emerald-100 text-emerald-700',
            'emptyIcon' => 'text-emerald-200',
            'emptyText' => 'Belum ada Task yang telah diselesaikan.',
        ],
    ];

    $statusConfigurations = [
        'assigned' => [
            'label' => 'Ditugaskan',
            'badge' => 'bg-gray-100 text-gray-600',
            'bar' => 'bg-gray-400',
            'border' => 'border-gray-200',
        ],
        'in_progress' => [
            'label' => 'Sedang Berjalan',
            'badge' => 'bg-blue-50 text-blue-700',
            'bar' => 'bg-blue-600',
            'border' => 'border-blue-200',
        ],
        'submitted' => [
            'label' => 'Menunggu Validasi',
            'badge' => 'bg-violet-50 text-violet-700',
            'bar' => 'bg-violet-500',
            'border' => 'border-violet-200',
        ],
        'revision' => [
            'label' => 'Perlu Revisi',
            'badge' => 'bg-amber-50 text-amber-700',
            'bar' => 'bg-amber-500',
            'border' => 'border-amber-200',
        ],
        'completed' => [
            'label' => 'Selesai',
            'badge' => 'bg-emerald-50 text-emerald-700',
            'bar' => 'bg-emerald-500',
            'border' => 'border-emerald-200',
        ],
        'cancelled' => [
            'label' => 'Dibatalkan',
            'badge' => 'bg-red-50 text-red-700',
            'bar' => 'bg-red-400',
            'border' => 'border-red-200',
        ],
    ];

    $priorityConfigurations = [
        'low' => [
            'label' => 'Rendah',
            'class' => 'bg-gray-100 text-gray-600',
        ],
        'medium' => [
            'label' => 'Sedang',
            'class' => 'bg-blue-50 text-blue-700',
        ],
        'high' => [
            'label' => 'Tinggi',
            'class' => 'bg-orange-50 text-orange-700',
        ],
        'urgent' => [
            'label' => 'Mendesak',
            'class' => 'bg-red-50 text-red-700',
        ],
    ];
@endphp

<section aria-labelledby="workStatusBoardTitle">

    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2
                id="workStatusBoardTitle"
                class="text-lg font-bold text-gray-900"
            >
                Status Pekerjaan
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Pengelompokan Task berdasarkan tahapan pengerjaannya.
            </p>
        </div>

        <p class="text-xs text-gray-400">
            Diperbarui {{ now()->locale('id')->translatedFormat('d M Y, H.i') }}
        </p>
    </div>

    <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-3">
        @foreach ($columns as $column)
            <x-ui.info-card class="overflow-hidden">
                <div
                    class="flex items-center justify-between border-b px-5 py-4 {{ $column['header'] }}"
                >
                    <div class="flex items-center gap-2">
                        <span
                            class="h-2.5 w-2.5 rounded-full {{ $column['dot'] }}"
                        ></span>

                        <h3
                            class="text-sm font-bold uppercase tracking-wide {{ $column['titleColor'] }}"
                        >
                            {{ $column['title'] }}
                        </h3>
                    </div>

                    <span
                        class="rounded-full px-2.5 py-1 text-xs font-bold {{ $column['count'] }}"
                    >
                        {{ $column['tasks']->count() }}
                    </span>
                </div>

                @if ($column['tasks']->isEmpty())
                    <div class="flex min-h-52 flex-col items-center justify-center px-6 py-10 text-center">
                        <svg
                            class="h-9 w-9 {{ $column['emptyIcon'] }}"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 11l3 3L22 4"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"
                            />
                        </svg>

                        <p class="mt-3 max-w-56 text-sm leading-6 text-gray-500">
                            {{ $column['emptyText'] }}
                        </p>
                    </div>
                @else
                    <div class="max-h-[38rem] space-y-3 overflow-y-auto p-4">
                        @foreach ($column['tasks'] as $task)
                            @php
                                $progress = max(
                                    0,
                                    min(100, (int) $task->progress)
                                );

                                $status = $statusConfigurations[
                                    $task->status
                                ] ?? $statusConfigurations['assigned'];

                                $priority = $priorityConfigurations[
                                    $task->priority
                                ] ?? $priorityConfigurations['medium'];

                                $isOverdue = $task->due_at
                                    && $task->due_at->isPast()
                                    && ! in_array(
                                        $task->status,
                                        ['completed', 'cancelled'],
                                        true
                                    );

                                $dateLabel = match ($task->status) {
                                    'completed' => $task->completed_at
                                        ? 'Selesai '
                                            . $task->completed_at
                                                ->locale('id')
                                                ->translatedFormat('d M Y, H.i')
                                        : 'Task telah diselesaikan',

                                    'submitted' => $task->submitted_at
                                        ? 'Dikirim '
                                            . $task->submitted_at
                                                ->locale('id')
                                                ->translatedFormat('d M Y, H.i')
                                        : 'Menunggu validasi Mandor',

                                    default => $task->due_at
                                        ? 'Tenggat '
                                            . $task->due_at
                                                ->locale('id')
                                                ->translatedFormat('d M Y, H.i')
                                        : 'Tenggat belum ditentukan',
                                };
                            @endphp

                            <article
                                wire:key="status-task-{{ $column['key'] }}-{{ $task->id }}"
                                x-data="{ progress: @js($progress) }"
                                class="rounded-xl border bg-white p-4 transition hover:-translate-y-0.5 hover:shadow-sm {{ $status['border'] }}"
                            >
                                <div class="flex items-start justify-between gap-3">
                                    <span
                                        class="rounded-md px-2 py-1 text-[10px] font-bold uppercase tracking-wide {{ $priority['class'] }}"
                                    >
                                        {{ $priority['label'] }}
                                    </span>

                                    <span
                                        class="rounded-full px-2 py-1 text-[10px] font-bold {{ $status['badge'] }}"
                                    >
                                        {{ $status['label'] }}
                                    </span>
                                </div>

                                <p class="mt-3 text-[11px] font-bold uppercase tracking-wide text-gray-400">
                                    {{ $task->task_code }}
                                </p>

                                <h4
                                    @class([
                                        'mt-1 font-semibold leading-6',
                                        'text-gray-500 line-through' =>
                                            $task->status === 'completed',
                                        'text-gray-900' =>
                                            $task->status !== 'completed',
                                    ])
                                >
                                    {{ $task->title }}
                                </h4>

                                @if ($task->description)
                                    <p class="mt-2 line-clamp-2 text-xs leading-5 text-gray-500">
                                        {{ $task->description }}
                                    </p>
                                @endif

                                <div class="mt-4 flex items-center gap-2 text-xs text-gray-500">
                                    <svg
                                        class="h-4 w-4 shrink-0 text-gray-400"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <circle cx="12" cy="8" r="4" />

                                        <path
                                            stroke-linecap="round"
                                            d="M4 21a8 8 0 0116 0"
                                        />
                                    </svg>

                                    <span class="truncate">
                                        {{ $task->worker?->name ?? 'Pekerja tidak tersedia' }}
                                    </span>
                                </div>

                                @if ($task->location)
                                    <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                                        <svg
                                            class="h-4 w-4 shrink-0 text-gray-400"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 21s7-4.35 7-11a7 7 0 10-14 0c0 6.65 7 11 7 11z"
                                            />

                                            <circle cx="12" cy="10" r="2.5" />
                                        </svg>

                                        <span class="truncate">
                                            {{ $task->location }}
                                        </span>
                                    </div>
                                @endif

                                <div class="mt-4 flex items-center justify-between gap-3">
                                    <span class="text-xs text-gray-500">
                                        Progress
                                    </span>

                                    <span class="text-xs font-bold text-gray-800">
                                        {{ $progress }}%
                                    </span>
                                </div>

                                <div class="mt-2 h-2 overflow-hidden rounded-full bg-gray-100">
                                    <div
                                        class="h-full rounded-full transition-all duration-500 {{ $status['bar'] }}"
                                        x-bind:style="{ width: progress + '%' }"
                                    ></div>
                                </div>

                                <div class="mt-4 border-t border-gray-100 pt-3">
                                    <p
                                        @class([
                                            'text-xs',
                                            'font-semibold text-red-600' => $isOverdue,
                                            'text-gray-400' => ! $isOverdue,
                                        ])
                                    >
                                        @if ($isOverdue)
                                            Terlambat ·
                                        @endif

                                        {{ $dateLabel }}
                                    </p>

                                    @if ($task->mandor_notes)
                                        <p class="mt-2 line-clamp-2 text-xs italic leading-5 text-gray-500">
                                            “{{ $task->mandor_notes }}”
                                        </p>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </x-ui.info-card>
        @endforeach
    </div>

    @if ($cancelledTasks->isNotEmpty())
        <x-ui.info-card class="mt-6 overflow-hidden border-red-100">
            <div class="flex items-center justify-between border-b border-red-100 bg-red-50/60 px-5 py-4">
                <div class="flex items-center gap-2">
                    <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>

                    <h3 class="text-sm font-bold uppercase tracking-wide text-red-700">
                        Task Dibatalkan
                    </h3>
                </div>

                <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-bold text-red-700">
                    {{ $cancelledTasks->count() }}
                </span>
            </div>

            <div class="grid grid-cols-1 gap-3 p-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($cancelledTasks as $task)
                    <article
                        wire:key="cancelled-task-{{ $task->id }}"
                        class="rounded-xl border border-red-100 bg-red-50/20 p-4"
                    >
                        <p class="text-[11px] font-bold uppercase tracking-wide text-red-400">
                            {{ $task->task_code }}
                        </p>

                        <h4 class="mt-1 font-semibold text-gray-700 line-through">
                            {{ $task->title }}
                        </h4>

                        <p class="mt-2 text-xs text-gray-500">
                            {{ $task->worker?->name ?? 'Pekerja tidak tersedia' }}
                        </p>
                    </article>
                @endforeach
            </div>
        </x-ui.info-card>
    @endif

</section>