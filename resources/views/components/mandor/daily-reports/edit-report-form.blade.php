@props([
    'reportId',
])

<div class="space-y-6">
    <x-mandor.daily-reports.edit-report-information />

    <x-mandor.daily-reports.edit-work-activities />

    <x-mandor.daily-reports.edit-documentations />

    <x-mandor.daily-reports.form-actions
        :report-id="$reportId"
    />
</div>