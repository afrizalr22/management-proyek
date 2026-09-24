<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold text-blue-600">
                Progress Pekerjaan
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                Pilih Project
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                Pilih Project untuk melihat perkembangan pekerjaan,
                mengelola Task, dan memantau progres Pekerja.
            </p>
        </div>
    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Total Project
            </p>

            <p class="mt-2 text-2xl font-bold text-gray-900">
                {{ number_format($statistics['total']) }}
            </p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Project Aktif
            </p>

            <p class="mt-2 text-2xl font-bold text-gray-900">
                {{ number_format($statistics['active']) }}
            </p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Project Selesai
            </p>

            <p class="mt-2 text-2xl font-bold text-gray-900">
                {{ number_format($statistics['completed']) }}
            </p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Rata-rata Progress
            </p>

            <p class="mt-2 text-2xl font-bold text-gray-900">
                {{ number_format($statistics['averageProgress']) }}%
            </p>
        </div>
    </div>

    {{-- Filter --}}
@php
    $statusLabel = match ($status) {
        'planning' => 'Perencanaan',
        'on_progress' => 'Sedang Berjalan',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
        default => 'Semua Status',
    };

    $sortLabel = match ($sort) {
        'oldest' => 'Terlama',
        'name_asc' => 'Nama A–Z',
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

            {{-- Filter Status --}}
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
                        'latest' => 'Terbaru',
                        'oldest' => 'Terlama',
                        'name_asc' => 'Nama A–Z',
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

    {{-- Daftar Project --}}
    @if ($projects->isNotEmpty())
        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 xl:grid-cols-3">
            @foreach ($projects as $project)
                @php
                    $statusLabel = match ($project->status) {
                        'planning' => 'Perencanaan',
                        'on_progress' => 'Sedang Berjalan',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => str($project->status)
                            ->replace('_', ' ')
                            ->title(),
                    };

                    $statusClasses = match ($project->status) {
                        'planning' =>
                            'bg-amber-50 text-amber-700 ring-amber-200',

                        'on_progress' =>
                            'bg-blue-50 text-blue-700 ring-blue-200',

                        'completed' =>
                            'bg-emerald-50 text-emerald-700 ring-emerald-200',

                        'cancelled' =>
                            'bg-red-50 text-red-700 ring-red-200',

                        default =>
                            'bg-gray-50 text-gray-600 ring-gray-200',
                    };

                    $progress = max(
                        0,
                        min(
                            100,
                            (int) $project->progress
                        )
                    );
                @endphp

                <article
                    wire:key="work-progress-project-{{ $project->id }}"
                    class="flex flex-col rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-md"
                >
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-xs font-bold uppercase tracking-wide text-blue-600">
                                {{ $project->project_code }}
                            </p>

                            <h2 class="mt-1 line-clamp-2 text-lg font-bold text-gray-900">
                                {{ $project->project_name }}
                            </h2>
                        </div>

                        <span
                            class="inline-flex shrink-0 rounded-full px-2.5 py-1 text-[11px] font-bold ring-1 ring-inset {{ $statusClasses }}"
                        >
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <div class="mt-4 space-y-2 text-sm text-gray-500">
                        <p class="truncate">
                            <span class="font-medium text-gray-700">
                                Client:
                            </span>

                            {{ $project->client?->company_name ?? '-' }}
                        </p>

                        <p class="truncate">
                            <span class="font-medium text-gray-700">
                                Lokasi:
                            </span>

                            {{ $project->location ?: '-' }}
                        </p>
                    </div>

                    <div class="mt-5">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-xs font-semibold text-gray-500">
                                Progress Project
                            </p>

                            <p class="text-sm font-bold text-gray-900">
                                {{ $progress }}%
                            </p>
                        </div>

                        <div class="mt-2 h-2 overflow-hidden rounded-full bg-gray-100">
                            <div
                                class="h-full rounded-full bg-blue-600 transition-all"
                                x-bind:style="'width: ' + @js($progress) + '%'"
                            ></div>
                        </div>
                    </div>

                    <div class="mt-5 grid grid-cols-3 divide-x divide-gray-100 rounded-xl bg-gray-50 py-3 text-center">
                        <div class="px-2">
                            <p class="text-lg font-bold text-gray-900">
                                {{ $project->tasks_count }}
                            </p>

                            <p class="mt-0.5 text-[11px] font-medium text-gray-400">
                                Total Task
                            </p>
                        </div>

                        <div class="px-2">
                            <p class="text-lg font-bold text-blue-600">
                                {{ $project->active_tasks_count }}
                            </p>

                            <p class="mt-0.5 text-[11px] font-medium text-gray-400">
                                Aktif
                            </p>
                        </div>

                        <div class="px-2">
                            <p class="text-lg font-bold text-emerald-600">
                                {{ $project->completed_tasks_count }}
                            </p>

                            <p class="mt-0.5 text-[11px] font-medium text-gray-400">
                                Selesai
                            </p>
                        </div>
                    </div>

                    <div class="mt-auto pt-5">
                        <a
                            href="{{ route(
                                'mandor.projects.work-progress.index',
                                [
                                    'project' => $project->id,
                                ]
                            ) }}"
                            wire:navigate
                            class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
                        >
                            <span>
                                Lihat Progress
                            </span>

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 12h14M13 6l6 6-6 6"
                                />
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div>
            {{ $projects->links() }}
        </div>
    @else
        <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                <svg
                    class="h-7 w-7"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 20.25h18M6.75 17.25v-4.5M12 17.25V9M17.25 17.25V5.25"
                    />
                </svg>
            </div>

            <h2 class="mt-4 font-bold text-gray-800">
                Project tidak ditemukan
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Tidak ada Project yang sesuai dengan pencarian atau filter.
            </p>

            @if (
                filled($search)
                || filled($status)
                || $sort !== 'latest'
            )
                <button
                    type="button"
                    wire:click="resetFilters"
                    class="mt-5 text-sm font-semibold text-blue-600 hover:text-blue-700"
                >
                    Reset Filter
                </button>
            @endif
        </div>
    @endif

</div>