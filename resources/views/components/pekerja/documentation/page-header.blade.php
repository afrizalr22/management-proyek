<header
    class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
>
    {{-- Judul halaman --}}
    <div>
        <p class="text-sm font-semibold text-blue-600">
            Dokumentasi Lapangan
        </p>

        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
            Dokumentasi Pekerjaan
        </h1>

        <p class="mt-2 text-sm text-slate-500 sm:text-base">
            Lihat dan kelola dokumentasi pekerjaan lapangan yang Anda unggah.
        </p>
    </div>

    {{-- Tombol tambah dokumentasi --}}
    <a
        href="{{ route('pekerja.documentation.create')}}"
        class="inline-flex min-h-11 w-fit items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
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

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M19.5 3.75v4.5m2.25-2.25h-4.5"
            />
        </svg>

        Tambah Dokumentasi
    </a>
</header>