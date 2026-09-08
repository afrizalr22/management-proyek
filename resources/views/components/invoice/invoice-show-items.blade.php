@props([
    'invoice',
])

<x-ui.info-card>
    <div class="p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Item Invoice
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Daftar pekerjaan yang ditagihkan dalam invoice.
                </p>
            </div>

            <x-ui.badge color="blue">
                {{ $invoice->items->count() }} Item
            </x-ui.badge>
        </div>

        <hr class="my-6 border-gray-200">

        @if ($invoice->items->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="pb-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Item
                            </th>

                            <th class="pb-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Qty
                            </th>

                            <th class="pb-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Satuan
                            </th>

                            <th class="pb-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Harga Satuan
                            </th>

                            <th class="pb-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Total
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach ($invoice->items as $item)
                            <tr>
                                <td class="py-5 pr-6">
                                    <p class="font-semibold text-gray-800">
                                        {{ $item->item_name }}
                                    </p>

                                    @if (filled($item->description))
                                        <p class="mt-1 whitespace-pre-line text-sm leading-relaxed text-gray-500">
                                            {{ $item->description }}
                                        </p>
                                    @endif
                                </td>

                                <td class="px-4 py-5 text-center text-gray-700">
                                    {{ number_format(
                                        (float) $item->qty,
                                        2,
                                        ',',
                                        '.'
                                    ) }}
                                </td>

                                <td class="px-4 py-5 text-center text-gray-700">
                                    {{ $item->unit }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-5 text-right text-gray-700">
                                    Rp {{ number_format(
                                        (float) $item->price,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </td>

                                <td class="whitespace-nowrap py-5 pl-4 text-right font-semibold text-gray-800">
                                    Rp {{ number_format(
                                        (float) $item->total,
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

            <div class="mt-4 text-xs text-gray-400 lg:hidden">
                Geser tabel ke samping untuk melihat seluruh informasi.
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center">
                <p class="font-semibold text-gray-700">
                    Tidak ada item invoice
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Invoice ini belum memiliki item pekerjaan.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>