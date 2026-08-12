<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    {{-- Pagination Information --}}
    <p class="text-sm text-gray-500">
        Showing 1 - 4 of 12 Projects
    </p>


    {{-- Pagination Navigation --}}
    <div class="flex items-center gap-2">

        {{-- Previous --}}
        <button
            type="button"
            class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50"
        >
            Previous
        </button>


        {{-- Current Page --}}
        <button
            type="button"
            class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm"
        >
            1
        </button>


        {{-- Next --}}
        <button
            type="button"
            class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50"
        >
            Next
        </button>

    </div>

</div>