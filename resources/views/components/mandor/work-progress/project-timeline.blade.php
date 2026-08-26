<x-ui.info-card class="h-full overflow-hidden">

    {{-- Header --}}
    <div
        class="flex items-center justify-between
               border-b border-gray-200 px-6 py-5"
    >

        <div>
            <h2 class="text-base font-bold text-gray-900">
                Timeline Proyek
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Tahapan dan perkembangan pekerjaan proyek
            </p>
        </div>

        {{-- Period Filter --}}
        <div class="flex rounded-lg bg-gray-100 p-1">

            <button
                type="button"
                class="rounded-md bg-white px-3 py-1.5
                       text-xs font-semibold text-gray-900 shadow-sm"
            >
                Mingguan
            </button>

            <button
                type="button"
                class="rounded-md px-3 py-1.5 text-xs
                       font-semibold text-gray-500 transition
                       hover:text-gray-900"
            >
                Bulanan
            </button>

        </div>

    </div>

    {{-- Timeline Content --}}
    <div class="space-y-6 p-6">

        {{-- Foundation --}}
        <div>

            <div class="mb-2 flex items-start justify-between gap-4">

                <div>
                    <h3 class="text-sm font-semibold text-gray-900">
                        Persiapan dan Pekerjaan Fondasi
                    </h3>

                    <span
                        class="mt-1 inline-flex text-xs font-semibold
                               uppercase text-emerald-600"
                    >
                        Selesai
                    </span>
                </div>

                <span class="text-sm font-bold text-emerald-600">
                    100%
                </span>

            </div>

            <div class="h-3 overflow-hidden rounded-full bg-gray-100">

                <div
                    class="h-full rounded-full bg-emerald-500"
                    style="width: 100%"
                ></div>

            </div>

            <div class="mt-2 flex items-center justify-between text-xs text-gray-400">

                <span>1–28 Februari 2026</span>

                <span>Selesai tepat waktu</span>

            </div>

        </div>

        {{-- Structural Work --}}
        <div>

            <div class="mb-2 flex items-start justify-between gap-4">

                <div>
                    <h3 class="text-sm font-semibold text-gray-900">
                        Pekerjaan Struktur Bangunan
                    </h3>

                    <span
                        class="mt-1 inline-flex text-xs font-semibold
                               uppercase text-blue-600"
                    >
                        Sedang Berjalan
                    </span>
                </div>

                <span class="text-sm font-bold text-blue-600">
                    75%
                </span>

            </div>

            <div class="h-3 overflow-hidden rounded-full bg-gray-100">

                <div
                    class="h-full rounded-full bg-blue-600"
                    style="width: 75%"
                ></div>

            </div>

            <div class="mt-2 flex items-center justify-between text-xs text-gray-400">

                <span>1 Maret–30 Juni 2026</span>

                <span>Sesuai target</span>

            </div>

        </div>

        {{-- Wall Installation --}}
        <div>

            <div class="mb-2 flex items-start justify-between gap-4">

                <div>
                    <h3 class="text-sm font-semibold text-gray-900">
                        Pemasangan Dinding dan Plester
                    </h3>

                    <span
                        class="mt-1 inline-flex text-xs font-semibold
                               uppercase text-amber-600"
                    >
                        Persiapan
                    </span>
                </div>

                <span class="text-sm font-bold text-amber-600">
                    20%
                </span>

            </div>

            <div class="h-3 overflow-hidden rounded-full bg-gray-100">

                <div
                    class="h-full rounded-full bg-amber-500"
                    style="width: 20%"
                ></div>

            </div>

            <div class="mt-2 flex items-center justify-between text-xs text-gray-400">

                <span>1 Juli–31 Agustus 2026</span>

                <span>Material dipersiapkan</span>

            </div>

        </div>

        {{-- Finishing --}}
        <div>

            <div class="mb-2 flex items-start justify-between gap-4">

                <div>
                    <h3 class="text-sm font-semibold text-gray-500">
                        Pekerjaan Arsitektur dan Finishing
                    </h3>

                    <span
                        class="mt-1 inline-flex text-xs font-semibold
                               uppercase text-gray-400"
                    >
                        Belum Dimulai
                    </span>
                </div>

                <span class="text-sm font-bold text-gray-400">
                    0%
                </span>

            </div>

            <div class="h-3 overflow-hidden rounded-full bg-gray-100">

                <div
                    class="h-full rounded-full bg-gray-300"
                    style="width: 0%"
                ></div>

            </div>

            <div class="mt-2 flex items-center justify-between text-xs text-gray-400">

                <span>1 September–20 Desember 2026</span>

                <span>Menunggu tahap sebelumnya</span>

            </div>

        </div>

    </div>

</x-ui.info-card>