<section
    class="h-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
        <div class="flex items-start gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"
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
                        d="m4.5 12.75 6 6 9-13.5"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Detail Hasil Pekerjaan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Hasil dan perkembangan pekerjaan yang dilaporkan.
                </p>
            </div>
        </div>
    </div>

    <div class="space-y-5 px-5 py-5 sm:px-6">
        {{-- Status dan progres --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Status Pekerjaan
                </p>

                <span
                    class="mt-2 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-sm font-semibold text-blue-600"
                >
                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>

                    Sedang Dikerjakan
                </span>
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Progres Pekerjaan
                    </p>

                    <span class="text-lg font-bold text-blue-600">
                        75%
                    </span>
                </div>

                <div class="mt-3 h-2.5 overflow-hidden rounded-full bg-slate-200">
                    <div
                        class="h-full rounded-full bg-blue-600"
                        style="width: 75%;"
                    ></div>
                </div>
            </div>
        </div>

        {{-- Uraian hasil --}}
        <div>
            <h3 class="text-sm font-semibold text-slate-700">
                Uraian Hasil Pekerjaan
            </h3>

            <div
                class="mt-2 rounded-xl border border-slate-200 bg-white p-4 text-sm leading-7 text-slate-600"
            >
                Pemasangan bekisting kolom pada lantai dua Zona A telah mencapai
                75%. Bekisting untuk enam kolom sudah terpasang dan telah diperiksa
                kesesuaiannya dengan ukuran pada gambar kerja. Pekerjaan berikutnya
                adalah penyelesaian dua kolom yang tersisa sebelum tahap pengecoran.
            </div>
        </div>

        {{-- Informasi tugas --}}
        <div class="grid grid-cols-1 gap-4 border-t border-slate-200 pt-5 sm:grid-cols-2">
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Target Tugas
                </p>

                <p class="mt-1 text-sm font-semibold text-slate-800">
                    8 kolom selesai dipasang
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Hasil Saat Ini
                </p>

                <p class="mt-1 text-sm font-semibold text-slate-800">
                    6 dari 8 kolom
                </p>
            </div>
        </div>
    </div>
</section>