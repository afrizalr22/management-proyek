@props([
    'search' => '',
    'status' => '',
    'sort' => 'latest',
])

@php
    $statusLabel = match ($status) {
        'planning' => 'Perencanaan',
        'on_progress',
        'in_progress',
        'ongoing' => 'Sedang Berjalan',
        'on_hold' => 'Ditunda',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
        default => 'Semua Status',
    };

    $sortLabel = match ($sort) {
        'oldest' => 'Terlama',
        'name_asc' => 'Nama A–Z',
        'name_desc' => 'Nama Z–A',
        'progress_highest' => 'Progres Tertinggi',
        'progress_lowest' => 'Progres Terendah',
        'deadline_nearest' => 'Deadline Terdekat',
        default => 'Terbaru',
    };
@endphp

<x-ui.toolbar>
    <x-slot:left>
        <div class="w-full">
            <x-ui.search
                wire:model.live.debounce.300ms="search"
                placeholder="Cari kode, Project, Client, atau lokasi..."
            />
        </div>
    </x-slot:left>

    <x-slot:right>
        <div class="flex w-full flex-col gap-3 sm:flex-row sm:flex-wrap lg:w-auto lg:flex-nowrap">
            {{-- Filter status --}}
            <div
                x-data="{ open: false }"
                class="relative w-full sm:w-52"
            >
                <button
                    type="button"
                    x-on:click="open = !open"
                    class="flex min-h-11 w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <span class="truncate">
                        {{ $statusLabel }}
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-4 w-4 shrink-0 text-gray-500 transition"
                        x-bind:class="{
                            'rotate-180': open
                        }"
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
                    x-transition.origin.top
                    x-on:click.outside="open = false"
                    class="absolute right-0 z-50 mt-2 w-full overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                >
                    <button
                        type="button"
                        wire:click="$set('status', '')"
                        x-on:click="open = false"
                        class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        <span class="h-2.5 w-2.5 shrink-0"></span>
                        Semua Status
                    </button>

                    <button
                        type="button"
                        wire:click="$set('status', 'planning')"
                        x-on:click="open = false"
                        class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-yellow-400"></span>
                        Perencanaan
                    </button>

                    <button
                        type="button"
                        wire:click="$set('status', 'on_progress')"
                        x-on:click="open = false"
                        class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-blue-500"></span>
                        Sedang Berjalan
                    </button>

                    <button
                        type="button"
                        wire:click="$set('status', 'on_hold')"
                        x-on:click="open = false"
                        class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-gray-400"></span>
                        Ditunda
                    </button>

                    <button
                        type="button"
                        wire:click="$set('status', 'completed')"
                        x-on:click="open = false"
                        class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-green-500"></span>
                        Selesai
                    </button>

                    <button
                        type="button"
                        wire:click="$set('status', 'cancelled')"
                        x-on:click="open = false"
                        class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-red-500"></span>
                        Dibatalkan
                    </button>
                </div>
            </div>

            {{-- Pengurutan --}}
            <div
                x-data="{ open: false }"
                class="relative w-full sm:w-52"
            >
                <button
                    type="button"
                    x-on:click="open = !open"
                    class="flex min-h-11 w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <span class="truncate">
                        {{ $sortLabel }}
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-4 w-4 shrink-0 text-gray-500 transition"
                        x-bind:class="{
                            'rotate-180': open
                        }"
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
                    x-transition.origin.top
                    x-on:click.outside="open = false"
                    class="absolute right-0 z-50 mt-2 w-full overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                >
                    @foreach ([
                        'latest' => 'Terbaru',
                        'oldest' => 'Terlama',
                        'name_asc' => 'Nama A–Z',
                        'name_desc' => 'Nama Z–A',
                        'progress_highest' => 'Progres Tertinggi',
                        'progress_lowest' => 'Progres Terendah',
                        'deadline_nearest' => 'Deadline Terdekat',
                    ] as $sortValue => $sortText)
                        <button
                            type="button"
                            wire:click="$set(
                                'sort',
                                '{{ $sortValue }}'
                            )"
                            x-on:click="open = false"
                            class="block w-full px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                        >
                            {{ $sortText }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Reset --}}
            <button
                type="button"
                wire:click="resetFilters"
                wire:loading.attr="disabled"
                wire:target="resetFilters"
                class="inline-flex min-h-11 w-full items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-600 shadow-sm transition hover:border-blue-400 hover:bg-gray-50 hover:text-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-50 sm:w-auto"
            >
                <span
                    wire:loading.remove
                    wire:target="resetFilters"
                >
                    Reset
                </span>

                <span
                    wire:loading
                    wire:target="resetFilters"
                >
                    Mereset...
                </span>
            </button>
        </div>
    </x-slot:right>
</x-ui.toolbar>