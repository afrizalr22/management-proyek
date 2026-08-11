<x-ui.info-card>

    <div class="p-6">

        {{-- Header --}}
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Ringkasan
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Ringkasan nilai invoice yang akan dibuat.
            </p>
        </div>

        <hr class="my-6">

        {{-- Summary --}}
        <div class="space-y-5">

            {{-- Subtotal --}}
            <div class="flex items-center justify-between gap-4">

                <span class="text-sm text-gray-500">
                    Subtotal
                </span>

                <span class="font-semibold text-gray-800">
                    Rp 0
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
                Rp 0
            </p>

        </div>

    </div>

</x-ui.info-card>