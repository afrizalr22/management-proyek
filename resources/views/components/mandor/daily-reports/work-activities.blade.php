<section
    class="w-full max-w-full overflow-hidden
           rounded-2xl border border-gray-200
           bg-white shadow-sm"
>

    {{-- Header --}}
    <div class="border-b border-gray-200 px-6 py-5">

        <h2 class="text-lg font-bold text-gray-900">
            Aktivitas Pekerjaan
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Jelaskan pekerjaan dan perkembangan proyek hari ini.
        </p>

    </div>

    {{-- Content --}}
    <div class="min-w-0 space-y-6 p-6">

        {{-- Activities --}}
        <div class="min-w-0">

            <label
                for="activities"
                class="mb-2 block text-sm font-semibold text-gray-700"
            >
                Deskripsi Aktivitas
                <span class="text-red-500">*</span>
            </label>

            <textarea
                id="activities"
                name="activities"
                rows="6"
                placeholder="Contoh: Pemasangan tulangan kolom zona B telah mencapai 80%..."
                class="block w-full max-w-full resize-y
                       rounded-lg border-gray-300
                       text-sm text-gray-700
                       placeholder:text-gray-400
                       focus:border-blue-500
                       focus:ring-blue-500"
            ></textarea>

            <p class="mt-2 text-xs text-gray-400">
                Jelaskan pekerjaan yang telah dilaksanakan secara ringkas dan jelas.
            </p>

        </div>

        {{-- Documentation Upload --}}
        <div class="min-w-0">

            <p class="mb-2 text-sm font-semibold text-gray-700">
                Dokumentasi Pekerjaan
            </p>

            <label
                for="documentations"
                class="flex w-full max-w-full cursor-pointer
                       flex-col items-center justify-center
                       rounded-xl border-2 border-dashed
                       border-gray-300 bg-gray-50
                       px-6 py-8 text-center transition
                       hover:border-blue-400 hover:bg-blue-50"
            >

                <svg
                    class="h-8 w-8 text-blue-600"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <rect
                        x="3"
                        y="3"
                        width="18"
                        height="18"
                        rx="2"
                    />

                    <circle cx="8.5" cy="8.5" r="1.5" />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 15l-5-5L5 21"
                    />
                </svg>

                <span class="mt-3 text-sm font-semibold text-gray-700">
                    Pilih foto perkembangan pekerjaan
                </span>

                <span class="mt-1 text-xs text-gray-400">
                    Maksimal 5 foto dengan format JPG atau PNG
                </span>

            </label>

            <input
                id="documentations"
                name="documentations[]"
                type="file"
                accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                multiple
                class="hidden"
            >

        </div>

        {{-- Documentation Description --}}
        <div class="min-w-0">

            <label
                for="documentation_description"
                class="mb-2 block text-sm font-semibold text-gray-700"
            >
                Keterangan Dokumentasi
            </label>

            <input
                id="documentation_description"
                name="documentation_description"
                type="text"
                placeholder="Contoh: Pengecoran kolom lantai dua zona B"
                class="block h-11 w-full max-w-full
                       rounded-lg border-gray-300
                       text-sm text-gray-700
                       placeholder:text-gray-400
                       focus:border-blue-500
                       focus:ring-blue-500"
            >

        </div>

    </div>

</section>