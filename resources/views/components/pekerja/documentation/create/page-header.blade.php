<header
    class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
>
    {{-- Judul halaman --}}
    <div>
        <a
            href="{{ route('pekerja.documentation.index') }}"
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

            Kembali ke Dokumentasi
        </a>

        <p class="text-sm font-semibold text-blue-600">
            Dokumentasi Lapangan
        </p>

        <h1
            class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"
        >
            Tambah Dokumentasi
        </h1>

        <p class="mt-2 max-w-2xl text-sm text-slate-500 sm:text-base">
            Tambahkan foto dan keterangan sebagai bukti pelaksanaan pekerjaan lapangan.
        </p>
    </div>

    {{-- Informasi --}}
    <div
        class="inline-flex w-fit items-center gap-3 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3"
    >
        <div
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white"
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
                    d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175A2.25 2.25 0 0 0 2.25 9.624V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.624a2.25 2.25 0 0 0-1.802-2.219"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M14.25 10.5a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"
                />
            </svg>
        </div>

        <div>
            <p class="text-xs font-medium text-blue-500">
                Dokumentasi baru
            </p>

            <p class="text-sm font-semibold text-blue-700">
                Maksimal 5 foto
            </p>
        </div>
    </div>
</header>