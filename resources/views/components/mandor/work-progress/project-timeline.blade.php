@props([
    'tasks',
    'project',
])

@php
    $statusConfigurations = [
        'assigned' => [
            'label' => 'Belum Dimulai',
            'badge' => 'bg-gray-100 text-gray-600',
            'bar' => 'bg-gray-400',
            'percentage' => 'text-gray-600',
        ],

        'in_progress' => [
            'label' => 'Sedang Berjalan',
            'badge' => 'bg-blue-50 text-blue-700',
            'bar' => 'bg-blue-600',
            'percentage' => 'text-blue-600',
        ],

        'submitted' => [
            'label' => 'Menunggu Validasi',
            'badge' => 'bg-violet-50 text-violet-700',
            'bar' => 'bg-violet-500',
            'percentage' => 'text-violet-600',
        ],

        'revision' => [
            'label' => 'Perlu Revisi',
            'badge' => 'bg-amber-50 text-amber-700',
            'bar' => 'bg-amber-500',
            'percentage' => 'text-amber-600',
        ],

        'completed' => [
            'label' => 'Selesai',
            'badge' => 'bg-emerald-50 text-emerald-700',
            'bar' => 'bg-emerald-500',
            'percentage' => 'text-emerald-600',
        ],

        'cancelled' => [
            'label' => 'Dibatalkan',
            'badge' => 'bg-red-50 text-red-700',
            'bar' => 'bg-red-500',
            'percentage' => 'text-red-600',
        ],
    ];

    $priorityLabels = [
        'low' => 'Rendah',
        'medium' => 'Sedang',
        'high' => 'Tinggi',
        'urgent' => 'Mendesak',
    ];
@endphp

<x-ui.info-card class="h-full overflow-hidden">

    <div class="flex flex-col gap-3 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-base font-bold text-gray-900">
                Timeline Task
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Tahapan pekerjaan berdasarkan jadwal Task proyek
            </p>
        </div>

        <span class="inline-flex w-fit rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
            {{ $tasks->count() }} Task
        </span>
    </div>

    @if ($tasks->isEmpty())
        <div class="flex min-h-80 flex-col items-center justify-center px-6 py-12 text-center">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                <svg
                    class="h-7 w-7"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
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
            </div>

            <h3 class="mt-4 font-semibold text-gray-900">
                Belum ada Task
            </h3>

            <p class="mt-2 max-w-sm text-sm leading-6 text-gray-500">
                Buat Task dan pilih pekerja aktif untuk mulai mencatat
                progress pekerjaan proyek.
            </p>

            <button
                type="button"
                wire:click="openTaskForm"
                class="mt-5 inline-flex min-h-10 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-sm font-semibold text-white transition hover:bg-blue-700"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 5v14M5 12h14"
                    />
                </svg>

                Buat Task
            </button>
        </div>
    @else
        <div class="max-h-[34rem] space-y-5 overflow-y-auto p-6">
            @foreach ($tasks as $task)
                @php
                    $progress = max(
                        0,
                        min(100, (int) $task->progress)
                    );

                    $status = $statusConfigurations[
                        $task->status
                    ] ?? $statusConfigurations['assigned'];

                    $startDate = $task->start_at
                        ? $task->start_at
                            ->locale('id')
                            ->translatedFormat('d M Y, H.i')
                        : 'Belum ditentukan';

                    $dueDate = $task->due_at
                        ? $task->due_at
                            ->locale('id')
                            ->translatedFormat('d M Y, H.i')
                        : 'Belum ditentukan';

                    $isOverdue = $task->due_at
                        && $task->due_at->isPast()
                        && ! in_array(
                            $task->status,
                            ['completed', 'cancelled'],
                            true
                        );
                @endphp

                <article
                    wire:key="timeline-task-{{ $task->id }}"
                    x-data="{ progress: @js($progress) }"
                    class="relative rounded-xl border border-gray-200 p-4 transition hover:border-blue-200 hover:bg-blue-50/20"
                >
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                    {{ $task->task_code }}
                                </span>

                                <span class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ $status['badge'] }}">
                                    {{ $status['label'] }}
                                </span>

                                @if ($isOverdue)
                                    <span class="rounded-full bg-red-50 px-2.5 py-1 text-[10px] font-bold text-red-700">
                                        Terlambat
                                    </span>
                                @endif
                            </div>

                            <h3 class="mt-2 font-semibold leading-6 text-gray-900">
                                {{ $task->title }}
                            </h3>

                            <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500">
                                <span>
                                    Pekerja:
                                    <strong class="font-semibold text-gray-700">
                                        {{ $task->worker?->name ?? 'Tidak tersedia' }}
                                    </strong>
                                </span>

                                <span>
                                    Prioritas:
                                    <strong class="font-semibold text-gray-700">
                                        {{ $priorityLabels[$task->priority] ?? ucfirst($task->priority) }}
                                    </strong>
                                </span>

                                @if ($task->location)
                                    <span>
                                        Lokasi:
                                        <strong class="font-semibold text-gray-700">
                                            {{ $task->location }}
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <span class="shrink-0 text-lg font-bold {{ $status['percentage'] }}">
                            {{ $progress }}%
                        </span>
                    </div>

                    <div class="mt-4 h-2.5 overflow-hidden rounded-full bg-gray-100">
                        <div
                            class="h-full rounded-full transition-all duration-500 {{ $status['bar'] }}"
                            x-bind:style="{ width: progress + '%' }"
                        ></div>
                    </div>

                    <div class="mt-3 flex flex-col gap-1 text-xs text-gray-400 sm:flex-row sm:items-center sm:justify-between">
                        <span>
                            Mulai: {{ $startDate }}
                        </span>

                        <span @class([
                            'font-semibold text-red-600' => $isOverdue,
                        ])>
                            Tenggat: {{ $dueDate }}
                        </span>
                    </div>
                </article>
            @endforeach
        </div>
    @endif

</x-ui.info-card>