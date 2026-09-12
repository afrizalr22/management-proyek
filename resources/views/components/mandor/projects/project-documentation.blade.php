@props([
    'project',
    'documentations' => collect(),
    'total' => 0,
])

@php
    $categoryLabels = [
        'progress' => 'Progress',
        'before' => 'Sebelum Pekerjaan',
        'after' => 'Setelah Pekerjaan',
        'material' => 'Material',
        'safety' => 'Keselamatan',
        'issue' => 'Kendala',
        'other' => 'Lainnya',
    ];
@endphp

<x-ui.info-card class="overflow-hidden">
    {{-- Header --}}
    <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div>
            <h2 class="text-base font-bold text-gray-900">
                Dokumentasi Project
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Foto terbaru dari aktivitas pekerjaan lapangan.
            </p>
        </div>

        <a
            href="{{ route(
                'mandor.projects.documentations.index',
                [
                    'project' => $project->id,
                ]
            ) }}"
            wire:navigate
            class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
        >
            Lihat Semua Foto

            @if ((int) $total > 0)
                <span class="rounded-full bg-blue-50 px-2 py-0.5 text-xs">
                    {{ $total }}
                </span>
            @endif

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
                    d="m9 18 6-6-6-6"
                />
            </svg>
        </a>
    </div>

    @if ($documentations->isNotEmpty())
        <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 sm:p-6 lg:grid-cols-3">
            @foreach ($documentations as $documentation)
                @php
                    $imageUrl = filled(
                        $documentation->photo
                    )
                        ? asset(
                            'storage/'
                            .ltrim(
                                $documentation->photo,
                                '/'
                            )
                        )
                        : null;

                    $documentationDate =
                        $documentation
                            ->documentation_date
                        ?? $documentation->taken_at
                        ?? $documentation->created_at;

                    $categoryLabel =
                        $categoryLabels[
                            $documentation->category
                        ]
                        ?? ucfirst(
                            str_replace(
                                '_',
                                ' ',
                                $documentation->category
                                    ?: 'Lainnya'
                            )
                        );
                @endphp

                <a
                    href="{{ route(
                        'mandor.projects.documentations.index',
                        [
                            'project' => $project->id,
                        ]
                    ) }}"
                    wire:navigate
                    wire:key="mandor-project-documentation-{{ $documentation->id }}"
                    class="group relative aspect-[4/3] overflow-hidden rounded-xl bg-gray-100"
                >
                    @if ($imageUrl)
                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $documentation->title
                                ?: 'Dokumentasi Project' }}"
                            loading="lazy"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                        >
                    @else
                        <div class="flex h-full w-full items-center justify-center text-gray-300">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-12 w-12"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"
                                />
                            </svg>
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-gray-950/85 via-gray-950/10 to-transparent"></div>

                    {{-- Kategori --}}
                    <span class="absolute right-3 top-3 rounded-lg bg-white/90 px-2 py-1 text-[10px] font-semibold text-gray-700 shadow-sm backdrop-blur-sm">
                        {{ $categoryLabel }}
                    </span>

                    {{-- Informasi --}}
                    <div class="absolute inset-x-0 bottom-0 p-4">
                        <h3 class="line-clamp-2 text-sm font-semibold text-white">
                            {{ $documentation->title
                                ?: 'Dokumentasi pekerjaan' }}
                        </h3>

                        <div class="mt-1 flex items-center justify-between gap-3 text-xs text-white/70">
                            <span>
                                {{ $documentationDate
                                    ?->translatedFormat(
                                        'd M Y'
                                    ) ?? '-' }}
                            </span>

                            <span class="truncate">
                                {{ $documentation->user?->name
                                    ?? 'Pengguna' }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach

            {{-- Lihat semua --}}
            @if ((int) $total > $documentations->count())
                <a
                    href="{{ route(
                        'mandor.projects.documentations.index',
                        [
                            'project' => $project->id,
                        ]
                    ) }}"
                    wire:navigate
                    class="group flex aspect-[4/3] items-center justify-center rounded-xl bg-slate-900 text-white transition hover:bg-slate-800"
                >
                    <div class="text-center">
                        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-full bg-white/10 transition group-hover:bg-white/20">
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
                                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"
                                />
                            </svg>
                        </div>

                        <p class="mt-3 text-sm font-semibold">
                            Lihat Semua Foto
                        </p>

                        <p class="mt-1 text-xs text-white/60">
                            {{ max(
                                0,
                                (int) $total
                                - $documentations->count()
                            ) }}
                            foto lainnya
                        </p>
                    </div>
                </a>
            @endif
        </div>
    @else
        {{-- Kondisi kosong --}}
        <div class="px-6 py-10 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-400">
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
                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"
                    />
                </svg>
            </div>

            <p class="mt-4 font-semibold text-gray-700">
                Belum ada dokumentasi
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Dokumentasi pekerjaan dari Pekerja akan muncul di sini.
            </p>
        </div>
    @endif
</x-ui.info-card>