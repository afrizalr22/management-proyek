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

<div class="w-full">

    <div class="mb-2 flex items-center justify-between">

        <span class="text-xs font-medium text-gray-500">
            Progress
        </span>

        <span class="text-xs font-semibold text-gray-700">
            {{ $value }}%
        </span>

    </div>

    <div class="h-2.5 w-full overflow-hidden rounded-full bg-gray-100">

        <div
            class="{{ $color }} h-full rounded-full transition-all duration-500"
            style="width: {{ $value }}%"
        ></div>

    </div>

</div>