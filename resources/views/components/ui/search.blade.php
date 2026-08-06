@props([
    'placeholder' => 'Search...',
    'name' => null,
])

<div class="relative w-full md:w-80">

    {{-- Icon --}}
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 text-gray-400"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"
            />
        </svg>

    </div>

    {{-- Input --}}
    <input
        type="text"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"

        {{ $attributes->merge([
            'class' =>
                'w-full rounded-xl border border-gray-300 bg-white py-3 pl-11 pr-4 text-sm shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none'
        ]) }}
    >

</div>