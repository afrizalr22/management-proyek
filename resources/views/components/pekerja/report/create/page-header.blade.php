<header
    class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
>
    {{-- Judul halaman --}}
    <div>
        <a
            href="{{ route('pekerja.report.index') }}"
            wire:navigate
            class="mb-3 inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-blue-600"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-4 w-4"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m15 18-6-6 6-6"
                />
            </svg>

            Kembali ke Daftar Laporan
        </a>

        <p class="text-sm font-semibold text-blue-600">
            Pelaporan Pekerjaan
        </p>

        <h1
            class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"
        >
            Buat Laporan Pekerjaan
        </h1>

        <p class="mt-2 max-w-2xl text-sm text-slate-500 sm:text-base">
            Laporkan hasil pekerjaan, progres, dan kendala untuk diperiksa oleh Mandor.
        </p>
    </div>

    {{-- Informasi status --}}
    <div
        class="inline-flex w-fit items-center gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3"
    >
        <div
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600"
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
                    d="M12 6v6h4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />
            </svg>
        </div>

        <div>
            <p class="text-xs font-medium text-amber-600">
                Status setelah dikirim
            </p>

            <p class="text-sm font-semibold text-amber-700">
                Menunggu Pemeriksaan
            </p>
        </div>
    </div>
</header>