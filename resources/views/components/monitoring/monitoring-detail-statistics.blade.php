<div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

    {{-- Overall Progress --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between p-6">

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Overall Progress
                </p>

                <h3 class="mt-2 text-3xl font-bold text-gray-900">
                    75%
                </h3>

                <p class="mt-3 text-sm text-gray-500">
                    Project Completion
                </p>
            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600">

                {{-- Progress Chart --}}
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-6 w-6">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 3v18h18" />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M7 15l3-3 3 2 4-6" />

                </svg>

            </div>

        </div>
    </x-ui.info-card>

    {{-- Current Phase --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between p-6">

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Current Phase
                </p>

                <h3 class="mt-2 text-3xl font-bold text-gray-900">
                    Structure
                </h3>

                <p class="mt-3 text-sm text-gray-500">
                    Tahap saat ini
                </p>
            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">

                {{-- Building --}}
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-6 w-6">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 21h18M6 21V7l6-4 6 4v14M9 10h.01M9 14h.01M9 18h.01M15 10h.01M15 14h.01M15 18h.01" />

                </svg>

            </div>

        </div>
    </x-ui.info-card>

    {{-- Active Workers --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between p-6">

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Active Workers
                </p>

                <h3 class="mt-2 text-3xl font-bold text-gray-900">
                    18
                </h3>

                <p class="mt-3 text-sm text-gray-500">
                    Pekerja di lapangan
                </p>
            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">

                {{-- Users --}}
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-6 w-6">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M18 20a6 6 0 00-12 0M12 11a4 4 0 100-8 4 4 0 000 8m8 9a5 5 0 00-4-4.9M20 7a3 3 0 11-6 0" />

                </svg>

            </div>

        </div>
    </x-ui.info-card>

    {{-- Active Issues --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between p-6">

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Active Issues
                </p>

                <h3 class="mt-2 text-3xl font-bold text-gray-900">
                    2
                </h3>

                <p class="mt-3 text-sm text-gray-500">
                    Perlu ditindaklanjuti
                </p>
            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 text-red-600">

                {{-- Warning --}}
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-6 w-6">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />

                </svg>

            </div>

        </div>
    </x-ui.info-card>

</div>