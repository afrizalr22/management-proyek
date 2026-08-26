<div class="grid grid-cols-1 gap-5 md:grid-cols-3">

    {{-- Reports This Week --}}
    <x-ui.info-card class="p-5">

        <div class="flex items-start justify-between gap-4">

            <div>

                <p
                    class="text-xs font-semibold uppercase
                           tracking-wide text-gray-500"
                >
                    Laporan Minggu Ini
                </p>

                <p class="mt-3 text-3xl font-bold text-gray-900">
                    12
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Laporan telah dibuat
                </p>

            </div>

            <span
                class="flex h-11 w-11 shrink-0 items-center
                       justify-center rounded-xl bg-blue-50
                       text-blue-600"
            >
                <svg
                    class="h-6 w-6"
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

        {{-- Weekly Progress --}}
        <div class="mt-5">

            <div class="flex items-center justify-between text-xs">

                <span class="text-gray-500">
                    Target mingguan
                </span>

                <span class="font-semibold text-blue-600">
                    12 dari 14
                </span>

            </div>

            <div class="mt-2 h-2 overflow-hidden rounded-full bg-gray-100">

                <div
                    class="h-full rounded-full bg-blue-600"
                    style="width: 86%"
                ></div>

            </div>

        </div>

    </x-ui.info-card>

    {{-- Reported Projects --}}
    <x-ui.info-card class="p-5">

        <div class="flex items-start justify-between gap-4">

            <div>

                <p
                    class="text-xs font-semibold uppercase
                           tracking-wide text-gray-500"
                >
                    Proyek Dilaporkan
                </p>

                <p class="mt-3 text-3xl font-bold text-gray-900">
                    3
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Proyek memiliki laporan
                </p>

            </div>

            <span
                class="flex h-11 w-11 shrink-0 items-center
                       justify-center rounded-xl bg-violet-50
                       text-violet-600"
            >
                <svg
                    class="h-6 w-6"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 21h18M5 21V7l7-4 7 4v14"
                    />

                    <path d="M9 21v-6h6v6M9 9h.01M15 9h.01" />
                </svg>
            </span>

        </div>

        <div class="mt-5 flex items-center gap-2">

            <span
                class="flex h-6 w-6 items-center justify-center
                       rounded-full bg-emerald-50 text-emerald-600"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                    />
                </svg>
            </span>

            <p class="text-sm font-medium text-emerald-600">
                Semua proyek aktif telah dilaporkan
            </p>

        </div>

    </x-ui.info-card>

    {{-- Reports with Obstacles --}}
    <x-ui.info-card class="p-5">

        <div class="flex items-start justify-between gap-4">

            <div>

                <p
                    class="text-xs font-semibold uppercase
                           tracking-wide text-gray-500"
                >
                    Laporan dengan Kendala
                </p>

                <p class="mt-3 text-3xl font-bold text-red-600">
                    2
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Memerlukan perhatian
                </p>

            </div>

            <span
                class="flex h-11 w-11 shrink-0 items-center
                       justify-center rounded-xl bg-red-50
                       text-red-600"
            >
                <svg
                    class="h-6 w-6"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3L2.5 20h19L12 3z"
                    />

                    <path
                        stroke-linecap="round"
                        d="M12 9v5M12 17h.01"
                    />
                </svg>
            </span>

        </div>

        <div
            class="mt-5 flex items-center justify-between
                   rounded-lg bg-red-50 px-3 py-2.5"
        >

            <span class="text-sm font-medium text-red-700">
                Periksa kendala proyek
            </span>

            <svg
                class="h-4 w-4 text-red-600"
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

        </div>

    </x-ui.info-card>

</div>