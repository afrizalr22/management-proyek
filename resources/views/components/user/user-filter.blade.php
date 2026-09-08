@props([
    'search' => '',
    'role' => 'all',
    'status' => 'all',
    'sort' => 'latest',
])

@php
    $roleLabel = match ($role) {
        'owner' => 'Owner',
        'mandor' => 'Mandor',
        'pekerja' => 'Pekerja',
        default => 'Semua Role',
    };

    $roleDotColor = match ($role) {
        'owner' => 'bg-red-500',
        'mandor' => 'bg-blue-500',
        'pekerja' => 'bg-green-500',
        default => 'bg-gray-300',
    };

    $statusLabel = match ($status) {
        'active' => 'Aktif',
        'inactive' => 'Tidak Aktif',
        default => 'Semua Status',
    };

    $statusDotColor = match ($status) {
        'active' => 'bg-green-500',
        'inactive' => 'bg-red-500',
        default => 'bg-gray-300',
    };

    $sortLabel = match ($sort) {
        'oldest' => 'Terlama',
        'name_asc' => 'Nama A–Z',
        'name_desc' => 'Nama Z–A',
        default => 'Terbaru',
    };
@endphp

<x-ui.toolbar>
    <x-slot:left>
        <div class="w-full">
            <x-ui.search
                wire:model.live.debounce.300ms="search"
                placeholder="Cari nama, email, atau telepon..."
            />
        </div>
    </x-slot:left>

    <x-slot:right>
        <div class="flex w-full flex-col gap-3 sm:flex-row sm:flex-wrap lg:w-auto lg:flex-nowrap">
            {{-- Filter Role --}}
            <div
                x-data="{ open: false }"
                class="relative w-full sm:w-48"
            >
                <button
                    type="button"
                    @click="open = !open"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <span class="flex min-w-0 items-center gap-2">
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $roleDotColor }}"></span>

                        <span class="truncate">
                            {{ $roleLabel }}
                        </span>
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-4 w-4 shrink-0 text-gray-500 transition"
                        :class="{ 'rotate-180': open }"
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
                    @click.outside="open = false"
                    class="absolute right-0 z-50 mt-2 w-full overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                >
                    <button
                        type="button"
                        wire:click="$set('role', 'all')"
                        @click="open = false"
                        @class([
                            'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-gray-100',
                            'bg-gray-50 font-semibold text-gray-900' =>
                                $role === 'all',
                            'text-gray-700' => $role !== 'all',
                        ])
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-gray-300"></span>
                        Semua Role
                    </button>

                    <button
                        type="button"
                        wire:click="$set('role', 'owner')"
                        @click="open = false"
                        @class([
                            'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-red-50',
                            'bg-red-50 font-semibold text-red-700' =>
                                $role === 'owner',
                            'text-gray-700' => $role !== 'owner',
                        ])
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-red-500"></span>
                        Owner
                    </button>

                    <button
                        type="button"
                        wire:click="$set('role', 'mandor')"
                        @click="open = false"
                        @class([
                            'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-blue-50',
                            'bg-blue-50 font-semibold text-blue-700' =>
                                $role === 'mandor',
                            'text-gray-700' => $role !== 'mandor',
                        ])
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-blue-500"></span>
                        Mandor
                    </button>

                    <button
                        type="button"
                        wire:click="$set('role', 'pekerja')"
                        @click="open = false"
                        @class([
                            'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-green-50',
                            'bg-green-50 font-semibold text-green-700' =>
                                $role === 'pekerja',
                            'text-gray-700' => $role !== 'pekerja',
                        ])
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-green-500"></span>
                        Pekerja
                    </button>
                </div>
            </div>

            {{-- Filter Status --}}
            <div
                x-data="{ open: false }"
                class="relative w-full sm:w-48"
            >
                <button
                    type="button"
                    @click="open = !open"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <span class="flex min-w-0 items-center gap-2">
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $statusDotColor }}"></span>

                        <span class="truncate">
                            {{ $statusLabel }}
                        </span>
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-4 w-4 shrink-0 text-gray-500 transition"
                        :class="{ 'rotate-180': open }"
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
                    @click.outside="open = false"
                    class="absolute right-0 z-50 mt-2 w-full overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                >
                    <button
                        type="button"
                        wire:click="$set('status', 'all')"
                        @click="open = false"
                        @class([
                            'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-gray-100',
                            'bg-gray-50 font-semibold text-gray-900' =>
                                $status === 'all',
                            'text-gray-700' => $status !== 'all',
                        ])
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-gray-300"></span>
                        Semua Status
                    </button>

                    <button
                        type="button"
                        wire:click="$set('status', 'active')"
                        @click="open = false"
                        @class([
                            'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-green-50',
                            'bg-green-50 font-semibold text-green-700' =>
                                $status === 'active',
                            'text-gray-700' => $status !== 'active',
                        ])
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-green-500"></span>
                        Aktif
                    </button>

                    <button
                        type="button"
                        wire:click="$set('status', 'inactive')"
                        @click="open = false"
                        @class([
                            'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-red-50',
                            'bg-red-50 font-semibold text-red-700' =>
                                $status === 'inactive',
                            'text-gray-700' => $status !== 'inactive',
                        ])
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-red-500"></span>
                        Tidak Aktif
                    </button>
                </div>
            </div>

            {{-- Pengurutan --}}
            <div
                x-data="{ open: false }"
                class="relative w-full sm:w-48"
            >
                <button
                    type="button"
                    @click="open = !open"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
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
                        :class="{ 'rotate-180': open }"
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
                    @click.outside="open = false"
                    class="absolute right-0 z-50 mt-2 w-full overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
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
                        wire:click="$set('sort', 'name_asc')"
                        @click="open = false"
                        class="block w-full px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        Nama A–Z
                    </button>

                    <button
                        type="button"
                        wire:click="$set('sort', 'name_desc')"
                        @click="open = false"
                        class="block w-full px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                    >
                        Nama Z–A
                    </button>
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