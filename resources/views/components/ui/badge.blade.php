@props([
    'color' => 'gray',
])

@php

$styles = [

    'green' => [
        'class' => 'bg-green-100 text-green-700',
        'dot'   => 'bg-green-500',
    ],

    'yellow' => [
        'class' => 'bg-yellow-100 text-yellow-700',
        'dot'   => 'bg-yellow-500',
    ],

    'red' => [
        'class' => 'bg-red-100 text-red-700',
        'dot'   => 'bg-red-500',
    ],

    'blue' => [
        'class' => 'bg-blue-100 text-blue-700',
        'dot'   => 'bg-blue-500',
    ],

    'gray' => [
        'class' => 'bg-gray-100 text-gray-700',
        'dot'   => 'bg-gray-400',
    ],

];

$style = $styles[$color] ?? $styles['gray'];

@endphp

<span
    {{ $attributes->merge([
        'class' => "inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {$style['class']}"
    ]) }}
>

    <span class="h-2 w-2 rounded-full {{ $style['dot'] }}"></span>

    {{ $slot }}

</span>