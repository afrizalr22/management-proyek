@props([
    'projects',
])

@php
    $averageProgress = $projects->isNotEmpty()
        ? (int) round(
            $projects->avg(
                fn ($project): int =>
                    min(
                        max(
                            (int) $project->progress,
                            0
                        ),
                        100
                    )
            )
        )
        : 0;

    $projectCount = $projects->count();
@endphp

<div class="h-full overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm xl:col-span-2">
    {{-- Header --}}
    <div class="flex flex-col gap-4 border-b border-gray-200 p-6 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">
                Grafik Progress Project
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Perbandingan persentase penyelesaian Project aktif.
            </p>
        </div>

        <div class="flex items-center gap-5">
            @if ($projects->isNotEmpty())
                <div class="text-right">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                        Rata-rata
                    </p>

                    <p class="text-xl font-bold text-blue-600">
                        {{ $averageProgress }}%
                    </p>
                </div>
            @endif

            <a
                href="{{ route('owner.monitoring.index') }}"
                wire:navigate
                class="text-sm font-semibold text-blue-600 transition hover:text-blue-700"
            >
                Lihat Monitoring
            </a>
        </div>
    </div>

    <div class="p-5 sm:p-6">
        @if ($projects->isNotEmpty())
            <div class="overflow-x-auto pb-2">
                <div
                    x-data="{
                        projectCount: @js($projectCount)
                    }"
                    x-bind:style="`
                        min-width: ${Math.max(
                            650,
                            projectCount * 145
                        )}px;
                    `"
                >
                    <div class="flex">
                        {{-- Sumbu Persentase --}}
                        <div class="relative h-80 w-14 shrink-0 xl:h-[520px]">
                            <span class="absolute right-3 top-1 text-xs font-medium text-gray-400">
                                100%
                            </span>

                            <span class="absolute right-3 top-1/4 -translate-y-1/2 text-xs font-medium text-gray-400">
                                75%
                            </span>

                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-medium text-gray-400">
                                50%
                            </span>

                            <span class="absolute right-3 top-3/4 -translate-y-1/2 text-xs font-medium text-gray-400">
                                25%
                            </span>

                            <span class="absolute bottom-0 right-3 text-xs font-medium text-gray-400">
                                0%
                            </span>
                        </div>

                        {{-- Grafik --}}
                        <div class="min-w-0 flex-1">
                            <div class="relative h-80 border-b border-l border-gray-300 xl:h-[520px]">
                                {{-- Garis Skala --}}
                                <div class="pointer-events-none absolute inset-0">
                                    <div class="absolute left-0 right-0 top-0 border-t border-dashed border-gray-200"></div>

                                    <div class="absolute left-0 right-0 top-1/4 border-t border-dashed border-gray-200"></div>

                                    <div class="absolute left-0 right-0 top-1/2 border-t border-dashed border-gray-200"></div>

                                    <div class="absolute left-0 right-0 top-3/4 border-t border-dashed border-gray-200"></div>
                                </div>

                                {{-- Batang Project --}}
                                <div
                                    x-bind:style="`
                                        grid-template-columns: repeat(
                                            ${projectCount},
                                            minmax(112px, 1fr)
                                        );
                                    `"
                                    class="absolute inset-0 grid items-end gap-6 px-8"
                                >
                                    @foreach ($projects as $project)
                                        @php
                                            $progress = min(
                                                max(
                                                    (int) $project->progress,
                                                    0
                                                ),
                                                100
                                            );

                                            $barHeight = max(
                                                $progress,
                                                1.5
                                            );

                                            $barColor = match (true) {
                                                $progress >= 100 =>
                                                    'bg-green-500',

                                                $progress >= 75 =>
                                                    'bg-blue-600',

                                                $progress >= 50 =>
                                                    'bg-indigo-500',

                                                $progress > 0 =>
                                                    'bg-amber-500',

                                                default =>
                                                    'bg-gray-400',
                                            };
                                        @endphp

                                        <div
                                            wire:key="dashboard-progress-chart-{{ $project->id }}"
                                            class="group relative flex h-full min-w-0 items-end justify-center"
                                        >
                                            <div
                                                x-data="{
                                                    height: @js($barHeight)
                                                }"
                                                x-bind:style="`
                                                    height: ${height}%;
                                                `"
                                                class="relative w-full max-w-24 rounded-t-xl transition-all duration-500 hover:opacity-85 {{ $barColor }}"
                                            >
                                                <span
                                                    @class([
                                                        'absolute left-1/2 z-10 -translate-x-1/2 whitespace-nowrap text-sm font-bold',

                                                        'top-2 text-white' =>
                                                            $progress >= 95,

                                                        '-top-8 text-gray-700' =>
                                                            $progress < 95,
                                                    ])
                                                >
                                                    {{ $progress }}%
                                                </span>

                                                <div class="absolute inset-x-0 top-3 z-20 hidden px-1 text-center group-hover:block">
                                                    <span class="inline-block max-w-44 rounded-lg bg-gray-900 px-2.5 py-1.5 text-[10px] font-semibold leading-4 text-white shadow-lg">
                                                        {{ $project->project_name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Label Project --}}
                            <div
                                x-bind:style="`
                                    grid-template-columns: repeat(
                                        ${projectCount},
                                        minmax(112px, 1fr)
                                    );
                                `"
                                class="grid gap-6 px-8 pt-4"
                            >
                                @foreach ($projects as $project)
                                    <div
                                        wire:key="dashboard-progress-label-{{ $project->id }}"
                                        class="min-w-0 text-center"
                                    >
                                        <a
                                            href="{{ route(
                                                'owner.monitoring.show',
                                                [
                                                    'project' =>
                                                        $project->id,
                                                ]
                                            ) }}"
                                            wire:navigate
                                            class="block truncate text-xs font-semibold text-gray-700 transition hover:text-blue-600"
                                            title="{{ $project->project_name }}"
                                        >
                                            {{ $project->project_code }}
                                        </a>

                                        <p
                                            class="mt-1 truncate text-[11px] text-gray-400"
                                            title="{{ $project->project_name }}"
                                        >
                                            {{ $project->project_name }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Legenda --}}
                    <div class="mt-5 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 border-t border-gray-100 pt-4">
                        <div class="flex items-center gap-2">
                            <span class="h-3 w-3 rounded-full bg-gray-400"></span>

                            <span class="text-xs text-gray-500">
                                Belum Dimulai
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="h-3 w-3 rounded-full bg-amber-500"></span>

                            <span class="text-xs text-gray-500">
                                1–49%
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="h-3 w-3 rounded-full bg-indigo-500"></span>

                            <span class="text-xs text-gray-500">
                                50–74%
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="h-3 w-3 rounded-full bg-blue-600"></span>

                            <span class="text-xs text-gray-500">
                                75–99%
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="h-3 w-3 rounded-full bg-green-500"></span>

                            <span class="text-xs text-gray-500">
                                Selesai
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="flex min-h-80 items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 text-center">
                <div>
                    <p class="font-semibold text-gray-700">
                        Belum ada Project aktif
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Grafik akan muncul ketika terdapat Project aktif.
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>