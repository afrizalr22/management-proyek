@props([
    'project',
    'tasks' => collect(),
])

@php
    $taskCollection = collect($tasks);

    $taskStart = $taskCollection
        ->pluck('start_at')
        ->filter()
        ->min();

    $taskEnd = $taskCollection
        ->pluck('due_at')
        ->filter()
        ->max();

    $timelineStart =
        $project->start_date?->copy()->startOfDay()
        ?? ($taskStart
            ? \Illuminate\Support\Carbon::parse($taskStart)
                ->startOfDay()
            : today()->startOfDay());

    $timelineEnd =
        $project->end_date?->copy()->endOfDay()
        ?? ($taskEnd
            ? \Illuminate\Support\Carbon::parse($taskEnd)
                ->endOfDay()
            : $timelineStart->copy()->addDays(30)->endOfDay());

    if ($taskStart) {
        $firstTaskDate = \Illuminate\Support\Carbon::parse(
            $taskStart
        )->startOfDay();

        if ($firstTaskDate->lt($timelineStart)) {
            $timelineStart = $firstTaskDate;
        }
    }

    if ($taskEnd) {
        $lastTaskDate = \Illuminate\Support\Carbon::parse(
            $taskEnd
        )->endOfDay();

        if ($lastTaskDate->gt($timelineEnd)) {
            $timelineEnd = $lastTaskDate;
        }
    }

    if ($timelineEnd->lte($timelineStart)) {
        $timelineEnd = $timelineStart
            ->copy()
            ->addDays(30)
            ->endOfDay();
    }

    $totalDays = max(
        $timelineStart->diffInDays($timelineEnd) + 1,
        1
    );

    $completedTasks = $taskCollection
        ->where('status', 'completed')
        ->count();

    $activeTasks = $taskCollection
        ->whereIn(
            'status',
            [
                'in_progress',
                'submitted',
                'revision',
            ]
        )
        ->count();
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Jadwal Konstruksi
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Jadwal dan perkembangan pekerjaan berdasarkan Task Project.
                </p>
            </div>

            @if ($taskCollection->isNotEmpty())
                <div class="flex flex-wrap gap-2">
                    <span class="rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-600">
                        {{ $taskCollection->count() }} Task
                    </span>

                    <span class="rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
                        {{ $activeTasks }} Berjalan
                    </span>

                    <span class="rounded-full bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700">
                        {{ $completedTasks }} Selesai
                    </span>
                </div>
            @endif
        </div>

        <div class="mt-5 flex flex-wrap items-center gap-x-6 gap-y-3">
            <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-emerald-500"></span>

                <span class="text-sm text-gray-600">
                    Selesai
                </span>
            </div>

            <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-blue-600"></span>

                <span class="text-sm text-gray-600">
                    Berjalan
                </span>
            </div>

            <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-amber-500"></span>

                <span class="text-sm text-gray-600">
                    Revisi
                </span>
            </div>

            <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-gray-400"></span>

                <span class="text-sm text-gray-600">
                    Menunggu
                </span>
            </div>

            <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-red-500"></span>

                <span class="text-sm text-gray-600">
                    Dibatalkan
                </span>
            </div>
        </div>

        <hr class="my-6 border-gray-200">

        @if ($taskCollection->isNotEmpty())
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                <div class="overflow-x-auto">
                    <div class="min-w-[1100px]">
                        <x-monitoring.gantt-header
                            :timeline-start="$timelineStart"
                            :timeline-end="$timelineEnd"
                            :total-days="$totalDays"
                        />

                        @foreach ($taskCollection as $task)
                            <x-monitoring.gantt-row
                                :task="$task"
                                :timeline-start="$timelineStart"
                                :timeline-end="$timelineEnd"
                                :total-days="$totalDays"
                            />
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-200 text-gray-500">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-6 w-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3.75 9.75h16.5m-15-4.5h13.5A1.5 1.5 0 0 1 20.25 6.75v12a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-12a1.5 1.5 0 0 1 1.5-1.5Z"
                        />
                    </svg>
                </div>

                <p class="mt-4 font-semibold text-gray-700">
                    Belum ada jadwal pekerjaan
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Jadwal akan ditampilkan setelah Mandor membuat Task.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>