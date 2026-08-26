<div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

    {{-- Page Information --}}
    <div>

        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            My Projects
        </h1>

        <p class="mt-2 text-gray-500">
            Daftar proyek konstruksi yang sedang menjadi tanggung jawab
            Anda sebagai mandor.
        </p>

    </div>


    {{-- Page Actions --}}
    <div class="flex items-center gap-3">

        {{-- Filter --}}
        <button
            type="button"
            class="inline-flex items-center gap-2 rounded-lg border border-gray-300
                   bg-white px-4 py-2.5 text-sm font-medium text-gray-700
                   transition hover:bg-gray-50"
        >

            {{-- Filter Icon --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 5h18M6 12h12M10 19h4"
                />
            </svg>

            <span>
                Filter
            </span>

        </button>


        {{-- Sort --}}
        <button
            type="button"
            class="inline-flex items-center gap-2 rounded-lg border border-gray-300
                   bg-white px-4 py-2.5 text-sm font-medium text-gray-700
                   transition hover:bg-gray-50"
        >

            {{-- Sort Icon --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8 6h13M8 12h10M8 18h7"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 6h.01M3 12h.01M3 18h.01"
                />
            </svg>

            <span>
                Sort by Date
            </span>

        </button>

    </div>

</div>