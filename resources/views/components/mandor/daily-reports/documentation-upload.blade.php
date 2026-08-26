<x-ui.info-card class="overflow-hidden">

    {{-- Header --}}
    <div class="border-b border-gray-200 px-6 py-5">

        <h2 class="text-base font-bold text-gray-900">
            Dokumentasi Pekerjaan
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Unggah foto sebagai bukti perkembangan pekerjaan.
        </p>

    </div>

    <div class="space-y-5 p-6">

        {{-- Upload Area --}}
        <label
            for="documentations"
            class="group flex min-h-56 cursor-pointer
                   flex-col items-center justify-center
                   rounded-xl border-2 border-dashed
                   border-gray-300 bg-gray-50 px-5 py-8
                   text-center transition
                   hover:border-blue-400 hover:bg-blue-50/50"
        >

            <span
                class="flex h-14 w-14 items-center justify-center
                       rounded-full bg-blue-50 text-blue-600
                       transition group-hover:bg-blue-100"
            >
                <svg
                    class="h-7 w-7"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <rect
                        x="3"
                        y="3"
                        width="18"
                        height="18"
                        rx="2"
                    />

                    <circle cx="8.5" cy="8.5" r="1.5" />

                    <path d="M21 15l-5-5L5 21" />

                    <path
                        stroke-linecap="round"
                        d="M12 17V9M9 12l3-3 3 3"
                    />
                </svg>
            </span>

            <p class="mt-4 text-sm font-semibold text-gray-700">
                Klik untuk memilih foto
            </p>

            <p class="mt-1 text-xs leading-5 text-gray-400">
                Anda dapat memilih lebih dari satu foto.
            </p>

            <p class="mt-3 text-xs font-medium text-gray-500">
                JPG, JPEG, atau PNG
            </p>

            <input
                id="documentations"
                name="documentations[]"
                type="file"
                accept="image/jpeg,image/png"
                multiple
                class="sr-only"
            >

        </label>

        {{-- Documentation Description --}}
        <div>

            <label
                for="documentation_description"
                class="mb-2 block text-sm font-semibold text-gray-700"
            >
                Keterangan Dokumentasi
            </label>

            <textarea
                id="documentation_description"
                name="documentation_description"
                rows="3"
                placeholder="Contoh: Pengecoran kolom lantai dua zona B..."
                class="w-full rounded-lg border-gray-300
                       text-sm text-gray-700
                       placeholder:text-gray-400
                       focus:border-blue-500 focus:ring-blue-500"
            ></textarea>

            <p class="mt-2 text-xs text-gray-400">
                Keterangan akan ditampilkan pada galeri dokumentasi.
            </p>

        </div>

        {{-- Upload Information --}}
        <div class="rounded-xl bg-blue-50 p-4">

            <div class="flex items-start gap-3">

                <svg
                    class="mt-0.5 h-5 w-5 shrink-0 text-blue-600"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle cx="12" cy="12" r="9" />

                    <path
                        stroke-linecap="round"
                        d="M12 11v5M12 8h.01"
                    />
                </svg>

                <p class="text-xs leading-5 text-blue-700">
                    Foto yang diunggah akan otomatis ditampilkan
                    pada modul Dokumentasi Proyek.
                </p>

            </div>

        </div>

    </div>

</x-ui.info-card>