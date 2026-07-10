@props([
    'href' => '#',
])

<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100 text-blue-600 transition hover:bg-blue-200',
    ]) }}
    title="View Detail"
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
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
        />

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z"
        />

    </svg>

</a>