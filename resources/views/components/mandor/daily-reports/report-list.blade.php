@props([
    'reports',
])

<section>
    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">
                Daftar Laporan
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Laporan Pekerja dari proyek yang Anda kelola.
            </p>
        </div>

        <span class="inline-flex w-fit rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
            {{ number_format($reports->total()) }} Laporan
        </span>
    </div>

    <div class="space-y-4">
        @foreach ($reports as $report)
            <x-mandor.daily-reports.report-card
                :report="$report"
                wire:key="mandor-report-{{ $report->id }}"
            />
        @endforeach
    </div>
</section>