<nav
    class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:px-6"
    aria-label="Navigasi halaman dokumentasi"
>
    {{-- Informasi data --}}
    <p class="text-sm text-slate-500">
        Menampilkan
        <span class="font-semibold text-slate-700">
            1–6
        </span>
        dari
        <span class="font-semibold text-slate-700">
            18
        </span>
        dokumentasi
    </p>

    {{-- Navigasi --}}
    <div class="flex items-center gap-2">
        {{-- Sebelumnya --}}
        <button
            type="button"
            disabled
            aria-label="Halaman sebelumnya"
            class="inline-flex h-10 w-10 cursor-not-allowed items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-300"
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
        </button>

        {{-- Halaman pertama --}}
        <button
            type="button"
            aria-current="page"
            class="inline-flex h-10 min-w-10 items-center justify-center rounded-lg border border-blue-600 bg-blue-600 px-3 text-sm font-semibold text-white"
        >
            1
        </button>

        <button
            type="button"
            class="inline-flex h-10 min-w-10 items-center justify-center rounded-lg border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
        >
            2
        </button>

        <button
            type="button"
            class="inline-flex h-10 min-w-10 items-center justify-center rounded-lg border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
        >
            3
        </button>

        {{-- Berikutnya --}}
        <button
            type="button"
            aria-label="Halaman berikutnya"
            class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-50"
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
                    d="m9 18 6-6-6-6"
                />
            </svg>
        </button>
    </div>
</nav>