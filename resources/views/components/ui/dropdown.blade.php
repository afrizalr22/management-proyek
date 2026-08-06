@props([
    'label' => 'Select',
])

<div
    x-data="{
        open:false,
        selected:'{{ $label }}'
    }"
    class="relative w-56"
>

    {{-- Button --}}
    <button
        type="button"
        @click="open=!open"
        class="flex w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100"
    >

        <span
            x-text="selected"
        ></span>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 text-gray-500 transition duration-200"
            :class="{ 'rotate-180': open }"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M19 9l-7 7-7-7"
            />
        </svg>

    </button>

    {{-- Menu --}}
    <div
        x-show="open"
        x-transition.origin.top
        @click.outside="open=false"
        x-cloak
        class="absolute left-0 z-50 mt-2 w-full overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl"
    >

        {{ $slot }}

    </div>

</div>