@props([
    'deliveryOrder',
])

@php
    $project = $deliveryOrder->project;
    $client = $project?->client;

    $projectProgress = min(
        max(
            (int) ($project?->progress ?? 0),
            0
        ),
        100
    );

    [$projectStatusText, $projectStatusColor] = match (
        $project?->status
    ) {
        'planning' => [
            'Perencanaan',
            'yellow',
        ],
        'ongoing', 'in_progress' => [
            'Berjalan',
            'blue',
        ],
        'completed' => [
            'Selesai',
            'green',
        ],
        'on_hold' => [
            'Ditunda',
            'gray',
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

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        {{-- Header --}}
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Informasi Project
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Project yang berkaitan dengan Surat Jalan.
                </p>
            </div>

            @if ($project)
                <x-ui.badge :color="$projectStatusColor">
                    {{ $projectStatusText }}
                </x-ui.badge>
            @endif
        </div>

        <hr class="my-6 border-gray-200">

        @if ($project)
            <div class="space-y-5">
                {{-- Kode Project --}}
                <div>
                    <p class="text-sm text-gray-500">
                        Kode Project
                    </p>

                    <p class="mt-1 font-semibold text-blue-600">
                        {{ $project->project_code ?: '-' }}
                    </p>
                </div>

                {{-- Nama Project --}}
                <div>
                    <p class="text-sm text-gray-500">
                        Nama Project
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $project->project_name ?: '-' }}
                    </p>
                </div>

                {{-- Lokasi --}}
                <div>
                    <p class="text-sm text-gray-500">
                        Lokasi Project
                    </p>

                    <p class="mt-1 whitespace-pre-line leading-7 text-gray-800">
                        {{ $project->location ?: '-' }}
                    </p>
                </div>

                {{-- Client dan kontrak --}}
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <p class="text-sm text-gray-500">
                            Client
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $client?->company_name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Nomor Kontrak
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $project->contract_number ?: '-' }}
                        </p>
                    </div>
                </div>

                {{-- Periode Project --}}
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <p class="text-sm text-gray-500">
                            Tanggal Mulai
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $project->start_date
                                ?->translatedFormat('d F Y') ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Tanggal Selesai
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $project->end_date
                                ?->translatedFormat('d F Y') ?? '-' }}
                        </p>
                    </div>
                </div>

                {{-- Progress --}}
                <div>
                    <div class="mb-2 flex items-center justify-between gap-4">
                        <p class="text-sm text-gray-500">
                            Progress Project
                        </p>

                        <p class="text-sm font-semibold text-gray-900">
                            {{ $projectProgress }}%
                        </p>
                    </div>

                    <div
                        x-data="{ progress: {{ $projectProgress }} }"
                        class="h-2.5 overflow-hidden rounded-full bg-gray-200"
                    >
                        <div
                            class="h-full rounded-full bg-blue-600 transition-all duration-300"
                            x-bind:style="{ width: progress + '%' }"
                        ></div>
                    </div>
                </div>

                {{-- Link Project --}}
                @if (
                    Route::has('owner.projects.show')
                    && $project->id
                )
                    <div class="pt-1">
                        <a
                            href="{{ route(
                                'owner.projects.show',
                                [
                                    'project' =>
                                        $project->id,
                                ]
                            ) }}"
                            wire:navigate
                            class="inline-flex min-h-10 items-center justify-center rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
                        >
                            Lihat Project
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-8 text-center">
                <p class="font-semibold text-gray-700">
                    Project tidak tersedia
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Project yang berkaitan dengan Surat Jalan ini tidak ditemukan.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>