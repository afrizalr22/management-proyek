@props([
    'search' => '',
    'status' => '',
    'sort' => 'latest',
])

@php
    $statusOptions = [
        '' => [
            'label' => 'Semua Status',
            'dot' => 'bg-gray-400',
        ],
        'draft' => [
            'label' => 'Draft',
            'dot' => 'bg-amber-500',
        ],
        'sent' => [
            'label' => 'Dikirim',
            'dot' => 'bg-blue-500',
        ],
        'received' => [
            'label' => 'Diterima',
            'dot' => 'bg-green-500',
        ],
        'cancelled' => [
            'label' => 'Dibatalkan',
            'dot' => 'bg-red-500',
        ],
    ];

    $sortOptions = [
        'latest' => 'Terbaru',
        'oldest' => 'Terlama',
        'delivery_date_desc' => 'Tanggal Kirim Terbaru',
        'delivery_date_asc' => 'Tanggal Kirim Terlama',
        'number_asc' => 'Nomor A–Z',
        'number_desc' => 'Nomor Z–A',
    ];

    $selectedStatus = $statusOptions[$status]
        ?? $statusOptions[''];

    $selectedSort = $sortOptions[$sort]
        ?? $sortOptions['latest'];
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        <div
            class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-12"
        >
            {{-- Pencarian --}}
            <div class="xl:col-span-5">
                <label
                    for="delivery-order-search"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Pencarian
                </label>

                <div class="relative">
                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
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
                                d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"
                            />
                        </svg>
                    </div>

                    <input
                        id="delivery-order-search"
                        type="search"
                        wire:model.live.debounce.400ms="search"
                        placeholder="Cari nomor, project, penerima..."
                        autocomplete="off"
                        class="min-h-11 w-full rounded-xl border-gray-300 py-2.5 pl-11 pr-4 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>
            </div>

            {{-- Filter Status --}}
            <div
                x-data="{ open: false }"
                x-on:keydown.escape.window="open = false"
                class="relative xl:col-span-3"
            >
                <label
                    id="delivery-order-status-label"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Status
                </label>

                <button
                    type="button"
                    x-on:click="open = ! open"
                    x-bind:aria-expanded="open"
                    aria-haspopup="listbox"
                    aria-labelledby="delivery-order-status-label"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 transition hover:border-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                >
                    <span class="flex min-w-0 items-center gap-2">
                        <span
                            class="h-2.5 w-2.5 shrink-0 rounded-full {{ $selectedStatus['dot'] }}"
                        ></span>

                        <span class="truncate">
                            {{ $selectedStatus['label'] }}
                        </span>
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-4 w-4 shrink-0 text-gray-400 transition-transform duration-200"
                        x-bind:class="{ 'rotate-180': open }"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m19.5 8.25-7.5 7.5-7.5-7.5"
                        />
                    </svg>
                </button>

                <div
                    x-cloak
                    x-show="open"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    x-on:click.outside="open = false"
                    class="absolute left-0 top-full z-50 mt-2 w-full min-w-56 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                    role="listbox"
                >
                    @foreach ($statusOptions as $statusValue => $statusOption)
                        <button
                            type="button"
                            wire:click="$set('status', '{{ $statusValue }}')"
                            x-on:click="open = false"
                            role="option"
                            @class([
                                'flex w-full items-center justify-between gap-3 px-4 py-3 text-left text-sm transition hover:bg-gray-50',
                                'bg-blue-50 font-semibold text-blue-700' =>
                                    $status === $statusValue,
                                'text-gray-700' =>
                                    $status !== $statusValue,
                            ])
                        >
                            <span class="flex min-w-0 items-center gap-3">
                                <span
                                    class="h-2.5 w-2.5 shrink-0 rounded-full {{ $statusOption['dot'] }}"
                                ></span>

                                <span class="truncate">
                                    {{ $statusOption['label'] }}
                                </span>
                            </span>

                            @if ($status === $statusValue)
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2.5"
                                    stroke="currentColor"
                                    class="h-4 w-4 shrink-0 text-blue-600"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m4.5 12.75 6 6 9-13.5"
                                    />
                                </svg>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Urutkan --}}
            <div
                x-data="{ open: false }"
                x-on:keydown.escape.window="open = false"
                class="relative xl:col-span-3"
            >
                <label
                    id="delivery-order-sort-label"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Urutkan
                </label>

                <button
                    type="button"
                    x-on:click="open = ! open"
                    x-bind:aria-expanded="open"
                    aria-haspopup="listbox"
                    aria-labelledby="delivery-order-sort-label"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 transition hover:border-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                >
                    <span class="truncate">
                        {{ $selectedSort }}
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-4 w-4 shrink-0 text-gray-400 transition-transform duration-200"
                        x-bind:class="{ 'rotate-180': open }"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m19.5 8.25-7.5 7.5-7.5-7.5"
                        />
                    </svg>
                </button>

                <div
                    x-cloak
                    x-show="open"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    x-on:click.outside="open = false"
                    class="absolute right-0 top-full z-50 mt-2 w-full min-w-64 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                    role="listbox"
                >
                    @foreach ($sortOptions as $sortValue => $sortLabel)
                        <button
                            type="button"
                            wire:click="$set('sort', '{{ $sortValue }}')"
                            x-on:click="open = false"
                            role="option"
                            @class([
                                'flex w-full items-center justify-between gap-3 px-4 py-3 text-left text-sm transition hover:bg-gray-50',
                                'bg-blue-50 font-semibold text-blue-700' =>
                                    $sort === $sortValue,
                                'text-gray-700' =>
                                    $sort !== $sortValue,
                            ])
                        >
                            <span>
                                {{ $sortLabel }}
                            </span>

                            @if ($sort === $sortValue)
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2.5"
                                    stroke="currentColor"
                                    class="h-4 w-4 shrink-0 text-blue-600"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m4.5 12.75 6 6 9-13.5"
                                    />
                                </svg>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Reset --}}
            <div class="flex items-end xl:col-span-1">
                <button
                    type="button"
                    wire:click="resetFilters"
                    wire:loading.attr="disabled"
                    title="Reset filter"
                    aria-label="Reset filter"
                    class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm font-semibold text-gray-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 disabled:cursor-wait disabled:opacity-60"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5 shrink-0"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.023 9.348h4.992V4.356m-1.681 4.992A9 9 0 1 0 21 12"
                        />
                    </svg>

                    <span class="xl:hidden">
                        Reset
                    </span>
                </button>
            </div>
        </div>
    </div>
</x-ui.info-card>