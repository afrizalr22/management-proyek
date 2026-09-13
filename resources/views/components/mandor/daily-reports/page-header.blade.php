@props([
    'statistics' => [],
])

<header class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

    <div>
        <nav
            class="flex flex-wrap items-center gap-2 text-sm"
            aria-label="Breadcrumb"
        >
            <a
                href="{{ route('mandor.dashboard') }}"
                wire:navigate
                class="font-medium text-blue-600 transition hover:text-blue-700"
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
        </nav>

        <p class="mt-4 text-sm font-semibold text-blue-600">
            Validasi Pekerjaan
        </p>

        <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
            Laporan Harian
        </h1>

        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
            Pantau dan validasi laporan pekerjaan yang dikirim oleh
            Pekerja dari seluruh proyek yang Anda kelola.
        </p>
    </div>

    <div class="inline-flex w-fit items-center gap-3 rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm">
        <span
            @class([
                'flex h-10 w-10 items-center justify-center rounded-lg',
                'bg-amber-50 text-amber-600' =>
                    ($statistics['submitted'] ?? 0) > 0,
                'bg-emerald-50 text-emerald-600' =>
                    ($statistics['submitted'] ?? 0) === 0,
            ])
        >
            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <rect
                    x="4"
                    y="3"
                    width="16"
                    height="18"
                    rx="2"
                />

                <path d="M8 8h8M8 12h8M8 16h5" />
            </svg>
        </span>

        <div>
            <p class="text-xs font-medium text-gray-500">
                Menunggu Validasi
            </p>

            <p class="text-lg font-bold text-gray-900">
                {{ number_format($statistics['submitted'] ?? 0) }}
                Laporan
            </p>
        </div>
    </div>

</header>