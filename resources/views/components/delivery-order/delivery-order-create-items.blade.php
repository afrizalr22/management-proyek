@props([
    'items' => [],
])

@php
    $unitOptions = [
        'unit' => 'Unit',
        'pcs' => 'Pcs',
        'set' => 'Set',
        'buah' => 'Buah',
        'batang' => 'Batang',
        'lembar' => 'Lembar',
        'sak' => 'Sak',
        'dus' => 'Dus',
        'box' => 'Box',
        'roll' => 'Roll',
        'titik' => 'Titik',
        'meter' => 'Meter',
        'm²' => 'Meter Persegi (m²)',
        'm³' => 'Meter Kubik (m³)',
        'kg' => 'Kilogram (kg)',
        'ton' => 'Ton',
        'liter' => 'Liter',
        'paket' => 'Paket',
        'ls' => 'Lumpsum (LS)',
    ];

    $conditionOptions = [
        'good' => 'Baik',
        'damaged' => 'Rusak',
    ];
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Item Pengiriman
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Masukkan barang atau material yang dikirim.
                </p>
            </div>

            <button
                type="button"
                wire:click="addItem"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 py-2.5 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="h-4 w-4"
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
                class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                role="alert"
            >
                {{ $message }}
            </div>
        @enderror

        <div class="space-y-5">
            @foreach ($items as $index => $item)
                <div
                    wire:key="delivery-order-item-{{ $index }}"
                    class="rounded-2xl border border-gray-200 bg-gray-50 p-4 sm:p-5"
                >
                    <div class="mb-5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">
                                {{ $index + 1 }}
                            </span>

                            <h3 class="font-semibold text-gray-800">
                                Item Pengiriman
                            </h3>
                        </div>

                        <button
                            type="button"
                            wire:click="removeItem({{ $index }})"
                            @disabled(count($items) <= 1)
                            title="Hapus item"
                            aria-label="Hapus item {{ $index + 1 }}"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-red-500 transition hover:bg-red-100 disabled:cursor-not-allowed disabled:text-gray-300 disabled:hover:bg-transparent"
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
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M18.228 5.79 17.16 19.673A2.25 2.25 0 0 1 14.916 21.75H9.084a2.25 2.25 0 0 1-2.244-2.077L5.772 5.79m12.456 0a48.108 48.108 0 0 0-3.478-.397m-9 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m4.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-1.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m5.5 0a48.667 48.667 0 0 0-5.5 0"
                                />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        {{-- Nama item --}}
                        <div>
                            <label
                                for="delivery-item-name-{{ $index }}"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Nama Item

                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="delivery-item-name-{{ $index }}"
                                type="text"
                                wire:model="items.{{ $index }}.item_name"
                                placeholder="Contoh: Semen Portland"
                                maxlength="255"
                                @class([
                                    'w-full rounded-xl bg-white px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500',
                                    'border-red-300' => $errors->has("items.{$index}.item_name"),
                                    'border-gray-300' => !$errors->has("items.{$index}.item_name"),
                                ])
                            >

                            @error("items.{$index}.item_name")
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            {{-- Quantity --}}
                            <div>
                                <label
                                    for="delivery-item-qty-{{ $index }}"
                                    class="mb-2 block text-sm font-medium text-gray-700"
                                >
                                    Jumlah

                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    id="delivery-item-qty-{{ $index }}"
                                    type="number"
                                    wire:model="items.{{ $index }}.qty"
                                    min="0.01"
                                    max="99999999.99"
                                    step="0.01"
                                    @class([
                                        'w-full rounded-xl bg-white px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500',
                                        'border-red-300' => $errors->has("items.{$index}.qty"),
                                        'border-gray-300' => !$errors->has("items.{$index}.qty"),
                                    ])
                                >

                                @error("items.{$index}.qty")
                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Satuan --}}
                            <div>
                                <label
                                    for="delivery-item-unit-{{ $index }}"
                                    class="mb-2 block text-sm font-medium text-gray-700"
                                >
                                    Satuan

                                    <span class="text-red-500">*</span>
                                </label>

                                <select
                                    id="delivery-item-unit-{{ $index }}"
                                    wire:model="items.{{ $index }}.unit"
                                    @class([
                                        'w-full rounded-xl bg-white px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500',
                                        'border-red-300' => $errors->has("items.{$index}.unit"),
                                        'border-gray-300' => !$errors->has("items.{$index}.unit"),
                                    ])
                                >
                                    <option value="">
                                        Pilih Satuan
                                    </option>

                                    @foreach ($unitOptions as $unitValue => $unitLabel)
                                        <option value="{{ $unitValue }}">
                                            {{ $unitLabel }}
                                        </option>
                                    @endforeach
                                </select>

                                @error("items.{$index}.unit")
                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Kondisi --}}
                            <div>
                                <label
                                    for="delivery-item-condition-{{ $index }}"
                                    class="mb-2 block text-sm font-medium text-gray-700"
                                >
                                    Kondisi

                                    <span class="text-red-500">*</span>
                                </label>

                                <select
                                    id="delivery-item-condition-{{ $index }}"
                                    wire:model="items.{{ $index }}.condition"
                                    @class([
                                        'w-full rounded-xl bg-white px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500',
                                        'border-red-300' => $errors->has("items.{$index}.condition"),
                                        'border-gray-300' => !$errors->has("items.{$index}.condition"),
                                    ])
                                >
                                    @foreach ($conditionOptions as $conditionValue => $conditionLabel)
                                        <option value="{{ $conditionValue }}">
                                            {{ $conditionLabel }}
                                        </option>
                                    @endforeach
                                </select>

                                @error("items.{$index}.condition")
                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label
                                for="delivery-item-description-{{ $index }}"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Deskripsi
                            </label>

                            <textarea
                                id="delivery-item-description-{{ $index }}"
                                wire:model="items.{{ $index }}.description"
                                rows="2"
                                maxlength="2000"
                                placeholder="Keterangan tambahan item"
                                @class([
                                    'w-full resize-y rounded-xl bg-white px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500',
                                    'border-red-300' => $errors->has("items.{$index}.description"),
                                    'border-gray-300' => !$errors->has("items.{$index}.description"),
                                ])
                            ></textarea>

                            @error("items.{$index}.description")
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-ui.info-card>