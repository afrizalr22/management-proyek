<div
    class="flex flex-col gap-5
           lg:flex-row lg:items-end lg:justify-between"
>

    <div>

        {{-- Breadcrumb --}}
        <div class="flex flex-wrap items-center gap-2 text-sm">

            <a
                href="{{ route('mandor.daily-reports.index') }}"
                class="font-medium text-blue-600 transition
                       hover:text-blue-700"
            >
                Laporan Harian
            </a>

            <svg
                class="h-4 w-4 text-gray-400"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 18l6-6-6-6"
                />
            </svg>

            <span class="font-medium text-gray-500">
                Detail Laporan
            </span>

        </div>

        <h1 class="mt-3 text-2xl font-bold text-gray-900 sm:text-3xl">
            Detail Laporan Harian
        </h1>

        <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-gray-500">

            <span class="font-semibold text-gray-700">
                Jakarta Sky Tower
            </span>

            <span>•</span>

            <span>24 Mei 2026</span>

            <span
                class="rounded-full bg-emerald-50 px-3 py-1
                       text-xs font-semibold text-emerald-700"
            >
                Tanpa Kendala
            </span>

        </div>

    </div>

    {{-- Edit Button --}}
    <a
        href="{{ route('mandor.daily-reports.edit', $reportId) }}"
        wire:navigate
        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
    >
        Edit Laporan
    </a>

</div>