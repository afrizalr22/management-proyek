@php
    $reports = [
        [
            'id' => '1',
            'project' => 'Jakarta Sky Tower',
            'date' => '24 Mei 2026',
            'uploader' => 'Mandor Utama',
            'activities' => 'Pengecoran kolom dan balok lantai dua telah diselesaikan. Pemeriksaan hasil pekerjaan dilakukan bersama tim lapangan.',
            'obstacles' => null,
            'notes' => 'Pekerjaan berikutnya dilanjutkan ke pemasangan bekisting zona C.',
        ],
        [
            'id' => '2',
            'project' => 'Jakarta Sky Tower',
            'date' => '23 Mei 2026',
            'uploader' => 'Mandor Utama',
            'activities' => 'Pemasangan tulangan struktur dan persiapan pengecoran pada zona B.',
            'obstacles' => 'Pengiriman material terlambat selama dua jam akibat hujan deras dan kondisi jalan menuju lokasi.',
            'notes' => 'Jadwal pengecoran disesuaikan menjadi sore hari.',
        ],
        [
            'id' => '3',
            'project' => 'Gedung Perkantoran Kemang',
            'date' => '22 Mei 2026',
            'uploader' => 'Budi Santoso',
            'activities' => 'Pemasangan instalasi listrik lantai satu dan pemeriksaan jalur kabel utama.',
            'obstacles' => null,
            'notes' => null,
        ],
        [
            'id' => '4',
            'project' => 'Renovasi Gudang Utama',
            'date' => '21 Mei 2026',
            'uploader' => 'Dedi Nugraha',
            'activities' => 'Pembongkaran bagian atap lama dan pembersihan area pekerjaan.',
            'obstacles' => 'Sebagian area pekerjaan belum dapat digunakan karena masih terdapat barang milik klien.',
            'notes' => 'Koordinasi pemindahan barang dilakukan dengan pihak klien.',
        ],
    ];
@endphp

<div class="space-y-5">

    {{-- Section Header --}}
    <div class="flex items-center justify-between gap-4">

        <div>
            <h2 class="text-lg font-bold text-gray-900">
                Daftar Laporan
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Laporan aktivitas proyek berdasarkan tanggal terbaru
            </p>
        </div>

        <span
            class="rounded-full bg-blue-50 px-3 py-1.5
                   text-xs font-semibold text-blue-700"
        >
            {{ count($reports) }} Laporan
        </span>

    </div>

    {{-- Reports --}}
    @foreach ($reports as $report)

        <x-mandor.daily-reports.report-card
            :id="$report['id']"
            :project="$report['project']"
            :date="$report['date']"
            :uploader="$report['uploader']"
            :activities="$report['activities']"
            :obstacles="$report['obstacles']"
            :notes="$report['notes']"
        />

    @endforeach

</div>