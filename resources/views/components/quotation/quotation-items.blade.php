@props([
    'mode' => 'create',
])
<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div class="flex items-start justify-between">

            <div>

                <h2 class="text-2xl font-bold text-gray-800">

                    Line Items

                </h2>

                <p class="mt-2 text-gray-500">

                    Tambahkan daftar pekerjaan yang akan dimasukkan ke dalam quotation.

                </p>

            </div>

            <x-ui.button variant="primary">

                + Tambah Item

            </x-ui.button>

        </div>

        <hr class="my-8">

        {{-- Table --}}
        <div class="overflow-x-auto">

            <div class="space-y-8">

                {{-- Item --}}
                <div class="rounded-2xl border border-gray-200 p-6">

                    {{-- Header Item --}}
                    <div class="mb-6 flex items-center justify-between">

                        <button
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-red-100 text-red-600 transition hover:bg-red-200">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 7H5" />

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 11v6" />

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14 11v6" />

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12" />

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3" />

                            </svg>

                        </button>

                    </div>

                    {{-- Nama Item --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-gray-700">

                            Item Name

                        </label>

                        <input
                            type="text"
                            placeholder="Contoh: Pengecoran Beton"
                            class="w-full rounded-xl border-gray-300">

                    </div>

                    {{-- Qty --}}
                    <div class="mt-6 grid grid-cols-12 gap-4">

                        <div class="col-span-2">

                            <label class="mb-2 block text-sm font-medium text-gray-700">

                                Qty

                            </label>

                            <input
                                type="number"
                                value="1"
                                class="w-full rounded-xl border-gray-300 text-center">

                        </div>

                        <div class="col-span-3">

                            <label class="mb-2 block text-sm font-medium text-gray-700">

                                Unit

                            </label>

                            <select class="w-full rounded-xl border-gray-300">

                                <option>Unit</option>
                                <option>m²</option>
                                <option>m³</option>
                                <option>Pcs</option>
                                <option>Lot</option>

                            </select>

                        </div>

                        <div class="col-span-4">

                            <label class="mb-2 block text-sm font-medium text-gray-700">

                                Unit Price

                            </label>

                            <input
                                type="number"
                                placeholder="0"
                                class="w-full rounded-xl border-gray-300 text-right">

                        </div>

                        <div class="col-span-3">

                            <label class="mb-2 block text-sm font-medium text-gray-700">

                                Total

                            </label>

                            <div class="flex h-11 items-center justify-end rounded-xl bg-gray-100 px-4 whitespace-nowrap font-semibold">

                                Rp 98.000.000

                            </div>

                        </div>

                    </div>

                    {{-- Description --}}
                    <div class="mt-6">

                        <label class="mb-2 block text-sm font-medium text-gray-700">

                            Description

                        </label>

                        <textarea
                            rows="10"
                            placeholder="Deskripsi pekerjaan..."
                            class="w-full rounded-xl border-gray-300 resize-none"></textarea>

                    </div>

                </div>

            </div>

        </div>

        {{-- Summary --}}
        <div class="mt-8 rounded-2xl border border-gray-200 bg-gray-50 p-6">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                <div>

                    <p class="text-sm text-gray-500">

                        Jumlah Item

                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800">

                        1

                    </h3>

                </div>

                <div>

                    <p class="text-sm text-gray-500">

                        Total Qty

                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800">

                        1

                    </h3>

                </div>

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