@props([
    'projects',
    'search' => '',
    'status' => '',
    'sort' => 'latest',
])

@php
    $hasFilters =
        trim($search) !== ''
        || $status !== ''
        || $sort !== 'latest';
@endphp

<div>
    @if ($projects->isNotEmpty())
        <div class="grid items-start grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($projects as $project)
                <x-mandor.projects.project-card
                    :project="$project"
                />
            @endforeach
        </div>

        @if ($projects->hasPages())
            <div class="mt-6">
                {{ $projects->links() }}
            </div>
        @endif
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
                            d="M3 20.25h18M5.25 20.25V8.25L12 3l6.75 5.25v12M9 20.25v-6h6v6"
                        />
                    </svg>
                </div>

                <p class="mt-4 font-semibold text-gray-700">
                    Project tidak ditemukan
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    @if ($hasFilters)
                        Tidak ada Project yang sesuai dengan pencarian atau filter.
                    @else
                        Belum ada Project yang ditugaskan kepada Anda.
                    @endif
                </p>

                @if ($hasFilters)
                    <button
                        type="button"
                        wire:click="resetFilters"
                        wire:loading.attr="disabled"
                        wire:target="resetFilters"
                        class="mt-5 inline-flex min-h-10 items-center justify-center rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        Reset Filter
                    </button>
                @endif
            </div>
        </x-ui.info-card>
    @endif
</div>