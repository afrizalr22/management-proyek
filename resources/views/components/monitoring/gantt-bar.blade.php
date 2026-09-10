@props([
    'task',
    'timelineStart',
    'timelineEnd',
    'totalDays',
])

@php
    $taskStart = $task->start_at
        ?->copy()
        ->startOfDay()
        ?? $timelineStart->copy();

    $taskEnd = $task->due_at
        ?->copy()
        ->endOfDay()
        ?? $taskStart->copy()->addDay()->endOfDay();

    if ($taskEnd->lt($taskStart)) {
        $taskEnd = $taskStart
            ->copy()
            ->endOfDay();
    }

    $visibleStart = $taskStart->lt($timelineStart)
        ? $timelineStart->copy()
        : $taskStart->copy();

    $visibleEnd = $taskEnd->gt($timelineEnd)
        ? $timelineEnd->copy()
        : $taskEnd->copy();

    $startsAfterTimeline =
        $visibleStart->gt($timelineEnd);

    $endsBeforeTimeline =
        $visibleEnd->lt($timelineStart);

    $isVisible =
        ! $startsAfterTimeline
        && ! $endsBeforeTimeline;

    $startOffset = $isVisible
        ? $timelineStart->diffInDays($visibleStart)
        : 0;

    $duration = $isVisible
        ? max(
            $visibleStart->diffInDays($visibleEnd) + 1,
            1
        )
        : 0;

    $left = min(
        max(
            ($startOffset / max($totalDays, 1)) * 100,
            0
        ),
        100
    );

    $width = min(
        max(
            ($duration / max($totalDays, 1)) * 100,
            1.5
        ),
        100 - $left
    );

    $progress = min(
        max((int) $task->progress, 0),
        100
    );

    [$barColor, $statusText] = match ($task->status) {
        'completed' => [
            'bg-emerald-500',
            'Selesai',
        ],

        'in_progress' => [
            'bg-blue-600',
            'Berjalan',
        ],

        'submitted' => [
            'bg-blue-600',
            'Menunggu Validasi',
        ],

        'revision' => [
            'bg-amber-500',
            'Revisi',
        ],

        'cancelled' => [
            'bg-red-500',
            'Dibatalkan',
        ],

        default => [
            'bg-gray-400',
            'Ditugaskan',
        ],
    };

    $dateDescription = sprintf(
        '%s sampai %s',
        $taskStart->translatedFormat('d M Y'),
        $taskEnd->translatedFormat('d M Y')
    );
@endphp

@if ($isVisible)
    <div
        x-data="{
            left: @js(round($left, 4)),
            width: @js(round($width, 4))
        }"
        x-bind:style="`
            left: ${left}%;
            width: ${width}%;
        `"
        class="absolute top-1/2 z-10 -translate-y-1/2 px-1"
        title="{{ $task->title }} — {{ $dateDescription }}"
    >
        <div class="flex h-9 min-w-8 items-center justify-center overflow-hidden rounded-lg px-2 text-white shadow-sm {{ $barColor }}">
            <span class="truncate text-[11px] font-semibold">
                {{ $progress }}%
            </span>
        </div>
    </div>
@endif