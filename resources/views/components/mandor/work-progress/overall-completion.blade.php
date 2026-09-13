@props([
    'actualProgress' => 0,
    'plannedProgress' => 0,
    'progressVariance' => 0,
    'taskStatistics' => [],
])

@php
    $actualProgress = max(
        0,
        min(100, (int) $actualProgress)
    );

    $plannedProgress = max(
        0,
        min(100, (int) $plannedProgress)
    );

    $progressVariance = (int) $progressVariance;

    $progressConfiguration = match (true) {
        $progressVariance > 0 => [
            'label' => 'Di Atas Rencana',
            'text' => 'text-emerald-600',
            'stroke' => 'stroke-emerald-500',
            'varianceBackground' => 'bg-emerald-50',
            'varianceText' => 'text-emerald-600',
        ],

        $progressVariance < 0 => [
            'label' => 'Di Bawah Rencana',
            'text' => 'text-amber-600',
            'stroke' => 'stroke-amber-500',
            'varianceBackground' => 'bg-amber-50',
            'varianceText' => 'text-amber-600',
        ],

        default => [
            'label' => 'Sesuai Rencana',
            'text' => 'text-blue-600',
            'stroke' => 'stroke-blue-600',
            'varianceBackground' => 'bg-blue-50',
            'varianceText' => 'text-blue-600',
        ],
    };

    $formattedVariance = $progressVariance > 0
        ? '+' . $progressVariance . '%'
        : $progressVariance . '%';
@endphp

<x-ui.info-card class="h-full overflow-hidden">

    <div class="border-b border-gray-200 px-6 py-5">
        <h2 class="text-base font-bold text-gray-900">
            Penyelesaian Keseluruhan
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Perbandingan progress aktual dan rencana proyek
        </p>
    </div>

    <div class="flex flex-col items-center px-6 py-7">

        <div class="relative flex h-44 w-44 items-center justify-center">
            <svg
                class="h-full w-full -rotate-90"
                viewBox="0 0 120 120"
                aria-hidden="true"
            >
                <circle
                    cx="60"
                    cy="60"
                    r="52"
                    pathLength="100"
                    fill="none"
                    stroke-width="10"
                    class="stroke-gray-100"
                />

                <circle
                    cx="60"
                    cy="60"
                    r="52"
                    pathLength="100"
                    fill="none"
                    stroke-width="10"
                    stroke-linecap="round"
                    stroke-dasharray="100"
                    stroke-dashoffset="{{ 100 - $actualProgress }}"
                    class="{{ $progressConfiguration['stroke'] }} transition-all duration-500"
                />
            </svg>

            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-4xl font-bold text-gray-900">
                    {{ $actualProgress }}%
                </span>

                <span
                    class="mt-1 text-center text-[11px] font-bold uppercase tracking-wide {{ $progressConfiguration['text'] }}"
                >
                    {{ $progressConfiguration['label'] }}
                </span>
            </div>
        </div>

        <div class="mt-7 grid w-full grid-cols-2 gap-3">
            <div class="rounded-xl bg-gray-50 p-4 text-center">
                <p class="text-xs font-medium text-gray-500">
                    Rencana
                </p>

                <p class="mt-1 text-xl font-bold text-gray-900">
                    {{ $plannedProgress }}%
                </p>
            </div>

            <div
                class="rounded-xl p-4 text-center {{ $progressConfiguration['varianceBackground'] }}"
            >
                <p class="text-xs font-medium text-gray-500">
                    Selisih
                </p>

                <p
                    class="mt-1 text-xl font-bold {{ $progressConfiguration['varianceText'] }}"
                >
                    {{ $formattedVariance }}
                </p>
            </div>
        </div>

        <div class="mt-5 grid w-full grid-cols-3 divide-x divide-gray-200 border-t border-gray-200 pt-5">
            <div class="px-2 text-center">
                <p class="text-lg font-bold text-gray-900">
                    {{ $taskStatistics['total'] ?? 0 }}
                </p>

                <p class="mt-1 text-[11px] text-gray-500">
                    Total Task
                </p>
            </div>

            <div class="px-2 text-center">
                <p class="text-lg font-bold text-blue-600">
                    {{ $taskStatistics['active'] ?? 0 }}
                </p>

                <p class="mt-1 text-[11px] text-gray-500">
                    Berjalan
                </p>
            </div>

            <div class="px-2 text-center">
                <p class="text-lg font-bold text-emerald-600">
                    {{ $taskStatistics['completed'] ?? 0 }}
                </p>

                <p class="mt-1 text-[11px] text-gray-500">
                    Selesai
                </p>
            </div>
        </div>

    </div>

</x-ui.info-card>