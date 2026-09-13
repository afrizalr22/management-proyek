@props([
    'taskOptions',
    'search' => '',
    'task' => '',
    'category' => '',
    'sort' => 'newest',
])

@php
    $taskFilterOptions = [
        '' => 'Semua Task',
    ];

    $taskColors = [
        '' => 'bg-gray-300',
    ];

    foreach ($taskOptions as $taskOption) {
        $taskFilterOptions[(string) $taskOption->id] =
            $taskOption->task_code
            . ' — '
            . $taskOption->title;

        $taskColors[(string) $taskOption->id] =
            'bg-violet-500';
    }

    $categoryOptions = [
        '' => 'Semua Kategori',
        'progress' => 'Progres',
        'material' => 'Material',
        'safety' => 'Keselamatan',
        'obstacle' => 'Kendala',
        'other' => 'Lainnya',
    ];

    $categoryColors = [
        '' => 'bg-gray-300',
        'progress' => 'bg-blue-500',
        'material' => 'bg-amber-500',
        'safety' => 'bg-emerald-500',
        'obstacle' => 'bg-red-500',
        'other' => 'bg-slate-500',
    ];

    $sortOptions = [
        'newest' => 'Dokumentasi Terbaru',
        'oldest' => 'Dokumentasi Terlama',
        'title' => 'Judul A–Z',
        'task' => 'Berdasarkan Task',
    ];

    $filters = [
        [
            'property' => 'task',
            'current' => $task,
            'options' => $taskFilterOptions,
            'colors' => $taskColors,
            'default' => '',
            'width' => 'sm:w-52',
            'showColor' => true,
        ],
        [
            'property' => 'category',
            'current' => $category,
            'options' => $categoryOptions,
            'colors' => $categoryColors,
            'default' => '',
            'width' => 'sm:w-48',
            'showColor' => true,
        ],
        [
            'property' => 'sort',
            'current' => $sort,
            'options' => $sortOptions,
            'colors' => [],
            'default' => 'newest',
            'width' => 'sm:w-56',
            'showColor' => false,
        ],
    ];
@endphp

<x-ui.toolbar>
    <x-slot:left>
        <div class="w-full">
            <x-ui.search
                wire:model.live.debounce.300ms="search"
                placeholder="Cari judul, Task, proyek, atau lokasi..."
            />
        </div>
    </x-slot:left>

    <x-slot:right>
        <div
            class="flex w-full flex-col gap-3 sm:flex-row sm:flex-wrap xl:w-auto xl:flex-nowrap"
        >
            @foreach ($filters as $filter)
                @php
                    $currentValue = array_key_exists(
                        $filter['current'],
                        $filter['options']
                    )
                        ? $filter['current']
                        : $filter['default'];

                    $currentLabel =
                        $filter['options'][$currentValue];

                    $currentColor =
                        $filter['colors'][$currentValue]
                        ?? 'bg-gray-300';
                @endphp

                <div
                    x-data="{ open: false }"
                    class="relative w-full {{ $filter['width'] }}"
                >
                    <button
                        type="button"
                        x-on:click="open = ! open"
                        x-on:keydown.escape.window="open = false"
                        class="flex min-h-11 w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
                    >
                        <span class="flex min-w-0 items-center gap-2.5">
                            @if ($filter['showColor'])
                                <span
                                    class="h-2.5 w-2.5 shrink-0 rounded-full {{ $currentColor }}"
                                ></span>
                            @endif

                            <span class="truncate">
                                {{ $currentLabel }}
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
                        class="absolute right-0 z-50 mt-2 max-h-72 w-full overflow-y-auto rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                    >
                        @foreach ($filter['options'] as $value => $label)
                            <button
                                type="button"
                                wire:click="$set(
                                    '{{ $filter['property'] }}',
                                    '{{ $value }}'
                                )"
                                x-on:click="open = false"
                                @class([
                                    'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition hover:bg-gray-100',
                                    'bg-blue-50 font-semibold text-blue-700' =>
                                        $currentValue === (string) $value,
                                    'text-gray-700' =>
                                        $currentValue !== (string) $value,
                                ])
                            >
                                @if ($filter['showColor'])
                                    <span
                                        class="h-2.5 w-2.5 shrink-0 rounded-full {{ $filter['colors'][(string) $value] ?? 'bg-gray-300' }}"
                                    ></span>
                                @endif

                                <span class="min-w-0 flex-1 truncate">
                                    {{ $label }}
                                </span>

                                @if ($currentValue === (string) $value)
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
            @endforeach

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