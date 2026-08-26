<x-ui.info-card class="overflow-hidden">

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5">

        <div>
            <h2 class="text-base font-bold text-gray-900">
                Detailed Timeline
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Riwayat tahapan dan perkembangan proyek
            </p>
        </div>

        <button
            type="button"
            class="text-sm font-semibold text-blue-600 transition hover:text-blue-700"
        >
            View All Progress
        </button>

    </div>

    {{-- Timeline --}}
    <div class="px-6 py-6">

        <div class="space-y-0">

            {{-- Tahap Selesai --}}
            <div class="relative flex gap-4 pb-8">

                {{-- Garis timeline --}}
                <div class="absolute left-2 top-5 h-full w-px bg-gray-200"></div>

                {{-- Ikon selesai --}}
                <div
                    class="relative mt-1 flex h-4 w-4 shrink-0 items-center
                           justify-center rounded-full bg-emerald-500
                           ring-4 ring-emerald-50"
                >
                    <svg
                        class="h-2.5 w-2.5 text-white"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M16.704 5.293a1 1 0 010 1.414l-8 8a1 1 0
                               01-1.414 0l-4-4a1 1 0 011.414-1.414L8
                               12.586l7.293-7.293a1 1 0 011.411 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>

                <div class="min-w-0 flex-1">

                    <div
                        class="flex flex-col gap-2 sm:flex-row
                               sm:items-start sm:justify-between"
                    >
                        <div>
                            <h3 class="font-semibold text-gray-900">
                                Persiapan dan Pekerjaan Fondasi
                            </h3>

                            <p class="mt-1 text-sm leading-6 text-gray-500">
                                Pembersihan lokasi, pengukuran, dan pekerjaan
                                fondasi telah selesai.
                            </p>
                        </div>

                        <span
                            class="shrink-0 rounded-lg bg-gray-100 px-3 py-1.5
                                   text-xs font-semibold text-gray-600"
                        >
                            Februari 2026
                        </span>
                    </div>

                    <span
                        class="mt-3 inline-flex rounded-md bg-emerald-50
                               px-2 py-1 text-xs font-bold uppercase
                               text-emerald-700"
                    >
                        Selesai
                    </span>

                </div>

            </div>

            {{-- Tahap Berjalan --}}
            <div class="relative flex gap-4 pb-8">

                {{-- Garis timeline --}}
                <div class="absolute left-2 top-5 h-full w-px bg-gray-200"></div>

                {{-- Ikon berjalan --}}
                <div
                    class="relative mt-1 h-4 w-4 shrink-0 rounded-full
                           bg-blue-600 ring-4 ring-blue-100"
                ></div>

                <div class="min-w-0 flex-1">

                    <div
                        class="flex flex-col gap-2 sm:flex-row
                               sm:items-start sm:justify-between"
                    >
                        <div>
                            <h3 class="font-semibold text-gray-900">
                                Pekerjaan Struktur Bangunan
                            </h3>

                            <p class="mt-1 text-sm leading-6 text-gray-500">
                                Pengerjaan kolom dan balok lantai sedang
                                berlangsung. Progres saat ini mencapai 64%.
                            </p>
                        </div>

                        <span
                            class="shrink-0 rounded-lg bg-gray-100 px-3 py-1.5
                                   text-xs font-semibold text-gray-600"
                        >
                            Maret–Juni 2026
                        </span>
                    </div>

                    <span
                        class="mt-3 inline-flex rounded-md bg-blue-50
                               px-2 py-1 text-xs font-bold uppercase
                               text-blue-700"
                    >
                        Berjalan
                    </span>

                </div>

            </div>

            {{-- Tahap Akan Datang --}}
            <div class="relative flex gap-4">

                {{-- Ikon akan datang --}}
                <div
                    class="relative mt-1 h-4 w-4 shrink-0 rounded-full
                           bg-gray-300 ring-4 ring-gray-100"
                ></div>

                <div class="min-w-0 flex-1">

                    <div
                        class="flex flex-col gap-2 sm:flex-row
                               sm:items-start sm:justify-between"
                    >
                        <div>
                            <h3 class="font-semibold text-gray-500">
                                Pekerjaan Arsitektur dan Finishing
                            </h3>

                            <p class="mt-1 text-sm leading-6 text-gray-400">
                                Tahap pemasangan dinding, lantai, plafon,
                                serta pekerjaan finishing bangunan.
                            </p>
                        </div>

                        <span
                            class="shrink-0 rounded-lg bg-gray-100 px-3 py-1.5
                                   text-xs font-semibold text-gray-500"
                        >
                            Juli 2026
                        </span>
                    </div>

                    <span
                        class="mt-3 inline-flex rounded-md bg-gray-100
                               px-2 py-1 text-xs font-bold uppercase
                               text-gray-500"
                    >
                        Akan Datang
                    </span>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>