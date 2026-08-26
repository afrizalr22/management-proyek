<x-ui.info-card class="overflow-hidden">

    {{-- Header --}}
    <div class="border-b border-gray-200 px-6 py-5">

        <h2 class="text-base font-bold text-gray-900">
            Informasi Proyek
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Informasi umum dan kontrak proyek
        </p>

    </div>

    {{-- Information --}}
    <div class="space-y-5 p-6">

        {{-- Client --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                Klien
            </p>

            <p class="mt-1 font-semibold text-gray-900">
                PT Pembangunan Indonesia
            </p>

        </div>

        {{-- Location --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                Lokasi Proyek
            </p>

            <div class="mt-1 flex items-start gap-2">

                <svg
                    class="mt-0.5 h-5 w-5 shrink-0 text-blue-600"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 21s7-4.35 7-11a7 7 0
                           10-14 0c0 6.65 7 11 7 11z"
                    />

                    <circle cx="12" cy="10" r="2.5" />
                </svg>

                <p class="text-sm leading-6 text-gray-700">
                    Jalan Jenderal Sudirman, Jakarta Pusat
                </p>

            </div>

        </div>

        {{-- Contract Number --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                Nomor Kontrak
            </p>

            <p class="mt-1 font-semibold text-gray-900">
                KTR/PROYEK/001/2026
            </p>

        </div>

        {{-- Project Period --}}
        <div>

            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                Periode Proyek
            </p>

            <div class="mt-2 grid grid-cols-2 gap-3">

                <div class="rounded-xl bg-gray-50 p-3">

                    <p class="text-xs text-gray-400">
                        Tanggal Mulai
                    </p>

                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        1 Februari 2026
                    </p>

                </div>

                <div class="rounded-xl bg-gray-50 p-3">

                    <p class="text-xs text-gray-400">
                        Tanggal Selesai
                    </p>

                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        20 Desember 2026
                    </p>

                </div>

            </div>

        </div>

        {{-- Financial Information --}}
        <div class="border-t border-gray-200 pt-5">

            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                Informasi Keuangan
            </p>

            <div class="mt-3 space-y-3">

                <div class="flex items-center justify-between gap-4">

                    <span class="text-sm text-gray-500">
                        Anggaran Proyek
                    </span>

                    <span class="text-sm font-semibold text-gray-900">
                        Rp8.500.000.000
                    </span>

                </div>

                <div class="flex items-center justify-between gap-4">

                    <span class="text-sm text-gray-500">
                        Nilai Kontrak
                    </span>

                    <span class="text-sm font-bold text-blue-600">
                        Rp9.000.000.000
                    </span>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>