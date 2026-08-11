<x-ui.info-card>

    <div class="p-8">

        <div>

            <h2 class="text-2xl font-bold text-gray-900">
                Financial Summary
            </h2>

            <p class="mt-2 text-gray-500">
                Ringkasan nilai keseluruhan invoice.
            </p>

        </div>

        <hr class="my-8">

        <div class="flex justify-end">

            <div class="w-full max-w-md space-y-5">

                {{-- Subtotal --}}
                <div class="flex items-center justify-between">

                    <span class="text-gray-600">
                        Subtotal
                    </span>

                    <span class="font-semibold text-gray-900">
                        Rp 450.000.000
                    </span>

                </div>

                <hr>

                {{-- Grand Total --}}
                <div class="flex items-center justify-between">

                    <span class="text-xl font-bold text-gray-900">
                        Grand Total
                    </span>

                    <span class="text-3xl font-bold text-blue-600">
                        Rp 450.000.000
                    </span>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>