<x-ui.info-card class="overflow-hidden">

    {{-- Header --}}
    <div
        class="flex items-center justify-between
               border-b border-gray-200 px-6 py-5"
    >

        <div>
            <h2 class="text-base font-bold text-gray-900">
                Laporan Harian Terbaru
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Aktivitas proyek yang terakhir dilaporkan
            </p>
        </div>

        <span
            class="rounded-full bg-blue-50 px-3 py-1.5
                   text-xs font-semibold text-blue-700"
        >
            3 Laporan
        </span>

    </div>

    {{-- Report List --}}
    <div class="divide-y divide-gray-100">

        {{-- Report 1 --}}
        <article class="group px-6 py-5">

            <div class="flex items-start justify-between gap-4">

                <div class="min-w-0">

                    {{-- Date --}}
                    <div class="flex flex-wrap items-center gap-2">

                        <h3 class="font-semibold text-gray-900">
                            24 Mei 2026
                        </h3>

                        <span
                            class="rounded-md bg-emerald-50 px-2 py-1
                                   text-[10px] font-bold uppercase
                                   text-emerald-700"
                        >
                            Selesai
                        </span>

                    </div>

                    {{-- Reporter --}}
                    <p class="mt-1 text-xs text-gray-400">
                        Dilaporkan oleh Mandor Utama
                    </p>

                    {{-- Activity --}}
                    <p class="mt-3 line-clamp-2 text-sm leading-6 text-gray-600">
                        Pengecoran kolom dan balok lantai dua telah
                        diselesaikan sesuai dengan jadwal pekerjaan.
                    </p>

                    {{-- Information --}}
                    <div class="mt-3 flex flex-wrap items-center gap-4">

                        <span
                            class="inline-flex items-center gap-1.5
                                   text-xs text-gray-500"
                        >
                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <rect
                                    x="3"
                                    y="3"
                                    width="18"
                                    height="18"
                                    rx="2"
                                />

                                <circle cx="8.5" cy="8.5" r="1.5" />

                                <path d="M21 15l-5-5L5 21" />
                            </svg>

                            4 Foto
                        </span>

                        <span
                            class="inline-flex items-center gap-1.5
                                   text-xs text-gray-500"
                        >
                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3 2" />
                            </svg>

                            17.30 WIB
                        </span>

                    </div>

                </div>

                {{-- Arrow --}}
                <button
                    type="button"
                    class="flex h-8 w-8 shrink-0 items-center
                           justify-center rounded-lg text-gray-400
                           transition group-hover:bg-blue-50
                           group-hover:text-blue-600"
                    title="Lihat laporan"
                >
                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 18l6-6-6-6"
                        />
                    </svg>
                </button>

            </div>

        </article>

        {{-- Report 2 --}}
        <article class="group px-6 py-5">

            <div class="flex items-start justify-between gap-4">

                <div class="min-w-0">

                    <div class="flex flex-wrap items-center gap-2">

                        <h3 class="font-semibold text-gray-900">
                            23 Mei 2026
                        </h3>

                        <span
                            class="rounded-md bg-emerald-50 px-2 py-1
                                   text-[10px] font-bold uppercase
                                   text-emerald-700"
                        >
                            Selesai
                        </span>

                    </div>

                    <p class="mt-1 text-xs text-gray-400">
                        Dilaporkan oleh Mandor Utama
                    </p>

                    <p class="mt-3 line-clamp-2 text-sm leading-6 text-gray-600">
                        Pemeriksaan tulangan dan pemasangan bekisting
                        pada zona B telah selesai dilakukan.
                    </p>

                    <div class="mt-3 flex flex-wrap items-center gap-4">

                        <span
                            class="inline-flex items-center gap-1.5
                                   text-xs text-gray-500"
                        >
                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <rect
                                    x="3"
                                    y="3"
                                    width="18"
                                    height="18"
                                    rx="2"
                                />

                                <circle cx="8.5" cy="8.5" r="1.5" />

                                <path d="M21 15l-5-5L5 21" />
                            </svg>

                            6 Foto
                        </span>

                        <span
                            class="inline-flex items-center gap-1.5
                                   text-xs text-gray-500"
                        >
                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3 2" />
                            </svg>

                            16.45 WIB
                        </span>

                    </div>

                </div>

                <button
                    type="button"
                    class="flex h-8 w-8 shrink-0 items-center
                           justify-center rounded-lg text-gray-400
                           transition group-hover:bg-blue-50
                           group-hover:text-blue-600"
                    title="Lihat laporan"
                >
                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 18l6-6-6-6"
                        />
                    </svg>
                </button>

            </div>

        </article>

        {{-- Report 3 --}}
        <article class="group px-6 py-5">

            <div class="flex items-start justify-between gap-4">

                <div class="min-w-0">

                    <div class="flex flex-wrap items-center gap-2">

                        <h3 class="font-semibold text-gray-900">
                            22 Mei 2026
                        </h3>

                        <span
                            class="rounded-md bg-amber-50 px-2 py-1
                                   text-[10px] font-bold uppercase
                                   text-amber-700"
                        >
                            Ada Kendala
                        </span>

                    </div>

                    <p class="mt-1 text-xs text-gray-400">
                        Dilaporkan oleh Mandor Utama
                    </p>

                    <p class="mt-3 line-clamp-2 text-sm leading-6 text-gray-600">
                        Pekerjaan sempat tertunda akibat hujan deras.
                        Aktivitas dilanjutkan setelah kondisi memungkinkan.
                    </p>

                    <div class="mt-3 flex flex-wrap items-center gap-4">

                        <span
                            class="inline-flex items-center gap-1.5
                                   text-xs text-gray-500"
                        >
                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <rect
                                    x="3"
                                    y="3"
                                    width="18"
                                    height="18"
                                    rx="2"
                                />

                                <circle cx="8.5" cy="8.5" r="1.5" />

                                <path d="M21 15l-5-5L5 21" />
                            </svg>

                            2 Foto
                        </span>

                        <span
                            class="inline-flex items-center gap-1.5
                                   text-xs text-gray-500"
                        >
                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3 2" />
                            </svg>

                            15.20 WIB
                        </span>

                    </div>

                </div>

                <button
                    type="button"
                    class="flex h-8 w-8 shrink-0 items-center
                           justify-center rounded-lg text-gray-400
                           transition group-hover:bg-blue-50
                           group-hover:text-blue-600"
                    title="Lihat laporan"
                >
                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 18l6-6-6-6"
                        />
                    </svg>
                </button>

            </div>

        </article>

    </div>

    {{-- Footer --}}
    <div class="border-t border-gray-200 px-6 py-4">

        <button
            type="button"
            class="w-full rounded-lg py-2 text-sm font-semibold
                   text-blue-600 transition hover:bg-blue-50"
        >
            Lihat Semua Laporan
        </button>

    </div>

</x-ui.info-card>