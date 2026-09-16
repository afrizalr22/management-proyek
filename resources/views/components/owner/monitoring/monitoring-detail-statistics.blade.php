@props([
    'project',
    'currentTask' => null,
])

@php
    $progress = min(
        max((int) $project->progress, 0),
        100
    );

    $currentPhase =
        $currentTask?->title
        ?? (
            (int) $project->tasks_count > 0
                ? 'Menunggu Pekerjaan'
                : 'Belum Ada Task'
        );
@endphp

<div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
    {{-- Overall Progress --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between gap-4 p-6">
            <div class="min-w-0">
                <p class="text-sm font-medium text-gray-500">
                    Progress Keseluruhan
                </p>

                <h3 class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $progress }}%
                </h3>

                <p class="mt-3 text-sm text-gray-500">
                    Penyelesaian Project
                </p>
            </div>

            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
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
                        d="M3 3v18h18M7 15l3-3 3 2 4-6"
                    />
                </svg>
            </div>
        </div>
    </x-ui.info-card>

    {{-- Current Phase --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between gap-4 p-6">
            <div class="min-w-0">
                <p class="text-sm font-medium text-gray-500">
                    Tahap Saat Ini
                </p>

                <h3
                    class="mt-2 truncate text-xl font-bold text-gray-900"
                    title="{{ $currentPhase }}"
                >
                    {{ $currentPhase }}
                </h3>

                <p class="mt-3 text-sm text-gray-500">
                    {{ $currentTask?->task_code ?? 'Informasi pekerjaan' }}
                </p>
            </div>

            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
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
                        d="M3 21h18M6 21V7l6-4 6 4v14M9 10h.01M9 14h.01M9 18h.01M15 10h.01M15 14h.01M15 18h.01"
                    />
                </svg>
            </div>
        </div>
    </x-ui.info-card>

    {{-- Active Workers --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between gap-4 p-6">
            <div class="min-w-0">
                <p class="text-sm font-medium text-gray-500">
                    Pekerja Aktif
                </p>

                <h3 class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $project->active_workers_count }}
                </h3>

                <p class="mt-3 text-sm text-gray-500">
                    Ditugaskan pada Project
                </p>
            </div>

            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
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
                        d="M18 20a6 6 0 0 0-12 0M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8m8 9a5 5 0 0 0-4-4.9M20 7a3 3 0 1 1-6 0"
                    />
                </svg>
            </div>
        </div>
    </x-ui.info-card>

    {{-- Issues --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between gap-4 p-6">
            <div class="min-w-0">
                <p class="text-sm font-medium text-gray-500">
                    Kendala Tercatat
                </p>

                <h3 class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $project->issues_count }}
                </h3>

                <p class="mt-3 text-sm text-gray-500">
                    Dari laporan harian
                </p>
            </div>

            <div
                @class([
                    'flex h-12 w-12 shrink-0 items-center justify-center rounded-xl',
                    'bg-red-100 text-red-600' =>
                        $project->issues_count > 0,
                    'bg-gray-100 text-gray-500' =>
                        $project->issues_count <= 0,
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
                        d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"
                    />
                </svg>
            </div>
        </div>
    </x-ui.info-card>
</div>