@props([
    'items' => [],
    'subtotal' => 0,
    'grandTotal' => 0,
])

@php
    $quotationItems = is_array($items)
        ? $items
        : [];

    $itemCount = count($quotationItems);

    $totalQuantity = collect($quotationItems)
        ->sum(function ($item) {
            return (float) ($item['qty'] ?? 0);
        });

    $subtotalValue = (float) $subtotal;
    $grandTotalValue = (float) $grandTotal;
@endphp

<section
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm"
>
    {{-- Header --}}
    <div class="border-b border-gray-200 px-5 py-4">
        <h2 class="font-semibold text-gray-900">
            Ringkasan Quotation
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Perhitungan otomatis berdasarkan item pekerjaan.
        </p>
    </div>

    {{-- Ringkasan --}}
    <div class="space-y-4 p-5">
        {{-- Jumlah item --}}
        <div class="flex items-center justify-between gap-4">
            <span class="text-sm text-gray-500">
                Jumlah Item
            </span>

            <span class="text-sm font-semibold text-gray-900">
                {{ $itemCount }} item
            </span>
        </div>

        {{-- Total kuantitas --}}
        <div class="flex items-center justify-between gap-4">
            <span class="text-sm text-gray-500">
                Total Kuantitas
            </span>

            <span class="text-sm font-semibold text-gray-900">
                {{ number_format(
                    $totalQuantity,
                    $totalQuantity == floor($totalQuantity) ? 0 : 2,
                    ',',
                    '.'
                ) }}
            </span>
        </div>

        {{-- Subtotal --}}
        <div class="flex items-center justify-between gap-4">
            <span class="text-sm text-gray-500">
                Subtotal
            </span>

            <span class="text-sm font-semibold text-gray-900">
                Rp {{ number_format(
                    $subtotalValue,
                    0,
                    ',',
                    '.'
                ) }}
            </span>
        </div>

        {{-- Grand total --}}
        <div class="border-t border-gray-200 pt-4">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="font-semibold text-gray-900">
                        Total Quotation
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Total keseluruhan penawaran
                    </p>
                </div>

                <span class="text-right text-xl font-bold text-blue-600">
                    Rp {{ number_format(
                        $grandTotalValue,
                        0,
                        ',',
                        '.'
                    ) }}
                </span>
            </div>
        </div>

        {{-- Informasi --}}
        <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3">
            <div class="flex items-start gap-3">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="mt-0.5 h-5 w-5 shrink-0 text-blue-600"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M11.25 11.25 9 13.5l2.25 2.25m1.5-4.5L15 13.5l-2.25 2.25M12 6.75h.008v.008H12V6.75Zm0 10.5h.008v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                    />
                </svg>

                <p class="text-xs leading-5 text-blue-700">
                    Nilai akan diperbarui otomatis ketika jumlah atau harga item diubah.
                </p>
            </div>
        </div>
    </div>
</section>