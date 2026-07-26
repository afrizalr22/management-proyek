<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-2xl font-bold text-gray-900">

                    Rincian Pekerjaan & Material

                </h2>

                <p class="mt-2 text-gray-500">

                    Daftar pekerjaan beserta material yang tercantum pada quotation.

                </p>

            </div>

            <div>

                <x-ui.badge color="blue">

                    5 Item

                </x-ui.badge>

            </div>

        </div>

        <hr class="my-8">

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead>

                    <tr class="border-b">

                        <th class="pb-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-500">

                            Deskripsi

                        </th>

                        <th class="pb-4 text-center text-sm font-semibold uppercase tracking-wide text-gray-500">

                            Qty

                        </th>

                        <th class="pb-4 text-center text-sm font-semibold uppercase tracking-wide text-gray-500">

                            Unit

                        </th>

                        <th class="pb-4 text-right text-sm font-semibold uppercase tracking-wide text-gray-500">

                            Harga

                        </th>

                        <th class="pb-4 text-right text-sm font-semibold uppercase tracking-wide text-gray-500">

                            Total

                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    {{-- Item 1 --}}
                    <tr>

                        <td class="py-6">

                            <h4 class="font-semibold text-gray-900">

                                Pekerjaan Pondasi Tiang Pancang

                            </h4>

                            <p class="mt-1 text-sm text-gray-500">

                                Diameter 400mm, kedalaman 24m, termasuk pengecoran.

                            </p>

                        </td>

                        <td class="text-center">

                            120

                        </td>

                        <td class="text-center">

                            Titik

                        </td>

                        <td class="text-right">

                            Rp 8.500.000

                        </td>

                        <td class="text-right font-semibold">

                            Rp 1.020.000.000

                        </td>

                    </tr>

                    {{-- Item 2 --}}
                    <tr>

                        <td class="py-6">

                            <h4 class="font-semibold text-gray-900">

                                Struktur Baja Atap

                            </h4>

                            <p class="mt-1 text-sm text-gray-500">

                                WF 200/250 finishing epoxy coating.

                            </p>

                        </td>

                        <td class="text-center">

                            15

                        </td>

                        <td class="text-center">

                            Ton

                        </td>

                        <td class="text-right">

                            Rp 18.000.000

                        </td>

                        <td class="text-right font-semibold">

                            Rp 270.000.000

                        </td>

                    </tr>

                    {{-- Item 3 --}}
                    <tr>

                        <td class="py-6">

                            <h4 class="font-semibold text-gray-900">

                                Pemasangan Lantai Beton Precast

                            </h4>

                            <p class="mt-1 text-sm text-gray-500">

                                K-350 tebal 15 cm.

                            </p>

                        </td>

                        <td class="text-center">

                            400

                        </td>

                        <td class="text-center">

                            m²

                        </td>

                        <td class="text-right">

                            Rp 450.000

                        </td>

                        <td class="text-right font-semibold">

                            Rp 180.000.000

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</x-ui.info-card>