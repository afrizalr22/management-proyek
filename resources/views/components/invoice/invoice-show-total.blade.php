@props([
    'invoice',
])

@php
    $totalQuantity = $invoice->items->sum(
        fn ($item) => (float) $item->qty
    );
@endphp

<x-ui.info-card>
    <div class="p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Ringkasan Keuangan
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Ringkasan nilai berdasarkan item invoice.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        <div class="space-y-5">
            <div class="flex items-center justify-between gap-4">
                <span class="text-gray-500">
                    Total Item
                </span>

                <span class="font-semibold text-gray-800">
                    {{ $invoice->items->count() }} Item
                </span>
            </div>

            <div class="flex items-center justify-between gap-4">
                <span class="text-gray-500">
                    Total Kuantitas
                </span>

                <span class="font-semibold text-gray-800">
                    {{ number_format(
                        $totalQuantity,
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
                        (float) $invoice->subtotal,
                        0,
                        ',',
                        '.'
                    ) }}
                </span>
            </div>
        </div>

        <hr class="my-6 border-gray-200">

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
                    Rp {{ number_format(
                        (float) $invoice->grand_total,
                        0,
                        ',',
                        '.'
                    ) }}
                </p>
            </div>
        </div>
    </div>
</x-ui.info-card>