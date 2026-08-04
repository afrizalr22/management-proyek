@props([
    'href' => '#',
])

<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'inline-flex h-9 w-9 items-center justify-center rounded-lg bg-red-100 text-red-600 transition hover:bg-red-200'
    ]) }}
    title="Delete"
>

    <svg xmlns="http://www.w3.org/2000/svg"
         class="h-5 w-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M19 7H5"
        />

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M10 11v6"
        />

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M14 11v6"
        />

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12"
        />

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"
        />

    </svg>

</a>