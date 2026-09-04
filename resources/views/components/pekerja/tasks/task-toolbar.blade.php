<section
    class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5"
>
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        {{-- Pencarian --}}
        <div class="relative w-full lg:max-w-md">
            <label for="searchTask" class="sr-only">
                Cari tugas
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
                id="searchTask"
                type="search"
                placeholder="Cari berdasarkan nama atau lokasi tugas..."
                class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            >
        </div>

        {{-- Filter --}}
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:flex">
            <div>
                <label for="statusFilter" class="sr-only">
                    Filter status
                </label>

                <select
                    id="statusFilter"
                    class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 lg:min-w-44"
                >
                    <option value="">Semua Status</option>
                    <option value="belum_dimulai">Belum Dimulai</option>
                    <option value="sedang_dikerjakan">Sedang Dikerjakan</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <div>
                <label for="priorityFilter" class="sr-only">
                    Filter prioritas
                </label>

                <select
                    id="priorityFilter"
                    class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 lg:min-w-44"
                >
                    <option value="">Semua Prioritas</option>
                    <option value="tinggi">Tinggi</option>
                    <option value="sedang">Sedang</option>
                    <option value="rendah">Rendah</option>
                </select>
            </div>
        </div>
    </div>
</section>