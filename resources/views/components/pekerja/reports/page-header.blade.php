<header
    class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
>
    {{-- Judul halaman --}}
    <div>
        <p class="text-sm font-semibold text-blue-600">
            Pelaporan Pekerjaan
        </p>

        <h1
            class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"
        >
            Laporan Pekerjaan
        </h1>

        <p class="mt-2 max-w-2xl text-sm text-slate-500 sm:text-base">
            Buat dan pantau laporan hasil pekerjaan yang diperiksa oleh Mandor.
        </p>
    </div>

    {{-- Tombol buat laporan --}}
    <a
        href="{{ route('pekerja.reports.create') }}"
        wire:navigate
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
                d="M12 4.5v15m7.5-7.5h-15"
            />
        </svg>

        Buat Laporan
    </a>
</header>