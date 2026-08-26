<x-ui.info-card class="overflow-hidden">

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5">

        <div>
            <h2 class="text-base font-bold text-gray-900">
                Assigned Team
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Daftar pekerja lapangan yang ditugaskan pada proyek
            </p>
        </div>

        <span
            class="rounded-full bg-blue-50 px-3 py-1.5
                   text-xs font-semibold text-blue-700"
        >
            4 Pekerja
        </span>

    </div>

    {{-- Worker List --}}
    <div class="grid grid-cols-1 gap-4 p-6 md:grid-cols-2">

        {{-- Worker 1 --}}
        <div
            class="flex items-center justify-between rounded-xl
                   border border-gray-200 p-4 transition
                   hover:border-blue-200 hover:bg-blue-50/30"
        >

            <div class="flex min-w-0 items-center gap-4">

                <div
                    class="flex h-12 w-12 shrink-0 items-center
                           justify-center rounded-xl bg-blue-600
                           text-sm font-bold text-white"
                >
                    BS
                </div>

                <div class="min-w-0">

                    <h3 class="truncate font-semibold text-gray-900">
                        Budi Santoso
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Pekerja Lapangan
                    </p>

                </div>

            </div>

            <button
                type="button"
                class="ml-3 flex h-9 w-9 shrink-0 items-center
                       justify-center rounded-lg text-blue-600
                       transition hover:bg-blue-100"
                title="Lihat detail pekerja"
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
                        d="M9 18l6-6-6-6"
                    />
                </svg>
            </button>

        </div>

        {{-- Worker 2 --}}
        <div
            class="flex items-center justify-between rounded-xl
                   border border-gray-200 p-4 transition
                   hover:border-blue-200 hover:bg-blue-50/30"
        >

            <div class="flex min-w-0 items-center gap-4">

                <div
                    class="flex h-12 w-12 shrink-0 items-center
                           justify-center rounded-xl bg-emerald-600
                           text-sm font-bold text-white"
                >
                    SA
                </div>

                <div class="min-w-0">

                    <h3 class="truncate font-semibold text-gray-900">
                        Siti Aminah
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Pekerja Lapangan
                    </p>

                </div>

            </div>

            <button
                type="button"
                class="ml-3 flex h-9 w-9 shrink-0 items-center
                       justify-center rounded-lg text-blue-600
                       transition hover:bg-blue-100"
                title="Lihat detail pekerja"
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
                        d="M9 18l6-6-6-6"
                    />
                </svg>
            </button>

        </div>

        {{-- Worker 3 --}}
        <div
            class="flex items-center justify-between rounded-xl
                   border border-gray-200 p-4 transition
                   hover:border-blue-200 hover:bg-blue-50/30"
        >

            <div class="flex min-w-0 items-center gap-4">

                <div
                    class="flex h-12 w-12 shrink-0 items-center
                           justify-center rounded-xl bg-amber-500
                           text-sm font-bold text-white"
                >
                    AR
                </div>

                <div class="min-w-0">

                    <h3 class="truncate font-semibold text-gray-900">
                        Andi Ramadhan
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Pekerja Lapangan
                    </p>

                </div>

            </div>

            <button
                type="button"
                class="ml-3 flex h-9 w-9 shrink-0 items-center
                       justify-center rounded-lg text-blue-600
                       transition hover:bg-blue-100"
                title="Lihat detail pekerja"
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
                        d="M9 18l6-6-6-6"
                    />
                </svg>
            </button>

        </div>

        {{-- Worker 4 --}}
        <div
            class="flex items-center justify-between rounded-xl
                   border border-gray-200 p-4 transition
                   hover:border-blue-200 hover:bg-blue-50/30"
        >

            <div class="flex min-w-0 items-center gap-4">

                <div
                    class="flex h-12 w-12 shrink-0 items-center
                           justify-center rounded-xl bg-violet-600
                           text-sm font-bold text-white"
                >
                    DN
                </div>

                <div class="min-w-0">

                    <h3 class="truncate font-semibold text-gray-900">
                        Dedi Nugraha
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Pekerja Lapangan
                    </p>

                </div>

            </div>

            <button
                type="button"
                class="ml-3 flex h-9 w-9 shrink-0 items-center
                       justify-center rounded-lg text-blue-600
                       transition hover:bg-blue-100"
                title="Lihat detail pekerja"
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
                        d="M9 18l6-6-6-6"
                    />
                </svg>
            </button>

        </div>

    </div>

</x-ui.info-card>