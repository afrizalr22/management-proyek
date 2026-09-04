<section
    class="h-full rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
        <div class="flex items-start gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600"
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
                        d="M12 9v3.75m9-1.5a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM12 16.5h.008v.008H12V16.5Z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Kendala dan Catatan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi tambahan yang disampaikan dalam laporan.
                </p>
            </div>
        </div>
    </div>

    {{-- Isi --}}
    <div class="space-y-5 px-5 py-5 sm:px-6">
        {{-- Kendala pekerjaan --}}
        <div>
            <div class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>

                <h3 class="text-sm font-semibold text-slate-700">
                    Kendala Pekerjaan
                </h3>
            </div>

            <div
                class="mt-3 rounded-xl border border-amber-100 bg-amber-50/60 p-4 text-sm leading-7 text-slate-600"
            >
                Pengiriman material pengikat bekisting mengalami keterlambatan.
                Beberapa material baru tiba setelah waktu istirahat sehingga pekerjaan
                dua kolom terakhir belum dapat diselesaikan pada hari yang sama.
            </div>
        </div>

        {{-- Catatan tambahan --}}
        <div class="border-t border-slate-200 pt-5">
            <div class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>

                <h3 class="text-sm font-semibold text-slate-700">
                    Catatan Tambahan
                </h3>
            </div>

            <div
                class="mt-3 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-600"
            >
                Pekerjaan akan dilanjutkan besok pagi setelah seluruh material tersedia.
                Bekisting yang sudah terpasang telah diamankan dan area kerja sudah
                dibersihkan.
            </div>
        </div>
    </div>
</section>