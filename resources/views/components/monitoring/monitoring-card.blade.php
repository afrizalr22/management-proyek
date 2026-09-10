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
            'in_progress', 'ongoing' => [
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
        ?->translatedFormat('d F Y')
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
    <div class="flex h-full flex-col p-5 sm:p-6">
        {{-- Header --}}
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">
                    {{ $project->project_code }}
                </p>

                <h3 class="mt-1 break-words text-lg font-bold text-gray-900">
                    {{ $project->project_name }}
                </h3>

                <p class="mt-1 break-words text-sm text-gray-500">
                    {{ $project->client?->company_name
                        ?? 'Client tidak tersedia' }}
                </p>
            </div>

            <x-ui.badge :color="$statusColor">
                {{ $statusText }}
            </x-ui.badge>
        </div>

        {{-- Progress --}}
        <div class="mt-6">
            <div class="mb-2 flex items-center justify-between gap-4">
                <span class="text-sm text-gray-600">
                    Progress
                </span>

                <span
                    @class([
                        'font-semibold',
                        'text-green-600' =>
                            $progress >= 100,
                        'text-blue-600' =>
                            $progress < 100,
                    ])
                >
                    {{ $progress }}%
                </span>
            </div>

            <div
                x-data="{ progress: {{ $progress }} }"
                class="h-3 overflow-hidden rounded-full bg-gray-200"
            >
                <div
                    @class([
                        'h-full rounded-full transition-all duration-300',
                        'bg-green-600' =>
                            $progress >= 100,
                        'bg-blue-600' =>
                            $progress < 100
                            && !$isDelayed,
                        'bg-red-600' =>
                            $progress < 100
                            && $isDelayed,
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
                'mt-6 rounded-xl border p-4',
                'border-blue-100 bg-blue-50' =>
                    !$isDelayed,
                'border-red-100 bg-red-50' =>
                    $isDelayed,
            ])
        >
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                Tahap Saat Ini
            </p>

            <h4
                @class([
                    'mt-1 font-semibold',
                    'text-blue-700' =>
                        !$isDelayed,
                    'text-red-700' =>
                        $isDelayed,
                ])
            >
                {{ $currentPhase }}
            </h4>

            @if ($currentTask)
                <p class="mt-1 text-xs text-gray-500">
                    Progress Task:
                    {{ min(
                        max(
                            (int) $currentTask->progress,
                            0
                        ),
                        100
                    ) }}%
                </p>
            @endif
        </div>

        {{-- Informasi --}}
        <div class="mt-6 space-y-4">
            <div class="flex items-start justify-between gap-4">
                <span class="shrink-0 text-sm text-gray-500">
                    Mandor
                </span>

                <span class="text-right text-sm font-medium text-gray-800">
                    {{ $project->mandor?->name
                        ?? 'Belum ditentukan' }}
                </span>
            </div>

            <div class="flex items-start justify-between gap-4">
                <span class="shrink-0 text-sm text-gray-500">
                    Lokasi
                </span>

                <span class="max-w-[65%] text-right text-sm font-medium text-gray-800">
                    {{ $project->location ?: '-' }}
                </span>
            </div>

            <div class="flex items-start justify-between gap-4">
                <span class="shrink-0 text-sm text-gray-500">
                    Deadline
                </span>

                <div class="text-right">
                    <span
                        @class([
                            'text-sm font-semibold',
                            'text-red-600' => $isDelayed,
                            'text-gray-800' => !$isDelayed,
                        ])
                    >
                        {{ $deadlineText }}
                    </span>

                    @if ($isDelayed)
                        <p class="mt-1 text-xs font-medium text-red-600">
                            Terlambat
                            {{ $project->end_date
                                ->diffInDays(today()) }}
                            hari
                        </p>
                    @elseif (
                        $remainingDays !== null
                        && $remainingDays >= 0
                    )
                        <p class="mt-1 text-xs text-gray-500">
                            {{ $remainingDays }} hari lagi
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <hr class="my-6 border-gray-200">

        {{-- Statistik Project --}}
        <div class="grid grid-cols-4 gap-3 text-center">
            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400">
                    Tim
                </p>

                <p class="mt-2 text-lg font-bold text-purple-600">
                    {{ $project->active_workers_count }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400">
                    Task
                </p>

                <p class="mt-2 text-lg font-bold text-amber-600">
                    {{ $project->tasks_count }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400">
                    Foto
                </p>

                <p class="mt-2 text-lg font-bold text-blue-600">
                    {{ $project->photos_count }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400">
                    Laporan
                </p>

                <p class="mt-2 text-lg font-bold text-green-600">
                    {{ $project->reports_count }}
                </p>
            </div>
        </div>

        @if ($project->issues_count > 0)
            <div class="mt-5 rounded-xl border border-red-100 bg-red-50 px-4 py-3">
                <p class="text-sm font-medium text-red-700">
                    {{ $project->issues_count }}
                    laporan memiliki kendala pekerjaan.
                </p>
            </div>
        @endif

        {{-- Tombol --}}
        <div class="mt-auto pt-7">
            <a
                href="{{ route(
                    'owner.monitoring.show',
                    [
                        'project' => $project->id,
                    ]
                ) }}"
                wire:navigate
                class="inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
            >
                Lihat Monitoring
            </a>
        </div>
    </div>
</x-ui.card>