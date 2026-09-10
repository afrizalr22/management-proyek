<div class="space-y-6">
    {{-- Header --}}
    <x-ui.page-header
        title="Project Monitoring"
        description="Pantau perkembangan seluruh Project perusahaan."
    />

    {{-- Statistik --}}
    <x-monitoring.monitoring-statistics
        :statistics="$statistics"
    />

    {{-- Toolbar --}}
    <x-monitoring.monitoring-toolbar
        :search="$search"
        :status="$status"
        :mandor-id="$mandorId"
        :sort="$sort"
        :mandors="$mandors"
    />

    {{-- Daftar Project --}}
    @if ($projects->isNotEmpty())
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            @foreach ($projects as $project)
                <x-monitoring.monitoring-card
                    :project="$project"
                    wire:key="monitoring-project-{{ $project->id }}"
                />
            @endforeach
        </div>
    @else
        <x-ui.info-card>
            <div class="px-6 py-14 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-7 w-7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h4.379a2.25 2.25 0 0 1 1.59.659l1.122 1.122a2.25 2.25 0 0 0 1.59.659H19.5A2.25 2.25 0 0 1 21.75 9v8.25A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75Z"
                        />
                    </svg>
                </div>

                <p class="mt-4 font-semibold text-gray-700">
                    Project tidak ditemukan
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Belum ada Project atau filter yang digunakan tidak sesuai.
                </p>

                @if (
                    $search !== ''
                    || $status !== ''
                    || $mandorId !== ''
                    || $sort !== 'latest'
                )
                    <button
                        type="button"
                        wire:click="resetFilters"
                        class="mt-5 inline-flex min-h-10 items-center justify-center rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
                    >
                        Reset Filter
                    </button>
                @endif
            </div>
        </x-ui.info-card>
    @endif

    {{-- Pagination --}}
    <x-monitoring.monitoring-pagination
        :projects="$projects"
    />
</div>