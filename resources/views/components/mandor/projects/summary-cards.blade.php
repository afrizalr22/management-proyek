@props([
    'project',
    'summary' => [],
])

@php
    $progress = min(
        100,
        max(
            0,
            (int) (
                $summary['progress']
                ?? 0
            )
        )
    );

    $remainingDays =
        $summary['remaining_days']
        ?? null;

    $isDelayed = (bool) (
        $summary['is_delayed']
        ?? false
    );

    $activeWorkers = (int) (
        $summary['active_workers']
        ?? 0
    );

    $totalTasks = (int) (
        $summary['total_tasks']
        ?? 0
    );

    $completedTasks = (int) (
        $summary['completed_tasks']
        ?? 0
    );

    $taskProgress = $totalTasks > 0
        ? (int) round(
            (
                $completedTasks
                / $totalTasks
            ) * 100
        )
        : 0;
@endphp

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    {{-- Total Progress --}}
    <x-ui.info-card>
        <div class="p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Total Progres
                    </p>

                    <p class="mt-2 text-3xl font-bold text-blue-600">
                        {{ $progress }}%
                    </p>
                </div>

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 20.25h18M6.75 17.25v-4.5M12 17.25V9M17.25 17.25V5.25"
                        />
                    </svg>
                </div>
            </div>

            <progress
                value="{{ $progress }}"
                max="100"
                aria-label="Progres Project {{ $progress }} persen"
                class="mt-4 block h-2 w-full appearance-none overflow-hidden rounded-full [&::-moz-progress-bar]:rounded-full [&::-moz-progress-bar]:bg-blue-600 [&::-webkit-progress-bar]:rounded-full [&::-webkit-progress-bar]:bg-gray-200 [&::-webkit-progress-value]:rounded-full [&::-webkit-progress-value]:bg-blue-600"
            >
                {{ $progress }}%
            </progress>
        </div>
    </x-ui.info-card>

    {{-- Waktu tersisa --}}
    <x-ui.info-card>
        <div class="p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Waktu Project
                    </p>

                    <div class="mt-2 flex items-baseline gap-2">
                        <p
                            @class([
                                'text-3xl font-bold',
                                'text-red-600' => $isDelayed,
                                'text-gray-900' => !$isDelayed,
                            ])
                        >
                            @if ($remainingDays === null)
                                -
                            @else
                                {{ abs($remainingDays) }}
                            @endif
                        </p>

                        @if ($remainingDays !== null)
                            <span class="text-sm text-gray-500">
                                hari
                            </span>
                        @endif
                    </div>
                </div>

                <div
                    @class([
                        'flex h-10 w-10 shrink-0 items-center justify-center rounded-xl',
                        'bg-red-50 text-red-600' =>
                            $isDelayed,
                        'bg-gray-100 text-gray-600' =>
                            !$isDelayed,
                    ])
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6.75 3v2.25m10.5-2.25v2.25M3.75 9.75h16.5m-15-4.5h13.5A1.5 1.5 0 0 1 20.25 6.75v12a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-12a1.5 1.5 0 0 1 1.5-1.5Z"
                        />
                    </svg>
                </div>
            </div>

            <p
                @class([
                    'mt-3 text-xs font-medium',
                    'text-red-600' =>
                        $isDelayed,
                    'text-gray-400' =>
                        !$isDelayed,
                ])
            >
                @if ($remainingDays === null)
                    Deadline belum ditentukan
                @elseif ($isDelayed)
                    Terlambat
                    {{ abs($remainingDays) }}
                    hari
                @elseif ($project->status === 'completed')
                    Project telah selesai
                @elseif ($project->status === 'cancelled')
                    Project dibatalkan
                @elseif ($remainingDays === 0)
                    Deadline hari ini
                @else
                    Tersisa
                    {{ $remainingDays }}
                    hari
                @endif
            </p>
        </div>
    </x-ui.info-card>

    {{-- Pekerja Aktif --}}
    <x-ui.info-card>
        <div class="p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Pekerja Aktif
                    </p>

                    <p class="mt-2 text-3xl font-bold text-purple-600">
                        {{ $activeWorkers }}
                    </p>
                </div>

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.205-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m10.117 0a9.027 9.027 0 0 1 .941 3.197M6 18.72c-1.355 0-2.638-.3-3.741-.479a3 3 0 0 1 4.682-2.72M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                        />
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-xs text-gray-400">
                Ditugaskan pada Project ini
            </p>
        </div>
    </x-ui.info-card>

    {{-- Task --}}
    <x-ui.info-card>
        <div class="p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Task Selesai
                    </p>

                    <p class="mt-2 text-3xl font-bold text-green-600">
                        {{ $completedTasks }}

                        <span class="text-lg font-medium text-gray-400">
                            / {{ $totalTasks }}
                        </span>
                    </p>
                </div>

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-xs text-gray-400">
                {{ $taskProgress }}% Task selesai
            </p>
        </div>
    </x-ui.info-card>
</div>