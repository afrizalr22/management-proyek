<x-ui.info-card>

    <div class="flex flex-col gap-6 p-8 sm:flex-row sm:items-center sm:justify-between">

        {{-- Header Information --}}
        <div>

            <p class="text-sm font-medium text-blue-600">
                Project Documentation
            </p>

            <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900">
                Dokumentasi Proyek
            </h1>

            <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-500">
                Seluruh dokumentasi proyek yang telah diunggah selama
                proses pelaksanaan konstruksi.
            </p>

        </div>


        {{-- Documentation Statistics --}}
        <div
            class="shrink-0 rounded-2xl border border-blue-100 bg-blue-50 px-6 py-4"
        >

            <p class="text-sm font-medium text-gray-500">
                Total Documentation
            </p>

            <div class="mt-1 flex items-baseline gap-2">

                <h3 class="text-3xl font-bold text-blue-600">
                    24
                </h3>

                <span class="text-sm text-gray-500">
                    dokumentasi
                </span>

            </div>

        </div>

    </div>

</x-ui.info-card>