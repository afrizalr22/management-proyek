@props([
    'mode' => 'create',
])
<x-ui.info-card>

    <div class="p-6">

        {{-- Header --}}
        <div>

            <h2 class="text-xl font-bold text-gray-800">

                Financial Summary

            </h2>

            <p class="mt-2 text-sm text-gray-500">

                Ringkasan nilai quotation berdasarkan item pekerjaan.

            </p>

        </div>

        <hr class="my-6">

        <div class="space-y-5">

            <div class="flex items-center justify-between">

                <span class="text-gray-500">

                    Total Item

                </span>

                <span class="font-semibold text-gray-800">

                    1 Item

                </span>

            </div>

            <div class="flex items-center justify-between">

                <span class="text-gray-500">

                    Total Quantity

                </span>

                <span class="font-semibold text-gray-800">

                    1

                </span>

            </div>

            <div class="flex items-center justify-between">

                <span class="text-gray-500">

                    Subtotal

                </span>

                <span class="font-semibold text-gray-800">

                    Rp 0

                </span>

            </div>

            <hr>

            <div class="flex items-center justify-between">

                <span class="text-lg font-semibold text-gray-800">

                    Grand Total

                </span>

                <span class="text-2xl font-bold text-blue-600">

                    Rp 0

                </span>

            </div>

        </div>

    </div>
L
</x-ui.info-card>