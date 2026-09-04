@php
    $reports = [
        [
            'id' => 1,
            'reportNumber' => 'RPT-2026-08-001',
            'task' => 'Pemasangan panel listrik lantai 12',
            'project' => 'Pembangunan Menara Danamon',
            'location' => 'Lantai 12, Sektor B',
            'date' => '24 Agustus 2026',
            'status' => 'Menunggu Pemeriksaan',
        ],
        [
            'id' => 2,
            'reportNumber' => 'RPT-2026-08-002',
            'task' => 'Penarikan kabel jalur utama',
            'project' => 'Pembangunan Menara Danamon',
            'location' => 'Lantai 12, Sektor A',
            'date' => '23 Agustus 2026',
            'status' => 'Diterima',
        ],
        [
            'id' => 3,
            'reportNumber' => 'RPT-2026-08-003',
            'task' => 'Pengecekan resistansi isolasi kabel',
            'project' => 'Pembangunan Menara Danamon',
            'location' => 'Lantai 12, Seluruh Sektor',
            'date' => '22 Agustus 2026',
            'status' => 'Perlu Revisi',
        ],
    ];
@endphp

<section
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    {{-- Header daftar --}}
    <div
        class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6"
    >
        <div>
            <h2 class="text-lg font-bold text-slate-900">
                Daftar Laporan
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Laporan pekerjaan yang berkaitan dengan tugas Anda.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
            <span class="inline-flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                Menunggu
            </span>

            <span class="inline-flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                Diterima
            </span>

            <span class="inline-flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>
                Perlu revisi
            </span>
        </div>
    </div>

    {{-- Judul kolom desktop --}}
    <div
        class="hidden grid-cols-[140px_minmax(180px,1.5fr)_minmax(190px,1.5fr)_150px_160px_100px] items-center gap-5 bg-slate-50 px-6 py-4 text-sm font-semibold text-slate-600 lg:grid"
    >
        <span>Nomor Laporan</span>
        <span>Tugas</span>
        <span>Proyek dan Lokasi</span>
        <span>Tanggal</span>
        <span>Status</span>
        <span class="text-center">Aksi</span>
    </div>

    {{-- Data laporan --}}
    <div>
        @forelse ($reports as $index => $report)
            <x-pekerja.reports.report-row
                :report-id="$report['id']"
                :report-number="$report['reportNumber']"
                :task="$report['task']"
                :project="$report['project']"
                :location="$report['location']"
                :date="$report['date']"
                :status="$report['status']"
            />
        @empty
            <div class="px-6 py-14 text-center">
                <div
                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.6"
                        stroke="currentColor"
                        class="h-7 w-7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m0 12.75h7.5m-7.5 3h4.5"
                        />
                    </svg>
                </div>

                <h3 class="mt-4 font-semibold text-slate-900">
                    Belum Ada Laporan
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                    Laporan pekerjaan yang berkaitan dengan tugas Anda akan tampil di sini.
                </p>
            </div>
        @endforelse
    </div>
    {{-- Pagination --}}
    <x-pekerja.reports.report-pagination />
</section>