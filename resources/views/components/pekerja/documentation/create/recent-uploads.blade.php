@php
    $uploads = [
        [
            'title' => 'Pemeriksaan Bekisting',
            'category' => 'Progres',
            'time' => '14.20 WIB',
            'photoCount' => 3,
            'color' => 'bg-blue-50 text-blue-600',
        ],
        [
            'title' => 'Pemeriksaan APD Pekerja',
            'category' => 'Keselamatan',
            'time' => '10.15 WIB',
            'photoCount' => 2,
            'color' => 'bg-emerald-50 text-emerald-600',
        ],
        [
            'title' => 'Material Besi Tulangan',
            'category' => 'Material',
            'time' => '08.45 WIB',
            'photoCount' => 4,
            'color' => 'bg-amber-50 text-amber-600',
        ],
    ];
@endphp

<aside
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    {{-- Header --}}
    <div
        class="flex items-center justify-between gap-3 border-b border-slate-200 px-5 py-5"
    >
        <div>
            <h2 class="font-semibold text-slate-900">
                Dokumentasi Hari Ini
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Foto yang baru Anda tambahkan.
            </p>
        </div>

        <span
            class="inline-flex shrink-0 rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-600"
        >
            {{ count($uploads) }} data
        </span>
    </div>

    {{-- Daftar dokumentasi --}}
    <div class="space-y-3 p-4">
        @forelse ($uploads as $index => $upload)
            <article
                class="rounded-xl border border-slate-200 p-3 transition hover:border-blue-200 hover:bg-blue-50/30"
            >
                <div class="flex gap-3">
                    {{-- Placeholder foto --}}
                    <div
                        class="flex h-16 w-16 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-400"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.6"
                            stroke="currentColor"
                            class="h-6 w-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909"
                            />
                        </svg>
                    </div>

                    {{-- Informasi --}}
                    <div class="min-w-0 flex-1">
                        <h3 class="line-clamp-2 text-sm font-semibold text-slate-900">
                            {{ $upload['title'] }}
                        </h3>

                        <div class="mt-2 flex flex-wrap items-center gap-2">
                            <span
                                class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $upload['color'] }}"
                            >
                                {{ $upload['category'] }}
                            </span>

                            <span class="text-xs text-slate-400">
                                {{ $upload['time'] }}
                            </span>
                        </div>

                        <p class="mt-2 text-xs font-medium text-slate-500">
                            {{ $upload['photoCount'] }} foto
                        </p>
                    </div>
                </div>

                {{-- Status --}}
                <div
                    class="mt-3 flex items-center justify-between border-t border-slate-100 pt-3"
                >
                    <span
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600"
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
                                d="m4.5 12.75 6 6 9-13.5"
                            />
                        </svg>

                        Tersimpan
                    </span>

                    <button
                        type="button"
                        class="text-xs font-semibold text-red-500 transition hover:text-red-600"
                    >
                        Hapus
                    </button>
                </div>
            </article>
        @empty
            <div class="px-4 py-10 text-center">
                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.6"
                        stroke="currentColor"
                        class="h-6 w-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159"
                        />
                    </svg>
                </div>

                <h3 class="mt-4 text-sm font-semibold text-slate-900">
                    Belum Ada Dokumentasi
                </h3>

                <p class="mt-1 text-xs leading-5 text-slate-500">
                    Dokumentasi yang ditambahkan hari ini akan tampil di sini.
                </p>
            </div>
        @endforelse
    </div>

    {{-- Footer --}}
    <a
        href="{{ route('pekerja.documentation.index') }}"
        wire:navigate
        class="flex items-center justify-center gap-2 border-t border-slate-200 px-4 py-4 text-sm font-semibold text-blue-600 transition hover:bg-blue-50"
    >
        Lihat Semua Dokumentasi

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
                d="m9 18 6-6-6-6"
            />
        </svg>
    </a>
</aside>