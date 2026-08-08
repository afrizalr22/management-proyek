@props([
    'mode' => 'create',
])

<x-ui.info-card>

    <div class="p-6">

        {{-- Header --}}
        <div>

            <h2 class="text-xl font-bold text-gray-900">

                Financial Summary

            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500">

                Ringkasan nilai quotation berdasarkan item pekerjaan.

            </p>

        </div>

        <hr class="my-6 border-gray-200">

        {{-- Summary --}}
        <div class="space-y-5">

            {{-- Total Item --}}
            <div class="flex items-center justify-between">

                <span class="text-gray-500">

                    Total Item

                </span>

                <span class="font-semibold text-gray-900">

                    1 Item

                </span>

            </div>

            {{-- Total Quantity --}}
            <div class="flex items-center justify-between">

                <span class="text-gray-500">

                    Total Qty

                </span>

                <span class="font-semibold text-gray-900">

                    1

                </span>

            </div>

            {{-- Subtotal --}}
            <div class="flex items-center justify-between">

                <span class="text-gray-500">

                    Subtotal

                </span>

                <span class="font-semibold text-gray-900">

                    Rp 0

                </span>

            </div>

            <hr class="border-gray-200">

            {{-- Grand Total --}}
            <div class="rounded-2xl bg-blue-50 p-5">

                <div class="flex items-center justify-between gap-4">

                    <span class="text-lg font-semibold text-gray-900">

                        Grand Total

                    </span>

                    <span class="text-2xl font-bold text-blue-600">

                        Rp 0

                    </span>

                </div>

                <p class="mt-2 text-xs leading-5 text-gray-500">

                    Total akhir berdasarkan seluruh item quotation.

                </p>

            </div>

        </div>

    </div>

</x-ui.info-card>