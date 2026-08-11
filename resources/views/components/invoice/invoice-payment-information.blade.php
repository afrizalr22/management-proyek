<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div>

            <h2 class="text-2xl font-bold text-gray-900">
                Payment Information
            </h2>

            <p class="mt-2 text-gray-500">
                Informasi pembayaran yang digunakan untuk penyelesaian invoice.
            </p>

        </div>


        <hr class="my-6">


        {{-- Payment Information --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- Bank Name --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Bank Name
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    Bank Mandiri
                </p>

            </div>


            {{-- Account Name --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Account Name
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    PT Satria Cipta Karya
                </p>

            </div>


            {{-- Account Number --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Account Number
                </p>

                <p class="mt-2 font-semibold text-gray-900">
                    1234567890
                </p>

            </div>


            {{-- Payment Status --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
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