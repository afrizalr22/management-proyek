<section
    class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5"
>
    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        {{-- Pencarian --}}
        <div class="relative w-full xl:max-w-xl">
            <label for="searchDocumentation" class="sr-only">
                Cari dokumentasi
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
                id="searchDocumentation"
                type="search"
                placeholder="Cari berdasarkan tugas, proyek, atau lokasi..."
                class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            >
        </div>

        {{-- Filter --}}
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:flex">
            {{-- Filter tugas --}}
            <div>
                <label for="taskFilter" class="sr-only">
                    Filter tugas
                </label>

                <select
                    id="taskFilter"
                    class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 xl:min-w-52"
                >
                    <option value="">Semua Tugas</option>
                    <option value="bekisting">
                        Pemasangan Bekisting
                    </option>
                    <option value="material">
                        Pengecekan Material
                    </option>
                    <option value="pembersihan">
                        Pembersihan Area
                    </option>
                    <option value="keselamatan">
                        Pemeriksaan Keselamatan
                    </option>
                </select>
            </div>

            {{-- Pengurutan --}}
            <div>
                <label for="sortDocumentation" class="sr-only">
                    Urutkan dokumentasi
                </label>

                <select
                    id="sortDocumentation"
                    class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 xl:min-w-44"
                >
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="task">Nama Tugas</option>
                </select>
            </div>
        </div>
    </div>
</section>