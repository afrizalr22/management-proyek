@props([
    'type' => 'button',
    'variant' => 'primary',
])

@php
    $base = 'inline-flex items-center justify-center h-11 px-5 rounded-xl font-medium transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $variants = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
        'secondary' => 'bg-gray-100 hover:bg-gray-200 text-gray-800 focus:ring-gray-400',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white focus:ring-emerald-500',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
        'outline' => 'border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 focus:ring-gray-400',
    ];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => $base . ' ' . $variants[$variant],
    ]) }}
>
    {{ $slot }}
</button>