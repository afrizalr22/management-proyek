@props([
    'quotation',
])

@php
    $subtotal = (float) ($quotation->subtotal ?? 0);
    $grandTotal = (float) ($quotation->grand_total ?? $subtotal);
@endphp

<section
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm"
>
    <div class="border-b border-gray-200 px-5 py-4 sm:px-6">
        <h2 class="text-lg font-semibold text-gray-900">
            Ringkasan Biaya
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Ringkasan nilai keseluruhan quotation.
        </p>
    </div>

    <div class="space-y-4 p-5 sm:p-6">
        <div class="flex items-center justify-between gap-4">
            <span class="text-sm text-gray-500">
                Jumlah Item
            </span>

            <span class="text-sm font-semibold text-gray-900">
                {{ $quotation->items->count() }} item
            </span>
        </div>

        <div class="flex items-center justify-between gap-4">
            <span class="text-sm text-gray-500">
                Total Kuantitas
            </span>

            <span class="text-sm font-semibold text-gray-900">
                {{ number_format(
                    (float) $quotation->items->sum('qty'),
                    2,
                    ',',
                    '.'
                ) }}
            </span>
        </div>

        <div class="flex items-center justify-between gap-4">
            <span class="text-sm text-gray-500">
                Subtotal
            </span>

            <span class="text-sm font-semibold text-gray-900">
                Rp {{ number_format($subtotal, 0, ',', '.') }}
            </span>
        </div>

        <div class="border-t border-gray-200 pt-4">
            <div class="flex items-center justify-between gap-4">
                <span class="font-semibold text-gray-900">
                    Total Quotation
                </span>

                <span class="text-xl font-bold text-blue-600">
                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="rounded-xl bg-blue-50 px-4 py-3">
            <p class="text-xs leading-5 text-blue-700">
                Total quotation dihitung berdasarkan seluruh item pekerjaan.
            </p>
        </div>
    </div>
</section>