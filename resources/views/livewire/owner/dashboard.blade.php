<div class="space-y-8">
    <x-ui.page-header
        title="Dashboard"
        description="Ringkasan aktivitas dan kondisi perusahaan."
    />

    <x-dashboard.statistics
        :statistics="$statistics"
    />

    <x-dashboard.attention-summary
        :summary="$summary"
    />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    <x-dashboard.chart
        :projects="$chartProjects"
    />

    <x-dashboard.recent-activity
        :activities="$recentActivities"
    />
</div>

    <x-dashboard.project-pipeline
        :projects="$pipelineProjects"
    />
</div>