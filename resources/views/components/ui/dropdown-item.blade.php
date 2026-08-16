@props([
    'value',
    'color' => null,
])

@php
    $dotColor = match ($color) {
        'green' => 'bg-green-500',
        'yellow' => 'bg-yellow-400',
        'blue' => 'bg-blue-500',
        'red' => 'bg-red-500',
        'gray' => 'bg-gray-400',
        default => 'hidden',
    };
@endphp

<button
    type="button"
    @click="
        selected = '{{ $value }}';
        open = false;
    "
    class="flex w-full items-center gap-3 px-4 py-2 text-left text-sm hover:bg-gray-100"
>

    @if($color)
        <span class="h-2.5 w-2.5 rounded-full {{ $dotColor }}"></span>
    @endif

    <span>{{ $value }}</span>

</button>