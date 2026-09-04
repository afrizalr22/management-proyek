<header
    class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
>
    {{-- Judul halaman --}}
    <div>
        <p class="text-sm font-semibold text-blue-600">
            Pekerjaan Lapangan
        </p>

        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
            Tugas Saya
        </h1>

        <p class="mt-2 text-sm text-slate-500 sm:text-base">
            Kelola dan pantau progres pekerjaan lapangan yang diberikan kepada Anda.
        </p>
    </div>

    {{-- Tanggal --}}
    <div
        class="inline-flex w-fit items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm"
    >
        <div
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
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
                    d="M6.75 3v2.25M17.25 3v2.25M3.75 9.75h16.5M5.25 5.25h13.5A1.5 1.5 0 0 1 20.25 6.75v12a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-12a1.5 1.5 0 0 1 1.5-1.5Z"
                />
            </svg>
        </div>

        <div>
            <p class="text-xs text-slate-400">
                Hari ini
            </p>

            <p class="text-sm font-semibold text-slate-700">
                {{ now()->locale('id')->translatedFormat('l, d F Y') }}
            </p>
        </div>
    </div>
</header>