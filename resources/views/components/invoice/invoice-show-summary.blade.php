<x-ui.info-card>

    <div class="p-6">

        {{-- Header --}}
        <div>

            <h2 class="text-xl font-bold text-gray-800">
                Invoice Summary
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Informasi utama invoice dan project yang terkait.
            </p>

        </div>

        <hr class="my-6">

        <div class="space-y-6">

            {{-- Invoice Number --}}
            <div>

                <p class="text-sm text-gray-500">
                    Invoice Number
                </p>

                <p class="mt-1 text-lg font-semibold text-gray-800">
                    INV-2026-0001
                </p>

            </div>

            {{-- Project --}}
            <div>

                <p class="text-sm text-gray-500">
                    Project
                </p>

                <p class="mt-1 font-semibold leading-relaxed text-gray-800">
                    Pembangunan Gudang Logistik Tahap II
                </p>

            </div>

            {{-- Invoice Date --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                <div>

                    <p class="text-sm text-gray-500">
                        Invoice Date
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        12 Oktober 2026
                    </p>

                </div>

                <div>

                    <p class="text-sm text-gray-500">
                        Due Date
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        26 Oktober 2026
                    </p>

                </div>

            </div>

            {{-- Payment Status --}}
            <div>

                <p class="text-sm text-gray-500">
                    Payment Status
                </p>

                <div class="mt-2">

                    <x-ui.badge color="yellow">
                        Unpaid
                    </x-ui.badge>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>