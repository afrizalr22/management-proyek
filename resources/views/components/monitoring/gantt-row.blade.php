@props([
    'task',
    'timelineStart',
    'timelineEnd',
    'totalDays',
])

@php
    [$statusText, $statusColor] = match ($task->status) {
        'assigned' => [
            'Ditugaskan',
            'bg-gray-400',
        ],

        'in_progress' => [
            'Berjalan',
            'bg-blue-600',
        ],

        'submitted' => [
            'Menunggu Validasi',
            'bg-blue-600',
        ],

        'revision' => [
            'Revisi',
            'bg-amber-500',
        ],

        'completed' => [
            'Selesai',
            'bg-emerald-500',
        ],

        'cancelled' => [
            'Dibatalkan',
            'bg-red-500',
        ],

        default => [
            'Tidak Diketahui',
            'bg-gray-400',
        ],
    };
@endphp

<div
    wire:key="monitoring-task-{{ $task->id }}"
    class="grid grid-cols-[300px_1fr] border-b border-gray-100 transition hover:bg-gray-50 last:border-b-0"
>
    <div class="flex min-w-0 items-center gap-3 px-5 py-4">
        <span class="h-3 w-3 shrink-0 rounded-full {{ $statusColor }}"></span>

        <div class="min-w-0">
            <h4
                class="truncate text-sm font-semibold text-gray-800"
                title="{{ $task->title }}"
            >
                {{ $task->title }}
            </h4>

            <p class="mt-1 truncate text-xs text-gray-500">
                {{ $task->task_code }}
                •
                {{ $task->worker?->name
                    ?? 'Pekerja belum tersedia' }}
            </p>

            <p class="mt-1 text-xs font-medium text-gray-400">
                {{ $statusText }}
            </p>
        </div>
    </div>

    <div class="relative min-h-20 overflow-hidden">
        <div class="absolute inset-0 grid grid-cols-12">
            @for ($column = 1; $column <= 12; $column++)
                <div class="border-l border-gray-100"></div>
            @endfor
        </div>

        <x-monitoring.gantt-bar
            :task="$task"
            :timeline-start="$timelineStart"
            :timeline-end="$timelineEnd"
            :total-days="$totalDays"
        />
    </div>
</div>