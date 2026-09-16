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

<div class="rounded-xl border border-gray-200 bg-white p-4">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        {{-- Pencarian --}}
        <div class="w-full lg:max-w-sm">
            <x-ui.search
                wire:model.live.debounce.300ms="search"
                placeholder="Cari Client..."
            />
        </div>

        {{-- Filter, urutan, dan reset --}}
        <div class="grid w-full grid-cols-1 gap-3 sm:grid-cols-2 lg:flex lg:w-auto lg:items-center">

            {{-- Filter status --}}
            <div
                x-data="{ open: false }"
                class="relative min-w-0 lg:w-52 xl:w-56"
            >
                <button
                    type="button"
                    @click="open = !open"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <span class="truncate">
                        {{ $statusLabel }}
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 shrink-0 text-gray-500 transition duration-200"
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
                    class="absolute left-0 right-0 z-50 mt-2 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl lg:left-auto lg:w-full"
                >
                    <button
                        type="button"
                        wire:click="$set('status', '')"
                        @click="open = false"
                        class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-gray-300"></span>
                        <span>Semua Status</span>
                    </button>

                    <button
                        type="button"
                        wire:click="$set('status', 'active')"
                        @click="open = false"
                        class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-green-500"></span>
                        <span>Aktif</span>
                    </button>

                    <button
                        type="button"
                        wire:click="$set('status', 'lead')"
                        @click="open = false"
                        class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-yellow-400"></span>
                        <span>Lead</span>
                    </button>

                    <button
                        type="button"
                        wire:click="$set('status', 'inactive')"
                        @click="open = false"
                        class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-red-500"></span>
                        <span>Nonaktif</span>
                    </button>
                </div>
            </div>

            {{-- Pengurutan --}}
            <div
                x-data="{ open: false }"
                class="relative min-w-0 lg:w-52 xl:w-56"
            >
                <button
                    type="button"
                    @click="open = !open"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <span class="truncate">
                        {{ $sortLabel }}
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 shrink-0 text-gray-500 transition duration-200"
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
                    class="absolute left-0 right-0 z-50 mt-2 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl lg:left-auto lg:w-full"
                >
                    <button
                        type="button"
                        wire:click="$set('sort', 'latest')"
                        @click="open = false"
                        class="block w-full px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        Terbaru
                    </button>

                    <button
                        type="button"
                        wire:click="$set('sort', 'oldest')"
                        @click="open = false"
                        class="block w-full px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        Terlama
                    </button>

                    <button
                        type="button"
                        wire:click="$set('sort', 'company_asc')"
                        @click="open = false"
                        class="block w-full px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        Perusahaan A–Z
                    </button>

                    <button
                        type="button"
                        wire:click="$set('sort', 'company_desc')"
                        @click="open = false"
                        class="block w-full px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        Perusahaan Z–A
                    </button>
                </div>
            </div>

            {{-- Reset --}}
            <button
                type="button"
                wire:click="resetFilters"
                wire:loading.attr="disabled"
                wire:target="resetFilters"
                class="inline-flex min-h-11 w-full items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-600 shadow-sm transition hover:border-blue-400 hover:bg-gray-50 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-50 sm:col-span-2 lg:w-auto"
            >
                <span wire:loading.remove wire:target="resetFilters">
                    Reset
                </span>

                <span wire:loading wire:target="resetFilters">
                    Mereset...
                </span>
            </button>
        </div>
    </div>
</div>