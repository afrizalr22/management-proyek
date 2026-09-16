<div class="space-y-6">
    {{-- Breadcrumb --}}
    <nav
        class="flex flex-wrap items-center gap-2 text-sm text-gray-500"
        aria-label="Breadcrumb"
    >
        <a
            href="{{ route('owner.monitoring.index') }}"
            wire:navigate
            class="transition hover:text-blue-600"
        >
            Project Monitoring
        </a>

        <span class="text-gray-400">/</span>

        <span class="font-medium text-gray-700">
            {{ $projectData->project_code }}
        </span>
    </nav>

    {{-- Project Header --}}
    <x-owner.monitoring.monitoring-detail-header
        :project="$projectData"
        :is-delayed="$isDelayed"
    />

    {{-- Project Statistics --}}
    <x-owner.monitoring.monitoring-detail-statistics
        :project="$projectData"
        :current-task="$currentTask"
    />

    {{-- Project Information --}}
    <x-owner.monitoring.monitoring-project-information
        :project="$projectData"
        :is-delayed="$isDelayed"
    />

    {{-- Construction Schedule --}}
    <x-owner.monitoring.construction-gantt
        :project="$projectData"
        :tasks="$projectData->tasks"
    />

    {{-- Progress & Documentation --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <x-owner.monitoring.latest-progress
                :project="$projectData"
            />
        </div>

        <div>
            <x-owner.monitoring.documentation-preview
                :project="$projectData"
            />
        </div>
    </div>

    {{-- Issues & Activity --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-owner.monitoring.issue-list
            :project="$projectData"
        />

        <x-owner.monitoring.activity-log
            :project="$projectData"
        />
    </div>
</div>