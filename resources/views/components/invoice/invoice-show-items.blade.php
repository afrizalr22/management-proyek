<x-ui.info-card>

    <div class="p-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

            <div>

                <h2 class="text-xl font-bold text-gray-800">
                    Invoice Items
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Daftar pekerjaan yang tercantum dalam invoice.
                </p>

            </div>

            <x-ui.badge color="blue">
                3 Item
            </x-ui.badge>

        </div>

        <hr class="my-6">

        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[800px]">

                {{-- Table Header --}}
                <thead>

                    <tr class="border-b border-gray-200">

                        <th
                            class="pb-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"
                        >
                            Item
                        </th>

                        <th
                            class="pb-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500"
                        >
                            Qty
                        </th>

                        <th
                            class="pb-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500"
                        >
                            Unit
                        </th>

                        <th
                            class="pb-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500"
                        >
                            Unit Price
                        </th>

                        <th
                            class="pb-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500"
                        >
                            Total
                        </th>

                    </tr>

                </thead>

                {{-- Table Body --}}
                <tbody class="divide-y divide-gray-100">

                    {{-- Item 1 --}}
                    <tr>

                        <td class="py-5 pr-6">

                            <p class="font-semibold text-gray-800">
                                Pekerjaan Pondasi Tiang Pancang
                            </p>

                            <p class="mt-1 text-sm leading-relaxed text-gray-500">
                                Diameter 400mm, kedalaman 24m.
                            </p>

                        </td>

                        <td class="px-4 py-5 text-center text-gray-700">
                            120
                        </td>

                        <td class="px-4 py-5 text-center text-gray-700">
                            Titik
                        </td>

                        <td class="px-4 py-5 text-right text-gray-700">
                            Rp 8.500.000
                        </td>

                        <td class="py-5 pl-4 text-right font-semibold text-gray-800">
                            Rp 1.020.000.000
                        </td>

                    </tr>

                    {{-- Item 2 --}}
                    <tr>

                        <td class="py-5 pr-6">

                            <p class="font-semibold text-gray-800">
                                Struktur Baja Atap
                            </p>

                            <p class="mt-1 text-sm leading-relaxed text-gray-500">
                                WF 200/250 finishing epoxy coating.
                            </p>

                        </td>

                        <td class="px-4 py-5 text-center text-gray-700">
                            15
                        </td>

                        <td class="px-4 py-5 text-center text-gray-700">
                            Ton
                        </td>

                        <td class="px-4 py-5 text-right text-gray-700">
                            Rp 18.000.000
                        </td>

                        <td class="py-5 pl-4 text-right font-semibold text-gray-800">
                            Rp 270.000.000
                        </td>

                    </tr>

                    {{-- Item 3 --}}
                    <tr>

                        <td class="py-5 pr-6">

                            <p class="font-semibold text-gray-800">
                                Pemasangan Lantai Beton Precast
                            </p>

                            <p class="mt-1 text-sm leading-relaxed text-gray-500">
                                Beton K-350 dengan ketebalan 15 cm.
                            </p>

                        </td>

                        <td class="px-4 py-5 text-center text-gray-700">
                            400
                        </td>

                        <td class="px-4 py-5 text-center text-gray-700">
                            m²
                        </td>

                        <td class="px-4 py-5 text-right text-gray-700">
                            Rp 450.000
                        </td>

                        <td class="py-5 pl-4 text-right font-semibold text-gray-800">
                            Rp 180.000.000
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

        {{-- Mobile Note --}}
        <div class="mt-4 text-xs text-gray-400 lg:hidden">
            Geser tabel ke samping untuk melihat seluruh informasi item.
        </div>

    </div>

</x-ui.info-card>