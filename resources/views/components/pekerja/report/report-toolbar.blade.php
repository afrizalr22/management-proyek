@props([
    'search' => '',
    'status' => '',
    'period' => '',
    'sort' => 'newest',
])

@php
    $statusOptions = [
        '' => 'Semua Status',
        'submitted' => 'Menunggu Pemeriksaan',
        'approved' => 'Diterima',
        'revision' => 'Perlu Revisi',
        'draft' => 'Draft',
    ];

    $statusColors = [
        '' => 'bg-gray-300',
        'submitted' => 'bg-amber-500',
        'approved' => 'bg-emerald-500',
        'revision' => 'bg-red-500',
        'draft' => 'bg-slate-400',
    ];

    $periodOptions = [
        '' => 'Semua Periode',
        'current_month' => 'Bulan Ini',
        'last_month' => 'Bulan Lalu',
        'last_three_months' => '3 Bulan Terakhir',
    ];

    $sortOptions = [
        'newest' => 'Laporan Terbaru',
        'oldest' => 'Laporan Terlama',
    ];

    $selectedStatus = array_key_exists(
        $status,
        $statusOptions
    )
        ? $status
        : '';

    $selectedPeriod = array_key_exists(
        $period,
        $periodOptions
    )
        ? $period
        : '';

    $selectedSort = array_key_exists(
        $sort,
        $sortOptions
    )
        ? $sort
        : 'newest';

    $statusLabel =
        $statusOptions[$selectedStatus];

    $periodLabel =
        $periodOptions[$selectedPeriod];

    $sortLabel =
        $sortOptions[$selectedSort];
@endphp

<x-ui.toolbar>
    <x-slot:left>
        <div class="w-full">
            <x-ui.search
                wire:model.live.debounce.300ms="search"
                placeholder="Cari nomor laporan, Task, proyek, atau lokasi..."
            />
        </div>
    </x-slot:left>

    <x-slot:right>
        <div
            class="flex w-full flex-col gap-3 sm:flex-row sm:flex-wrap xl:w-auto xl:justify-end 2xl:flex-nowrap"
        >
            {{-- Status --}}
            <div
                x-data="{ open: false }"
                class="relative w-full sm:w-56"
            >
                <button
                    type="button"
                    x-on:click="open = ! open"
                    x-on:keydown.escape.window="open = false"
                    class="flex min-h-11 w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <span class="flex min-w-0 items-center gap-2.5">
                        <span
                            class="h-2.5 w-2.5 shrink-0 rounded-full {{ $statusColors[$selectedStatus] }}"
                        ></span>

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
                    @foreach ($statusOptions as $value => $label)
                        <button
                            type="button"
                            wire:click="$set('status', '{{ $value }}')"
                            x-on:click="open = false"
                            @class([
                                'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-gray-100',
                                'bg-blue-50 font-semibold text-blue-700' =>
                                    $selectedStatus === $value,
                                'text-gray-700' =>
                                    $selectedStatus !== $value,
                            ])
                        >
                            <span
                                class="h-2.5 w-2.5 shrink-0 rounded-full {{ $statusColors[$value] }}"
                            ></span>

                            <span class="min-w-0 flex-1">
                                {{ $label }}
                            </span>

                            @if ($selectedStatus === $value)
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="ml-auto h-4 w-4 shrink-0 text-blue-600"
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

            {{-- Periode --}}
            <div
                x-data="{ open: false }"
                class="relative w-full sm:w-48"
            >
                <button
                    type="button"
                    x-on:click="open = ! open"
                    x-on:keydown.escape.window="open = false"
                    class="flex min-h-11 w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <span class="truncate">
                        {{ $periodLabel }}
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
                    @foreach ($periodOptions as $value => $label)
                        <button
                            type="button"
                            wire:click="$set('period', '{{ $value }}')"
                            x-on:click="open = false"
                            @class([
                                'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-gray-100',
                                'bg-blue-50 font-semibold text-blue-700' =>
                                    $selectedPeriod === $value,
                                'text-gray-700' =>
                                    $selectedPeriod !== $value,
                            ])
                        >
                            <span class="min-w-0 flex-1">
                                {{ $label }}
                            </span>

                            @if ($selectedPeriod === $value)
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="ml-auto h-4 w-4 shrink-0 text-blue-600"
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

            {{-- Pengurutan --}}
            <div
                x-data="{ open: false }"
                class="relative w-full sm:w-48"
            >
                <button
                    type="button"
                    x-on:click="open = ! open"
                    x-on:keydown.escape.window="open = false"
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
                    @foreach ($sortOptions as $value => $label)
                        <button
                            type="button"
                            wire:click="$set('sort', '{{ $value }}')"
                            x-on:click="open = false"
                            @class([
                                'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-gray-100',
                                'bg-blue-50 font-semibold text-blue-700' =>
                                    $selectedSort === $value,
                                'text-gray-700' =>
                                    $selectedSort !== $value,
                            ])
                        >
                            <span class="min-w-0 flex-1">
                                {{ $label }}
                            </span>

                            @if ($selectedSort === $value)
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="ml-auto h-4 w-4 shrink-0 text-blue-600"
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