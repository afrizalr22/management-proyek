@props([
    'start',
    'duration',
    'progress',
    'status',
])

@php
    $left = (($start - 1) / 12) * 100 + 0.4;
    $width = (($duration / 12) * 100) - 0.8;

    $color = match ($status) {
        'completed' => 'bg-emerald-500',
        'current' => 'bg-blue-600',
        default => 'bg-gray-400',
    };
@endphp


<div
    class="absolute top-1/2 -translate-y-1/2"
    style="left: {{ $left }}%; width: {{ $width }}%;"
>

    <div
        class="flex h-7 w-full items-center justify-center rounded-lg {{ $color }} shadow-sm"
    >

        <span
            class="text-[11px] font-semibold tracking-wide text-white"
        >
            {{ $progress }}%
        </span>

    </div>

</div>