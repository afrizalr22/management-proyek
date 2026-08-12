<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    {{-- Result Information --}}
    <p class="text-sm text-gray-500">
        Showing
        <span class="font-medium text-gray-700">
            1–12
        </span>
        of
        <span class="font-medium text-gray-700">
            24
        </span>
        documentations
    </p>


    {{-- Pagination --}}
    <div class="flex items-center gap-2">

        {{-- Previous --}}
        <button
            type="button"
            class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-500 shadow-sm transition hover:bg-gray-50 hover:text-gray-700"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m15 19-7-7 7-7"
                />
            </svg>

            <span class="hidden sm:inline">
                Previous
            </span>

        </button>


        {{-- Page 1 --}}
        <button
            type="button"
            class="inline-flex h-9 min-w-9 items-center justify-center rounded-xl bg-blue-600 px-3 text-sm font-semibold text-white shadow-sm"
        >
            1
        </button>


        {{-- Page 2 --}}
        <button
            type="button"
            class="inline-flex h-9 min-w-9 items-center justify-center rounded-xl border border-gray-200 bg-white px-3 text-sm font-medium text-gray-600 shadow-sm transition hover:bg-gray-50 hover:text-gray-800"
        >
            2
        </button>


        {{-- Next --}}
        <button
            type="button"
            class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-600 shadow-sm transition hover:bg-gray-50 hover:text-gray-800"
        >

            <span class="hidden sm:inline">
                Next
            </span>

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m9 5 7 7-7 7"
                />
            </svg>

        </button>

    </div>

</div>