<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div class="mb-8">

            <h2 class="text-2xl font-bold text-gray-800">
                Latest Progress
            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500">
                Progress pekerjaan terakhir yang dikirim oleh Mandor.
            </p>

        </div>


        {{-- Latest Progress Summary --}}
        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-6">

            <div class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">

                {{-- Progress Information --}}
                <div class="min-w-0">

                    <h3 class="text-lg font-semibold leading-7 text-gray-900">
                        Pengecoran Kolom Lantai 2
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Seluruh kolom area timur telah selesai dilakukan pengecoran.
                        Proses curing akan dimulai besok.
                    </p>

                </div>


                {{-- Progress --}}
                <div class="shrink-0 sm:min-w-[90px] sm:text-right">

                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                        Progress
                    </p>

                    <p class="mt-1 text-3xl font-bold text-blue-600">
                        75%
                    </p>

                </div>

            </div>

        </div>


        {{-- Progress Metadata --}}
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-3">

            {{-- Updated By --}}
            <div class="rounded-xl bg-gray-50 p-4">

                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Updated By
                </p>

                <h4 class="mt-1.5 font-semibold text-gray-900">
                    Budi Santoso
                </h4>

            </div>


            {{-- Date --}}
            <div class="rounded-xl bg-gray-50 p-4">

                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Date
                </p>

                <h4 class="mt-1.5 font-semibold text-gray-900">
                    27 Juli 2026
                </h4>

            </div>


            {{-- Duration --}}
            <div class="rounded-xl bg-gray-50 p-4">

                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Duration
                </p>

                <h4 class="mt-1.5 font-semibold text-gray-900">
                    Hari ke-108
                </h4>

            </div>

        </div>

    </div>

</x-ui.info-card>