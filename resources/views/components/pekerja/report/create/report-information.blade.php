<section
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
        <div class="flex items-start gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
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
                        d="M9 5.25H6.75A2.25 2.25 0 0 0 4.5 7.5v11.25A2.25 2.25 0 0 0 6.75 21h10.5a2.25 2.25 0 0 0 2.25-2.25V7.5a2.25 2.25 0 0 0-2.25-2.25H15M9 5.25A2.25 2.25 0 0 1 11.25 3h1.5A2.25 2.25 0 0 1 15 5.25"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Informasi Laporan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Pilih tugas yang akan dilaporkan.
                </p>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="grid grid-cols-1 gap-5 px-5 py-5 sm:px-6 lg:grid-cols-2">
        {{-- Pilih tugas --}}
        <div class="min-w-0">
            <label
                for="reportTask"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Tugas
                <span class="text-red-500">*</span>
            </label>

            <select
                id="reportTask"
                name="reportTask"
                class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            >
                <option value="">
                    Pilih tugas yang akan dilaporkan
                </option>

                <option value="1">
                    Pemasangan Bekisting Kolom
                </option>

                <option value="2">
                    Pengecekan Material Besi
                </option>

                <option value="3">
                    Pembersihan Area Pekerjaan
                </option>

                <option value="4">
                    Pemasangan Tulangan Balok
                </option>

                <option value="5">
                    Pemeriksaan Alat Keselamatan
                </option>
            </select>

            <p class="mt-2 text-xs text-slate-500">
                Hanya tugas yang diberikan kepada Anda yang ditampilkan.
            </p>
        </div>

        {{-- Tanggal laporan --}}
        <div class="min-w-0">
            <label
                for="reportDate"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Tanggal Laporan
                <span class="text-red-500">*</span>
            </label>

            <input
                id="reportDate"
                name="reportDate"
                type="date"
                value="{{ now()->format('Y-m-d') }}"
                class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            >

            <p class="mt-2 text-xs text-slate-500">
                Gunakan tanggal pelaksanaan pekerjaan.
            </p>
        </div>

        {{-- Proyek --}}
        <div class="min-w-0">
            <label
                for="reportProject"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Proyek
            </label>

            <input
                id="reportProject"
                type="text"
                value="Proyek Gedung Perkantoran"
                readonly
                class="block min-h-11 w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 outline-none"
            >
        </div>

        {{-- Lokasi --}}
        <div class="min-w-0">
            <label
                for="reportLocation"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Lokasi Pekerjaan
            </label>

            <input
                id="reportLocation"
                type="text"
                value="Lantai 2, Zona A"
                readonly
                class="block min-h-11 w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 outline-none"
            >
        </div>
    </div>
</section>