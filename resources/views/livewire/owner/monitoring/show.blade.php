<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500">

        <a
            href="{{ route('owner.monitoring.index') }}"
            class="hover:text-blue-600 transition"
        >
            Project Monitoring
        </a>

        <span class="mx-2">/</span>

        <span class="font-medium text-gray-700">
            Monitoring Detail
        </span>

    </div>

    {{-- Header --}}
    <x-monitoring.monitoring-detail-header />

    {{-- Statistics --}}
    <x-monitoring.monitoring-detail-statistics />

    {{-- Project Information --}}
    <x-monitoring.monitoring-project-information />

    {{-- Construction Schedule (Gantt Chart) --}}
    <x-monitoring.construction-gantt />

    {{-- Progress & Documentation --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Latest Progress --}}
        <div class="xl:col-span-2">

            <x-monitoring.latest-progress />

        </div>

        {{-- Documentation --}}
        <div>

            <x-monitoring.documentation-preview />

        </div>

    </div>

    {{-- Issue & Activity --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        <x-monitoring.issue-list />

        <x-monitoring.activity-log />

    </div>

</div>