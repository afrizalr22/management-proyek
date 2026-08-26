<div class="grid grid-cols-1 gap-4 md:grid-cols-3">

    {{-- Total Progress --}}
    <x-ui.info-card>

        <div class="p-5">

            <div class="flex items-center justify-between">

                <span class="text-sm font-medium text-gray-600">
                    Total Progress
                </span>

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
                            d="M9 17v-2m3 2v-4m3 4v-6m2 9H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v9a2 2 0 01-2 2z"
                        />
                    </svg>
                </div>

            </div>


            <div class="mt-5 flex items-end gap-2">

                <span class="text-3xl font-bold text-gray-900">
                    64%
                </span>

                <span class="mb-1 text-sm font-semibold text-green-600">
                    +4.2%
                </span>

            </div>


            <div class="mt-4 h-2 overflow-hidden rounded-full bg-gray-200">

                <div
                    class="h-full rounded-full bg-blue-600"
                    style="width: 64%"
                ></div>

            </div>

        </div>

    </x-ui.info-card>


    {{-- Days Remaining --}}
    <x-ui.info-card>

        <div class="p-5">

            <div class="flex items-center justify-between">

                <span class="text-sm font-medium text-gray-600">
                    Days Remaining
                </span>

                <div
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-50 text-gray-600"
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

            </div>


            <div class="mt-5">

                <div class="flex items-baseline gap-2">

                    <span class="text-3xl font-bold text-gray-900">
                        128
                    </span>

                    <span class="text-sm text-gray-500">
                        days
                    </span>

                </div>

                <p class="mt-2 text-sm text-gray-500">
                    Target Dec 2024
                </p>

                <p class="mt-1 text-sm font-medium text-green-600">
                    Ahead of schedule
                </p>

            </div>

        </div>

    </x-ui.info-card>


    {{-- Active Workers --}}
    <x-ui.info-card>

        <div class="p-5">

            <div class="flex items-center justify-between">

                <span class="text-sm font-medium text-gray-600">
                    Active Workers
                </span>

                <div
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-50 text-gray-600"
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
                            d="M17 20h5V4H2v16h5m10 0v-5H7v5m10 0H7m5-5V9"
                        />
                    </svg>
                </div>

            </div>


            <div class="mt-5">

                <div class="flex items-baseline gap-2">

                    <span class="text-3xl font-bold text-gray-900">
                        242
                    </span>

                    <span class="text-sm font-semibold text-blue-600">
                        Peak shift
                    </span>

                </div>


                <div class="mt-4 flex -space-x-2">

                    <div class="h-8 w-8 rounded-full border-2 border-white bg-gray-300"></div>

                    <div class="h-8 w-8 rounded-full border-2 border-white bg-gray-400"></div>

                    <div class="h-8 w-8 rounded-full border-2 border-white bg-gray-500"></div>

                    <div class="flex h-8 w-8 items-center justify-center rounded-full border-2 border-white bg-gray-200 text-xs font-semibold text-gray-600">
                        +239
                    </div>

                </div>

            </div>

        </div>

    </x-ui.info-card>

</div>