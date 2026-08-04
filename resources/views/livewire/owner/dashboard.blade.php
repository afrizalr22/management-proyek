<div class="space-y-8">

    <x-ui.page-header
        title="Dashboard"
        description="Ringkasan aktivitas perusahaan."
    />

    <x-dashboard.statistics />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        <x-dashboard.chart />

        <x-dashboard.recent-activity />

    </div>

    <x-dashboard.project-pipeline />

</div>