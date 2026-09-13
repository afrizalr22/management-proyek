@props([
    'search' => '',
    'status' => '',
    'priority' => '',
    'sort' => 'deadline',
])

@php
    $statusOptions = [
        '' => 'Semua Status',
        'assigned' => 'Belum Dimulai',
        'in_progress' => 'Sedang Dikerjakan',
        'submitted' => 'Menunggu Pemeriksaan',
        'revision' => 'Perlu Revisi',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    $statusColors = [
        '' => 'bg-gray-300',
        'assigned' => 'bg-slate-400',
        'in_progress' => 'bg-blue-500',
        'submitted' => 'bg-violet-500',
        'revision' => 'bg-amber-500',
        'completed' => 'bg-emerald-500',
        'cancelled' => 'bg-red-500',
    ];

    $priorityOptions = [
        '' => 'Semua Prioritas',
        'urgent' => 'Mendesak',
        'high' => 'Tinggi',
        'medium' => 'Sedang',
        'low' => 'Rendah',
    ];

    $priorityColors = [
        '' => 'bg-gray-300',
        'urgent' => 'bg-red-500',
        'high' => 'bg-orange-500',
        'medium' => 'bg-amber-500',
        'low' => 'bg-emerald-500',
    ];

    $sortOptions = [
        'deadline' => 'Deadline Terdekat',
        'latest' => 'Task Terbaru',
        'oldest' => 'Task Terlama',
        'priority' => 'Prioritas Tertinggi',
        'progress_highest' => 'Progres Tertinggi',
        'progress_lowest' => 'Progres Terendah',
    ];

    $statusLabel =
        $statusOptions[$status]
        ?? $statusOptions[''];

    $priorityLabel =
        $priorityOptions[$priority]
        ?? $priorityOptions[''];

    $sortLabel =
        $sortOptions[$sort]
        ?? $sortOptions['deadline'];
@endphp

<x-ui.toolbar>
    <x-slot:left>
        <div class="w-full">
            <x-ui.search
                wire:model.live.debounce.300ms="search"
                placeholder="Cari kode, judul, proyek, atau lokasi task..."
            />
        </div>
    </x-slot:left>

    <x-slot:right>
        <div class="flex w-full flex-col gap-3 sm:flex-row sm:flex-wrap xl:w-auto xl:flex-nowrap">
            {{-- Status --}}
            <div
                x-data="{ open: false }"
                class="relative w-full sm:w-52"
            >
                <button
                    type="button"
                    x-on:click="open = !open"
                    class="flex min-h-11 w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <span class="flex min-w-0 items-center gap-2.5">
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $statusColors[$status] ?? $statusColors[''] }}"></span>

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
                        wire:click="$set(
                            'status',
                            '{{ $value }}'
                        )"
                        x-on:click="open = false"
                        @class([
                            'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-gray-100',
                            'bg-blue-50 font-semibold text-blue-700' =>
                                $status === $value,
                            'text-gray-700' =>
                                $status !== $value,
                        ])
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $statusColors[$value] }}"></span>

                        <span>
                            {{ $label }}
                        </span>

                        @if ($status === $value)
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

            {{-- Prioritas --}}
            <div
                x-data="{ open: false }"
                class="relative w-full sm:w-48"
            >
                <button
                    type="button"
                    x-on:click="open = !open"
                    class="flex min-h-11 w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <span class="flex min-w-0 items-center gap-2.5">
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $priorityColors[$priority] ?? $priorityColors[''] }}"></span>

                        <span class="truncate">
                            {{ $priorityLabel }}
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
                    @foreach ($priorityOptions as $value => $label)
                    <button
                        type="button"
                        wire:click="$set(
                            'priority',
                            '{{ $value }}'
                        )"
                        x-on:click="open = false"
                        @class([
                            'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-gray-100',
                            'bg-blue-50 font-semibold text-blue-700' =>
                                $priority === $value,
                            'text-gray-700' =>
                                $priority !== $value,
                        ])
                    >
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $priorityColors[$value] }}"></span>

                        <span>
                            {{ $label }}
                        </span>

                        @if ($priority === $value)
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
                class="relative w-full sm:w-56"
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
                    @foreach ($sortOptions as $value => $label)
                        <button
                            type="button"
                            wire:click="$set(
                                'sort',
                                '{{ $value }}'
                            )"
                            x-on:click="open = false"
                            @class([
                                'block w-full px-4 py-2.5 text-left text-sm transition hover:bg-gray-100',
                                'bg-blue-50 font-semibold text-blue-700' =>
                                    $sort === $value,
                                'text-gray-700' =>
                                    $sort !== $value,
                            ])
                        >
                            {{ $label }}
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