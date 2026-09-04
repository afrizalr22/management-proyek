@php
    $documentations = [
        [
            'title' => 'Pemasangan Bekisting Kolom',
            'task' => 'Tugas Struktur Zona A',
            'project' => 'Proyek Gedung Perkantoran',
            'location' => 'Lantai 2, Zona A',
            'date' => '30 Agustus 2026',
            'description' => 'Dokumentasi proses pemasangan bekisting kolom sebelum pekerjaan pengecoran dimulai.',
            'category' => 'Struktur',
            'photoCount' => 3,
            'photo' => null,
        ],
        [
            'title' => 'Pengecekan Material Besi',
            'task' => 'Pemeriksaan Material',
            'project' => 'Proyek Gedung Perkantoran',
            'location' => 'Gudang Material',
            'date' => '30 Agustus 2026',
            'description' => 'Pemeriksaan jumlah dan kondisi material besi yang diterima di area penyimpanan.',
            'category' => 'Material',
            'photoCount' => 4,
            'photo' => null,
        ],
        [
            'title' => 'Pembersihan Area Kerja',
            'task' => 'Pembersihan Zona B',
            'project' => 'Proyek Gedung Perkantoran',
            'location' => 'Lantai 2, Zona B',
            'date' => '29 Agustus 2026',
            'description' => 'Kondisi area pekerjaan setelah proses pembersihan dan pemindahan sisa material.',
            'category' => 'Kebersihan',
            'photoCount' => 2,
            'photo' => null,
        ],
        [
            'title' => 'Pemeriksaan Alat Keselamatan',
            'task' => 'Pemeriksaan Keselamatan Kerja',
            'project' => 'Proyek Gedung Perkantoran',
            'location' => 'Area Utama Proyek',
            'date' => '28 Agustus 2026',
            'description' => 'Dokumentasi pemeriksaan alat pelindung diri sebelum pekerjaan dimulai.',
            'category' => 'Keselamatan',
            'photoCount' => 5,
            'photo' => null,
        ],
        [
            'title' => 'Pemasangan Tulangan Balok',
            'task' => 'Pekerjaan Struktur Lantai 2',
            'project' => 'Proyek Gedung Perkantoran',
            'location' => 'Lantai 2, Zona A',
            'date' => '27 Agustus 2026',
            'description' => 'Progres pemasangan tulangan balok sesuai dengan gambar kerja yang diberikan.',
            'category' => 'Struktur',
            'photoCount' => 3,
            'photo' => null,
        ],
        [
            'title' => 'Persiapan Area Pengecoran',
            'task' => 'Persiapan Pengecoran',
            'project' => 'Proyek Gedung Perkantoran',
            'location' => 'Lantai 2, Zona C',
            'date' => '26 Agustus 2026',
            'description' => 'Kondisi area setelah proses persiapan dan pemeriksaan sebelum pengecoran.',
            'category' => 'Pengecoran',
            'photoCount' => 4,
            'photo' => null,
        ],
    ];
@endphp

<section>
    {{-- Header galeri --}}
    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-bold text-slate-900">
                Galeri Dokumentasi
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Dokumentasi terbaru dari pekerjaan lapangan Anda.
            </p>
        </div>

        <p class="text-sm text-slate-500">
            <span class="font-semibold text-slate-700">
                {{ count($documentations) }}
            </span>
            dokumentasi ditemukan
        </p>
    </div>

    {{-- Daftar kartu --}}
    @if (count($documentations) > 0)
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($documentations as $index => $documentation)
                <x-pekerja.documentations.documentation-card
                    :title="$documentation['title']"
                    :task="$documentation['task']"
                    :project="$documentation['project']"
                    :location="$documentation['location']"
                    :date="$documentation['date']"
                    :description="$documentation['description']"
                    :category="$documentation['category']"
                    :photo-count="$documentation['photoCount']"
                    :photo="$documentation['photo']"
                    wire:key="worker-documentation-{{ $index }}"
                />
            @endforeach
        </div>
    @else
        {{-- Kondisi kosong --}}
        <div
            class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center"
        >
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
                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909"
                    />
                </svg>
            </div>

            <h3 class="mt-4 font-semibold text-slate-900">
                Belum Ada Dokumentasi
            </h3>

            <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                Dokumentasi pekerjaan yang Anda unggah akan tampil pada halaman ini.
            </p>

            <a
                href="#"
                class="mt-5 inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
            >
                Tambah Dokumentasi
            </a>
        </div>
    @endif
</section>