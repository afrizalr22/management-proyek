<x-ui.info-card class="overflow-hidden">

    <div class="border-b border-gray-200 px-6 py-5">

        <h2 class="text-lg font-bold text-gray-900">
            Informasi Umum
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Tentukan proyek dan tanggal pelaksanaan pekerjaan.
        </p>

    </div>

    <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

        {{-- Report Date --}}
        <div>

            <label
                for="report_date"
                class="mb-2 block text-sm font-semibold text-gray-700"
            >
                Tanggal Laporan
                <span class="text-red-500">*</span>
            </label>

            <input
                id="report_date"
                name="report_date"
                type="date"
                class="h-11 w-full rounded-lg border-gray-300
                       focus:border-blue-500 focus:ring-blue-500"
            >

        </div>

        {{-- Project --}}
        <div>

            <label
                for="project_id"
                class="mb-2 block text-sm font-semibold text-gray-700"
            >
                Proyek
                <span class="text-red-500">*</span>
            </label>

            <select
                id="project_id"
                name="project_id"
                class="h-11 w-full rounded-lg border-gray-300
                       focus:border-blue-500 focus:ring-blue-500"
            >
                <option value="">
                    Pilih proyek
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

    </div>

</x-ui.info-card>