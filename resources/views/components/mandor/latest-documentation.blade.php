@props([
    'documentations' => collect(),
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

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Dokumentasi Terbaru
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Foto pekerjaan terbaru dari Project yang Anda kelola.
                </p>
            </div>

            <a
                href="{{ route('mandor.projects.index') }}"
                wire:navigate
                class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
            >
                Lihat Project Saya

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
            {{-- Daftar dokumentasi --}}
            <div class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
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

                    <article
                        wire:key="mandor-latest-documentation-{{ $documentation->id }}"
                        class="group overflow-hidden rounded-xl border border-gray-200 bg-white transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-md"
                    >
                        {{-- Foto --}}
                        <a
                            href="{{ route(
                                'mandor.projects.documentations.index',
                                [
                                    'project' =>
                                        $documentation->project_id,
                                ]
                            ) }}"
                            wire:navigate
                            class="relative block aspect-video overflow-hidden bg-gray-100"
                        >
                            @if ($imageUrl)
                                <img
                                    src="{{ $imageUrl }}"
                                    alt="{{ $documentation->title
                                        ?: 'Dokumentasi pekerjaan' }}"
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
                                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Z"
                                        />
                                    </svg>
                                </div>
                            @endif

                            {{-- Lapisan gambar --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-950/60 via-transparent to-transparent"></div>

                            {{-- Kode Project --}}
                            <span class="absolute left-3 top-3 rounded-lg bg-blue-600 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white shadow-sm">
                                {{ $documentation
                                    ->project
                                    ?->project_code
                                    ?? 'Project' }}
                            </span>

                            {{-- Kategori --}}
                            <span class="absolute bottom-3 right-3 rounded-lg bg-white/90 px-2.5 py-1 text-[10px] font-semibold text-gray-700 shadow-sm backdrop-blur-sm">
                                {{ $categoryLabel }}
                            </span>
                        </a>

                        {{-- Informasi --}}
                        <div class="p-4">
                            <a
                                href="{{ route(
                                    'mandor.projects.documentations.index',
                                    [
                                        'project' =>
                                            $documentation->project_id,
                                    ]
                                ) }}"
                                wire:navigate
                                class="line-clamp-2 font-semibold leading-6 text-gray-900 transition hover:text-blue-600"
                            >
                                {{ $documentation->title
                                    ?: 'Dokumentasi pekerjaan' }}
                            </a>

                            <p class="mt-1 truncate text-sm text-blue-600">
                                {{ $documentation
                                    ->project
                                    ?->project_name
                                    ?? 'Project tidak ditemukan' }}
                            </p>

                            @if ($documentation->description)
                                <p class="mt-3 line-clamp-2 text-sm leading-5 text-gray-500">
                                    {{ $documentation->description }}
                                </p>
                            @endif

                            <div class="mt-4 flex items-end justify-between gap-3 border-t border-gray-100 pt-3">
                                <div class="min-w-0">
                                    <p class="truncate text-xs font-medium text-gray-600">
                                        {{ $documentation
                                            ->user
                                            ?->name
                                            ?? 'Pengguna tidak ditemukan' }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">
                                        {{ $documentationDate
                                            ?->translatedFormat(
                                                'd M Y'
                                            ) ?? '-' }}
                                    </p>
                                </div>

                                <a
                                    href="{{ route(
                                        'mandor.projects.documentations.index',
                                        [
                                            'project' =>
                                                $documentation->project_id,
                                        ]
                                    ) }}"
                                    wire:navigate
                                    class="shrink-0 text-xs font-semibold text-blue-600 transition hover:text-blue-700"
                                >
                                    Lihat Foto
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            {{-- Kondisi kosong --}}
            <div class="mt-6 rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-white text-gray-400 shadow-sm">
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
                    Dokumentasi dari Project yang Anda kelola akan muncul di sini.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>