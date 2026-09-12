@props([
    'project',
])

@php
    $progress = min(
        100,
        max(
            0,
            (int) $project->progress
        )
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

    [$statusText, $badgeColor, $progressColor] =
        $isDelayed
            ? [
                'Terlambat',
                'red',
                'red',
            ]
            : match ($project->status) {
                'planning' => [
                    'Perencanaan',
                    'yellow',
                    'yellow',
                ],

                'on_progress',
                'in_progress',
                'ongoing' => [
                    'Sedang Berjalan',
                    'blue',
                    'blue',
                ],

                'on_hold' => [
                    'Ditunda',
                    'gray',
                    'gray',
                ],

                'completed' => [
                    'Selesai',
                    'green',
                    'green',
                ],

                'cancelled' => [
                    'Dibatalkan',
                    'red',
                    'red',
                ],

                default => [
                    'Tidak Diketahui',
                    'gray',
                    'gray',
                ],
            };

    $currentTask = $project->tasks
        ->first(
            fn ($task): bool =>
                !in_array(
                    $task->status,
                    [
                        'completed',
                        'approved',
                        'cancelled',
                    ],
                    true
                )
        )
        ?? $project->tasks->first();

    $progressClasses = match ($progressColor) {
        'yellow' =>
            '[&::-moz-progress-bar]:bg-yellow-500 [&::-webkit-progress-value]:bg-yellow-500',

        'blue' =>
            '[&::-moz-progress-bar]:bg-blue-600 [&::-webkit-progress-value]:bg-blue-600',

        'green' =>
            '[&::-moz-progress-bar]:bg-green-600 [&::-webkit-progress-value]:bg-green-600',

        'red' =>
            '[&::-moz-progress-bar]:bg-red-500 [&::-webkit-progress-value]:bg-red-500',

        default =>
            '[&::-moz-progress-bar]:bg-gray-500 [&::-webkit-progress-value]:bg-gray-500',
    };
@endphp

<article
    wire:key="mandor-project-card-{{ $project->id }}"
    class="flex h-full flex-col rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:border-blue-300 hover:shadow-md"
>
    {{-- Status dan kode --}}
    <div class="flex items-center justify-between gap-3">
        <x-ui.badge :color="$badgeColor">
            {{ $statusText }}
        </x-ui.badge>

        <span class="truncate text-xs font-semibold text-gray-400">
            {{ $project->project_code }}
        </span>
    </div>

    {{-- Identitas --}}
    <div class="mt-4">
        <a
            href="{{ route(
                'mandor.projects.show',
                [
                    'project' => $project->id,
                ]
            ) }}"
            wire:navigate
            class="line-clamp-2 text-lg font-bold leading-6 text-gray-900 transition hover:text-blue-600"
        >
            {{ $project->project_name }}
        </a>

        <p class="mt-1 truncate text-sm text-gray-500">
            {{ $project->client?->company_name
                ?? 'Client tidak tersedia' }}
        </p>
    </div>

    {{-- Lokasi dan tahap --}}
    <div class="mt-4 grid grid-cols-2 gap-3 rounded-xl bg-gray-50 p-3">
        <div class="min-w-0">
            <p class="text-xs text-gray-400">
                Lokasi
            </p>

            <p class="mt-1 truncate text-sm font-semibold text-gray-700">
                {{ $project->location ?: '-' }}
            </p>
        </div>

        <div class="min-w-0">
            <p class="text-xs text-gray-400">
                Tahap
            </p>

            <p
                class="mt-1 truncate text-sm font-semibold text-gray-700"
                title="{{ $currentTask?->title
                    ?? 'Belum ada Task' }}"
            >
                {{ $currentTask?->title
                    ?? 'Belum ada Task' }}
            </p>
        </div>
    </div>

    {{-- Progress --}}
    <div class="mt-4">
        <div class="mb-2 flex items-center justify-between gap-4">
            <span class="text-sm font-medium text-gray-600">
                Progres
            </span>

            <span class="text-sm font-bold text-gray-900">
                {{ $progress }}%
            </span>
        </div>

        <progress
            value="{{ $progress }}"
            max="100"
            aria-label="Progres Project {{ $progress }} persen"
            class="block h-2.5 w-full appearance-none overflow-hidden rounded-full [&::-moz-progress-bar]:rounded-full [&::-webkit-progress-bar]:rounded-full [&::-webkit-progress-bar]:bg-gray-200 [&::-webkit-progress-value]:rounded-full {{ $progressClasses }}"
        >
            {{ $progress }}%
        </progress>
    </div>

    {{-- Statistik singkat --}}
    <div class="mt-4 grid grid-cols-3 gap-2 border-t border-gray-100 pt-4 text-center">
        <div>
            <p class="text-xs text-gray-400">
                Pekerja
            </p>

            <p class="mt-1 text-sm font-bold text-gray-800">
                {{ $project->active_workers_count }}
            </p>
        </div>

        <div>
            <p class="text-xs text-gray-400">
                Task
            </p>

            <p class="mt-1 text-sm font-bold text-gray-800">
                {{ $project->tasks_count }}
            </p>
        </div>

        <div>
            <p class="text-xs text-gray-400">
                Deadline
            </p>

            <p
                @class([
                    'mt-1 truncate text-xs font-semibold',
                    'text-red-600' => $isDelayed,
                    'text-gray-700' => !$isDelayed,
                ])
            >
                {{ $project->end_date
                    ?->translatedFormat('d M Y')
                    ?? '-' }}
            </p>
        </div>
    </div>

    {{-- Aksi --}}
    <div class="mt-auto flex items-center justify-between gap-4 pt-4">
        <p class="truncate text-xs text-gray-400">
            {{ $project->updated_at
                ?->diffForHumans()
                ?? '-' }}
        </p>

        <a
            href="{{ route(
                'mandor.projects.show',
                [
                    'project' => $project->id,
                ]
            ) }}"
            wire:navigate
            class="shrink-0 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
        >
            Lihat Detail
        </a>
    </div>
</article>