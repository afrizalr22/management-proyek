@props([
    'task',
])

@php

    $statusColor = match ($task['status']) {
        'completed' => 'bg-emerald-500',
        'current' => 'bg-blue-600',
        default => 'bg-gray-400',
    };

@endphp

<div
    class="grid grid-cols-[260px_1fr] border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200"
>

    {{-- Task --}}
    <div class="flex items-center gap-3 px-5 py-4">

        {{-- Status Indicator --}}
        <span
            class="h-3 w-3 rounded-full {{ $statusColor }} ring-2 ring-white shadow-sm"
        ></span>

        <div>

            <h4 class="text-sm font-medium text-gray-700">

                {{ $task['name'] }}

            </h4>

            <p class="mt-1 text-xs text-gray-400">

                {{ ucfirst($task['status']) }}

            </p>

        </div>

    </div>

    {{-- Timeline --}}
    <div class="relative h-16">

        {{-- Grid --}}
        <div class="absolute inset-0 grid grid-cols-12">

            @for ($i = 1; $i <= 12; $i++)

                <div class="border-l border-dashed border-gray-200"></div>

            @endfor

        </div>

        <x-monitoring.gantt-bar
            :start="$task['start']"
            :duration="$task['duration']"
            :progress="$task['progress']"
            :status="$task['status']"
        />

    </div>

</div>