@props([
    'href' => '#',
])

<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'inline-flex h-9 w-9 items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 transition hover:bg-yellow-200',
    ]) }}
    title="Edit"
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
            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"
        />

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
        />

    </svg>

</a>