<x-ui.info-card class="overflow-hidden">

    {{-- Header --}}
    <div class="border-b border-gray-200 px-6 py-5">

        <h2 class="text-base font-bold text-gray-900">
            Informasi Laporan
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Lengkapi informasi kegiatan proyek yang dilaksanakan.
        </p>

    </div>

    {{-- Form --}}
    <div class="space-y-6 p-6">

        {{-- Project and Date --}}
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

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
                           bg-white px-3 text-sm text-gray-700
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

                <p class="mt-2 text-xs text-gray-400">
                    Hanya proyek yang ditugaskan kepada Mandor.
                </p>

            </div>

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
                           bg-white px-3 text-sm text-gray-700
                           focus:border-blue-500 focus:ring-blue-500"
                >

                <p class="mt-2 text-xs text-gray-400">
                    Pilih tanggal pelaksanaan pekerjaan.
                </p>

            </div>

        </div>

        {{-- Activities --}}
        <div>

            <label
                for="activities"
                class="mb-2 block text-sm font-semibold text-gray-700"
            >
                Aktivitas Pekerjaan
                <span class="text-red-500">*</span>
            </label>

            <textarea
                id="activities"
                name="activities"
                rows="5"
                placeholder="Jelaskan pekerjaan yang dilakukan, hasil pekerjaan, dan perkembangan proyek..."
                class="w-full rounded-lg border-gray-300
                       text-sm text-gray-700
                       placeholder:text-gray-400
                       focus:border-blue-500 focus:ring-blue-500"
            ></textarea>

            <div class="mt-2 flex items-center justify-between gap-4">

                <p class="text-xs text-gray-400">
                    Tuliskan aktivitas secara ringkas dan jelas.
                </p>

                <span class="text-xs text-gray-400">
                    Maksimal 2.000 karakter
                </span>

            </div>

        </div>

        {{-- Obstacles --}}
        <div>

            <div class="mb-2 flex items-center justify-between gap-4">

                <label
                    for="obstacles"
                    class="block text-sm font-semibold text-gray-700"
                >
                    Kendala Pekerjaan
                </label>

                <span
                    class="rounded-md bg-gray-100 px-2 py-1
                           text-[10px] font-semibold uppercase text-gray-500"
                >
                    Opsional
                </span>

            </div>

            <textarea
                id="obstacles"
                name="obstacles"
                rows="4"
                placeholder="Jelaskan kendala yang terjadi, seperti keterlambatan material, cuaca, atau masalah teknis..."
                class="w-full rounded-lg border-gray-300
                       text-sm text-gray-700
                       placeholder:text-gray-400
                       focus:border-blue-500 focus:ring-blue-500"
            ></textarea>

            <p class="mt-2 text-xs text-gray-400">
                Kosongkan apabila tidak terdapat kendala.
            </p>

        </div>

        {{-- Notes --}}
        <div>

            <div class="mb-2 flex items-center justify-between gap-4">

                <label
                    for="notes"
                    class="block text-sm font-semibold text-gray-700"
                >
                    Catatan Tambahan
                </label>

                <span
                    class="rounded-md bg-gray-100 px-2 py-1
                           text-[10px] font-semibold uppercase text-gray-500"
                >
                    Opsional
                </span>

            </div>

            <textarea
                id="notes"
                name="notes"
                rows="3"
                placeholder="Tambahkan rencana pekerjaan berikutnya atau informasi penting lainnya..."
                class="w-full rounded-lg border-gray-300
                       text-sm text-gray-700
                       placeholder:text-gray-400
                       focus:border-blue-500 focus:ring-blue-500"
            ></textarea>

        </div>

    </div>

</x-ui.info-card>