@props([
    'projects',
    'projectFilter' => '',
    'status' => '',
    'sort' => 'newest',
    'resultCount' => 0,
    'hasActiveFilters' => false,
])

@php
    $selectedProject = $projects->first(
        fn ($project) =>
            (string) $project->id
                === (string) $projectFilter
    );

    $projectLabel = $selectedProject
        ? $selectedProject->project_code
        : 'Semua Project';

    $statusLabel = match ($status) {
        'submitted' => 'Menunggu Validasi',
        'revision' => 'Perlu Revisi',
        'approved' => 'Disetujui',
        default => 'Semua Status',
    };

    $sortLabel = match ($sort) {
        'oldest' => 'Terlama',
        'progress_highest' => 'Progress Tertinggi',
        'progress_lowest' => 'Progress Terendah',
        default => 'Terbaru',
    };
@endphp

<div class="space-y-3">

    <x-ui.toolbar>
        <x-slot:left>
            <div class="w-full">
                <x-ui.search
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari nomor, aktivitas, Project, Task, atau Pekerja..."
                />
            </div>
        </x-slot:left>

        <x-slot:right>
            <div class="flex w-full flex-col gap-3 sm:flex-row sm:flex-wrap lg:w-auto lg:flex-nowrap">

                {{-- Project --}}
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
                            {{ $projectLabel }}
                        </span>

                        <svg
                            class="h-4 w-4 shrink-0 text-gray-500 transition"
                            x-bind:class="{ 'rotate-180': open }"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
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
                        class="absolute right-0 z-50 mt-2 max-h-72 w-72 overflow-y-auto rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                    >
                        <button
                            type="button"
                            wire:click="$set('projectFilter', '')"
                            x-on:click="open = false"
                            class="block w-full px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                        >
                            Semua Project
                        </button>

                        @foreach ($projects as $project)
                            <button
                                type="button"
                                wire:key="report-project-{{ $project->id }}"
                                wire:click="$set(
                                    'projectFilter',
                                    '{{ $project->id }}'
                                )"
                                x-on:click="open = false"
                                @class([
                                    'block w-full px-4 py-2.5 text-left transition hover:bg-gray-100',
                                    'bg-blue-50' =>
                                        (string) $projectFilter
                                            === (string) $project->id,
                                ])
                            >
                                <span class="block text-xs font-bold uppercase tracking-wide text-blue-600">
                                    {{ $project->project_code }}
                                </span>

                                <span class="mt-0.5 block truncate text-sm text-gray-700">
                                    {{ $project->project_name }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>

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
                        <span class="truncate">
                            {{ $statusLabel }}
                        </span>

                        <svg
                            class="h-4 w-4 shrink-0 text-gray-500 transition"
                            x-bind:class="{ 'rotate-180': open }"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
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
                            wire:click="$set('status', 'submitted')"
                            x-on:click="open = false"
                            class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                        >
                            <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-amber-500"></span>

                            Menunggu Validasi
                        </button>

                        <button
                            type="button"
                            wire:click="$set('status', 'revision')"
                            x-on:click="open = false"
                            class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                        >
                            <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-red-500"></span>

                            Perlu Revisi
                        </button>

                        <button
                            type="button"
                            wire:click="$set('status', 'approved')"
                            x-on:click="open = false"
                            class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                        >
                            <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-emerald-500"></span>

                            Disetujui
                        </button>
                    </div>
                </div>

                {{-- Urutan --}}
                <div
                    x-data="{ open: false }"
                    class="relative w-full sm:w-48"
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
                            class="h-4 w-4 shrink-0 text-gray-500 transition"
                            x-bind:class="{ 'rotate-180': open }"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
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
                            'newest' => 'Terbaru',
                            'oldest' => 'Terlama',
                            'progress_highest' => 'Progress Tertinggi',
                            'progress_lowest' => 'Progress Terendah',
                        ] as $sortValue => $sortText)
                            <button
                                type="button"
                                wire:key="report-sort-{{ $sortValue }}"
                                wire:click="$set(
                                    'sort',
                                    '{{ $sortValue }}'
                                )"
                                x-on:click="open = false"
                                @class([
                                    'block w-full px-4 py-2.5 text-left text-sm transition hover:bg-gray-100',
                                    'bg-blue-50 font-semibold text-blue-700' =>
                                        $sort === $sortValue,
                                    'text-gray-700' =>
                                        $sort !== $sortValue,
                                ])
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

    <div class="flex flex-col gap-2 px-1 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-gray-500">
            Ditemukan
            <span class="font-semibold text-gray-900">
                {{ number_format($resultCount) }}
            </span>
            laporan
        </p>

        @if ($hasActiveFilters)
            <div class="flex items-center gap-2 text-xs font-medium text-blue-600">
                <span class="h-2 w-2 rounded-full bg-blue-500"></span>

                Filter sedang diterapkan
            </div>
        @else
            <p class="text-xs text-gray-400">
                Laporan terbaru ditampilkan lebih dahulu
            </p>
        @endif
    </div>

</div>