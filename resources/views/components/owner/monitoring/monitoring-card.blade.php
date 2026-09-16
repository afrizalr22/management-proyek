@props([
    'project',
])

@php
    $progress = min(
        max((int) $project->progress, 0),
        100
    );

    $isDelayed =
        $project->end_date
        && $project->end_date->lt(today())
        && !in_array(
            $project->status,
            [
                'completed',
                'cancelled',
            ],
            true
        );

    [$statusText, $statusColor] = $isDelayed
        ? [
            'Terlambat',
            'red',
        ]
        : match ($project->status) {
            'planning' => [
                'Perencanaan',
                'yellow',
            ],

            'in_progress',
            'on_progress',
            'ongoing' => [
                'Berjalan',
                'blue',
            ],

            'completed' => [
                'Selesai',
                'green',
            ],

            'on_hold' => [
                'Ditunda',
                'gray',
            ],

            'cancelled' => [
                'Dibatalkan',
                'red',
            ],

            default => [
                'Tidak Diketahui',
                'gray',
            ],
        };

    $currentTask = $project->tasks
        ->first(
            fn ($task) =>
                $task->status !== 'cancelled'
        );

    $currentPhase =
        $currentTask?->title
        ?? 'Belum ada Task';

    $deadlineText = $project->end_date
        ?->translatedFormat('d M Y')
        ?? 'Belum ditentukan';

    $remainingDays = null;

    if (
        $project->end_date
        && !$isDelayed
        && !in_array(
            $project->status,
            [
                'completed',
                'cancelled',
            ],
            true
        )
    ) {
        $remainingDays = today()->diffInDays(
            $project->end_date,
            false
        );
    }
@endphp

<x-ui.card>
    <div class="flex h-full flex-col p-4 sm:p-5">
        {{-- Header --}}
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <p class="text-[11px] font-semibold uppercase tracking-wide text-blue-600">
                    {{ $project->project_code }}
                </p>

                <h3 class="mt-1 line-clamp-2 text-base font-bold leading-6 text-gray-900">
                    {{ $project->project_name }}
                </h3>

                <p class="mt-0.5 truncate text-sm text-gray-500">
                    {{ $project->client?->company_name
                        ?? 'Client tidak tersedia' }}
                </p>
            </div>

            <div class="shrink-0">
                <x-ui.badge :color="$statusColor">
                    {{ $statusText }}
                </x-ui.badge>
            </div>
        </div>

        {{-- Progress --}}
        <div class="mt-4">
            <div class="mb-1.5 flex items-center justify-between gap-3">
                <span class="text-xs font-medium text-gray-500">
                    Progress Project
                </span>

                <span
                    @class([
                        'text-sm font-bold',
                        'text-green-600' => $progress >= 100,
                        'text-red-600' =>
                            $progress < 100 && $isDelayed,
                        'text-blue-600' =>
                            $progress < 100 && !$isDelayed,
                    ])
                >
                    {{ $progress }}%
                </span>
            </div>

            <div
                x-data="{ progress: {{ $progress }} }"
                class="h-2 overflow-hidden rounded-full bg-gray-200"
            >
                <div
                    @class([
                        'h-full rounded-full transition-all duration-300',
                        'bg-green-600' => $progress >= 100,
                        'bg-blue-600' =>
                            $progress < 100 && !$isDelayed,
                        'bg-red-600' =>
                            $progress < 100 && $isDelayed,
                    ])
                    x-bind:style="{
                        width: progress + '%'
                    }"
                ></div>
            </div>
        </div>

        {{-- Tahap saat ini --}}
        <div
            @class([
                'mt-4 rounded-xl border px-3.5 py-3',
                'border-blue-100 bg-blue-50' => !$isDelayed,
                'border-red-100 bg-red-50' => $isDelayed,
            ])
        >
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-500">
                        Tahap Saat Ini
                    </p>

                    <h4
                        @class([
                            'mt-1 truncate text-sm font-semibold',
                            'text-blue-700' => !$isDelayed,
                            'text-red-700' => $isDelayed,
                        ])
                    >
                        {{ $currentPhase }}
                    </h4>
                </div>

                @if ($currentTask)
                    <span
                        @class([
                            'shrink-0 rounded-lg bg-white/80 px-2 py-1 text-xs font-bold',
                            'text-blue-700' => !$isDelayed,
                            'text-red-700' => $isDelayed,
                        ])
                    >
                        {{ min(
                            max(
                                (int) $currentTask->progress,
                                0
                            ),
                            100
                        ) }}%
                    </span>
                @endif
            </div>
        </div>

        {{-- Informasi Project --}}
        <div class="mt-4 divide-y divide-gray-100">
            <div class="flex items-start justify-between gap-3 py-2">
                <span class="shrink-0 text-xs text-gray-500">
                    Mandor
                </span>

                <span class="truncate text-right text-xs font-semibold text-gray-800">
                    {{ $project->mandor?->name
                        ?? 'Belum ditentukan' }}
                </span>
            </div>

            <div class="flex items-start justify-between gap-3 py-2">
                <span class="shrink-0 text-xs text-gray-500">
                    Lokasi
                </span>

                <span
                    class="max-w-[65%] truncate text-right text-xs font-semibold text-gray-800"
                    title="{{ $project->location ?: '-' }}"
                >
                    {{ $project->location ?: '-' }}
                </span>
            </div>

            <div class="flex items-start justify-between gap-3 py-2">
                <span class="shrink-0 text-xs text-gray-500">
                    Deadline
                </span>

                <div class="text-right">
                    <p
                        @class([
                            'text-xs font-semibold',
                            'text-red-600' => $isDelayed,
                            'text-gray-800' => !$isDelayed,
                        ])
                    >
                        {{ $deadlineText }}
                    </p>

                    @if ($isDelayed)
                        <p class="mt-0.5 text-[11px] font-medium text-red-600">
                            Terlambat
                            {{ $project->end_date->diffInDays(today()) }}
                            hari
                        </p>
                    @elseif (
                        $remainingDays !== null
                        && $remainingDays >= 0
                    )
                        <p class="mt-0.5 text-[11px] text-gray-500">
                            {{ $remainingDays }} hari lagi
                        </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Statistik --}}
        <div class="mt-4 grid grid-cols-4 divide-x divide-gray-100 rounded-xl bg-gray-50 py-3 text-center">
            <div class="px-2">
                <p class="text-[10px] uppercase tracking-wide text-gray-400">
                    Tim
                </p>

                <p class="mt-1 text-base font-bold text-purple-600">
                    {{ $project->active_workers_count }}
                </p>
            </div>

            <div class="px-2">
                <p class="text-[10px] uppercase tracking-wide text-gray-400">
                    Task
                </p>

                <p class="mt-1 text-base font-bold text-amber-600">
                    {{ $project->tasks_count }}
                </p>
            </div>

            <div class="px-2">
                <p class="text-[10px] uppercase tracking-wide text-gray-400">
                    Foto
                </p>

                <p class="mt-1 text-base font-bold text-blue-600">
                    {{ $project->photos_count }}
                </p>
            </div>

            <div class="px-2">
                <p class="text-[10px] uppercase tracking-wide text-gray-400">
                    Laporan
                </p>

                <p class="mt-1 text-base font-bold text-green-600">
                    {{ $project->reports_count }}
                </p>
            </div>
        </div>

        @if ($project->issues_count > 0)
            <div class="mt-3 rounded-xl border border-red-100 bg-red-50 px-3 py-2.5">
                <p class="text-xs font-medium text-red-700">
                    {{ $project->issues_count }}
                    laporan memiliki kendala.
                </p>
            </div>
        @endif

        {{-- Tombol --}}
        <div class="mt-auto pt-4">
            <a
                href="{{ route(
                    'owner.monitoring.show',
                    [
                        'project' => $project->id,
                    ]
                ) }}"
                wire:navigate
                class="inline-flex min-h-10 w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
            >
                Lihat Monitoring
            </a>
        </div>
    </div>
</x-ui.card>