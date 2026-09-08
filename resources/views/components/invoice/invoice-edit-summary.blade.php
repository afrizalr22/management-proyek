@props([
    'items' => [],
    'subtotal' => 0,
    'totalQuantity' => 0,
])

<x-ui.info-card>
    <div class="p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Ringkasan Keuangan
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Nilai invoice dihitung otomatis dari seluruh item.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        <div class="space-y-5">
            <div class="flex items-center justify-between gap-4">
                <span class="text-gray-500">
                    Total Item
                </span>

                <span class="font-semibold text-gray-800">
                    {{ count($items) }} Item
                </span>
            </div>

            <div class="flex items-center justify-between gap-4">
                <span class="text-gray-500">
                    Total Kuantitas
                </span>

                <span class="font-semibold text-gray-800">
                    {{ number_format(
                        (float) $totalQuantity,
                        2,
                        ',',
                        '.'
                    ) }}
                </span>
            </div>

            <div class="flex items-center justify-between gap-4">
                <span class="text-gray-500">
                    Subtotal
                </span>

                <span class="text-right font-semibold text-gray-800">
                    Rp {{ number_format(
                        (float) $subtotal,
                        0,
                        ',',
                        '.'
                    ) }}
                </span>
            </div>
        </div>

        <hr class="my-6 border-gray-200">

        <div class="rounded-2xl bg-blue-50 p-5">
            <p class="text-sm font-medium text-blue-700">
                Grand Total
            </p>

            <p class="mt-2 break-words text-3xl font-bold text-blue-600">
                Rp {{ number_format(
                    (float) $subtotal,
                    0,
                    ',',
                    '.'
                ) }}
            </p>

            <p class="mt-2 text-xs leading-5 text-blue-600">
                Pajak dan diskon belum digunakan sehingga grand total sama
                dengan subtotal.
            </p>
        </div>

        <div class="mt-6 rounded-xl border border-yellow-200 bg-yellow-50 p-4">
            <p class="text-sm font-semibold text-yellow-800">
                Invoice Draft
            </p>

            <p class="mt-1 text-xs leading-5 text-yellow-700">
                Invoice hanya dapat diedit selama masih berstatus draft.
            </p>
        </div>
    </div>
</x-ui.info-card>