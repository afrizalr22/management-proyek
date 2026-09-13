@props([
    'project',
    'activeWorkerCount' => 0,
])

<div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

    <div>
        <nav
            class="flex flex-wrap items-center gap-2 text-sm"
            aria-label="Breadcrumb"
        >
            <a
                href="{{ route('mandor.projects.index') }}"
                wire:navigate
                class="font-medium text-blue-600 transition hover:text-blue-700"
            >
                Proyek Saya
            </a>

            <svg
                class="h-4 w-4 text-gray-400"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 18l6-6-6-6"
                />
            </svg>

            <a
                href="{{ route('mandor.projects.show', $project) }}"
                wire:navigate
                class="max-w-64 truncate font-medium text-gray-500 transition hover:text-gray-700"
            >
                {{ $project->project_name }}
            </a>

            <svg
                class="h-4 w-4 text-gray-400"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 18l6-6-6-6"
                />
            </svg>

            <span class="font-medium text-gray-500">
                Progress Pekerjaan
            </span>
        </nav>

        <h1 class="mt-3 text-2xl font-bold text-gray-900 sm:text-3xl">
            Progress Pekerjaan
        </h1>

        <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1">
            <p class="text-sm leading-6 text-gray-500">
                Pantau perkembangan Task pada
                <span class="font-semibold text-gray-700">
                    {{ $project->project_name }}
                </span>
            </p>

            <span class="hidden h-1 w-1 rounded-full bg-gray-300 sm:block"></span>

            <span class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                {{ $project->project_code }}
            </span>
        </div>
    </div>

    <div class="flex flex-col items-stretch gap-2 sm:items-end">
        <button
            type="button"
            wire:click="openTaskForm"
            wire:loading.attr="disabled"
            @disabled($activeWorkerCount === 0)
            @class([
                'inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-5 text-sm font-semibold transition',

                'bg-blue-600 text-white shadow-sm shadow-blue-200 hover:bg-blue-700' =>
                    $activeWorkerCount > 0,

                'cursor-not-allowed bg-gray-200 text-gray-400' =>
                    $activeWorkerCount === 0,
            ])
        >
            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 5v14M5 12h14"
                />
            </svg>

            Buat Task
        </button>

        @if ($activeWorkerCount === 0)
            <p class="text-xs text-amber-600">
                Belum ada pekerja aktif pada proyek ini.
            </p>
        @else
            <p class="text-xs text-gray-400">
                {{ $activeWorkerCount }} pekerja aktif tersedia
            </p>
        @endif
    </div>

</div>