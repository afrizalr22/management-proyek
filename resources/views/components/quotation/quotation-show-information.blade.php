<x-ui.info-card>

    <div class="p-8">

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">

            {{-- Client --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Client
                </p>

                <h3 class="mt-2 text-lg font-bold text-gray-900">
                    PT Maju Bersama Properti
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Jakarta Selatan, Indonesia
                </p>

            </div>

            {{-- Project --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Project
                </p>

                <h3 class="mt-2 text-lg font-semibold leading-7 text-gray-900">
                    Pembangunan Gudang Logistik Tahap II
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Mandor: Ir. Haryono Kusuma
                </p>

            </div>

            {{-- Quotation --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Quotation
                </p>

                <div class="mt-3 space-y-2">

                    <p class="font-semibold text-gray-900">
                        12 Oktober 2026
                    </p>

                    <p class="text-sm text-gray-500">
                        Berlaku hingga: 26 Oktober 2026
                    </p>

                    <div class="pt-1">

                        <x-ui.badge color="green">
                            Approved
                        </x-ui.badge>

                    </div>

                </div>

            </div>

            {{-- Grand Total --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Grand Total
                </p>

                <h3 class="mt-3 text-2xl font-bold text-blue-600">
                    Rp 1.452.000.000
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Total nilai quotation
                </p>

            </div>

        </div>

    </div>

</x-ui.info-card>