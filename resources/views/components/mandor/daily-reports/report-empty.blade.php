<x-ui.info-card>

    <div class="px-6 py-16 text-center">

        {{-- Empty Icon --}}
        <div
            class="mx-auto flex h-20 w-20 items-center
                   justify-center rounded-full bg-gray-100
                   text-gray-400"
        >
            <svg
                class="h-10 w-10"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
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
        </div>

        {{-- Empty Information --}}
        <h2 class="mt-5 text-lg font-bold text-gray-900">
            Laporan tidak ditemukan
        </h2>

        <p
            class="mx-auto mt-2 max-w-md
                   text-sm leading-6 text-gray-500"
        >
            Belum ada laporan yang sesuai dengan proyek,
            tanggal, kondisi, atau kata kunci yang dipilih.
        </p>

        {{-- Actions --}}
        <div
            class="mt-6 flex flex-col items-center
                   justify-center gap-3 sm:flex-row"
        >

            <button
                type="button"
                class="inline-flex h-10 items-center justify-center
                       rounded-lg border border-gray-300
                       bg-white px-5 text-sm font-semibold
                       text-gray-700 transition hover:bg-gray-50"
            >
                Reset Pencarian
            </button>

            <a
                href="{{ route('mandor.daily-reports.create') }}"
                class="inline-flex h-10 items-center justify-center
                       gap-2 rounded-lg bg-blue-600 px-5
                       text-sm font-semibold text-white
                       transition hover:bg-blue-700"
            >
                <svg
                    class="h-4 w-4"
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

                Buat Laporan
            </a>

        </div>

    </div>

</x-ui.info-card>