@props([
    'items' => [],
])

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Item Invoice
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Item disalin otomatis dari Quotation dan tidak dapat diubah.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        @if (count($items) > 0)
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px]">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-3 pb-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Item
                            </th>

                            <th class="w-28 px-3 pb-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Qty
                            </th>

                            <th class="w-28 px-3 pb-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Satuan
                            </th>

                            <th class="w-40 px-3 pb-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Harga
                            </th>

                            <th class="w-40 px-3 pb-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Total
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach ($items as $index => $item)
                            <tr wire:key="invoice-item-{{ $index }}">
                                <td class="px-3 py-4">
                                    <p class="font-semibold text-gray-900">
                                        {{ $item['item_name'] }}
                                    </p>

                                    @if (!empty($item['description']))
                                        <p class="mt-1 text-sm leading-5 text-gray-500">
                                            {{ $item['description'] }}
                                        </p>
                                    @endif
                                </td>

                                <td class="px-3 py-4 text-right text-sm text-gray-700">
                                    {{ number_format(
                                        (float) $item['qty'],
                                        2,
                                        ',',
                                        '.'
                                    ) }}
                                </td>

                                <td class="px-3 py-4 text-sm text-gray-700">
                                    {{ $item['unit'] }}
                                </td>

                                <td class="whitespace-nowrap px-3 py-4 text-right text-sm text-gray-700">
                                    Rp {{ number_format(
                                        (float) $item['price'],
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </td>

                                <td class="whitespace-nowrap px-3 py-4 text-right font-semibold text-gray-900">
                                    Rp {{ number_format(
                                        (float) $item['total'],
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 py-10 text-center">
                <p class="font-semibold text-gray-700">
                    Belum ada item Invoice
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Pilih Quotation untuk menampilkan item pekerjaan.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>