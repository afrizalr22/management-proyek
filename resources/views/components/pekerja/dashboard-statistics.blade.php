@props([
    'statistics',
])

<section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    {{-- Task aktif --}}
    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Task Aktif
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $statistics['active_tasks'] }}
                </p>
            </div>

            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
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
                        d="M9 5.25H6.75A2.25 2.25 0 0 0 4.5 7.5v11.25A2.25 2.25 0 0 0 6.75 21h10.5a2.25 2.25 0 0 0 2.25-2.25V7.5a2.25 2.25 0 0 0-2.25-2.25H15M9 5.25A2.25 2.25 0 0 1 11.25 3h1.5A2.25 2.25 0 0 1 15 5.25"
                    />
                </svg>
            </div>
        </div>

        <p class="mt-4 text-sm font-medium text-blue-600">
            {{ $statistics['new_tasks'] }}
            task baru
        </p>
    </article>

    {{-- Task selesai --}}
    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Task Selesai
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $statistics['completed_tasks'] }}
                </p>
            </div>

            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
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
                        d="m4.5 12.75 6 6 9-13.5"
                    />
                </svg>
            </div>
        </div>

        <p class="mt-4 text-sm font-medium text-emerald-600">
            {{ $statistics['completion_rate'] }}%
            dari seluruh task
        </p>
    </article>

    {{-- Dokumentasi --}}
    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Dokumentasi
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $statistics['documentations'] }}
                </p>
            </div>

            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
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
        </div>

        <p class="mt-4 text-sm font-medium text-violet-600">
            {{ $statistics['photos_today'] }}
            diunggah hari ini
        </p>
    </article>

    {{-- Laporan terkirim --}}
    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Laporan Terkirim
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $statistics['submitted_reports'] }}
                </p>
            </div>

            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
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
        </div>

        <p class="mt-4 text-sm font-medium text-amber-600">
            {{ $statistics['reports_this_month'] }}
            laporan bulan ini
        </p>
    </article>
</section>