@props([
    'projects',
])

<x-ui.info-card>
    <div class="flex flex-col gap-4 border-b border-gray-200 p-6 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">
                Pipeline Project
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Ringkasan status dan perkembangan Project perusahaan.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <span class="rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-600">
                {{ $projects->count() }} Project
            </span>

            <a
                href="{{ route('owner.monitoring.index') }}"
                wire:navigate
                class="text-sm font-semibold text-blue-600 transition hover:text-blue-700"
            >
                Lihat Semua
            </a>
        </div>
    </div>

    @if ($projects->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b border-gray-200">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Project
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Client
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Mandor
                        </th>

                        <th class="min-w-64 px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Progress
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Task
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Deadline
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($projects as $project)
                        @php
                            $progress = min(
                                max(
                                    (int) $project->progress,
                                    0
                                ),
                                100
                            );

                            $isDelayed =
                                $project->end_date
                                && $project->end_date->lt(today())
                                && ! in_array(
                                    $project->status,
                                    [
                                        'completed',
                                        'cancelled',
                                    ],
                                    true
                                );

                            [$statusText, $statusColor] =
                                match (true) {
                                    $isDelayed => [
                                        'Terlambat',
                                        'red',
                                    ],

                                    $project->status ===
                                        'planning' => [
                                        'Perencanaan',
                                        'yellow',
                                    ],

                                    in_array(
                                        $project->status,
                                        [
                                            'in_progress',
                                            'ongoing',
                                        ],
                                        true
                                    ) => [
                                        'Berjalan',
                                        'blue',
                                    ],

                                    $project->status ===
                                        'completed' => [
                                        'Selesai',
                                        'green',
                                    ],

                                    $project->status ===
                                        'on_hold' => [
                                        'Ditunda',
                                        'yellow',
                                    ],

                                    $project->status ===
                                        'cancelled' => [
                                        'Dibatalkan',
                                        'red',
                                    ],

                                    default => [
                                        'Tidak Diketahui',
                                        'gray',
                                    ],
                                };

                            $deadlineText = '-';
                            $deadlineColor =
                                'text-gray-500';

                            if ($project->end_date) {
                                if (
                                    $project->status ===
                                    'completed'
                                ) {
                                    $deadlineText =
                                        'Project selesai';

                                    $deadlineColor =
                                        'text-green-600';
                                } elseif (
                                    $project->status ===
                                    'cancelled'
                                ) {
                                    $deadlineText =
                                        'Project dibatalkan';

                                    $deadlineColor =
                                        'text-red-600';
                                } elseif ($isDelayed) {
                                    $lateDays =
                                        (int) $project
                                            ->end_date
                                            ->diffInDays(
                                                today()
                                            );

                                    $deadlineText =
                                        'Terlambat '
                                        .$lateDays
                                        .' hari';

                                    $deadlineColor =
                                        'text-red-600';
                                } else {
                                    $remainingDays =
                                        (int) today()
                                            ->diffInDays(
                                                $project
                                                    ->end_date
                                            );

                                    $deadlineText =
                                        'Sisa '
                                        .$remainingDays
                                        .' hari';

                                    $deadlineColor =
                                        $remainingDays <= 7
                                            ? 'text-amber-600'
                                            : 'text-green-600';
                                }
                            }
                        @endphp

                        <tr
                            wire:key="dashboard-project-{{ $project->id }}"
                            class="transition hover:bg-blue-50"
                        >
                            <td class="px-6 py-5">
                                <a
                                    href="{{ route(
                                        'owner.monitoring.show',
                                        [
                                            'project' =>
                                                $project->id,
                                        ]
                                    ) }}"
                                    wire:navigate
                                    class="group block"
                                >
                                    <p class="font-semibold text-gray-900 transition group-hover:text-blue-600">
                                        {{ $project->project_name }}
                                    </p>

                                    <p class="mt-1 text-xs font-medium uppercase tracking-wide text-gray-400">
                                        {{ $project->project_code }}
                                    </p>
                                </a>
                            </td>

                            <td class="px-6 py-5">
                                <p class="font-medium text-gray-900">
                                    {{ $project->client
                                        ?->company_name
                                        ?? 'Client tidak tersedia' }}
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $project->client?->city
                                        ?? '-' }}
                                </p>
                            </td>

                            <td class="px-6 py-5">
                                <p class="font-medium text-gray-900">
                                    {{ $project->mandor?->name
                                        ?? 'Belum ditentukan' }}
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Mandor Project
                                </p>
                            </td>

                            <td class="min-w-64 px-6 py-5">
                                <div class="mb-2 flex items-center justify-between gap-4">
                                    <span class="text-sm text-gray-500">
                                        Penyelesaian
                                    </span>

                                    <span class="text-sm font-semibold text-blue-600">
                                        {{ $progress }}%
                                    </span>
                                </div>

                                <div class="h-2.5 overflow-hidden rounded-full bg-gray-200">
                                    <div
                                        x-data="{
                                            progress: @js($progress)
                                        }"
                                        x-bind:style="`width: ${progress}%`"
                                        @class([
                                            'h-full rounded-full',
                                            'bg-green-500' =>
                                                $progress >= 100,
                                            'bg-blue-600' =>
                                                $progress > 0
                                                && $progress < 100,
                                            'bg-gray-400' =>
                                                $progress <= 0,
                                        ])
                                    ></div>
                                </div>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <p class="font-semibold text-gray-900">
                                    {{ $project->completed_tasks_count }}
                                    /
                                    {{ $project->tasks_count }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Selesai
                                </p>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <x-ui.badge :color="$statusColor">
                                    {{ $statusText }}
                                </x-ui.badge>
                            </td>

                            <td class="whitespace-nowrap px-6 py-5">
                                <p class="font-medium text-gray-900">
                                    {{ $project->end_date
                                        ?->translatedFormat(
                                            'd M Y'
                                        ) ?? '-' }}
                                </p>

                                <p class="mt-1 text-xs font-medium {{ $deadlineColor }}">
                                    {{ $deadlineText }}
                                </p>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <a
                                    href="{{ route(
                                        'owner.monitoring.show',
                                        [
                                            'project' =>
                                                $project->id,
                                        ]
                                    ) }}"
                                    wire:navigate
                                    title="Lihat Monitoring"
                                    aria-label="Lihat Monitoring {{ $project->project_name }}"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 transition hover:bg-blue-100 hover:text-blue-700"
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
                                            d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6-9.75-6-9.75-6Z"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="2.5"
                                        />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="px-6 py-14 text-center">
            <p class="font-semibold text-gray-700">
                Belum ada Project
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Pipeline akan tampil setelah Project dibuat.
            </p>
        </div>
    @endif
</x-ui.info-card>