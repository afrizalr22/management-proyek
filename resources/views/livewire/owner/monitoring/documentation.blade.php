<div class="space-y-6">
    {{-- Breadcrumb --}}
    <nav
        class="flex flex-wrap items-center gap-2 text-sm"
        aria-label="Breadcrumb"
    >
        <a
            href="{{ route('owner.monitoring.index') }}"
            wire:navigate
            class="font-medium text-gray-500 transition hover:text-blue-600"
        >
            Project Monitoring
        </a>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 text-gray-400"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m9 5 7 7-7 7"
            />
        </svg>

        <a
            href="{{ route(
                'owner.monitoring.show',
                [
                    'project' => $project->id,
                ]
            ) }}"
            wire:navigate
            class="font-medium text-gray-500 transition hover:text-blue-600"
        >
            {{ $project->project_code }}
        </a>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 text-gray-400"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m9 5 7 7-7 7"
            />
        </svg>

        <span class="font-semibold text-gray-700">
            Dokumentasi
        </span>
    </nav>

    <x-monitoring.documentation-header
        :project="$project"
        :total-documentations="$totalDocumentations"
        :category-statistics="$categoryStatistics"
    />

    <x-monitoring.documentation-filter
        :search="$search"
        :category="$category"
        :date="$date"
        :sort="$sort"
    />

    @error('category')
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
            role="alert"
        >
            {{ $message }}
        </div>
    @enderror

    @error('date')
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
            role="alert"
        >
            {{ $message }}
        </div>
    @enderror

    <x-monitoring.documentation-gallery
        :documentations="$documentations"
    />

    <x-monitoring.documentation-pagination
        :documentations="$documentations"
    />
</div>