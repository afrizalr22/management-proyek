<div class="space-y-6">
    {{-- Header --}}
    <x-mandor.projects.detail-header
        :project="$project"
        :summary="$summary"
    />

    {{-- Ringkasan --}}
    <x-mandor.projects.summary-cards
        :project="$project"
        :summary="$summary"
    />

    <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-3">
        {{-- Kolom utama --}}
        <div class="space-y-6 xl:col-span-2">
            <x-mandor.projects.progress-timeline
                :project="$project"
                :tasks="$tasks"
                :progresses="$progresses"
            />

            <x-mandor.projects.assigned-team
                :project="$project"
                :workers="$workers"
            />

            <x-mandor.projects.project-documentation
                :project="$project"
                :documentations="$latestDocumentations"
                :total="$summary['documentations']"
            />
        </div>

        {{-- Kolom informasi --}}
        <div class="space-y-6">
            <x-mandor.projects.project-information
                :project="$project"
            />

            <x-mandor.projects.recent-daily-reports
                :project="$project"
                :reports="$recentReports"
                :total="$summary['daily_reports']"
            />
        </div>
    </div>
</div>