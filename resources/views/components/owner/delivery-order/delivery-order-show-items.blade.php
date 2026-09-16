@props([
    'items',
])

@php
    $unitLabels = [
        'unit' => 'Unit',
        'pcs' => 'Pcs',
        'set' => 'Set',
        'buah' => 'Buah',
        'batang' => 'Batang',
        'lembar' => 'Lembar',
        'sak' => 'Sak',
        'dus' => 'Dus',
        'box' => 'Box',
        'roll' => 'Roll',
        'titik' => 'Titik',
        'meter' => 'Meter',
        'm²' => 'm²',
        'm³' => 'm³',
        'kg' => 'Kg',
        'ton' => 'Ton',
        'liter' => 'Liter',
        'paket' => 'Paket',
        'ls' => 'Lumpsum',
    ];

    $formatQuantity = static function (
        mixed $quantity
    ): string {
        $formatted = number_format(
            (float) $quantity,
            2,
            ',',
            '.'
        );

        return rtrim(
            rtrim($formatted, '0'),
            ','
        );
    };
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Item Pengiriman
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Daftar barang atau material yang dikirim.
                </p>
            </div>

            <span class="inline-flex min-w-9 items-center justify-center rounded-full bg-gray-100 px-3 py-1 text-sm font-semibold text-gray-700">
                {{ $items->count() }} Item
            </span>
        </div>

        <hr class="my-6 border-gray-200">

        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-16 px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                            No.
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Item
                        </th>

                        <th class="whitespace-nowrap px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Jumlah
                        </th>

                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Satuan
                        </th>

                        <th class="whitespace-nowrap px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Kondisi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($items as $index => $item)
                        @php
                            [$conditionText, $conditionColor] =
                                match ($item->condition) {
                                    'good' => [
                                        'Baik',
                                        'green',
                                    ],
                                    'damaged' => [
                                        'Rusak',
                                        'red',
                                    ],
                                    default => [
                                        'Tidak Diketahui',
                                        'gray',
                                    ],
                                };

                            $unit =
                                $unitLabels[$item->unit]
                                ?? $item->unit
                                ?? '-';
                        @endphp

                        <tr>
                            <td class="px-4 py-4 text-center text-sm text-gray-500">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-4 py-4">
                                <p class="font-semibold text-gray-900">
                                    {{ $item->item_name }}
                                </p>

                                @if (filled($item->description))
                                    <p class="mt-1 whitespace-pre-line text-sm leading-6 text-gray-500">
                                        {{ $item->description }}
                                    </p>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-4 py-4 text-right font-semibold text-gray-900">
                                {{ $formatQuantity($item->qty) }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700">
                                {{ $unit }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-4 text-center">
                                <x-ui.badge :color="$conditionColor">
                                    {{ $conditionText }}
                                </x-ui.badge>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="5"
                                class="px-6 py-10 text-center"
                            >
                                <p class="font-semibold text-gray-700">
                                    Tidak ada item
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Surat Jalan ini tidak mempunyai item pengiriman.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                @if ($items->isNotEmpty())
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td
                                colspan="2"
                                class="px-4 py-4 font-semibold text-gray-700"
                            >
                                Total
                            </td>

                            <td class="whitespace-nowrap px-4 py-4 text-right font-bold text-gray-900">
                                {{ $formatQuantity(
                                    $items->sum('qty')
                                ) }}
                            </td>

                            <td
                                colspan="2"
                                class="px-4 py-4 text-sm text-gray-500"
                            >
                                Total quantity seluruh item
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</x-ui.info-card>