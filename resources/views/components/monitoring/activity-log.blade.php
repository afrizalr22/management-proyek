@props([
    'project',
])

@php
    $activities = collect();

    foreach ($project->progresses as $progress) {
        $activities->push([
            'key' => 'progress-'.$progress->id,
            'title' => 'Progress Project diperbarui',
            'description' => sprintf(
                '%s memperbarui progress menjadi %d%%.',
                $progress->user?->name
                    ?? 'Pengguna',
                (int) $progress->progress_percentage
            ),
            'occurred_at' => $progress->created_at,
            'color' => 'bg-blue-500',
        ]);
    }

    foreach ($project->dailyReports as $report) {
        $reportStatus = match ($report->status) {
            'draft' => 'dibuat sebagai draft',
            'submitted' => 'dikirim untuk diperiksa',
            'revision' => 'dikembalikan untuk direvisi',
            'approved' => 'telah disetujui',
            default => 'diperbarui',
        };

        $activities->push([
            'key' => 'report-'.$report->id,
            'title' => 'Laporan harian '.$reportStatus,
            'description' => sprintf(
                '%s — %s',
                $report->report_number
                    ?: 'Laporan Harian',
                $report->user?->name
                    ?? 'Pengguna tidak tersedia'
            ),
            'occurred_at' =>
                $report->reviewed_at
                ?? $report->submitted_at
                ?? $report->updated_at,
            'color' => match ($report->status) {
                'approved' => 'bg-green-500',
                'revision' => 'bg-amber-500',
                'submitted' => 'bg-indigo-500',
                default => 'bg-gray-400',
            },
        ]);
    }

    foreach ($project->documentations as $documentation) {
        $activities->push([
            'key' => 'documentation-'.$documentation->id,
            'title' => 'Dokumentasi ditambahkan',
            'description' => sprintf(
                '%s mengunggah “%s”.',
                $documentation->user?->name
                    ?? 'Pengguna',
                $documentation->title
                    ?: 'Dokumentasi Project'
            ),
            'occurred_at' =>
                $documentation->taken_at
                ?? $documentation->created_at,
            'color' => 'bg-purple-500',
        ]);
    }

    foreach ($project->tasks as $task) {
        $taskStatus = match ($task->status) {
            'assigned' => 'ditugaskan',
            'in_progress' => 'mulai dikerjakan',
            'submitted' => 'dikirim untuk divalidasi',
            'revision' => 'memerlukan revisi',
            'completed' => 'telah diselesaikan',
            'cancelled' => 'dibatalkan',
            default => 'diperbarui',
        };

        $occurredAt = match ($task->status) {
            'completed' =>
                $task->completed_at
                ?? $task->updated_at,

            'submitted' =>
                $task->submitted_at
                ?? $task->updated_at,

            'in_progress' =>
                $task->started_at
                ?? $task->updated_at,

            default =>
                $task->updated_at,
        };

        $activities->push([
            'key' => 'task-'.$task->id,
            'title' => 'Task '.$taskStatus,
            'description' => sprintf(
                '%s — %s',
                $task->task_code,
                $task->title
            ),
            'occurred_at' => $occurredAt,
            'color' => match ($task->status) {
                'completed' => 'bg-green-500',
                'in_progress' => 'bg-blue-500',
                'submitted' => 'bg-indigo-500',
                'revision' => 'bg-amber-500',
                'cancelled' => 'bg-red-500',
                default => 'bg-gray-400',
            },
        ]);
    }

    $activities = $activities
        ->filter(
            fn (array $activity): bool =>
                $activity['occurred_at'] !== null
        )
        ->sortByDesc('occurred_at')
        ->take(8)
        ->values();
@endphp

<x-ui.info-card>
    <div class="p-6 sm:p-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Aktivitas Terbaru
            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500">
                Riwayat Task, laporan, progress, dan dokumentasi Project.
            </p>
        </div>

        @if ($activities->isNotEmpty())
            <div class="mt-8 space-y-6">
                @foreach ($activities as $activity)
                    @php
                        $activityDate =
                            \Illuminate\Support\Carbon::parse(
                                $activity['occurred_at']
                            );
                    @endphp

                    <article
                        wire:key="activity-{{ $activity['key'] }}"
                        class="flex gap-4"
                    >
                        <div class="relative flex w-4 shrink-0 justify-center">
                            @unless ($loop->last)
                                <div class="absolute left-1/2 top-3.5 h-[calc(100%+24px)] w-px -translate-x-1/2 bg-gray-200"></div>
                            @endunless

                            <span class="relative z-10 h-3.5 w-3.5 shrink-0 rounded-full {{ $activity['color'] }}"></span>
                        </div>

                        <div class="min-w-0 flex-1 pb-1">
                            <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between sm:gap-4">
                                <h3 class="font-semibold text-gray-800">
                                    {{ $activity['title'] }}
                                </h3>

                                <time
                                    datetime="{{ $activityDate->toIso8601String() }}"
                                    class="shrink-0 text-xs font-medium text-gray-400"
                                >
                                    {{ $activityDate->translatedFormat(
                                        'd M Y, H:i'
                                    ) }}
                                </time>
                            </div>

                            <p class="mt-1.5 text-sm leading-6 text-gray-500">
                                {{ $activity['description'] }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="mt-8 rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center">
                <p class="font-semibold text-gray-700">
                    Belum ada aktivitas
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Aktivitas Project akan muncul pada bagian ini.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>