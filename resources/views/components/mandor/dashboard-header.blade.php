<div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

    {{-- Project Information --}}
    <div>

        <h1 class="text-3xl font-bold text-gray-900">
            Foreman Dashboard
        </h1>

        <p class="mt-2 text-gray-500">
            Pembangunan Gudang PT Maju Bersama
        </p>

        <p class="mt-1 text-sm text-gray-400">
            Tangerang Selatan
        </p>

    </div>


    {{-- Date & Alert --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">

        {{-- Date --}}
        <div
            class="flex items-center gap-3 rounded-xl border border-gray-200 bg-white px-5 py-3"
        >

            <div
                class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    />

                </svg>

            </div>

            <div>

                <p class="text-xs text-gray-400">
                    Today
                </p>

                <p class="text-sm font-semibold text-gray-700">
                    19 August 2026
                </p>

            </div>

        </div>


        {{-- Project Alert --}}
        <div
            class="flex items-center gap-3 rounded-xl bg-red-50 px-5 py-3"
        >

            <div
                class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-100 text-red-600"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                    />

                </svg>

            </div>

            <div>

                <p class="text-xs font-medium text-red-500">
                    Project Alert
                </p>

                <p class="text-sm font-semibold text-red-700">
                    High Priority Issue
                </p>

            </div>

        </div>

    </div>

</div>