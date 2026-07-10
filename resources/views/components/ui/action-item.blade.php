@props([
    'href' => '#',
    'danger' => false,
])

@if($danger)

<button
    type="button"
    {{ $attributes->merge([
        'class' => 'flex w-full items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition',
    ]) }}
>

    {{ $slot }}

</button>

@else

<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition',
    ]) }}
>

    {{ $slot }}

</a>

@endif