<section
    class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"
>
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        {{-- Informasi --}}
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
                <p class="text-sm font-semibold text-slate-800">
                    Periksa kembali laporan
                </p>

                <p class="mt-1 max-w-xl text-sm leading-5 text-slate-500">
                    Setelah dikirim, laporan akan diperiksa oleh Mandor dan berstatus Menunggu Pemeriksaan.
                </p>
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row">
            <a
                href="{{ route('pekerja.report.index') }}"
                wire:navigate
                class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100"
            >
                Batal
            </a>

            <button
                type="button"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
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
                        d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L6 12Zm0 0h7.5"
                    />
                </svg>

                Kirim Laporan
            </button>
        </div>
    </div>
</section>