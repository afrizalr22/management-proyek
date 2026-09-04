<section
    class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5"
>
    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        {{-- Pencarian --}}
        <div class="relative w-full xl:max-w-xl">
            <label for="searchReport" class="sr-only">
                Cari laporan
            </label>

            <div
                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
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
                        d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"
                    />
                </svg>
            </div>

            <input
                id="searchReport"
                type="search"
                placeholder="Cari nomor laporan, tugas, proyek, atau lokasi..."
                class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            >
        </div>

        {{-- Filter --}}
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3 xl:flex">
            {{-- Status --}}
            <div>
                <label for="reportStatus" class="sr-only">
                    Filter status
                </label>

                <select
                    id="reportStatus"
                    class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 xl:min-w-48"
                >
                    <option value="">Semua Status</option>
                    <option value="waiting">
                        Menunggu Pemeriksaan
                    </option>
                    <option value="accepted">
                        Diterima
                    </option>
                    <option value="revision">
                        Perlu Revisi
                    </option>
                </select>
            </div>

            {{-- Periode --}}
            <div>
                <label for="reportPeriod" class="sr-only">
                    Filter periode
                </label>

                <select
                    id="reportPeriod"
                    class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 xl:min-w-44"
                >
                    <option value="">Semua Periode</option>
                    <option value="current-month">
                        Bulan Ini
                    </option>
                    <option value="last-month">
                        Bulan Lalu
                    </option>
                    <option value="last-three-months">
                        3 Bulan Terakhir
                    </option>
                </select>
            </div>

            {{-- Pengurutan --}}
            <div>
                <label for="reportSort" class="sr-only">
                    Urutkan laporan
                </label>

                <select
                    id="reportSort"
                    class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 xl:min-w-40"
                >
                    <option value="newest">
                        Terbaru
                    </option>
                    <option value="oldest">
                        Terlama
                    </option>
                </select>
            </div>
        </div>
    </div>
</section>