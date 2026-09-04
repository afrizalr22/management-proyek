<section
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
        <div class="flex items-start gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
            >
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
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.5-1.632Z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Ringkasan Laporan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi pekerja dan tugas yang dilaporkan.
                </p>
            </div>
        </div>
    </div>

    {{-- Informasi --}}
    <dl class="grid grid-cols-1 gap-x-6 gap-y-5 px-5 py-5 sm:grid-cols-2 sm:px-6">
        {{-- Nama pekerja --}}
        <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Nama Pekerja
            </dt>

            <dd class="mt-1 text-sm font-semibold text-slate-900">
                {{ auth()->user()->name ?? 'Budi Santoso' }}
            </dd>
        </div>

        {{-- Tanggal laporan --}}
        <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Tanggal Laporan
            </dt>

            <dd class="mt-1 text-sm font-semibold text-slate-900">
                30 Agustus 2026
            </dd>
        </div>

        {{-- Tugas --}}
        <div class="sm:col-span-2">
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Tugas
            </dt>

            <dd class="mt-1 text-sm font-semibold text-slate-900">
                Pemasangan Bekisting Kolom
            </dd>
        </div>

        {{-- Proyek --}}
        <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Proyek
            </dt>

            <dd class="mt-1 text-sm font-semibold text-slate-900">
                Proyek Gedung Perkantoran
            </dd>
        </div>

        {{-- Lokasi --}}
        <div>
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Lokasi Pekerjaan
            </dt>

            <dd class="mt-1 flex items-start gap-1.5 text-sm font-semibold text-slate-900">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="mt-0.5 h-4 w-4 shrink-0 text-slate-400"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 21s6-4.35 6-10.5a6 6 0 1 0-12 0C6 16.65 12 21 12 21Z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 12.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z"
                    />
                </svg>

                Lantai 2, Zona A
            </dd>
        </div>

        {{-- Waktu pengiriman --}}
        <div class="border-t border-slate-100 pt-4 sm:col-span-2">
            <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Waktu Pengiriman
            </dt>

            <dd class="mt-1 text-sm text-slate-600">
                30 Agustus 2026, 16.45 WIB
            </dd>
        </div>
    </dl>
</section>