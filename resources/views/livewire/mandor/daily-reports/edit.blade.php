<div class="w-full min-w-0 space-y-6">

    <x-mandor.daily-reports.edit-page-header
        :report="$report"
    />

    <x-mandor.daily-reports.report-overview
        :report="$report"
    />

    <x-mandor.daily-reports.report-activities
        :report="$report"
    />

    <x-mandor.daily-reports.report-documentations
        :documentations="$report->documentations"
    />

    <x-mandor.daily-reports.report-obstacles-notes
        :report="$report"
    />

    <x-mandor.daily-reports.validation-form
        :report="$report"
    />

</div>