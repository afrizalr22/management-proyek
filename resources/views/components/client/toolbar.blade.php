@props([
    'search' => '',
    'status' => '',
    'sort' => 'latest',
])

@php
    $statusLabel = match ($status) {
        'active' => 'Aktif',
        'lead' => 'Lead',
        'inactive' => 'Nonaktif',
        default => 'Semua Status',
    };

    $sortLabel = match ($sort) {
        'oldest' => 'Terlama',
        'company_asc' => 'Perusahaan A–Z',
        'company_desc' => 'Perusahaan Z–A',
        default => 'Terbaru',
    };
@endphp

<x-ui.toolbar>

    <x-slot:left>
        <x-ui.search
            wire:model.live.debounce.300ms="search"
            placeholder="Cari Client..."
        />
    </x-slot:left>

    <x-slot:right>

        {{-- Filter status --}}
        <div
            x-data="{ open: false }"
            class="relative w-56"
        >
            <button
                type="button"
                @click="open = !open"
                class="flex w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100"
            >
                <span>{{ $statusLabel }}</span>

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-gray-500 transition duration-200"
                    :class="{ 'rotate-180': open }"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>
            </button>

            <div
                x-cloak
                x-show="open"
                x-transition.origin.top
                @click.outside="open = false"
                class="absolute right-0 z-50 mt-2 w-full overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl"
            >
                <button
                    type="button"
                    wire:click="$set('status', '')"
                    @click="open = false"
                    class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-gray-100"
                >
                    <span class="h-2.5 w-2.5"></span>
                    <span>Semua Status</span>
                </button>

                <button
                    type="button"
                    wire:click="$set('status', 'active')"
                    @click="open = false"
                    class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-gray-100"
                >
                    <span class="h-2.5 w-2.5 rounded-full bg-green-500"></span>
                    <span>Aktif</span>
                </button>

                <button
                    type="button"
                    wire:click="$set('status', 'lead')"
                    @click="open = false"
                    class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-gray-100"
                >
                    <span class="h-2.5 w-2.5 rounded-full bg-yellow-400"></span>
                    <span>Lead</span>
                </button>

                <button
                    type="button"
                    wire:click="$set('status', 'inactive')"
                    @click="open = false"
                    class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-gray-100"
                >
                    <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>
                    <span>Nonaktif</span>
                </button>
            </div>
        </div>

        {{-- Pengurutan --}}
        <div
            x-data="{ open: false }"
            class="relative w-56"
        >
            <button
                type="button"
                @click="open = !open"
                class="flex w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100"
            >
                <span>{{ $sortLabel }}</span>

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-gray-500 transition duration-200"
                    :class="{ 'rotate-180': open }"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>
            </button>

            <div
                x-cloak
                x-show="open"
                x-transition.origin.top
                @click.outside="open = false"
                class="absolute right-0 z-50 mt-2 w-full overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl"
            >
                <button
                    type="button"
                    wire:click="$set('sort', 'latest')"
                    @click="open = false"
                    class="block w-full px-4 py-2.5 text-left text-sm transition hover:bg-gray-100"
                >
                    Terbaru
                </button>

                <button
                    type="button"
                    wire:click="$set('sort', 'oldest')"
                    @click="open = false"
                    class="block w-full px-4 py-2.5 text-left text-sm transition hover:bg-gray-100"
                >
                    Terlama
                </button>

                <button
                    type="button"
                    wire:click="$set('sort', 'company_asc')"
                    @click="open = false"
                    class="block w-full px-4 py-2.5 text-left text-sm transition hover:bg-gray-100"
                >
                    Perusahaan A–Z
                </button>

                <button
                    type="button"
                    wire:click="$set('sort', 'company_desc')"
                    @click="open = false"
                    class="block w-full px-4 py-2.5 text-left text-sm transition hover:bg-gray-100"
                >
                    Perusahaan Z–A
                </button>
            </div>
        </div>

        <button
            type="button"
            wire:click="resetFilters"
            wire:loading.attr="disabled"
            wire:target="resetFilters"
            class="rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-600 shadow-sm transition hover:border-blue-400 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50"
        >
            <span wire:loading.remove wire:target="resetFilters">
                Reset
            </span>

            <span wire:loading wire:target="resetFilters">
                Mereset...
            </span>
        </button>

    </x-slot:right>

</x-ui.toolbar>