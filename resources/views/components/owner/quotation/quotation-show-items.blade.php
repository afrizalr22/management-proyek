@props([
    'items',
])

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900 sm:text-2xl">
                    Rincian Pekerjaan dan Material
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-500 sm:text-base">
                    Daftar pekerjaan dan material yang tercantum dalam quotation.
                </p>
            </div>

            <div class="shrink-0">
                <x-ui.badge color="blue">
                    {{ $items->count() }} Item
                </x-ui.badge>
            </div>
        </div>

        <hr class="my-6 border-gray-200 sm:my-8">

        @if ($items->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="min-w-[850px] divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="pb-4 pr-6 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                No
                            </th>

                            <th class="pb-4 pr-6 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Item
                            </th>

                            <th class="whitespace-nowrap px-4 pb-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Quantity
                            </th>

                            <th class="whitespace-nowrap px-4 pb-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Satuan
                            </th>

                            <th class="whitespace-nowrap px-4 pb-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Harga Satuan
                            </th>

                            <th class="whitespace-nowrap pl-4 pb-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Total
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach ($items as $item)
                            @php
                                $formattedQuantity = rtrim(
                                    rtrim(
                                        number_format(
                                            (float) $item->qty,
                                            2,
                                            ',',
                                            '.'
                                        ),
                                        '0'
                                    ),
                                    ','
                                );
                            @endphp

                            <tr
                                wire:key="quotation-show-item-{{ $item->id }}"
                                class="transition hover:bg-gray-50"
                            >
                                <td class="whitespace-nowrap py-5 pr-6 text-sm text-gray-500">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="py-5 pr-6">
                                    <h3 class="font-semibold text-gray-900">
                                        {{ $item->item_name }}
                                    </h3>

                                    @if ($item->description)
                                        <p class="mt-1 max-w-xl whitespace-pre-line text-sm leading-6 text-gray-500">
                                            {{ $item->description }}
                                        </p>
                                    @else
                                        <p class="mt-1 text-sm text-gray-400">
                                            Tidak ada deskripsi.
                                        </p>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-4 py-5 text-center text-sm font-medium text-gray-800">
                                    {{ $formattedQuantity }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-5 text-center text-sm text-gray-600">
                                    {{ $item->unit }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-5 text-right text-sm text-gray-700">
                                    Rp {{ number_format(
                                        (float) $item->price,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </td>

                                <td class="whitespace-nowrap py-5 pl-4 text-right font-semibold text-gray-900">
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
        @else
            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center">
                <p class="font-semibold text-gray-700">
                    Belum ada item quotation
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Quotation ini belum memiliki rincian pekerjaan atau material.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>