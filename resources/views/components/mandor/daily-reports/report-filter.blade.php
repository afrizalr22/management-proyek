<x-ui.info-card class="overflow-hidden">

    <div class="p-5">

        <div
            class="grid grid-cols-1 gap-4
                   md:grid-cols-2 xl:grid-cols-12"
        >

            {{-- Search --}}
            <div class="md:col-span-2 xl:col-span-4">

                <label
                    for="report-search"
                    class="mb-2 block text-xs font-semibold
                           uppercase tracking-wide text-gray-500"
                >
                    Cari Laporan
                </label>

                <div class="relative">

                    <svg
                        class="pointer-events-none absolute left-3.5 top-1/2
                               h-5 w-5 -translate-y-1/2 text-gray-400"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <circle cx="11" cy="11" r="7" />

                        <path
                            stroke-linecap="round"
                            d="M20 20l-3.5-3.5"
                        />
                    </svg>

                    <input
                        id="report-search"
                        type="text"
                        placeholder="Cari aktivitas, kendala, atau catatan..."
                        class="h-11 w-full rounded-lg border-gray-300
                               bg-white pl-11 pr-4 text-sm text-gray-900
                               placeholder:text-gray-400
                               focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>

            </div>

            {{-- Project Filter --}}
            <div class="xl:col-span-3">

                <label
                    for="report-project"
                    class="mb-2 block text-xs font-semibold
                           uppercase tracking-wide text-gray-500"
                >
                    Proyek
                </label>

                <select
                    id="report-project"
                    class="h-11 w-full rounded-lg border-gray-300
                           bg-white px-3 text-sm text-gray-700
                           focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">
                        Semua Proyek
                    </option>

                    <option value="1">
                        Jakarta Sky Tower
                    </option>

                    <option value="2">
                        Gedung Perkantoran Kemang
                    </option>

                    <option value="3">
                        Renovasi Gudang Utama
                    </option>
                </select>

            </div>

            {{-- Date Filter --}}
            <div class="xl:col-span-2">

                <label
                    for="report-date"
                    class="mb-2 block text-xs font-semibold
                           uppercase tracking-wide text-gray-500"
                >
                    Tanggal
                </label>

                <select
                    id="report-date"
                    class="h-11 w-full rounded-lg border-gray-300
                           bg-white px-3 text-sm text-gray-700
                           focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">
                        Semua Tanggal
                    </option>

                    <option value="today">
                        Hari Ini
                    </option>

                    <option value="7">
                        7 Hari Terakhir
                    </option>

                    <option value="30">
                        30 Hari Terakhir
                    </option>

                    <option value="90">
                        3 Bulan Terakhir
                    </option>
                </select>

            </div>

            {{-- Obstacle Filter --}}
            <div class="xl:col-span-2">

                <label
                    for="report-obstacle"
                    class="mb-2 block text-xs font-semibold
                           uppercase tracking-wide text-gray-500"
                >
                    Kondisi
                </label>

                <select
                    id="report-obstacle"
                    class="h-11 w-full rounded-lg border-gray-300
                           bg-white px-3 text-sm text-gray-700
                           focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">
                        Semua Laporan
                    </option>

                    <option value="without-obstacle">
                        Tanpa Kendala
                    </option>

                    <option value="with-obstacle">
                        Dengan Kendala
                    </option>
                </select>

            </div>

            {{-- Reset Button --}}
            <div class="flex items-end xl:col-span-1">

                <button
                    type="button"
                    title="Reset filter"
                    class="flex h-11 w-full items-center justify-center
                           rounded-lg border border-gray-300 bg-white
                           text-gray-500 transition
                           hover:border-red-200 hover:bg-red-50
                           hover:text-red-600"
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
                            d="M4 4v6h6"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20 20v-6h-6"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5.5 15a7 7 0 0011.5 2l3-3"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M18.5 9A7 7 0 007 7l-3 3"
                        />
                    </svg>

                </button>

            </div>

        </div>

    </div>

    {{-- Filter Information --}}
    <div
        class="flex flex-col gap-2 border-t border-gray-100
               bg-gray-50 px-5 py-4 sm:flex-row
               sm:items-center sm:justify-between"
    >

        <p class="text-sm text-gray-500">
            Menampilkan
            <span class="font-semibold text-gray-900">
                12 laporan
            </span>
            dari semua proyek
        </p>

        <p class="text-xs font-medium text-gray-400">
            Diurutkan berdasarkan laporan terbaru
        </p>

    </div>

</x-ui.info-card>