@props([
    'project',
])

@php
    $documentations = $project->documentations
        ->take(3);

    $categoryLabels = [
        'progress' => 'Progress',
        'material' => 'Material',
        'safety' => 'Keselamatan',
        'obstacle' => 'Kendala',
        'other' => 'Lainnya',
    ];

    $categoryColors = [
        'progress' => 'blue',
        'material' => 'yellow',
        'safety' => 'green',
        'obstacle' => 'red',
        'other' => 'gray',
    ];
@endphp

<x-ui.info-card class="h-full">
    <div class="flex h-full flex-col p-6 sm:p-8">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h2 class="text-2xl font-bold text-gray-800">
                    Dokumentasi Terbaru
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Dokumentasi terbaru dari lokasi Project.
                </p>
            </div>

            <a
                href="{{ route(
                    'owner.monitoring.documentation',
                    [
                        'project' => $project->id,
                    ]
                ) }}"
                wire:navigate
                class="inline-flex shrink-0 items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
            >
                <span>Lihat Semua</span>

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m9 5 7 7-7 7"
                    />
                </svg>
            </a>
        </div>

        @if ($documentations->isNotEmpty())
            <div class="mt-8 flex-1 space-y-5">
                @foreach ($documentations as $documentation)
                    @php
                        $category =
                            $documentation->category
                            ?? 'other';

                        $categoryLabel =
                            $categoryLabels[$category]
                            ?? 'Lainnya';

                        $categoryColor =
                            $categoryColors[$category]
                            ?? 'gray';

                        $imageUrl =
                            \Illuminate\Support\Facades\Storage::url(
                                $documentation->photo
                            );
                    @endphp

                    <article
                        wire:key="documentation-preview-{{ $documentation->id }}"
                        class="overflow-hidden rounded-2xl border border-gray-200 bg-white"
                    >
                        <div class="aspect-video overflow-hidden bg-gray-100">
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $documentation->title
                                    ?: 'Dokumentasi Project' }}"
                                loading="lazy"
                                class="h-full w-full object-cover transition duration-300 hover:scale-105"
                            >
                        </div>

                        <div class="p-4">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <h3 class="font-semibold text-gray-900">
                                    {{ $documentation->title
                                        ?: 'Dokumentasi Project' }}
                                </h3>

                                <x-ui.badge :color="$categoryColor">
                                    {{ $categoryLabel }}
                                </x-ui.badge>
                            </div>

                            <p class="mt-2 text-xs text-gray-500">
                                {{ $documentation->documentation_date
                                    ?->translatedFormat('d F Y') ?? '-' }}
                            </p>

                            @if ($documentation->user)
                                <p class="mt-1 text-xs text-gray-400">
                                    Oleh {{ $documentation->user->name }}
                                </p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="mt-8 rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-5 py-10 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-200 text-gray-500">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-6 w-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5A1.5 1.5 0 0 0 21.75 18V6A1.5 1.5 0 0 0 20.25 4.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm12-11.25h.008v.008h-.008V8.25Z"
                        />
                    </svg>
                </div>

                <p class="mt-4 font-semibold text-gray-700">
                    Belum ada dokumentasi
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Foto Project akan tampil setelah diunggah.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>