@props([
    'projects',
    'tasks',
    'projectFilter' => '',
    'taskFilter' => '',
    'sort' => 'newest',
    'filteredDocumentations' => 0,
    'totalDocumentations' => 0,
    'hasActiveFilters' => false,
])

@php
    $selectedProject = $projects->first(
        fn ($project) =>
            (string) $project->id === (string) $projectFilter
    );

    $projectLabel = $selectedProject
        ? $selectedProject->project_code
        : 'Semua Project';

    $selectedTask = $tasks->first(
        fn ($task) =>
            (string) $task->id === (string) $taskFilter
    );

    $taskLabel = $selectedTask
        ? $selectedTask->task_code
        : 'Semua Task';

    $sortLabel = match ($sort) {
        'oldest' => 'Terlama',
        'title' => 'Judul A–Z',
        default => 'Terbaru',
    };
@endphp

<div class="space-y-3">

    <x-ui.toolbar>
        <x-slot:left>
            <div class="w-full">
                <x-ui.search
                    wire:model.live.debounce.400ms="search"
                    placeholder="Cari judul, Task, atau pengunggah..."
                />
            </div>
        </x-slot:left>

        <x-slot:right>
            <div class="flex w-full flex-col gap-3 sm:flex-row sm:flex-wrap lg:w-auto">

                {{-- Project --}}
                <div
                    x-data="{ open: false }"
                    class="relative w-full sm:w-56"
                >
                    <button
                        type="button"
                        x-on:click="open = !open"
                        class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-left text-sm shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
                    >
                        <div class="min-w-0">
                            <span class="block truncate font-medium text-gray-700">
                                {{ $projectLabel }}
                            </span>

                            @if ($selectedProject)
                                <span class="mt-0.5 block truncate text-xs text-gray-400">
                                    {{ $selectedProject->project_name }}
                                </span>
                            @endif
                        </div>

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
                        class="absolute left-0 z-50 mt-2 w-full min-w-80 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl"
                    >
                        <div class="max-h-80 overflow-y-auto p-1.5">

                            <button
                                type="button"
                                wire:click="$set('projectFilter', '')"
                                x-on:click="open = false"
                                @class([
                                    'flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2.5 text-left transition',
                                    'bg-blue-50 text-blue-700' =>
                                        $projectFilter === '',
                                    'text-gray-700 hover:bg-gray-50' =>
                                        $projectFilter !== '',
                                ])
                            >
                                <div class="min-w-0">
                                    <span class="block text-sm font-semibold">
                                        Semua Project
                                    </span>

                                    <span class="mt-0.5 block text-xs text-gray-400">
                                        Tampilkan seluruh dokumentasi
                                    </span>
                                </div>

                                @if ($projectFilter === '')
                                    <svg
                                        class="h-4 w-4 shrink-0 text-blue-600"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m4.5 12.75 6 6 9-13.5"
                                        />
                                    </svg>
                                @endif
                            </button>

                            @if ($projects->isNotEmpty())
                                <div class="my-1 border-t border-gray-100"></div>
                            @endif

                            @forelse ($projects as $project)
                                <button
                                    type="button"
                                    wire:key="project-filter-{{ $project->id }}"
                                    wire:click="$set(
                                        'projectFilter',
                                        '{{ $project->id }}'
                                    )"
                                    x-on:click="open = false"
                                    @class([
                                        'flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2.5 text-left transition',
                                        'bg-blue-50' =>
                                            (string) $projectFilter
                                                === (string) $project->id,
                                        'hover:bg-gray-50' =>
                                            (string) $projectFilter
                                                !== (string) $project->id,
                                    ])
                                >
                                    <div class="min-w-0">
                                        <span
                                            @class([
                                                'block truncate text-xs font-bold uppercase tracking-wide',
                                                'text-blue-700' =>
                                                    (string) $projectFilter
                                                        === (string) $project->id,
                                                'text-blue-600' =>
                                                    (string) $projectFilter
                                                        !== (string) $project->id,
                                            ])
                                        >
                                            {{ $project->project_code }}
                                        </span>

                                        <span class="mt-1 block truncate text-sm font-medium text-gray-700">
                                            {{ $project->project_name }}
                                        </span>
                                    </div>

                                    @if (
                                        (string) $projectFilter
                                            === (string) $project->id
                                    )
                                        <svg
                                            class="h-4 w-4 shrink-0 text-blue-600"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2.5"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m4.5 12.75 6 6 9-13.5"
                                            />
                                        </svg>
                                    @endif
                                </button>
                            @empty
                                <div class="px-3 py-6 text-center">
                                    <p class="text-sm font-medium text-gray-500">
                                        Belum ada Project
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">
                                        Belum ada Project yang memiliki dokumentasi.
                                    </p>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>

                {{-- Task --}}
                <div
                    x-data="{ open: false }"
                    class="relative w-full sm:w-56"
                >
                    <button
                        type="button"
                        x-on:click="open = !open"
                        class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-left text-sm shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
                    >
                        <div class="min-w-0">
                            <span class="block truncate font-medium text-gray-700">
                                {{ $taskLabel }}
                            </span>

                            @if ($selectedTask)
                                <span class="mt-0.5 block truncate text-xs text-gray-400">
                                    {{ $selectedTask->title }}
                                </span>
                            @endif
                        </div>

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
                        class="absolute left-0 z-50 mt-2 w-full min-w-80 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl"
                    >
                        <div class="max-h-80 overflow-y-auto p-1.5">

                            <button
                                type="button"
                                wire:click="$set('taskFilter', '')"
                                x-on:click="open = false"
                                @class([
                                    'flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2.5 text-left transition',
                                    'bg-blue-50 text-blue-700' =>
                                        $taskFilter === '',
                                    'text-gray-700 hover:bg-gray-50' =>
                                        $taskFilter !== '',
                                ])
                            >
                                <div class="min-w-0">
                                    <span class="block text-sm font-semibold">
                                        Semua Task
                                    </span>

                                    <span class="mt-0.5 block text-xs text-gray-400">
                                        Tampilkan seluruh dokumentasi Task
                                    </span>
                                </div>

                                @if ($taskFilter === '')
                                    <svg
                                        class="h-4 w-4 shrink-0 text-blue-600"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m4.5 12.75 6 6 9-13.5"
                                        />
                                    </svg>
                                @endif
                            </button>

                            @if ($tasks->isNotEmpty())
                                <div class="my-1 border-t border-gray-100"></div>
                            @endif

                            @forelse ($tasks as $task)
                                <button
                                    type="button"
                                    wire:key="task-filter-{{ $task->id }}"
                                    wire:click="$set(
                                        'taskFilter',
                                        '{{ $task->id }}'
                                    )"
                                    x-on:click="open = false"
                                    @class([
                                        'flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2.5 text-left transition',
                                        'bg-blue-50' =>
                                            (string) $taskFilter
                                                === (string) $task->id,
                                        'hover:bg-gray-50' =>
                                            (string) $taskFilter
                                                !== (string) $task->id,
                                    ])
                                >
                                    <div class="min-w-0">
                                        <span
                                            @class([
                                                'block truncate text-xs font-bold uppercase tracking-wide',
                                                'text-blue-700' =>
                                                    (string) $taskFilter
                                                        === (string) $task->id,
                                                'text-blue-600' =>
                                                    (string) $taskFilter
                                                        !== (string) $task->id,
                                            ])
                                        >
                                            {{ $task->task_code }}
                                        </span>

                                        <span class="mt-1 block truncate text-sm font-medium text-gray-700">
                                            {{ $task->title }}
                                        </span>
                                    </div>

                                    @if (
                                        (string) $taskFilter
                                            === (string) $task->id
                                    )
                                        <svg
                                            class="h-4 w-4 shrink-0 text-blue-600"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2.5"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m4.5 12.75 6 6 9-13.5"
                                            />
                                        </svg>
                                    @endif
                                </button>
                            @empty
                                <div class="px-3 py-6 text-center">
                                    <p class="text-sm font-medium text-gray-500">
                                        Belum ada Task
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">
                                        Belum ada Task yang memiliki dokumentasi.
                                    </p>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>

                {{-- Urutkan --}}
                <div
                    x-data="{ open: false }"
                    class="relative w-full sm:w-40"
                >
                    <button
                        type="button"
                        x-on:click="open = !open"
                        class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
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
                        class="absolute right-0 z-50 mt-2 w-full min-w-44 overflow-hidden rounded-xl border border-gray-200 bg-white p-1.5 shadow-xl"
                    >
                        @foreach ([
                            'newest' => 'Terbaru',
                            'oldest' => 'Terlama',
                            'title' => 'Judul A–Z',
                        ] as $sortValue => $sortText)
                            <button
                                type="button"
                                wire:key="sort-{{ $sortValue }}"
                                wire:click="$set(
                                    'sort',
                                    '{{ $sortValue }}'
                                )"
                                x-on:click="open = false"
                                @class([
                                    'flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-left text-sm transition',
                                    'bg-blue-50 font-semibold text-blue-700' =>
                                        $sort === $sortValue,
                                    'text-gray-700 hover:bg-gray-50' =>
                                        $sort !== $sortValue,
                                ])
                            >
                                <span>
                                    {{ $sortText }}
                                </span>

                                @if ($sort === $sortValue)
                                    <svg
                                        class="h-4 w-4 shrink-0 text-blue-600"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
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

    <div class="flex flex-col gap-2 px-1 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-gray-500">
            Ditemukan

            <span class="font-semibold text-gray-900">
                {{ number_format($filteredDocumentations) }}
            </span>

            dari

            <span class="font-semibold text-gray-900">
                {{ number_format($totalDocumentations) }}
            </span>

            dokumentasi
        </p>

        @if ($hasActiveFilters)
            <div class="flex items-center gap-2 text-xs font-medium text-blue-600">
                <span class="h-2 w-2 rounded-full bg-blue-500"></span>

                Filter sedang diterapkan
            </div>
        @endif
    </div>

</div>