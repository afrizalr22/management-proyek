@props([
    'search' => '',
    'status' => '',
    'mandorId' => '',
    'sort' => 'latest',
    'mandors',
])

@php
    $statusOptions = [
        '' => [
            'label' => 'Semua Status',
            'dot' => 'bg-gray-400',
        ],
        'planning' => [
            'label' => 'Perencanaan',
            'dot' => 'bg-amber-500',
        ],
        'in_progress' => [
            'label' => 'Berjalan',
            'dot' => 'bg-blue-500',
        ],
        'completed' => [
            'label' => 'Selesai',
            'dot' => 'bg-green-500',
        ],
        'on_hold' => [
            'label' => 'Ditunda',
            'dot' => 'bg-gray-500',
        ],
        'cancelled' => [
            'label' => 'Dibatalkan',
            'dot' => 'bg-red-500',
        ],
        'delayed' => [
            'label' => 'Terlambat',
            'dot' => 'bg-red-500',
        ],
    ];

    $sortOptions = [
        'latest' => 'Terbaru',
        'oldest' => 'Terlama',
        'progress_desc' => 'Progress Tertinggi',
        'progress_asc' => 'Progress Terendah',
        'deadline_asc' => 'Deadline Terdekat',
        'deadline_desc' => 'Deadline Terjauh',
        'name_asc' => 'Nama A–Z',
        'name_desc' => 'Nama Z–A',
    ];

    $selectedStatus = $statusOptions[$status]
        ?? $statusOptions[''];

    $selectedMandor = $mandors->firstWhere(
        'id',
        (int) $mandorId
    );

    $selectedMandorLabel = $selectedMandor?->name
        ?? 'Semua Mandor';

    $selectedSort = $sortOptions[$sort]
        ?? $sortOptions['latest'];
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-12">
            {{-- Pencarian --}}
            <div class="xl:col-span-4">
                <label
                    for="monitoring-search"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Pencarian
                </label>

                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
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
                        id="monitoring-search"
                        type="search"
                        wire:model.live.debounce.400ms="search"
                        placeholder="Cari Project, Client, Mandor..."
                        autocomplete="off"
                        class="min-h-11 w-full rounded-xl border-gray-300 py-2.5 pl-11 pr-4 text-sm placeholder:text-gray-400 focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>
            </div>

            {{-- Status --}}
            <div
                x-data="{ open: false }"
                x-on:keydown.escape.window="open = false"
                class="relative xl:col-span-2"
            >
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Status
                </label>

                <button
                    type="button"
                    x-on:click="open = ! open"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 transition hover:border-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                >
                    <span class="flex min-w-0 items-center gap-2">
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $selectedStatus['dot'] }}"></span>

                        <span class="truncate">
                            {{ $selectedStatus['label'] }}
                        </span>
                    </span>

                    <span
                        class="text-gray-400 transition-transform"
                        x-bind:class="{ 'rotate-180': open }"
                    >
                        ▾
                    </span>
                </button>

                <div
                    x-cloak
                    x-show="open"
                    x-on:click.outside="open = false"
                    x-transition
                    class="absolute left-0 top-full z-50 mt-2 w-full min-w-52 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                >
                    @foreach ($statusOptions as $statusValue => $statusOption)
                        <button
                            type="button"
                            wire:click="$set('status', '{{ $statusValue }}')"
                            x-on:click="open = false"
                            @class([
                                'flex w-full items-center justify-between gap-3 px-4 py-3 text-left text-sm transition hover:bg-gray-50',
                                'bg-blue-50 font-semibold text-blue-700' =>
                                    $status === $statusValue,
                                'text-gray-700' =>
                                    $status !== $statusValue,
                            ])
                        >
                            <span class="flex items-center gap-3">
                                <span class="h-2.5 w-2.5 rounded-full {{ $statusOption['dot'] }}"></span>

                                {{ $statusOption['label'] }}
                            </span>

                            @if ($status === $statusValue)
                                <span class="text-blue-600">
                                    ✓
                                </span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Mandor --}}
            <div
                x-data="{ open: false }"
                x-on:keydown.escape.window="open = false"
                class="relative xl:col-span-2"
            >
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Mandor
                </label>

                <button
                    type="button"
                    x-on:click="open = ! open"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 transition hover:border-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                >
                    <span class="truncate">
                        {{ $selectedMandorLabel }}
                    </span>

                    <span
                        class="text-gray-400 transition-transform"
                        x-bind:class="{ 'rotate-180': open }"
                    >
                        ▾
                    </span>
                </button>

                <div
                    x-cloak
                    x-show="open"
                    x-on:click.outside="open = false"
                    x-transition
                    class="absolute left-0 top-full z-50 mt-2 w-full min-w-52 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                >
                    <button
                        type="button"
                        wire:click="$set('mandorId', '')"
                        x-on:click="open = false"
                        @class([
                            'flex w-full items-center justify-between gap-3 px-4 py-3 text-left text-sm transition hover:bg-gray-50',
                            'bg-blue-50 font-semibold text-blue-700' =>
                                $mandorId === '',
                            'text-gray-700' =>
                                $mandorId !== '',
                        ])
                    >
                        Semua Mandor

                        @if ($mandorId === '')
                            <span class="text-blue-600">
                                ✓
                            </span>
                        @endif
                    </button>

                    @foreach ($mandors as $mandor)
                        <button
                            type="button"
                            wire:click="$set('mandorId', '{{ $mandor->id }}')"
                            x-on:click="open = false"
                            @class([
                                'flex w-full items-center justify-between gap-3 px-4 py-3 text-left text-sm transition hover:bg-gray-50',
                                'bg-blue-50 font-semibold text-blue-700' =>
                                    (string) $mandorId === (string) $mandor->id,
                                'text-gray-700' =>
                                    (string) $mandorId !== (string) $mandor->id,
                            ])
                        >
                            <span class="truncate">
                                {{ $mandor->name }}
                            </span>

                            @if (
                                (string) $mandorId
                                === (string) $mandor->id
                            )
                                <span class="text-blue-600">
                                    ✓
                                </span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Urutan --}}
            <div
                x-data="{ open: false }"
                x-on:keydown.escape.window="open = false"
                class="relative xl:col-span-3"
            >
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Urutkan
                </label>

                <button
                    type="button"
                    x-on:click="open = ! open"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 transition hover:border-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                >
                    <span class="truncate">
                        {{ $selectedSort }}
                    </span>

                    <span
                        class="text-gray-400 transition-transform"
                        x-bind:class="{ 'rotate-180': open }"
                    >
                        ▾
                    </span>
                </button>

                <div
                    x-cloak
                    x-show="open"
                    x-on:click.outside="open = false"
                    x-transition
                    class="absolute right-0 top-full z-50 mt-2 w-full min-w-60 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                >
                    @foreach ($sortOptions as $sortValue => $sortLabel)
                        <button
                            type="button"
                            wire:click="$set('sort', '{{ $sortValue }}')"
                            x-on:click="open = false"
                            @class([
                                'flex w-full items-center justify-between gap-3 px-4 py-3 text-left text-sm transition hover:bg-gray-50',
                                'bg-blue-50 font-semibold text-blue-700' =>
                                    $sort === $sortValue,
                                'text-gray-700' =>
                                    $sort !== $sortValue,
                            ])
                        >
                            {{ $sortLabel }}

                            @if ($sort === $sortValue)
                                <span class="text-blue-600">
                                    ✓
                                </span>
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
                    class="inline-flex min-h-11 w-full items-center justify-center rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-gray-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 disabled:opacity-60"
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
                            d="M16.023 9.348h4.992V4.356m-1.681 4.992A9 9 0 1 0 21 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</x-ui.info-card>