<section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    {{-- Total laporan --}}
    <article
        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
    >
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Total Laporan
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    12
                </p>
            </div>

            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
            >
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
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m0 12.75h7.5m-7.5 3h4.5"
                    />
                </svg>
            </div>
        </div>

        <p class="mt-4 text-sm text-slate-500">
            Seluruh laporan terkait pekerjaan Anda.
        </p>
    </article>

    {{-- Laporan bulan ini --}}
    <article
        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
    >
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Bulan Ini
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    4
                </p>
            </div>

            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600"
            >
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
                        d="M6.75 3v2.25M17.25 3v2.25M3.75 9.75h16.5M5.25 5.25h13.5A1.5 1.5 0 0 1 20.25 6.75v12a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-12a1.5 1.5 0 0 1 1.5-1.5Z"
                    />
                </svg>
            </div>
        </div>

        <p class="mt-4 text-sm text-slate-500">
            Laporan pekerjaan pada bulan berjalan.
        </p>
    </article>

    {{-- Laporan diterima --}}
    <article
        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
    >
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Laporan Diterima
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    9
                </p>
            </div>

            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"
            >
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
                        d="m4.5 12.75 6 6 9-13.5"
                    />
                </svg>
            </div>
        </div>

        <p class="mt-4 text-sm text-emerald-600">
            Sudah diperiksa dan diterima.
        </p>
    </article>

    {{-- Menunggu pemeriksaan --}}
    <article
        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
    >
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Menunggu Pemeriksaan
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    3
                </p>
            </div>

            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600"
            >
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
                        d="M12 6v6h4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                    />
                </svg>
            </div>
        </div>

        <p class="mt-4 text-sm text-amber-600">
            Belum selesai diperiksa.
        </p>
    </article>
</section>