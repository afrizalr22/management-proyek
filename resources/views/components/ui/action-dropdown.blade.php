<div
    x-data="{ open: false }"
    class="relative inline-block text-left"
>

    <button
        type="button"
        @click.stop="open = ! open"
        class="rounded-lg p-2 hover:bg-gray-100 transition"
    >

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 text-gray-600"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 5h.01M12 12h.01M12 19h.01"
            />

        </svg>

    </button>

    <div
        x-show="open"
        x-transition
        @click.outside="open = false"
        x-cloak
        class="absolute right-0 mt-2 w-48 rounded-xl border border-gray-200 bg-white shadow-xl z-[9999]"
    >

        {{ $slot }}

    </div>

</div>