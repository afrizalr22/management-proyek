<section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
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
                        d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.592c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.246c.275.476.198 1.078-.176 1.482l-.883.956c-.257.278-.386.655-.376 1.034a7.43 7.43 0 0 1 0 .255c-.01.378.119.755.376 1.033l.883.956c.374.404.451 1.006.176 1.482l-1.296 2.246a1.125 1.125 0 0 1-1.37.49l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.542-.56.94-1.11.94h-2.592c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.063-.374-.313-.686-.645-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.075-.124l-1.217.456a1.125 1.125 0 0 1-1.37-.49l-1.296-2.246a1.125 1.125 0 0 1 .176-1.482l.883-.956c.257-.278.386-.655.376-1.033a7.43 7.43 0 0 1 0-.255c.01-.379-.119-.756-.376-1.034l-.883-.956a1.125 1.125 0 0 1-.176-1.482L5.33 6.376a1.125 1.125 0 0 1 1.37-.49l1.217.456c.355.133.75.072 1.076-.124.072-.044.145-.086.219-.127.332-.184.582-.496.645-.87l.213-1.281Z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Pengaturan Akun
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola keamanan dan preferensi akun Anda.
                </p>
            </div>
        </div>
    </div>

    {{-- Menu pengaturan --}}
    <div class="divide-y divide-slate-100">
        {{-- Keamanan --}}
        <button
            type="button"
            class="flex w-full items-center gap-4 px-5 py-4 text-left transition hover:bg-slate-50 sm:px-6"
        >
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
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
                        d="M16.5 10.5V6.75a4.5 4.5 0 0 0-9 0v3.75m-.75 0h10.5A2.25 2.25 0 0 1 19.5 12.75v6A2.25 2.25 0 0 1 17.25 21H6.75a2.25 2.25 0 0 1-2.25-2.25v-6a2.25 2.25 0 0 1 2.25-2.25Z"
                    />
                </svg>
            </span>

            <span class="min-w-0 flex-1">
                <span class="block text-sm font-semibold text-slate-800">
                    Keamanan dan Kata Sandi
                </span>

                <span class="mt-1 block text-xs text-slate-500">
                    Perbarui kata sandi untuk menjaga keamanan akun.
                </span>
            </span>

            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-5 w-5 shrink-0 text-slate-400"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m9 18 6-6-6-6"
                />
            </svg>
        </button>

        {{-- Notifikasi --}}
        <button
            type="button"
            class="flex w-full items-center gap-4 px-5 py-4 text-left transition hover:bg-slate-50 sm:px-6"
        >
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
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
                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022 23.848 23.848 0 0 0 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"
                    />
                </svg>
            </span>

            <span class="min-w-0 flex-1">
                <span class="block text-sm font-semibold text-slate-800">
                    Notifikasi
                </span>

                <span class="mt-1 block text-xs text-slate-500">
                    Atur pemberitahuan tugas, dokumentasi, dan laporan.
                </span>
            </span>

            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-5 w-5 shrink-0 text-slate-400"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m9 18 6-6-6-6"
                />
            </svg>
        </button>
    </div>

    {{-- Logout --}}
    <div class="border-t border-slate-200 p-5 sm:p-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl border border-red-300 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50"
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
                        d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3-3H9.75m9 0-3-3m3 3-3 3"
                    />
                </svg>

                Keluar
            </button>
        </form>
    </div>
</section>