@php
    $documentations = [
        [
            'image' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=900&q=80',
            'project' => 'Jakarta Sky Tower',
            'description' => 'Pengecoran kolom dan balok lantai dua telah selesai dilaksanakan.',
            'date' => '24 Mei 2026',
            'uploader' => 'Mandor Utama',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1541971875076-8f970d573be6?auto=format&fit=crop&w=900&q=80',
            'project' => 'Jakarta Sky Tower',
            'description' => 'Pemeriksaan pemasangan tulangan struktur pada zona B.',
            'date' => '23 Mei 2026',
            'uploader' => 'Mandor Utama',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1590644365607-1c5a38e88a8c?auto=format&fit=crop&w=900&q=80',
            'project' => 'Gedung Kemang',
            'description' => 'Aktivitas pekerja lapangan pada pekerjaan struktur utama.',
            'date' => '22 Mei 2026',
            'uploader' => 'Andi Saputra',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=900&q=80',
            'project' => 'Jakarta Sky Tower',
            'description' => 'Perkembangan pembangunan struktur bangunan sisi timur.',
            'date' => '21 Mei 2026',
            'uploader' => 'Mandor Utama',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1487958449943-2429e8be8625?auto=format&fit=crop&w=900&q=80',
            'project' => 'Gedung Kemang',
            'description' => 'Pemeriksaan kesesuaian pekerjaan dengan gambar perencanaan.',
            'date' => '20 Mei 2026',
            'uploader' => 'Budi Santoso',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1531834685032-c34bf0d84c77?auto=format&fit=crop&w=900&q=80',
            'project' => 'Renovasi Gudang',
            'description' => 'Pemasangan rangka bangunan dan pemeriksaan area pekerjaan.',
            'date' => '19 Mei 2026',
            'uploader' => 'Dedi Nugraha',
        ],
    ];
@endphp

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">

    @foreach ($documentations as $documentation)

        <x-mandor.documentations.documentation-card
            :image="$documentation['image']"
            :project="$documentation['project']"
            :description="$documentation['description']"
            :date="$documentation['date']"
            :uploader="$documentation['uploader']"
        />

    @endforeach

</div>