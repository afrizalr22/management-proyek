@props([
    'status' => 'Menunggu Pemeriksaan',
])

<section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
    <div class="flex items-start gap-3">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
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
                    d="M9 12.75 11.25 15 15 9.75m5.25-4.5v6c0 5.25-3.438 9.75-8.25 11.25C7.188 21 3.75 16.5 3.75 11.25v-6L12 2.25l8.25 3Z"
                />
            </svg>
        </div>

        <div>
            <h2 class="text-lg font-semibold text-slate-900">
                Tanggapan Mandor
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Hasil pemeriksaan dan catatan dari Mandor.
            </p>
        </div>
    </div>

    <div class="mt-5">
        @if ($status === 'Diterima')
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-sm font-semibold text-white">
                        AH
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-900">
                            Agus Hermawan
                        </p>

                        <p class="text-xs text-slate-500">
                            Mandor Lapangan
                        </p>
                    </div>
                </div>

                <p class="mt-4 text-sm leading-6 text-slate-700">
                    Laporan sudah sesuai dengan kondisi pekerjaan di lapangan.
                    Dokumentasi dan uraian pekerjaan telah diperiksa.
                </p>

                <p class="mt-3 text-xs font-medium text-emerald-700">
                    Diterima pada 24 Agustus 2026, 17:30 WIB
                </p>
            </div>
        @elseif ($status === 'Perlu Revisi')
            <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-600 text-sm font-semibold text-white">
                        AH
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-900">
                            Agus Hermawan
                        </p>

                        <p class="text-xs text-slate-500">
                            Mandor Lapangan
                        </p>
                    </div>
                </div>

                <p class="mt-4 text-sm leading-6 text-slate-700">
                    Mohon perjelas uraian pekerjaan dan tambahkan dokumentasi
                    hasil akhir pekerjaan sebelum laporan dikirim kembali.
                </p>

                <p class="mt-3 text-xs font-medium text-red-700">
                    Revisi diminta pada 24 Agustus 2026, 17:30 WIB
                </p>
            </div>
        @else
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                <div class="flex items-start gap-3">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="mt-0.5 h-5 w-5 shrink-0 text-amber-600"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>

                    <div>
                        <p class="text-sm font-semibold text-amber-900">
                            Menunggu pemeriksaan
                        </p>

                        <p class="mt-1 text-sm leading-6 text-amber-800">
                            Laporan telah dikirim dan sedang menunggu pemeriksaan
                            dari Mandor.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>