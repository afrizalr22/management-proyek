<div class="space-y-6">

    <x-mandor.daily-reports.page-header
        :statistics="$statistics"
    />

    <x-mandor.daily-reports.report-statistics
        :statistics="$statistics"
    />

    <x-mandor.daily-reports.report-filter
        :projects="$projects"
        :project-filter="$projectFilter"
        :status="$status"
        :sort="$sort"
        :result-count="$reports->total()"
        :has-active-filters="$hasActiveFilters"
    />

    @if ($reports->isNotEmpty())
        <x-mandor.daily-reports.report-list
            :reports="$reports"
        />

        <x-mandor.daily-reports.report-footer
            :reports="$reports"
        />
    @else
        <x-mandor.daily-reports.report-empty
            :has-active-filters="$hasActiveFilters"
        />
    @endif

</div>