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
            <div class="flex items-center justify-between gap-4">

                <span class="text-gray-500">
                    Total Item
                </span>

                <span class="font-semibold text-gray-800">
                    3 Item
                </span>

            </div>

            {{-- Total Quantity --}}
            <div class="flex items-center justify-between gap-4">

                <span class="text-gray-500">
                    Total Quantity
                </span>

                <span class="font-semibold text-gray-800">
                    535
                </span>

            </div>

            {{-- Subtotal --}}
            <div class="flex items-center justify-between gap-4">

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

            <p class="text-sm font-medium text-blue-700">
                Grand Total
            </p>

            <p class="mt-2 text-3xl font-bold text-blue-600">
                Rp 1.470.000.000
            </p>

        </div>

    </div>

</x-ui.info-card>