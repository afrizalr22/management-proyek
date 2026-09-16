<div class="space-y-8">
    <x-ui.page-header
        title="Dashboard"
        description="Ringkasan aktivitas dan kondisi perusahaan."
    />

    <x-owner.dashboard.statistics
        :statistics="$statistics"
    />

    <x-owner.dashboard.attention-summary
        :summary="$summary"
    />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <x-owner.dashboard.chart
            :projects="$chartProjects"
        />

        <x-owner.dashboard.recent-activity
            :activities="$recentActivities"
        />
    </div>

    <x-owner.dashboard.project-pipeline
        :projects="$pipelineProjects"
    />
</div>