<section
    class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"
>
    {{-- Header --}}
    <div>
        <h2 class="text-lg font-bold text-slate-900">
            Aksi Cepat
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Pilih aktivitas yang ingin Anda kerjakan.
        </p>
    </div>

    {{-- Daftar aksi --}}
    <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2">
        {{-- Unggah foto --}}
        <a
            href="#"
            class="group flex items-center gap-4 rounded-xl border border-blue-200 bg-blue-50 p-4 transition hover:border-blue-300 hover:bg-blue-100/70"
        >
            <div
                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-6 w-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175A2.25 2.25 0 0 0 2.25 9.624V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.624a2.25 2.25 0 0 0-1.802-2.219"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M14.25 10.5a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"
                    />
                </svg>
            </div>

            <div class="min-w-0 flex-1">
                <h3 class="font-semibold text-slate-900">
                    Unggah Foto Pekerjaan
                </h3>

                <p class="mt-1 text-sm leading-5 text-slate-500">
                    Tambahkan bukti dokumentasi dari lokasi proyek.
                </p>
            </div>

            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-5 w-5 shrink-0 text-blue-600 transition group-hover:translate-x-1"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m9 18 6-6-6-6"
                />
            </svg>
        </a>

        {{-- Membuat laporan --}}
        <a
            href="#"
            class="group flex items-center gap-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 transition hover:border-emerald-300 hover:bg-emerald-100/70"
        >
            <div
                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-sm"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-6 w-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m-2.25 12h12m-12 3h7.5"
                    />
                </svg>
            </div>

            <div class="min-w-0 flex-1">
                <h3 class="font-semibold text-slate-900">
                    Buat Laporan Pekerjaan
                </h3>

                <p class="mt-1 text-sm leading-5 text-slate-500">
                    Laporkan hasil dan kendala pekerjaan hari ini.
                </p>
            </div>

            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-5 w-5 shrink-0 text-emerald-600 transition group-hover:translate-x-1"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m9 18 6-6-6-6"
                />
            </svg>
        </a>
    </div>
</section>