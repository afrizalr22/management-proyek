<x-ui.info-card class="overflow-hidden">

    <div class="p-5">

        <div
            class="grid grid-cols-1 gap-4
                   md:grid-cols-2 xl:grid-cols-12"
        >

            {{-- Search --}}
            <div class="md:col-span-2 xl:col-span-5">

                <label
                    for="documentation-search"
                    class="mb-2 block text-xs font-semibold
                           uppercase tracking-wide text-gray-500"
                >
                    Cari Dokumentasi
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
                        id="documentation-search"
                        type="text"
                        placeholder="Cari proyek atau deskripsi foto..."
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
                    for="project-filter"
                    class="mb-2 block text-xs font-semibold
                           uppercase tracking-wide text-gray-500"
                >
                    Proyek
                </label>

                <select
                    id="project-filter"
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
            <div class="xl:col-span-3">

                <label
                    for="date-filter"
                    class="mb-2 block text-xs font-semibold
                           uppercase tracking-wide text-gray-500"
                >
                    Rentang Tanggal
                </label>

                <select
                    id="date-filter"
                    class="h-11 w-full rounded-lg border-gray-300
                           bg-white px-3 text-sm text-gray-700
                           focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">
                        Semua Tanggal
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

                    <option value="year">
                        Tahun Ini
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

    {{-- Filter Footer --}}
    <div
        class="flex flex-col gap-3 border-t border-gray-100
               bg-gray-50 px-5 py-4 sm:flex-row
               sm:items-center sm:justify-between"
    >

        {{-- Result Information --}}
        <p class="text-sm text-gray-500">
            Menampilkan
            <span class="font-semibold text-gray-900">
                12 dokumentasi
            </span>
            dari semua proyek
        </p>

        {{-- Grid View --}}
        <div class="flex items-center gap-2">

            <span class="text-xs font-medium text-gray-400">
                Tampilan
            </span>

            <button
                type="button"
                title="Tampilan grid"
                class="flex h-9 w-9 items-center justify-center
                       rounded-lg bg-blue-600 text-white"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                </svg>
            </button>

        </div>

    </div>

</x-ui.info-card>