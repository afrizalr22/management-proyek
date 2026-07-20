<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-xl font-bold">

                    Progress Project

                </h2>

                <p class="mt-1 text-gray-500">

                    Progress pekerjaan berdasarkan laporan terakhir.

                </p>

            </div>

            <x-ui.badge color="green">

                On Track

            </x-ui.badge>

        </div>

        <hr class="my-8">

        {{-- Progress --}}
        <div>

            <div class="mb-3 flex items-center justify-between">

                <span class="font-medium text-gray-700">

                    Total Progress

                </span>

                <span class="text-xl font-bold text-blue-600">

                    72%

                </span>

            </div>

            <div class="h-4 overflow-hidden rounded-full bg-gray-200">

                <div
                    class="h-full rounded-full bg-blue-600 transition-all duration-500"
                    style="width:72%"
                ></div>

            </div>

        </div>

        {{-- Progress Detail --}}
        <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-3">

            <div class="rounded-xl bg-blue-50 p-5">

                <p class="text-sm text-gray-500">

                    Progress Minggu Ini

                </p>

                <h3 class="mt-2 text-2xl font-bold text-blue-700">

                    +8%

                </h3>

            </div>

            <div class="rounded-xl bg-green-50 p-5">

                <p class="text-sm text-gray-500">

                    Target Progress

                </p>

                <h3 class="mt-2 text-2xl font-bold text-green-700">

                    75%

                </h3>

            </div>

            <div class="rounded-xl bg-yellow-50 p-5">

                <p class="text-sm text-gray-500">

                    Sisa Progress

                </p>

                <h3 class="mt-2 text-2xl font-bold text-yellow-700">

                    28%

                </h3>

            </div>

        </div>

    </div>

</x-ui.info-card>