<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div>

            <h2 class="text-2xl font-bold text-gray-900">
                Related Documents
            </h2>

            <p class="mt-2 text-gray-500">
                Dokumen yang berkaitan dengan invoice ini.
            </p>

        </div>


        <hr class="my-8">


        <div class="grid gap-6 md:grid-cols-2">

            {{-- Quotation --}}
            <div class="rounded-2xl border border-gray-200 p-6">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">
                            Quotation
                        </p>

                        <h3 class="mt-2 text-xl font-bold text-gray-900">
                            QT-2026-0001
                        </h3>

                        <p class="mt-2 text-gray-500">
                            Quotation yang menjadi dasar pembuatan invoice ini.
                        </p>

                    </div>

                    <x-ui.badge color="green">
                        Approved
                    </x-ui.badge>

                </div>


                <div class="mt-6">

                    <a href="{{ route('owner.quotations.show', 1) }}">

                        <x-ui.button variant="secondary">

                            Lihat Quotation

                        </x-ui.button>

                    </a>

                </div>

            </div>


            {{-- Delivery Order --}}
            <div class="rounded-2xl border border-gray-200 p-6">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">
                            Delivery Order
                        </p>

                        <h3 class="mt-2 text-xl font-bold text-gray-900">
                            Belum Tersedia
                        </h3>

                        <p class="mt-2 text-gray-500">
                            Delivery Order akan tersedia setelah proses pengiriman dibuat.
                        </p>

                    </div>

                    <x-ui.badge color="gray">
                        Waiting
                    </x-ui.badge>

                </div>


                <div class="mt-6">

                    <x-ui.button
                        variant="secondary"
                        disabled
                    >

                        Belum Tersedia

                    </x-ui.button>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>