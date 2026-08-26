<div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-3">

    {{-- Belum Dimulai --}}
    <x-ui.info-card class="overflow-hidden">

        {{-- Header --}}
        <div
            class="flex items-center justify-between
                   border-b border-gray-200 px-5 py-4"
        >

            <div class="flex items-center gap-2">

                <span class="h-2.5 w-2.5 rounded-full bg-gray-400"></span>

                <h2 class="text-sm font-bold uppercase tracking-wide text-gray-700">
                    Belum Dimulai
                </h2>

            </div>

            <span
                class="rounded-full bg-gray-100 px-2.5 py-1
                       text-xs font-bold text-gray-600"
            >
                2
            </span>

        </div>

        {{-- Work List --}}
        <div class="space-y-4 p-5">

            {{-- Work Card 1 --}}
            <article class="rounded-xl border border-gray-200 p-4">

                <div class="flex items-start justify-between gap-3">

                    <span
                        class="rounded-md bg-amber-50 px-2 py-1
                               text-[10px] font-bold uppercase
                               text-amber-700"
                    >
                        Arsitektur
                    </span>

                    <button
                        type="button"
                        class="rounded-lg p-1 text-gray-400
                               transition hover:bg-gray-100"
                    >
                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                        >
                            <circle cx="12" cy="5" r="2" />
                            <circle cx="12" cy="12" r="2" />
                            <circle cx="12" cy="19" r="2" />
                        </svg>
                    </button>

                </div>

                <h3 class="mt-3 font-semibold leading-6 text-gray-900">
                    Pemasangan dinding dan pekerjaan plester
                </h3>

                <div class="mt-4 flex items-center justify-between gap-3">

                    <span class="text-xs text-gray-500">
                        Mulai 1 Juli 2026
                    </span>

                    <span class="text-xs font-semibold text-gray-500">
                        0%
                    </span>

                </div>

                <div class="mt-2 h-2 overflow-hidden rounded-full bg-gray-100">

                    <div
                        class="h-full rounded-full bg-gray-300"
                        style="width: 0%"
                    ></div>

                </div>

            </article>

            {{-- Work Card 2 --}}
            <article class="rounded-xl border border-gray-200 p-4">

                <span
                    class="rounded-md bg-violet-50 px-2 py-1
                           text-[10px] font-bold uppercase
                           text-violet-700"
                >
                    Finishing
                </span>

                <h3 class="mt-3 font-semibold leading-6 text-gray-900">
                    Pemasangan lantai, plafon, dan pengecatan
                </h3>

                <div class="mt-4 flex items-center justify-between gap-3">

                    <span class="text-xs text-gray-500">
                        Mulai 1 September 2026
                    </span>

                    <span class="text-xs font-semibold text-gray-500">
                        0%
                    </span>

                </div>

                <div class="mt-2 h-2 overflow-hidden rounded-full bg-gray-100">

                    <div
                        class="h-full rounded-full bg-gray-300"
                        style="width: 0%"
                    ></div>

                </div>

            </article>

        </div>

    </x-ui.info-card>

    {{-- Sedang Berjalan --}}
    <x-ui.info-card class="overflow-hidden border-blue-200">

        {{-- Header --}}
        <div
            class="flex items-center justify-between
                   border-b border-blue-100 bg-blue-50/50 px-5 py-4"
        >

            <div class="flex items-center gap-2">

                <span class="h-2.5 w-2.5 rounded-full bg-blue-600"></span>

                <h2 class="text-sm font-bold uppercase tracking-wide text-blue-700">
                    Sedang Berjalan
                </h2>

            </div>

            <span
                class="rounded-full bg-blue-600 px-2.5 py-1
                       text-xs font-bold text-white"
            >
                2
            </span>

        </div>

        {{-- Work List --}}
        <div class="space-y-4 p-5">

            {{-- Work Card 1 --}}
            <article class="rounded-xl border border-blue-300 bg-blue-50/30 p-4">

                <div class="flex items-start justify-between gap-3">

                    <span
                        class="rounded-md bg-blue-600 px-2 py-1
                               text-[10px] font-bold uppercase text-white"
                    >
                        Struktur
                    </span>

                    <span
                        class="rounded-full bg-emerald-50 px-2 py-1
                               text-[10px] font-bold text-emerald-700"
                    >
                        Sesuai Target
                    </span>

                </div>

                <h3 class="mt-3 font-semibold leading-6 text-gray-900">
                    Pengecoran kolom dan balok lantai
                </h3>

                <div class="mt-4 flex items-center justify-between">

                    <span class="text-xs text-gray-500">
                        Progres pekerjaan
                    </span>

                    <span class="text-xs font-bold text-blue-600">
                        75%
                    </span>

                </div>

                <div class="mt-2 h-2 overflow-hidden rounded-full bg-blue-100">

                    <div
                        class="h-full rounded-full bg-blue-600"
                        style="width: 75%"
                    ></div>

                </div>

                <div
                    class="mt-4 flex items-center justify-between
                           border-t border-blue-100 pt-3"
                >

                    <span class="text-xs text-gray-500">
                        Diperbarui hari ini
                    </span>

                    <span class="text-xs font-medium text-gray-500">
                        Mandor Utama
                    </span>

                </div>

            </article>

            {{-- Work Card 2 --}}
            <article class="rounded-xl border border-gray-200 p-4">

                <span
                    class="rounded-md bg-cyan-50 px-2 py-1
                           text-[10px] font-bold uppercase text-cyan-700"
                >
                    Utilitas
                </span>

                <h3 class="mt-3 font-semibold leading-6 text-gray-900">
                    Instalasi jalur listrik dan perpipaan
                </h3>

                <div class="mt-4 flex items-center justify-between">

                    <span class="text-xs text-gray-500">
                        Progres pekerjaan
                    </span>

                    <span class="text-xs font-bold text-blue-600">
                        35%
                    </span>

                </div>

                <div class="mt-2 h-2 overflow-hidden rounded-full bg-gray-100">

                    <div
                        class="h-full rounded-full bg-blue-600"
                        style="width: 35%"
                    ></div>

                </div>

                <p class="mt-3 text-xs text-gray-500">
                    Diperbarui 2 hari lalu
                </p>

            </article>

        </div>

    </x-ui.info-card>

    {{-- Selesai --}}
    <x-ui.info-card class="overflow-hidden">

        {{-- Header --}}
        <div
            class="flex items-center justify-between
                   border-b border-emerald-100 bg-emerald-50/50 px-5 py-4"
        >

            <div class="flex items-center gap-2">

                <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>

                <h2 class="text-sm font-bold uppercase tracking-wide text-emerald-700">
                    Selesai
                </h2>

            </div>

            <span
                class="rounded-full bg-emerald-100 px-2.5 py-1
                       text-xs font-bold text-emerald-700"
            >
                2
            </span>

        </div>

        {{-- Work List --}}
        <div class="space-y-4 p-5">

            {{-- Completed Work 1 --}}
            <article class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                <div class="flex items-start justify-between gap-3">

                    <span
                        class="rounded-md bg-emerald-100 px-2 py-1
                               text-[10px] font-bold uppercase
                               text-emerald-700"
                    >
                        Persiapan
                    </span>

                    <span
                        class="flex h-6 w-6 items-center justify-center
                               rounded-full bg-emerald-500 text-white"
                    >
                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="3"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                    </span>

                </div>

                <h3
                    class="mt-3 font-semibold leading-6
                           text-gray-500 line-through"
                >
                    Pembersihan dan pengukuran lokasi proyek
                </h3>

                <p class="mt-3 text-xs text-gray-400">
                    Selesai pada 7 Februari 2026
                </p>

            </article>

            {{-- Completed Work 2 --}}
            <article class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                <div class="flex items-start justify-between gap-3">

                    <span
                        class="rounded-md bg-emerald-100 px-2 py-1
                               text-[10px] font-bold uppercase
                               text-emerald-700"
                    >
                        Fondasi
                    </span>

                    <span
                        class="flex h-6 w-6 items-center justify-center
                               rounded-full bg-emerald-500 text-white"
                    >
                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="3"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                    </span>

                </div>

                <h3
                    class="mt-3 font-semibold leading-6
                           text-gray-500 line-through"
                >
                    Pengecoran dan pemeriksaan fondasi bangunan
                </h3>

                <p class="mt-3 text-xs text-gray-400">
                    Selesai pada 28 Februari 2026
                </p>

            </article>

        </div>

    </x-ui.info-card>

</div>