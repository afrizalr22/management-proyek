@php
    $tasks = [
        [
            'title' => 'Pemasangan Bekisting Kolom',
            'project' => 'Proyek Gedung Perkantoran',
            'location' => 'Gedung Utama, Zona A',
            'deadline' => 'Hari ini, 10.00 WIB',
            'priority' => 'Tinggi',
            'status' => 'Sedang Dikerjakan',
        ],
        [
            'title' => 'Pengecekan Material Besi',
            'project' => 'Pekerjaan Struktur Lantai 2',
            'location' => 'Gudang Material',
            'deadline' => 'Hari ini, 12.00 WIB',
            'priority' => 'Sedang',
            'status' => 'Belum Dimulai',
        ],
        [
            'title' => 'Pembersihan Area Pekerjaan',
            'project' => 'Proyek Gedung Perkantoran',
            'location' => 'Lantai 2, Zona B',
            'deadline' => 'Hari ini, 15.30 WIB',
            'priority' => 'Rendah',
            'status' => 'Belum Dimulai',
        ],
        [
            'title' => 'Pemasangan Tulangan Balok',
            'project' => 'Pekerjaan Struktur Lantai 2',
            'location' => 'Lantai 2, Zona A',
            'deadline' => 'Besok, 09.00 WIB',
            'priority' => 'Tinggi',
            'status' => 'Sedang Dikerjakan',
        ],
        [
            'title' => 'Pemeriksaan Alat Keselamatan',
            'project' => 'Pemeriksaan Keselamatan Kerja',
            'location' => 'Area Proyek',
            'deadline' => 'Selesai, 16.00 WIB',
            'priority' => 'Sedang',
            'status' => 'Selesai',
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
                Daftar Tugas
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Tugas pekerjaan yang diberikan kepada Anda.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
            <span class="inline-flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                Sedang dikerjakan
            </span>

            <span class="inline-flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-slate-300"></span>
                Belum dimulai
            </span>

            <span class="inline-flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                Selesai
            </span>
        </div>
    </div>

    {{-- Judul kolom desktop --}}
    <div
        class="hidden grid-cols-[minmax(0,2fr)_minmax(150px,1.2fr)_minmax(130px,1fr)_110px_150px_130px] items-center gap-5 bg-slate-50 px-6 py-4 text-sm font-semibold text-slate-600 lg:grid"
    >
        <span>Detail Tugas</span>
        <span>Lokasi</span>
        <span>Tenggat Waktu</span>
        <span>Prioritas</span>
        <span>Status</span>
        <span class="text-center">Aksi</span>
    </div>

        {{-- Data tugas --}}
    <div>
        @forelse ($tasks as $index => $task)
            <x-pekerja.tasks.task-row
                :title="$task['title']"
                :project="$task['project']"
                :location="$task['location']"
                :deadline="$task['deadline']"
                :priority="$task['priority']"
                :status="$task['status']"
                wire:key="worker-task-{{ $index }}"
            />
        @empty
            <div class="px-6 py-12 text-center">
                <h3 class="font-semibold text-slate-900">
                    Belum Ada Tugas
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Tugas yang diberikan oleh Mandor akan tampil di sini.
                </p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <x-pekerja.tasks.task-pagination />
</section>
</section>