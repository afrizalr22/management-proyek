<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">

    {{-- Active Workers --}}
    <x-ui.info-card>

        <div class="p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Active Workers
                    </p>

                    <h3 class="mt-3 text-3xl font-bold text-gray-900">
                        42
                    </h3>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-9a4 4 0 11-8 0 4 4 0 018 0zm6 2a3 3 0 10-6 0"
                        />

                    </svg>

                </div>

            </div>

            <div class="mt-4">

                <span class="text-sm font-medium text-emerald-600">
                    5%
                </span>

                <span class="text-sm text-gray-400">
                    vs yesterday
                </span>

            </div>

        </div>

    </x-ui.info-card>


    {{-- Today's Tasks --}}
    <x-ui.info-card>

        <div class="p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Today's Tasks
                    </p>

                    <h3 class="mt-3 text-3xl font-bold text-gray-900">
                        12
                        <span class="text-lg font-medium text-gray-400">
                            / 18
                        </span>
                    </h3>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />

                    </svg>

                </div>

            </div>

            <div class="mt-4">

                <div class="h-2 overflow-hidden rounded-full bg-gray-100">

                    <div
                        class="h-full rounded-full bg-emerald-500"
                        style="width: 67%;"
                    ></div>

                </div>

                <p class="mt-2 text-sm text-gray-400">
                    67% completed
                </p>

            </div>

        </div>

    </x-ui.info-card>


    {{-- Daily Reports --}}
    <x-ui.info-card>

        <div class="p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Daily Reports
                    </p>

                    <h3 class="mt-3 text-3xl font-bold text-gray-900">
                        02
                    </h3>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l4 4v12a2 2 0 01-2 2z"
                        />

                    </svg>

                </div>

            </div>

            <div class="mt-4">

                <span class="text-sm font-medium text-blue-600">
                    Today
                </span>

                <span class="text-sm text-gray-400">
                    reports submitted
                </span>

            </div>

        </div>

    </x-ui.info-card>


    {{-- Safety Alerts --}}
    <x-ui.info-card>

        <div class="p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Safety Alerts
                    </p>

                    <h3 class="mt-3 text-3xl font-bold text-gray-900">
                        0
                    </h3>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
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

            </div>

            <div class="mt-4">

                <span class="text-sm font-medium text-emerald-600">
                    All clear
                </span>

                <span class="text-sm text-gray-400">
                    no safety alerts
                </span>

            </div>

        </div>

    </x-ui.info-card>

</div>