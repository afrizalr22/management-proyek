@props([
    'search' => '',
    'category' => '',
    'date' => '',
    'sort' => 'latest',
])

@php
    $categoryOptions = [
        '' => [
            'label' => 'Semua Kategori',
            'color' => 'bg-gray-400',
        ],

        'progress' => [
            'label' => 'Progress',
            'color' => 'bg-blue-500',
        ],

        'material' => [
            'label' => 'Material',
            'color' => 'bg-amber-500',
        ],

        'safety' => [
            'label' => 'Keselamatan',
            'color' => 'bg-green-500',
        ],

        'obstacle' => [
            'label' => 'Kendala',
            'color' => 'bg-red-500',
        ],

        'other' => [
            'label' => 'Lainnya',
            'color' => 'bg-gray-500',
        ],
    ];

    $sortOptions = [
        'latest' => 'Terbaru',
        'oldest' => 'Terlama',
        'title_asc' => 'Judul A–Z',
        'title_desc' => 'Judul Z–A',
    ];

    $activeCategory =
        $categoryOptions[$category]
        ?? $categoryOptions[''];

    $activeSort =
        $sortOptions[$sort]
        ?? $sortOptions['latest'];

    $hasFilters =
        filled($search)
        || filled($category)
        || filled($date)
        || $sort !== 'latest';
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:items-end">
            {{-- Pencarian --}}
            <div class="lg:col-span-4">
                <label
                    for="documentation-search"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Cari Dokumentasi
                </label>

                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                            />
                        </svg>
                    </div>

                    <input
                        id="documentation-search"
                        type="search"
                        wire:model.live.debounce.400ms="search"
                        placeholder="Judul, Task, atau pengunggah..."
                        maxlength="255"
                        class="w-full rounded-xl border-gray-300 py-3 pl-11 pr-4 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>
            </div>

            {{-- Kategori --}}
            <div
                x-data="{ open: false }"
                x-on:click.outside="open = false"
                class="relative lg:col-span-2"
            >
                <label
                    id="documentation-category-label"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Kategori
                </label>

                <button
                    type="button"
                    x-on:click="open = ! open"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-3 text-left text-sm text-gray-700 transition hover:bg-gray-50 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    aria-labelledby="documentation-category-label"
                    x-bind:aria-expanded="open"
                >
                    <span class="flex min-w-0 items-center gap-2">
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $activeCategory['color'] }}"></span>

                        <span class="truncate">
                            {{ $activeCategory['label'] }}
                        </span>
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-4 w-4 shrink-0 text-gray-400 transition"
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
                    x-show="open"
                    x-transition
                    x-cloak
                    class="absolute left-0 top-full z-30 mt-2 w-full min-w-52 overflow-hidden rounded-xl border border-gray-200 bg-white p-1.5 shadow-xl"
                >
                    @foreach ($categoryOptions as $value => $option)
                        <button
                            type="button"
                            wire:click="$set('category', '{{ $value }}')"
                            x-on:click="open = false"
                            @class([
                                'flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm transition',
                                'bg-blue-50 font-semibold text-blue-700' =>
                                    $category === $value,
                                'text-gray-700 hover:bg-gray-100' =>
                                    $category !== $value,
                            ])
                        >
                            <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $option['color'] }}"></span>

                            <span>{{ $option['label'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Tanggal --}}
            <div class="lg:col-span-2">
                <label
                    for="documentation-date"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Tanggal
                </label>

                <input
                    id="documentation-date"
                    type="date"
                    wire:model.live="date"
                    class="min-h-11 w-full rounded-xl border-gray-300 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            {{-- Urutan --}}
            <div
                x-data="{ open: false }"
                x-on:click.outside="open = false"
                class="relative lg:col-span-2"
            >
                <label
                    id="documentation-sort-label"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Urutkan
                </label>

                <button
                    type="button"
                    x-on:click="open = ! open"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-3 text-left text-sm text-gray-700 transition hover:bg-gray-50 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    aria-labelledby="documentation-sort-label"
                    x-bind:aria-expanded="open"
                >
                    <span class="truncate">
                        {{ $activeSort }}
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-4 w-4 shrink-0 text-gray-400 transition"
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
                    x-show="open"
                    x-transition
                    x-cloak
                    class="absolute right-0 top-full z-30 mt-2 w-full min-w-48 overflow-hidden rounded-xl border border-gray-200 bg-white p-1.5 shadow-xl"
                >
                    @foreach ($sortOptions as $value => $label)
                        <button
                            type="button"
                            wire:click="$set('sort', '{{ $value }}')"
                            x-on:click="open = false"
                            @class([
                                'w-full rounded-lg px-3 py-2.5 text-left text-sm transition',
                                'bg-blue-50 font-semibold text-blue-700' =>
                                    $sort === $value,
                                'text-gray-700 hover:bg-gray-100' =>
                                    $sort !== $value,
                            ])
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Reset --}}
            <div class="lg:col-span-2">
                <button
                    type="button"
                    wire:click="resetFilters"
                    wire:loading.attr="disabled"
                    wire:target="resetFilters"
                    @class([
                        'inline-flex min-h-11 w-full items-center justify-center rounded-xl border px-4 py-3 text-sm font-semibold transition',
                        'border-gray-300 bg-white text-gray-700 hover:bg-gray-100' =>
                            $hasFilters,
                        'cursor-not-allowed border-gray-200 bg-gray-100 text-gray-400' =>
                            ! $hasFilters,
                    ])
                    @disabled(! $hasFilters)
                >
                    <span
                        wire:loading.remove
                        wire:target="resetFilters"
                    >
                        Reset Filter
                    </span>

                    <span
                        wire:loading
                        wire:target="resetFilters"
                    >
                        Memproses...
                    </span>
                </button>
            </div>
        </div>

        <div
            wire:loading.flex
            wire:target="search,category,date,sort,resetFilters"
            class="mt-4 items-center gap-2 text-sm text-blue-600"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                class="h-4 w-4 animate-spin"
            >
                <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                ></circle>

                <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"
                ></path>
            </svg>

            Memuat dokumentasi...
        </div>
    </div>
</x-ui.info-card>