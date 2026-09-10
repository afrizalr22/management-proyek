@props([
    'project',
])

@php
    $latestProgress = $project->progresses->first();

    $latestReport = $project->dailyReports
        ->first(
            fn ($report): bool =>
                $report->status === 'approved'
        );

    $progressPercentage = $latestProgress
        ? (int) $latestProgress->progress_percentage
        : (
            $latestReport
                ? (int) $latestReport->reported_progress
                : (int) $project->progress
        );

    $progressPercentage = min(
        max($progressPercentage, 0),
        100
    );

    $progressTitle = match (true) {
        $latestProgress !== null =>
            'Pembaruan Progress Project',

        $latestReport?->task !== null =>
            $latestReport->task->title,

        $latestReport !== null =>
            'Laporan Harian Project',

        default =>
            'Progress Project',
    };

    $progressDescription = match (true) {
        $latestProgress !== null =>
            $latestProgress->description,

        $latestReport !== null =>
            $latestReport->activities,

        default =>
            'Belum ada pembaruan progress atau laporan harian.',
    };

    $updatedBy = match (true) {
        $latestProgress !== null =>
            $latestProgress->user?->name,

        $latestReport !== null =>
            $latestReport->user?->name,

        default =>
            null,
    };

    $updatedAt = match (true) {
        $latestProgress !== null =>
            $latestProgress->created_at,

        $latestReport !== null =>
            $latestReport->report_date,

        default =>
            null,
    };

    $dayNumber = null;

    if ($project->start_date && $updatedAt) {
        $updateDate = \Illuminate\Support\Carbon::parse(
            $updatedAt
        )->startOfDay();

        if ($updateDate->gte($project->start_date)) {
            $dayNumber =
                (int) $project->start_date
                    ->diffInDays($updateDate)
                + 1;
        }
    }

    $hasProgressSource =
        $latestProgress !== null
        || $latestReport !== null;
@endphp

<x-ui.info-card class="h-full">
    <div class="flex h-full flex-col p-6 sm:p-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Progress Terbaru
            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500">
                Pembaruan progress terakhir berdasarkan riwayat dan laporan harian.
            </p>
        </div>

        <div class="mt-8 rounded-2xl border border-blue-100 bg-blue-50 p-5 sm:p-6">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
                <div class="min-w-0">
                    <h3 class="text-lg font-semibold leading-7 text-gray-900">
                        {{ $progressTitle }}
                    </h3>

                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-600">
                        {{ $progressDescription }}
                    </p>

                    @if ($latestReport?->obstacles)
                        <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-amber-700">
                                Kendala
                            </p>

                            <p class="mt-1 text-sm leading-6 text-amber-800">
                                {{ $latestReport->obstacles }}
                            </p>
                        </div>
                    @endif
                </div>

                <div class="shrink-0 sm:min-w-[90px] sm:text-right">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                        Progress
                    </p>

                    <p class="mt-1 text-3xl font-bold text-blue-600">
                        {{ $progressPercentage }}%
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="rounded-xl bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Diperbarui Oleh
                </p>

                <p class="mt-1.5 font-semibold text-gray-900">
                    {{ $updatedBy ?? 'Belum tersedia' }}
                </p>
            </div>

            <div class="rounded-xl bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Tanggal
                </p>

                <p class="mt-1.5 font-semibold text-gray-900">
                    {{ $updatedAt
                        ? \Illuminate\Support\Carbon::parse($updatedAt)
                            ->translatedFormat('d F Y')
                        : '-' }}
                </p>
            </div>

            <div class="rounded-xl bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Periode Pelaksanaan
                </p>

                <p class="mt-1.5 font-semibold text-gray-900">
                    {{ $dayNumber
                        ? 'Hari ke-'.$dayNumber
                        : '-' }}
                </p>
            </div>
        </div>

        @unless ($hasProgressSource)
            <p class="mt-5 text-sm text-gray-500">
                Persentase yang ditampilkan masih menggunakan progress utama Project.
            </p>
        @endunless
    </div>
</x-ui.info-card>