@props([
    'mode' => 'create',
])

<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

            <div>

                <h2 class="text-2xl font-bold text-gray-900">

                    Line Items

                </h2>

                <p class="mt-2 text-gray-500">

                    Tambahkan daftar pekerjaan dan material yang akan dimasukkan ke dalam quotation.

                </p>

            </div>

            <x-ui.button variant="primary">

                + Tambah Item

            </x-ui.button>

        </div>

        <hr class="my-8">

        {{-- Items --}}
        <div class="space-y-6">

            {{-- Item --}}
            <div class="rounded-2xl border border-gray-200 p-6">

                {{-- Item Header --}}
                <div class="mb-6 flex items-center justify-between">

                    <div>

                        <h3 class="font-semibold text-gray-900">

                            Item #1

                        </h3>

                        <p class="mt-1 text-sm text-gray-500">

                            Masukkan detail pekerjaan dan harga.

                        </p>

                    </div>

                    <button
                        type="button"
                        title="Hapus item"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-red-100 text-red-600 transition hover:bg-red-200"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 7H5"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10 11v6"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14 11v6"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"
                            />

                        </svg>

                    </button>

                </div>

                {{-- Item Name --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-gray-700">

                        Item Name

                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="text"
                        placeholder="Contoh: Pengecoran Beton"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>

                {{-- Quantity & Price --}}
                <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-12">

                    {{-- Qty --}}
                    <div class="xl:col-span-2">

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Qty

                            <span class="text-red-500">*</span>

                        </label>

                        <input
                            type="number"
                            value="1"
                            min="1"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-center focus:border-blue-500 focus:ring-blue-500"
                        >

                    </div>

                    {{-- Unit --}}
                    <div class="xl:col-span-3">

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Unit

                            <span class="text-red-500">*</span>

                        </label>

                        <select
                            class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >

                            <option value="" disabled selected>

                                Pilih Unit

                            </option>

                            <option>

                                Unit

                            </option>

                            <option>

                                m²

                            </option>

                            <option>

                                m³

                            </option>

                            <option>

                                Pcs

                            </option>

                            <option>

                                Lot

                            </option>

                        </select>

                    </div>

                    {{-- Unit Price --}}
                    <div class="xl:col-span-4">

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Unit Price

                            <span class="text-red-500">*</span>

                        </label>

                        <div class="flex">

                            <span class="flex items-center rounded-l-xl border border-r-0 border-gray-300 bg-gray-100 px-4 text-gray-600">

                                Rp

                            </span>

                            <input
                                type="number"
                                min="0"
                                placeholder="0"
                                class="w-full rounded-r-xl border-gray-300 px-4 py-3 text-right focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                    </div>

                    {{-- Total --}}
                    <div class="xl:col-span-3">

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Total

                        </label>

                        <div class="flex h-[50px] items-center justify-end rounded-xl bg-gray-100 px-4 font-semibold text-gray-800">

                            Rp 0

                        </div>

                    </div>

                </div>

                {{-- Description --}}
                <div class="mt-6">

                    <label class="mb-2 block text-sm font-semibold text-gray-700">

                        Description

                    </label>

                    <textarea
                        rows="4"
                        placeholder="Contoh: Pekerjaan pengecoran beton K-300 termasuk material dan tenaga kerja."
                        class="w-full resize-y rounded-xl border-gray-300 px-4 py-3 leading-6 focus:border-blue-500 focus:ring-blue-500"
                    ></textarea>

                    <p class="mt-2 text-xs text-gray-500">

                        Jelaskan detail pekerjaan atau material yang termasuk dalam item ini.

                    </p>

                </div>

            </div>

        </div>

        {{-- Summary --}}
        <div class="mt-8 rounded-2xl border border-gray-200 bg-gray-50 p-6">

            <h3 class="text-lg font-bold text-gray-900">

                Items Summary

            </h3>

            <div class="mt-5 grid grid-cols-1 gap-6 md:grid-cols-3">

                {{-- Total Items --}}
                <div>

                    <p class="text-sm text-gray-500">

                        Jumlah Item

                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-900">

                        1

                    </h3>

                </div>

                {{-- Total Qty --}}
                <div>

                    <p class="text-sm text-gray-500">

                        Total Qty

                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-900">

                        1

                    </h3>

                </div>

                {{-- Subtotal --}}
                <div>

                    <p class="text-sm text-gray-500">

                        Subtotal

                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-blue-600">

                        Rp 0

                    </h3>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>