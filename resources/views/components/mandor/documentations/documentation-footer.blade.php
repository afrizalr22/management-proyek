<x-ui.info-card class="overflow-hidden">

    <div
        class="flex flex-col items-center justify-between gap-5
               px-6 py-5 sm:flex-row"
    >

        {{-- Result Information --}}
        <div>

            <p class="text-sm text-gray-500">
                Menampilkan
                <span class="font-semibold text-gray-900">
                    6
                </span>
                dari
                <span class="font-semibold text-gray-900">
                    124
                </span>
                dokumentasi
            </p>

            {{-- Loading Progress --}}
            <div class="mt-2 h-1.5 w-48 overflow-hidden rounded-full bg-gray-100">

                <div
                    class="h-full rounded-full bg-blue-600"
                    style="width: 5%"
                ></div>

            </div>

        </div>

        {{-- Load More Button --}}
        <button
            type="button"
            class="inline-flex h-11 items-center justify-center
                   gap-2 rounded-lg border border-gray-300
                   bg-white px-5 text-sm font-semibold
                   text-gray-700 transition
                   hover:border-blue-300 hover:bg-blue-50
                   hover:text-blue-700"
        >
            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 5v14M5 12h14"
                />
            </svg>

            Muat Lebih Banyak
        </button>

    </div>

</x-ui.info-card>