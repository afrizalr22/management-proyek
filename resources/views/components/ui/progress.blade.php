@props([
    'value' => 0,
])

@php
    $value = max(0, min(100, (int) $value));

    $color = match (true) {
        $value >= 100 => 'bg-green-500',
        $value >= 75 => 'bg-blue-600',
        $value >= 50 => 'bg-blue-500',
        $value >= 25 => 'bg-yellow-500',
        default => 'bg-red-500',
    };
@endphp

<div class="flex items-center gap-3">

    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">

        <div
            class="{{ $color }} h-full rounded-full transition-all duration-500"
            style="width: {{ $value }}%"
        ></div>

    </div>

    <span class="text-sm font-medium text-gray-600 w-10 text-right">
        {{ $value }}%
    </span>

</div>