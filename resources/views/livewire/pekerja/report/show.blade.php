<div class="space-y-6">
    <x-pekerja.report.show.page-header
        :report="$report"
    />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div>
            <x-pekerja.report.show.report-summary
                :report="$report"
            />
        </div>

        <div class="xl:col-span-2">
            <x-pekerja.report.show.work-detail
                :report="$report"
            />
        </div>
    </div>

    <x-pekerja.report.show.documentation-gallery
        :documentations="$report->documentations"
    />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <x-pekerja.report.show.obstacle-notes
            :report="$report"
        />

        <x-pekerja.report.show.mandor-response
            :report="$report"
        />
    </div>
</div>