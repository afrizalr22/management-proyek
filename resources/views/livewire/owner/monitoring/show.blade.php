<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500">

        <a
            href="{{ route('owner.monitoring.index') }}"
            class="transition hover:text-blue-600"
        >
            Project Monitoring
        </a>

        <span class="text-gray-400">
            /
        </span>

        <span class="font-medium text-gray-700">
            Monitoring Detail
        </span>

    </div>


    {{-- Project Header --}}
    <x-monitoring.monitoring-detail-header />


    {{-- Project Statistics --}}
    <x-monitoring.monitoring-detail-statistics />


    {{-- Project Information --}}
    <x-monitoring.monitoring-project-information />


    {{-- Construction Schedule --}}
    <x-monitoring.construction-gantt />


    {{-- Progress & Documentation --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Latest Progress --}}
        <div class="xl:col-span-2">

            <x-monitoring.latest-progress />

        </div>


        {{-- Documentation Preview --}}
        <div>

            <x-monitoring.documentation-preview />

        </div>

    </div>


    {{-- Issues & Activity --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        {{-- Issues --}}
        <x-monitoring.issue-list />


        {{-- Activity --}}
        <x-monitoring.activity-log />

    </div>

</div>