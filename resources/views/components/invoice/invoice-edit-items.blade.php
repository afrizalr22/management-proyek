@props([
    'items' => [],
])

<x-ui.info-card>
    <div class="p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Item Invoice
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Kelola item pekerjaan yang ditagihkan.
                </p>
            </div>

            <button
                type="button"
                wire:click="addItem"
                wire:loading.attr="disabled"
                wire:target="addItem"
                class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100 disabled:opacity-60"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15"
                    />
                </svg>

                Tambah Item
            </button>
        </div>

        <hr class="my-6 border-gray-200">

        @error('items')
            <div
                class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                role="alert"
            >
                {{ $message }}
            </div>
        @enderror

        <div class="space-y-5">
            @foreach ($items as $index => $item)
                @php
                    $qty = is_numeric($item['qty'] ?? null)
                        ? (float) $item['qty']
                        : 0;

                    $price = is_numeric($item['price'] ?? null)
                        ? (float) $item['price']
                        : 0;

                    $itemTotal = $qty * $price;
                @endphp

                <div
                    wire:key="invoice-edit-item-{{ $index }}"
                    class="rounded-2xl border border-gray-200 bg-gray-50 p-4 sm:p-5"
                >
                    <div class="mb-5 flex items-center justify-between gap-4">
                        <h3 class="font-semibold text-gray-800">
                            Item {{ $index + 1 }}
                        </h3>

                        <button
                            type="button"
                            wire:click="removeItem({{ $index }})"
                            wire:loading.attr="disabled"
                            wire:target="removeItem({{ $index }})"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-red-500 transition hover:bg-red-100 hover:text-red-700 disabled:opacity-50"
                            title="Hapus item"
                            aria-label="Hapus item {{ $index + 1 }}"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-5 w-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0V4.477c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                />
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-12">
                        <div class="lg:col-span-5">
                            <label
                                for="item-name-{{ $index }}"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Nama Item
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="item-name-{{ $index }}"
                                type="text"
                                wire:model="items.{{ $index }}.item_name"
                                placeholder="Nama pekerjaan atau barang"
                                class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                            @error("items.$index.item_name")
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="lg:col-span-2">
                            <label
                                for="item-qty-{{ $index }}"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Kuantitas
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="item-qty-{{ $index }}"
                                type="number"
                                wire:model.live.debounce.300ms="items.{{ $index }}.qty"
                                min="0.01"
                                step="0.01"
                                class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                            @error("items.$index.qty")
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="lg:col-span-2">
                            <label
                                for="item-unit-{{ $index }}"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Satuan
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="item-unit-{{ $index }}"
                                wire:model="items.{{ $index }}.unit"
                                class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="">
                                    Pilih Satuan
                                </option>

                                @foreach ([
                                    'unit' => 'Unit',
                                    'pcs' => 'Pcs',
                                    'set' => 'Set',
                                    'buah' => 'Buah',
                                    'batang' => 'Batang',
                                    'lembar' => 'Lembar',
                                    'titik' => 'Titik',
                                    'meter' => 'Meter',
                                    'm²' => 'Meter Persegi (m²)',
                                    'm³' => 'Meter Kubik (m³)',
                                    'kg' => 'Kilogram (kg)',
                                    'ton' => 'Ton',
                                    'liter' => 'Liter',
                                    'hari' => 'Hari',
                                    'minggu' => 'Minggu',
                                    'bulan' => 'Bulan',
                                    'paket' => 'Paket',
                                    'ls' => 'Lumpsum (LS)',
                                ] as $unitValue => $unitLabel)
                                    <option value="{{ $unitValue }}">
                                        {{ $unitLabel }}
                                    </option>
                                @endforeach
                            </select>

                            @error("items.$index.unit")
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="lg:col-span-3">
                            <label
                                for="item-price-{{ $index }}"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Harga Satuan
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="item-price-{{ $index }}"
                                type="number"
                                wire:model.live.debounce.300ms="items.{{ $index }}.price"
                                min="0"
                                step="0.01"
                                class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                            @error("items.$index.price")
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="lg:col-span-12">
                            <label
                                for="item-description-{{ $index }}"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Deskripsi
                            </label>

                            <textarea
                                id="item-description-{{ $index }}"
                                wire:model="items.{{ $index }}.description"
                                rows="2"
                                placeholder="Deskripsi tambahan item..."
                                class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            ></textarea>

                            @error("items.$index.description")
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5 flex items-center justify-between border-t border-gray-200 pt-4">
                        <span class="text-sm text-gray-500">
                            Total Item
                        </span>

                        <span class="font-semibold text-gray-800">
                            Rp {{ number_format(
                                $itemTotal,
                                0,
                                ',',
                                '.'
                            ) }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <button
            type="button"
            wire:click="addItem"
            class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
        >
            <span class="text-lg">+</span>
            Tambah Item
        </button>
    </div>
</x-ui.info-card>