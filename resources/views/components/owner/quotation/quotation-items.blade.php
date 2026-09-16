@props([
    'items' => [],
    'subtotal' => 0,
    'totalQuantity' => 0,
])

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900 sm:text-2xl">
                    Item Quotation
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-500 sm:text-base">
                    Tambahkan rincian pekerjaan, material, quantity, dan harga.
                </p>
            </div>

            <button
                type="button"
                wire:click="addItem"
                wire:loading.attr="disabled"
                wire:target="addItem"
                class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-60"
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

        <hr class="my-6 border-gray-200 sm:my-8">

        {{-- Error item secara umum --}}
        @error('items')
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $message }}
            </div>
        @enderror

        {{-- Daftar item --}}
        <div class="space-y-6">
            @foreach ($items as $index => $item)
                @php
                    $quantity = (float) ($item['qty'] ?? 0);
                    $price = (float) ($item['price'] ?? 0);
                    $itemTotal = $quantity * $price;
                @endphp

                <section
                    wire:key="quotation-item-{{ $index }}"
                    class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6"
                >
                    {{-- Header item --}}
                    <div class="mb-6 flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-semibold text-gray-900">
                                Item #{{ $index + 1 }}
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Masukkan detail pekerjaan atau material.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="removeItem({{ $index }})"
                            wire:loading.attr="disabled"
                            wire:target="removeItem({{ $index }})"
                            @disabled(count($items) <= 1)
                            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 transition hover:bg-red-200 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-400"
                            title="{{ count($items) <= 1
                                ? 'Minimal satu item'
                                : 'Hapus item' }}"
                            aria-label="Hapus item {{ $index + 1 }}"
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
                                    d="M19 7H5m5 4v6m4-6v6M9 7V4h6v3m-9 0 1 13h10l1-13"
                                />
                            </svg>
                        </button>
                    </div>

                    {{-- Nama item --}}
                    <div>
                        <label
                            for="item-name-{{ $index }}"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Nama Item
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="item-name-{{ $index }}"
                            type="text"
                            wire:model.blur="items.{{ $index }}.item_name"
                            placeholder="Contoh: Pengecoran beton K-300"
                            class="block min-h-12 w-full rounded-xl border bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:ring-4
                                @error("items.$index.item_name")
                                    border-red-400 focus:border-red-500 focus:ring-red-100
                                @else
                                    border-gray-300 focus:border-blue-500 focus:ring-blue-100
                                @enderror"
                        >

                        @error("items.$index.item_name")
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Quantity, satuan, harga dan total --}}
                    <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-12">

                        {{-- Quantity --}}
                        <div class="xl:col-span-2">
                            <label
                                for="item-qty-{{ $index }}"
                                class="mb-2 block text-sm font-semibold text-gray-700"
                            >
                                Quantity
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="item-qty-{{ $index }}"
                                type="number"
                                wire:model.live.debounce.300ms="items.{{ $index }}.qty"
                                min="0.01"
                                step="0.01"
                                inputmode="decimal"
                                class="block min-h-12 w-full rounded-xl border bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:ring-4
                                    @error("items.$index.qty")
                                        border-red-400 focus:border-red-500 focus:ring-red-100
                                    @else
                                        border-gray-300 focus:border-blue-500 focus:ring-blue-100
                                    @enderror"
                            >

                            @error("items.$index.qty")
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Satuan --}}
                        <div class="xl:col-span-3">
                            <label
                                for="item-unit-{{ $index }}"
                                class="mb-2 block text-sm font-semibold text-gray-700"
                            >
                                Satuan
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="item-unit-{{ $index }}"
                                wire:model="items.{{ $index }}.unit"
                                class="block min-h-12 w-full rounded-xl border bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:ring-4
                                    @error("items.$index.unit")
                                        border-red-400 focus:border-red-500 focus:ring-red-100
                                    @else
                                        border-gray-300 focus:border-blue-500 focus:ring-blue-100
                                    @enderror"
                            >
                                <option value="">
                                    Pilih satuan
                                </option>

                                <option value="unit">Unit</option>
                                <option value="pcs">Pcs</option>
                                <option value="set">Set</option>
                                <option value="lot">Lot</option>
                                <option value="meter">Meter</option>
                                <option value="m2">m²</option>
                                <option value="m3">m³</option>
                                <option value="kg">Kg</option>
                                <option value="hari">Hari</option>
                                <option value="orang">Orang</option>
                            </select>

                            @error("items.$index.unit")
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Harga satuan --}}
                        <div class="sm:col-span-1 xl:col-span-4">
                            <label
                                for="item-price-{{ $index }}"
                                class="mb-2 block text-sm font-semibold text-gray-700"
                            >
                                Harga Satuan
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="flex">
                                <span class="flex min-h-12 items-center rounded-l-xl border border-r-0 border-gray-300 bg-gray-100 px-4 text-sm font-medium text-gray-600">
                                    Rp
                                </span>

                                <input
                                    id="item-price-{{ $index }}"
                                    type="number"
                                    wire:model.live.debounce.300ms="items.{{ $index }}.price"
                                    min="0"
                                    step="1"
                                    inputmode="numeric"
                                    placeholder="0"
                                    class="block min-h-12 w-full rounded-r-xl border bg-white px-4 py-3 text-right text-sm text-gray-900 outline-none transition focus:ring-4
                                        @error("items.$index.price")
                                            border-red-400 focus:border-red-500 focus:ring-red-100
                                        @else
                                            border-gray-300 focus:border-blue-500 focus:ring-blue-100
                                        @enderror"
                                >
                            </div>

                            @error("items.$index.price")
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Total item --}}
                        <div class="sm:col-span-1 xl:col-span-3">
                            <p class="mb-2 block text-sm font-semibold text-gray-700">
                                Total
                            </p>

                            <div class="flex min-h-12 items-center justify-end rounded-xl bg-gray-100 px-4 text-sm font-semibold text-gray-800">
                                Rp {{ number_format(
                                    $itemTotal,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mt-6">
                        <label
                            for="item-description-{{ $index }}"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Deskripsi
                        </label>

                        <textarea
                            id="item-description-{{ $index }}"
                            wire:model.blur="items.{{ $index }}.description"
                            rows="4"
                            maxlength="2000"
                            placeholder="Jelaskan pekerjaan, material, atau lingkup item."
                            class="block w-full resize-y rounded-xl border bg-white px-4 py-3 text-sm leading-6 text-gray-900 outline-none transition focus:ring-4
                                @error("items.$index.description")
                                    border-red-400 focus:border-red-500 focus:ring-red-100
                                @else
                                    border-gray-300 focus:border-blue-500 focus:ring-blue-100
                                @enderror"
                        ></textarea>

                        @error("items.$index.description")
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @else
                            <p class="mt-2 text-xs text-gray-500">
                                Maksimal 2.000 karakter.
                            </p>
                        @enderror
                    </div>
                </section>
            @endforeach
        </div>

        {{-- Ringkasan item --}}
        <div class="mt-8 rounded-2xl border border-gray-200 bg-gray-50 p-5 sm:p-6">
            <h3 class="text-lg font-bold text-gray-900">
                Ringkasan Item
            </h3>

            <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div>
                    <p class="text-sm text-gray-500">
                        Jumlah Item
                    </p>

                    <p class="mt-1 text-xl font-bold text-gray-900">
                        {{ count($items) }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Total Quantity
                    </p>

                    <p class="mt-1 text-xl font-bold text-gray-900">
                        {{ number_format(
                            (float) $totalQuantity,
                            2,
                            ',',
                            '.'
                        ) }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Subtotal
                    </p>

                    <p class="mt-1 text-xl font-bold text-blue-600">
                        Rp {{ number_format(
                            (float) $subtotal,
                            0,
                            ',',
                            '.'
                        ) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-ui.info-card>