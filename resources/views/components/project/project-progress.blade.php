@props([
    'project',
])

@php
    $progress = min(
        100,
        max(0, (int) $project->progress)
    );

    $statusText = match ($project->status) {
        'planning' => 'Perencanaan',
        'on_progress' => 'Sedang Berjalan',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
        default => 'Tidak Diketahui',
    };

    $statusColor = match ($project->status) {
        'planning' => 'yellow',
        'on_progress' => 'blue',
        'completed' => 'green',
        'cancelled' => 'red',
        default => 'gray',
    };

    $tasks = $project->tasks ?? collect();

    $totalTasks = $tasks->count();

    $completedTasks = $tasks
        ->where('status', 'completed')
        ->count();

    $submittedTasks = $tasks
        ->where('status', 'submitted')
        ->count();

    $inProgressTasks = $tasks
        ->where('status', 'in_progress')
        ->count();

    $revisionTasks = $tasks
        ->where('status', 'revision')
        ->count();

    $pendingTasks = $totalTasks
        - $completedTasks
        - $submittedTasks
        - $inProgressTasks
        - $revisionTasks;

    $pendingTasks = max(0, $pendingTasks);

    $latestProgress = $project->progresses?->first();

    $lastUpdate = $latestProgress?->created_at
        ?? $project->updated_at;
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Progres Project
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Monitoring perkembangan berdasarkan pekerjaan dan laporan yang telah divalidasi.
                </p>
            </div>

            <x-ui.badge :color="$statusColor">
                {{ $statusText }}
            </x-ui.badge>
        </div>

        <hr class="my-6 border-gray-200 sm:my-8">

        {{-- Progres utama --}}
        <div>
            <div class="mb-3 flex items-center justify-between gap-4">
                <span class="text-sm font-medium text-gray-600">
                    Penyelesaian keseluruhan
                </span>

                <span class="text-lg font-bold text-gray-900">
                    {{ $progress }}%
                </span>
            </div>

            <progress
                value="{{ $progress }}"
                max="100"
                aria-label="Progres penyelesaian Project {{ $progress }} persen"
                @class([
                    'block h-4 w-full appearance-none overflow-hidden rounded-full bg-gray-200',
                    '[&::-webkit-progress-bar]:rounded-full',
                    '[&::-webkit-progress-bar]:bg-gray-200',
                    '[&::-webkit-progress-value]:rounded-full',
                    '[&::-moz-progress-bar]:rounded-full',

                    '[&::-webkit-progress-value]:bg-yellow-500 [&::-moz-progress-bar]:bg-yellow-500' =>
                        $project->status === 'planning',

                    '[&::-webkit-progress-value]:bg-blue-600 [&::-moz-progress-bar]:bg-blue-600' =>
                        $project->status === 'on_progress',

                    '[&::-webkit-progress-value]:bg-green-600 [&::-moz-progress-bar]:bg-green-600' =>
                        $project->status === 'completed',

                    '[&::-webkit-progress-value]:bg-red-500 [&::-moz-progress-bar]:bg-red-500' =>
                        $project->status === 'cancelled',

                    '[&::-webkit-progress-value]:bg-gray-500 [&::-moz-progress-bar]:bg-gray-500' =>
                        !in_array(
                            $project->status,
                            [
                                'planning',
                                'on_progress',
                                'completed',
                                'cancelled',
                            ],
                            true
                        ),
                ])
            >
                {{ $progress }}%
            </progress>

            <div class="mt-3 flex flex-col gap-1 text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between">
                <span>
                    0%
                </span>

                <span>
                    Progres diperbarui setelah laporan pekerjaan divalidasi Mandor
                </span>

                <span>
                    100%
                </span>
            </div>
        </div>

        {{-- Rekap tugas --}}
        <div class="mt-8">
            <h3 class="font-semibold text-gray-900">
                Rekap Status Pekerjaan
            </h3>

            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $totalTasks }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Total Tugas
                    </p>
                </div>

                <div class="rounded-xl border border-yellow-200 bg-yellow-50 p-4">
                    <p class="text-2xl font-bold text-yellow-700">
                        {{ $pendingTasks }}
                    </p>

                    <p class="mt-1 text-xs text-yellow-700">
                        Belum Dimulai
                    </p>
                </div>

                <div class="rounded-xl border border-blue-200 bg-blue-50 p-4">
                    <p class="text-2xl font-bold text-blue-700">
                        {{ $inProgressTasks }}
                    </p>

                    <p class="mt-1 text-xs text-blue-700">
                        Dikerjakan
                    </p>
                </div>

                <div class="rounded-xl border border-purple-200 bg-purple-50 p-4">
                    <p class="text-2xl font-bold text-purple-700">
                        {{ $submittedTasks + $revisionTasks }}
                    </p>

                    <p class="mt-1 text-xs text-purple-700">
                        Pemeriksaan
                    </p>
                </div>

                <div class="rounded-xl border border-green-200 bg-green-50 p-4">
                    <p class="text-2xl font-bold text-green-700">
                        {{ $completedTasks }}
                    </p>

                    <p class="mt-1 text-xs text-green-700">
                        Selesai
                    </p>
                </div>
            </div>
        </div>

        <hr class="my-6 border-gray-200 sm:my-8">

        {{-- Riwayat perkembangan --}}
        <div>
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900">
                        Riwayat Perkembangan
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Catatan perubahan progres Project.
                    </p>
                </div>

                <span class="text-sm text-gray-500">
                    {{ $project->progresses?->count() ?? 0 }}
                    pembaruan
                </span>
            </div>

            @if ($project->progresses?->isNotEmpty())
                <div class="mt-6">
                    @foreach ($project->progresses as $progressHistory)
                        @php
                            $historyPercentage = min(
                                100,
                                max(
                                    0,
                                    (int) $progressHistory
                                        ->progress_percentage
                                )
                            );
                        @endphp

                        <div
                            wire:key="project-progress-{{ $progressHistory->id }}"
                            class="relative flex gap-4 pb-6 last:pb-0"
                        >
                            @if (!$loop->last)
                                <div
                                    class="absolute left-5 top-10 h-full w-px bg-gray-200"
                                ></div>
                            @endif

                            <div
                                class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700"
                            >
                                {{ $historyPercentage }}%
                            </div>

                            <div class="min-w-0 flex-1 rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            Progres diperbarui menjadi
                                            {{ $historyPercentage }}%
                                        </p>

                                        <p class="mt-1 text-sm text-gray-500">
                                            Oleh
                                            {{ $progressHistory->user?->name
                                                ?? 'Sistem' }}
                                        </p>
                                    </div>

                                    <time
                                        datetime="{{ $progressHistory->created_at?->toIso8601String() }}"
                                        class="shrink-0 text-xs text-gray-500"
                                    >
                                        {{ $progressHistory->created_at
                                            ? $progressHistory->created_at
                                                ->translatedFormat('d M Y, H:i')
                                            : '-' }}
                                    </time>
                                </div>

                                @if ($progressHistory->description)
                                    <p class="mt-3 whitespace-pre-line break-words text-sm leading-6 text-gray-700">
                                        {{ $progressHistory->description }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    class="mt-5 rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 py-8 text-center"
                >
                    <p class="font-semibold text-gray-700">
                        Belum ada riwayat progres
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Riwayat akan tersedia setelah pekerjaan mulai berjalan dan laporan divalidasi Mandor.
                    </p>
                </div>
            @endif
        </div>

        <hr class="my-6 border-gray-200">

        {{-- Terakhir diperbarui --}}
        <div class="flex flex-col gap-1 text-sm sm:flex-row sm:items-center sm:justify-between">
            <span class="text-gray-500">
                Terakhir diperbarui
            </span>

            <span class="font-semibold text-gray-700">
                {{ $lastUpdate
                    ? $lastUpdate->translatedFormat('d F Y, H:i')
                    : '-' }}
            </span>
        </div>
    </div>
</x-ui.info-card>