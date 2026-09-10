@props([
    'project',
    'isDelayed' => false,
])

@php
    [$statusText, $statusColor] = match (true) {
        $isDelayed => [
            'Terlambat',
            'red',
        ],

        $project->status === 'planning' => [
            'Perencanaan',
            'yellow',
        ],

        in_array(
            $project->status,
            ['in_progress', 'ongoing'],
            true
        ) => [
            'Berjalan',
            'blue',
        ],

        $project->status === 'completed' => [
            'Selesai',
            'green',
        ],

        $project->status === 'on_hold' => [
            'Ditunda',
            'yellow',
        ],

        $project->status === 'cancelled' => [
            'Dibatalkan',
            'red',
        ],

        default => [
            'Tidak Diketahui',
            'gray',
        ],
    };

    $progress = min(
        max((int) $project->progress, 0),
        100
    );
@endphp

<x-ui.card>
    <div class="p-6 sm:p-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-3">
                    <p class="text-sm font-semibold text-blue-600">
                        {{ $project->project_code }}
                    </p>

                    <x-ui.badge :color="$statusColor">
                        {{ $statusText }}
                    </x-ui.badge>
                </div>

                <h1 class="mt-3 break-words text-2xl font-bold leading-tight text-gray-900 sm:text-3xl">
                    {{ $project->project_name }}
                </h1>

                <p class="mt-3 max-w-3xl text-sm leading-6 text-gray-500">
                    {{ filled($project->description)
                        ? $project->description
                        : 'Monitoring perkembangan Project, pekerjaan, laporan, dan dokumentasi lapangan.' }}
                </p>

                <div class="mt-5 max-w-2xl">
                    <div class="mb-2 flex items-center justify-between gap-4">
                        <span class="text-sm font-medium text-gray-600">
                            Progress Project
                        </span>

                        <span class="font-bold text-blue-600">
                            {{ $progress }}%
                        </span>
                    </div>

                    <div class="h-3 overflow-hidden rounded-full bg-gray-200">
                        <div
                            x-data="{ progress: @js($progress) }"
                            x-bind:style="`width: ${progress}%`"
                            class="h-full rounded-full bg-blue-600 transition-all duration-500"
                        ></div>
                    </div>
                </div>
            </div>

            <a
                href="{{ route('owner.monitoring.index') }}"
                wire:navigate
                class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
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
                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
                    />
                </svg>

                Kembali
            </a>
        </div>
    </div>
</x-ui.card>