@props([
    'reportId',
])
<div class="space-y-6">
    <x-pekerja.report.show.page-header
        :report-id="$reportId"
        status="Menunggu Pemeriksaan"
    />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div>
            <x-pekerja.report.show.report-summary />
        </div>

        <div class="xl:col-span-2">
            <x-pekerja.report.show.work-detail />
        </div>
    </div>

    <x-pekerja.report.show.documentation-gallery />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <x-pekerja.report.show.obstacle-notes />

        <x-pekerja.report.show.mandor-response
            status="Menunggu Pemeriksaan"
        />
    </div>
</div>