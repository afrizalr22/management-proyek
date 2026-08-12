<div class="flex flex-col items-center justify-between gap-4 lg:flex-row">

    {{-- Information --}}
    <p class="text-sm text-gray-500">

        Showing
        <span class="font-medium text-gray-700">1</span>
        to
        <span class="font-medium text-gray-700">10</span>
        of
        <span class="font-medium text-gray-700">24</span>
        users

    </p>


    {{-- Pagination --}}
    <div class="flex items-center gap-2">

        {{-- Previous --}}
        <button
            type="button"
            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-500 transition hover:bg-gray-100"
        >
            Previous
        </button>


        {{-- Page 1 --}}
        <button
            type="button"
            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white"
        >
            1
        </button>


        {{-- Page 2 --}}
        <button
            type="button"
            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
        >
            2
        </button>


        {{-- Page 3 --}}
        <button
            type="button"
            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
        >
            3
        </button>


        {{-- Next --}}
        <button
            type="button"
            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
        >
            Next
        </button>

    </div>

</div>