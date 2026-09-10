@props([
    'project',
    'totalDocumentations' => 0,
    'categoryStatistics' => collect(),
])

@php
    $progressCount = (int) (
        $categoryStatistics['progress']
        ?? 0
    );

    $obstacleCount = (int) (
        $categoryStatistics['obstacle']
        ?? 0
    );
@endphp

<x-ui.info-card>
    <div class="flex flex-col gap-6 p-6 sm:p-8 lg:flex-row lg:items-center lg:justify-between">
        <div class="min-w-0">
            <p class="text-sm font-semibold text-blue-600">
                {{ $project->project_code }}
            </p>

            <h1 class="mt-2 break-words text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                Dokumentasi Project
            </h1>

            <p class="mt-2 font-medium text-gray-700">
                {{ $project->project_name }}
            </p>

            <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-500">
                Seluruh dokumentasi yang telah diunggah selama pelaksanaan Project.
            </p>
        </div>

        <div class="grid shrink-0 grid-cols-3 gap-3">
            <div class="rounded-2xl border border-blue-100 bg-blue-50 px-4 py-4 text-center">
                <p class="text-xs font-medium text-gray-500">
                    Total
                </p>

                <p class="mt-1 text-2xl font-bold text-blue-600">
                    {{ $totalDocumentations }}
                </p>
            </div>

            <div class="rounded-2xl border border-green-100 bg-green-50 px-4 py-4 text-center">
                <p class="text-xs font-medium text-gray-500">
                    Progress
                </p>

                <p class="mt-1 text-2xl font-bold text-green-600">
                    {{ $progressCount }}
                </p>
            </div>

            <div class="rounded-2xl border border-red-100 bg-red-50 px-4 py-4 text-center">
                <p class="text-xs font-medium text-gray-500">
                    Kendala
                </p>

                <p class="mt-1 text-2xl font-bold text-red-600">
                    {{ $obstacleCount }}
                </p>
            </div>
        </div>
    </div>
</x-ui.info-card>