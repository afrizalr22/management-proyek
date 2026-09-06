@props([
    'projects',
    'search' => '',
    'status' => '',
    'sort' => 'latest',
])

<div class="grid items-start gap-6 pb-8 md:grid-cols-2 xl:grid-cols-3">
    @forelse ($projects as $project)
        @php
            $statusText = match ($project->status) {
                'planning' => 'Perencanaan',
                'on_progress' => 'Sedang Berjalan',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
                default => 'Tidak Diketahui',
            };

            $progress = min(
                100,
                max(0, (int) $project->progress)
            );

            $clientName =
                $project->client?->company_name
                ?? 'Client tidak tersedia';

            $mandorName =
                $project->mandor?->name
                ?? 'Belum ditentukan';

            $budget = 'Rp'.number_format(
                (float) $project->contract_value,
                0,
                ',',
                '.'
            );

            $target = $project->end_date
                ? $project->end_date->translatedFormat('d F Y')
                : 'Belum ditentukan';
        @endphp

        <div
            wire:key="project-card-{{ $project->id }}"
            class="min-w-0 self-start"
        >
            <x-project.project-card
                :project-id="$project->id"
                :code="$project->project_code"
                :name="$project->project_name"
                :type="$project->location"
                :client="$clientName"
                :mandor="$mandorName"
                :progress="$progress"
                :budget="$budget"
                :target="$target"
                :status="$project->status"
                :show-url="route('owner.projects.show', [
                    'project' => $project->id,
                ])"
                :edit-url="route('owner.projects.edit', [
                    'project' => $project->id,
                ])"
                :can-edit="$project->status !== 'completed'
                    && $project->status !== 'cancelled'"
                :can-delete="$project->status === 'planning'"
            />

            {{-- Informasi tambahan --}}
            <div
                class="mt-3 rounded-2xl border border-gray-200 bg-gray-50 p-5"
            >
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-xs text-gray-500">
                            Pekerja
                        </p>

                        <p class="mt-1 font-semibold text-gray-800">
                            {{ $project->workers_count }} orang
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">
                            Pekerjaan
                        </p>

                        <p class="mt-1 font-semibold text-gray-800">
                            {{ $project->tasks_count }} tugas
                        </p>
                    </div>
                </div>

                @if ($project->location)
                    <div class="mt-3 border-t border-gray-200 pt-3">
                        <p class="text-xs text-gray-500">
                            Lokasi
                        </p>

                        <p class="mt-1 line-clamp-2 text-sm font-medium text-gray-700">
                            {{ $project->location }}
                        </p>
                    </div>
                @endif

                <p class="mt-3 text-xs font-medium text-gray-500">
                    Status: {{ $statusText }}
                </p>
            </div>
        </div>
    @empty
        <div
            class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center md:col-span-2 xl:col-span-3"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="mx-auto h-12 w-12 text-gray-300"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3.75 21h16.5M4.5 3h15l-.75 18H5.25L4.5 3Zm3 4.5h9m-9 4.5h9m-9 4.5h5.25"
                />
            </svg>

            <p class="mt-4 font-semibold text-gray-700">
                Data Project tidak ditemukan
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Ubah pencarian atau filter untuk menemukan Project lainnya.
            </p>

            @if (
                $search !== ''
                || $status !== ''
                || $sort !== 'latest'
            )
                <button
                    type="button"
                    wire:click="resetFilters"
                    class="mt-5 inline-flex min-h-10 items-center justify-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
                >
                    Reset Filter
                </button>
            @endif
        </div>
    @endforelse
</div>