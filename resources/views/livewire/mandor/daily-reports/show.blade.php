<div class="w-full min-w-0 space-y-6">

    {{-- Detail Header --}}
    <x-mandor.daily-reports.detail-header
    :report-id="$reportId"/>

    {{-- Report Overview --}}
    <x-mandor.daily-reports.report-overview />

    {{-- Work Activities --}}
    <x-mandor.daily-reports.report-activities />

    {{-- Report Documentation --}}
    <x-mandor.daily-reports.report-documentations />

    {{-- Obstacles and Notes --}}
    <x-mandor.daily-reports.report-obstacles-notes />

</div>