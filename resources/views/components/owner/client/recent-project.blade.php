@props([
    'projects',
])

<x-ui.info-card>

    <div class="border-b p-6">
        <h3 class="text-lg font-bold text-gray-800">
            Project Terbaru
        </h3>

        <p class="mt-1 text-sm text-gray-500">
            Daftar Project terakhir milik Client.
        </p>
    </div>

    <div class="space-y-4 p-6">
        @forelse ($projects as $project)
            @php
                $statusText = match ($project->status) {
                    'draft' => 'Draft',
                    'planning' => 'Perencanaan',
                    'on_progress' => 'Berjalan',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                    default => 'Tidak diketahui',
                };

                $statusColor = match ($project->status) {
                    'planning', 'on_progress' => 'blue',
                    'completed' => 'green',
                    'cancelled' => 'red',
                    default => 'gray',
                };

                $progress = min(
                    100,
                    max(0, (float) ($project->progress ?? 0))
                );
            @endphp

            <a
                href="{{ route(
                    'owner.projects.show',
                    ['project' => $project->id]
                ) }}"
                wire:navigate
                class="block"
            >
                <div
                    class="rounded-xl border border-gray-200 p-5 transition hover:border-blue-200 hover:bg-blue-50/30"
                >
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <h3 class="break-words font-semibold text-gray-900">
                                {{ $project->project_name }}
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                {{ $project->start_date
                                    ? $project->start_date->format('d-m-Y')
                                    : '-' }}
                            </p>
                        </div>

                        <x-ui.badge :color="$statusColor">
                            {{ $statusText }}
                        </x-ui.badge>
                    </div>

                    <div class="mt-5">
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-sm text-gray-500">
                                Progress
                            </span>

                            <span class="text-sm font-semibold text-blue-600">
                                {{ $progress }}%
                            </span>
                        </div>

                        <div
                            x-data="{ progress: @js($progress) }"
                            class="h-3 overflow-hidden rounded-full bg-gray-200"
                        >
                            <div
                                x-bind:style="{ width: progress + '%' }"
                                class="h-full rounded-full bg-blue-600 transition-all duration-500"
                            ></div>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div
                class="rounded-xl border border-dashed border-gray-300 px-6 py-10 text-center"
            >
                <p class="font-semibold text-gray-700">
                    Belum ada Project
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Client ini belum memiliki Project yang terdaftar.
                </p>
            </div>
        @endforelse
    </div>

</x-ui.info-card>