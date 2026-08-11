<x-ui.info-card>

    <div class="p-6">

        {{-- Header --}}
        <div class="flex items-center justify-between gap-4">

            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Detail Pekerjaan
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Tambahkan pekerjaan atau item yang akan ditagihkan.
                </p>
            </div>

            {{-- Add Item --}}
            <button
                type="button"
                class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 transition hover:text-blue-700"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 5v14M5 12h14"
                    />
                </svg>

                Tambah Item

            </button>

        </div>

        <hr class="my-6">


        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[700px]">

                <thead>

                    <tr class="border-b border-gray-200">

                        <th class="px-2 pb-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Deskripsi Pekerjaan
                        </th>

                        <th class="w-28 px-2 pb-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Kuantitas
                        </th>

                        <th class="w-32 px-2 pb-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Satuan
                        </th>

                        <th class="w-40 px-2 pb-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Harga Satuan
                        </th>

                        <th class="w-36 px-2 pb-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Total
                        </th>

                    </tr>

                </thead>


                <tbody>

                    {{-- Item --}}
                    <tr class="border-b border-gray-100">

                        {{-- Description --}}
                        <td class="px-2 py-4">

                            <input
                                type="text"
                                placeholder="Mis: Pemasangan Rangka Baja"
                                class="w-full rounded-lg border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                        </td>


                        {{-- Quantity --}}
                        <td class="px-2 py-4">

                            <input
                                type="number"
                                value="1"
                                min="0.01"
                                step="0.01"
                                class="w-full rounded-lg border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                        </td>


                        {{-- Unit --}}
                        <td class="px-2 py-4">

                            <input
                                type="text"
                                placeholder="Unit"
                                class="w-full rounded-lg border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                        </td>


                        {{-- Price --}}
                        <td class="px-2 py-4">

                            <input
                                type="number"
                                value="0"
                                min="0"
                                step="0.01"
                                class="w-full rounded-lg border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                        </td>


                        {{-- Total --}}
                        <td class="px-2 py-4 text-right">

                            <span class="text-sm font-medium text-gray-800">
                                Rp 0
                            </span>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        {{-- Add Item Bottom --}}
        <div class="mt-4">

            <button
                type="button"
                class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 transition hover:text-blue-700"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 5v14M5 12h14"
                    />
                </svg>

                Tambah Item

            </button>

        </div>

    </div>

</x-ui.info-card>