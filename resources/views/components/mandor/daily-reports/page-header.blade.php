<div
    class="flex flex-col gap-5
           lg:flex-row lg:items-end lg:justify-between"
>

    {{-- Page Information --}}
    <div>

        {{-- Breadcrumb --}}
        <div class="flex flex-wrap items-center gap-2 text-sm">

            <a
                href="{{ route('mandor.dashboard') }}"
                class="font-medium text-blue-600
                       transition hover:text-blue-700"
            >
                Dashboard
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
                Laporan Harian
            </span>

        </div>

        {{-- Title --}}
        <h1 class="mt-3 text-2xl font-bold text-gray-900 sm:text-3xl">
            Laporan Harian
        </h1>

        {{-- Description --}}
        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
            Catat dan pantau aktivitas, kendala, serta perkembangan
            pekerjaan proyek setiap hari.
        </p>

    </div>

    {{-- Create Report Button --}}
   <a
    href="{{ route('mandor.daily-reports.create') }}"
    class="inline-flex h-11 w-fit items-center
           justify-center gap-2 rounded-lg bg-blue-600
           px-5 text-sm font-semibold text-white
           shadow-sm transition hover:bg-blue-700"
>
    <svg
        class="h-5 w-5"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
    >
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 5v14M5 12h14"
        />
    </svg>

    Tambah Laporan Harian
</a>

</div>