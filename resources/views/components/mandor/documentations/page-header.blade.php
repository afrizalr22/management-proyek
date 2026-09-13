@props([
    'project',
    'totalDocumentations' => 0,
])

<header class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

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
                Dokumentasi
            </span>
        </nav>

        <p class="mt-4 text-sm font-semibold text-blue-600">
            Photo Gallery
        </p>

        <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
            Dokumentasi Proyek
        </h1>

        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
            Lihat dokumentasi perkembangan pekerjaan pada
            <span class="font-semibold text-gray-700">
                {{ $project->project_name }}
            </span>.
        </p>
    </div>

    <div class="inline-flex w-fit items-center gap-3 rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm">
        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <rect
                    x="3"
                    y="3"
                    width="18"
                    height="18"
                    rx="2"
                />

                <circle cx="8.5" cy="8.5" r="1.5" />

                <path d="M21 15l-5-5L5 21" />
            </svg>
        </span>

        <div>
            <p class="text-xs font-medium text-gray-500">
                Total Dokumentasi
            </p>

            <p class="text-lg font-bold text-gray-900">
                {{ number_format($totalDocumentations) }}
                Foto
            </p>
        </div>
    </div>

</header>