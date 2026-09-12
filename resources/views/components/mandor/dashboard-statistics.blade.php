@props([
    'statistics' => [],
])

@php
    $activeProjects = (int) (
        $statistics['active_projects']
        ?? 0
    );

    $activeWorkers = (int) (
        $statistics['active_workers']
        ?? 0
    );

    $todayTasks = (int) (
        $statistics['today_tasks']
        ?? 0
    );

    $completedTodayTasks = (int) (
        $statistics['completed_today_tasks']
        ?? 0
    );

    $todayTaskProgress = min(
        max(
            (int) (
                $statistics['today_task_progress']
                ?? 0
            ),
            0
        ),
        100
    );

    $todayReports = (int) (
        $statistics['today_reports']
        ?? 0
    );

    $reportsAwaitingReview = (int) (
        $statistics['reports_awaiting_review']
        ?? 0
    );
@endphp

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
    {{-- Project aktif --}}
    <x-ui.info-card>
        <div class="flex h-full flex-col p-5 sm:p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Project Aktif
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $activeProjects }}
                    </p>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
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
                            d="M2.25 12 11.204 3.045a1.125 1.125 0 0 1 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-5.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"
                        />
                    </svg>
                </div>
            </div>

            <p class="mt-auto pt-4 text-sm text-gray-400">
                Project yang sedang dikelola
            </p>
        </div>
    </x-ui.info-card>

    {{-- Pekerja aktif --}}
    <x-ui.info-card>
        <div class="flex h-full flex-col p-5 sm:p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Pekerja Aktif
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $activeWorkers }}
                    </p>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
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
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.205-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m10.117 0a9.027 9.027 0 0 1 .941 3.197M6 18.72c-1.355 0-2.638-.3-3.741-.479a3 3 0 0 1 4.682-2.72M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                        />
                    </svg>
                </div>
            </div>

            <p class="mt-auto pt-4 text-sm text-gray-400">
                Ditugaskan pada Project aktif
            </p>
        </div>
    </x-ui.info-card>

    {{-- Task hari ini --}}
    <x-ui.info-card>
        <div class="flex h-full flex-col p-5 sm:p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Task Hari Ini
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $completedTodayTasks }}

                        <span class="text-lg font-medium text-gray-400">
                            / {{ $todayTasks }}
                        </span>
                    </p>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600">
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
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>
                </div>
            </div>

            <div class="mt-auto pt-4">
                <div class="h-2 overflow-hidden rounded-full bg-gray-100">
                    <div
                        x-data="{
                            progress: @js($todayTaskProgress)
                        }"
                        x-bind:style="{
                            width: progress + '%'
                        }"
                        class="h-full rounded-full bg-green-500 transition-all duration-500"
                    ></div>
                </div>

                <p class="mt-2 text-sm text-gray-400">
                    {{ $todayTaskProgress }}% selesai
                </p>
            </div>
        </div>
    </x-ui.info-card>

    {{-- Laporan --}}
    <x-ui.info-card>
        <div class="flex h-full flex-col p-5 sm:p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Laporan Hari Ini
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $todayReports }}
                    </p>
                </div>

                <div
                    @class([
                        'flex h-11 w-11 shrink-0 items-center justify-center rounded-xl',
                        'bg-amber-50 text-amber-600' =>
                            $reportsAwaitingReview > 0,
                        'bg-indigo-50 text-indigo-600' =>
                            $reportsAwaitingReview === 0,
                    ])
                >
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
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m0 12.75h7.5m-7.5 3h4.5m-7.5 3h9a2.25 2.25 0 0 0 2.25-2.25V8.108a2.25 2.25 0 0 0-.659-1.591l-3.108-3.108a2.25 2.25 0 0 0-1.591-.659H5.25A2.25 2.25 0 0 0 3 5v13.75A2.25 2.25 0 0 0 5.25 21Z"
                        />
                    </svg>
                </div>
            </div>

            <p
                @class([
                    'mt-auto pt-4 text-sm',
                    'font-medium text-amber-600' =>
                        $reportsAwaitingReview > 0,
                    'text-gray-400' =>
                        $reportsAwaitingReview === 0,
                ])
            >
                @if ($reportsAwaitingReview > 0)
                    {{ $reportsAwaitingReview }}
                    laporan menunggu pemeriksaan
                @else
                    Seluruh laporan telah diperiksa
                @endif
            </p>
        </div>
    </x-ui.info-card>
</div>