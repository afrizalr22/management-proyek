@props([
    'project',
    'summary' => [],
])

@php
    $isDelayed = (bool) (
        $summary['is_delayed']
        ?? false
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

            'on_progress',
            'in_progress',
            'ongoing' => [
                'Sedang Berjalan',
                'blue',
            ],

            'on_hold' => [
                'Ditunda',
                'gray',
            ],

            'completed' => [
                'Selesai',
                'green',
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
@endphp

<x-ui.info-card class="overflow-hidden">
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 px-5 py-6 sm:px-7 sm:py-7">
        {{-- Dekorasi --}}
        <div class="absolute -right-12 -top-16 h-48 w-48 rounded-full bg-white/10"></div>

        <div class="absolute -bottom-20 left-1/3 h-48 w-48 rounded-full bg-white/5"></div>

        <div class="relative">
            {{-- Kembali --}}
            <a
                href="{{ route('mandor.projects.index') }}"
                wire:navigate
                class="inline-flex items-center gap-2 text-sm font-semibold text-blue-100 transition hover:text-white"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="h-4 w-4"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m15 18-6-6 6-6"
                    />
                </svg>

                Kembali ke Proyek Saya
            </a>

            <div class="mt-5 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                {{-- Identitas Project --}}
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-3">
                        <x-ui.badge :color="$statusColor">
                            {{ $statusText }}
                        </x-ui.badge>

                        <span class="text-xs font-semibold uppercase tracking-wider text-blue-200">
                            {{ $project->project_code }}
                        </span>
                    </div>

                    <h1 class="mt-3 break-words text-2xl font-bold text-white sm:text-3xl">
                        {{ $project->project_name }}
                    </h1>

                    <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-blue-100">
                        <span class="inline-flex items-center gap-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-4 w-4"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"
                                />
                            </svg>

                            {{ $project->location
                                ?: 'Lokasi belum ditentukan' }}
                        </span>

                        <span class="inline-flex items-center gap-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-4 w-4"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
                                />
                            </svg>

                            {{ $project->client?->company_name
                                ?? 'Client tidak tersedia' }}
                        </span>
                    </div>
                </div>

                {{-- Navigasi Project --}}
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a
                        href="{{ route(
                            'mandor.projects.work-progress.index',
                            [
                                'project' => $project->id,
                            ]
                        ) }}"
                        wire:navigate
                        class="inline-flex min-h-11 items-center justify-center rounded-xl border border-white/30 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20"
                    >
                        Progress Pekerjaan
                    </a>

                    <a
                        href="{{ route(
                            'mandor.projects.documentations.index',
                            [
                                'project' => $project->id,
                            ]
                        ) }}"
                        wire:navigate
                        class="inline-flex min-h-11 items-center justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-blue-700 shadow-sm transition hover:bg-blue-50"
                    >
                        Photo Gallery
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-ui.info-card>