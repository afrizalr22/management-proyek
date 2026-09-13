@props([
    'statistics' => [],
])

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

    {{-- Minggu ini --}}
    <x-ui.info-card>
        <div class="p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Minggu Ini
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ number_format($statistics['this_week'] ?? 0) }}
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Laporan diterima
                    </p>
                </div>

                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
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

                        <path d="M8 7h8M8 11h8M8 15h5" />
                    </svg>
                </span>
            </div>
        </div>
    </x-ui.info-card>

    {{-- Menunggu validasi --}}
    <x-ui.info-card>
        <div class="p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Menunggu Validasi
                    </p>

                    <p class="mt-3 text-3xl font-bold text-amber-600">
                        {{ number_format($statistics['submitted'] ?? 0) }}
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Perlu diperiksa
                    </p>
                </div>

                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <circle cx="12" cy="12" r="9" />

                        <path
                            stroke-linecap="round"
                            d="M12 7v5l3 2"
                        />
                    </svg>
                </span>
            </div>
        </div>
    </x-ui.info-card>

    {{-- Revisi --}}
    <x-ui.info-card>
        <div class="p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Perlu Revisi
                    </p>

                    <p class="mt-3 text-3xl font-bold text-red-600">
                        {{ number_format($statistics['revision'] ?? 0) }}
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Dikembalikan
                    </p>
                </div>

                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600">
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
                            d="M4 4v6h6M20 20v-6h-6"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5.5 15A7 7 0 0017 17l3-3M18.5 9A7 7 0 007 7l-3 3"
                        />
                    </svg>
                </span>
            </div>
        </div>
    </x-ui.info-card>

    {{-- Disetujui --}}
    <x-ui.info-card>
        <div class="p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Disetujui
                    </p>

                    <p class="mt-3 text-3xl font-bold text-emerald-600">
                        {{ number_format($statistics['approved'] ?? 0) }}
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Laporan tervalidasi
                    </p>
                </div>

                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
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
                            d="M9 12l2 2 4-4"
                        />

                        <circle cx="12" cy="12" r="9" />
                    </svg>
                </span>
            </div>
        </div>
    </x-ui.info-card>

</div>