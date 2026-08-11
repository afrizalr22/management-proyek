<x-ui.info-card>

    <div class="p-6">

        {{-- Header --}}
        <div>

            <h2 class="text-xl font-bold text-gray-800">
                Financial Summary
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Ringkasan nilai invoice berdasarkan item pekerjaan.
            </p>

        </div>

        <hr class="my-6">

        <div class="space-y-5">

            {{-- Total Item --}}
            <div class="flex items-center justify-between">

                <span class="text-gray-500">
                    Total Item
                </span>

                <span class="font-semibold text-gray-800">
                    3 Item
                </span>

            </div>

            {{-- Total Quantity --}}
            <div class="flex items-center justify-between">

                <span class="text-gray-500">
                    Total Quantity
                </span>

                <span class="font-semibold text-gray-800">
                    535
                </span>

            </div>

            {{-- Subtotal --}}
            <div class="flex items-center justify-between">

                <span class="text-gray-500">
                    Subtotal
                </span>

                <span class="font-semibold text-gray-800">
                    Rp 1.470.000.000
                </span>

            </div>

        </div>

        <hr class="my-6">

        {{-- Grand Total --}}
        <div class="rounded-2xl bg-blue-50 p-5">

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <p class="text-sm font-medium text-blue-700">
                        Grand Total
                    </p>

                    <p class="mt-1 text-xs text-blue-600">
                        Total nilai invoice
                    </p>

                </div>

                <p class="text-2xl font-bold text-blue-600 sm:text-3xl">
                    Rp 1.470.000.000
                </p>

            </div>

        </div>

    </div>

</x-ui.info-card>