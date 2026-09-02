@php
    $documentations = [
        [
            'title' => 'Pemasangan Bekisting Kolom',
            'time' => '10.15 WIB',
        ],
        [
            'title' => 'Pemeriksaan Ukuran Bekisting',
            'time' => '13.30 WIB',
        ],
        [
            'title' => 'Kondisi Akhir Zona A',
            'time' => '15.45 WIB',
        ],
    ];
@endphp

<section
    class="rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    {{-- Header --}}
    <div
        class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6"
    >
        <div class="flex items-start gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600"
            >
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
                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Dokumentasi Pendukung
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Foto yang dilampirkan bersama laporan.
                </p>
            </div>
        </div>

        <span
            class="inline-flex w-fit rounded-lg bg-violet-50 px-3 py-1.5 text-xs font-semibold text-violet-600"
        >
            {{ count($documentations) }} foto
        </span>
    </div>

    {{-- Galeri --}}
    <div class="grid grid-cols-1 gap-4 px-5 py-5 sm:px-6 md:grid-cols-3">
        @forelse ($documentations as $documentation)
            <article
                class="overflow-hidden rounded-xl border border-slate-200 bg-white"
            >
                {{-- Placeholder foto --}}
                <div
                    class="flex h-40 items-center justify-center bg-slate-100 text-slate-400"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-10 w-10"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909"
                        />
                    </svg>
                </div>

                {{-- Informasi foto --}}
                <div class="p-4">
                    <h3 class="text-sm font-semibold text-slate-900">
                        {{ $documentation['title'] }}
                    </h3>

                    <div class="mt-2 flex items-center justify-between gap-3">
                        <p class="text-xs text-slate-500">
                            30 Agustus 2026
                        </p>

                        <p class="shrink-0 text-xs font-medium text-slate-500">
                            {{ $documentation['time'] }}
                        </p>
                    </div>
                </div>
            </article>
        @empty
            <div
                class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center md:col-span-3"
            >
                <p class="text-sm font-semibold text-slate-700">
                    Tidak ada dokumentasi
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Laporan ini tidak memiliki foto pendukung.
                </p>
            </div>
        @endforelse
    </div>
</section>