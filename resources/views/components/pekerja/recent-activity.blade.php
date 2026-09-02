@php
    $activities = [
        [
            'title' => 'Tugas Diperbarui',
            'description' => 'Status pemasangan bekisting diubah menjadi sedang dikerjakan.',
            'time' => '20 menit lalu',
            'color' => 'bg-blue-500',
        ],
        [
            'title' => 'Foto Berhasil Diunggah',
            'description' => 'Tiga foto pekerjaan berhasil ditambahkan ke dokumentasi.',
            'time' => '1 jam lalu',
            'color' => 'bg-emerald-500',
        ],
        [
            'title' => 'Laporan Terkirim',
            'description' => 'Laporan hasil pekerjaan harian berhasil dikirim.',
            'time' => 'Kemarin',
            'color' => 'bg-violet-500',
        ],
        [
            'title' => 'Tugas Diselesaikan',
            'description' => 'Pembersihan area kerja lantai satu telah selesai.',
            'time' => '2 hari lalu',
            'color' => 'bg-amber-500',
        ],
    ];
@endphp

<section
    class="h-full rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"
>
    {{-- Header --}}
    <div class="border-b border-slate-200 pb-5">
        <h2 class="text-lg font-bold text-slate-900">
            Aktivitas Terbaru
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Riwayat aktivitas pekerjaan Anda.
        </p>
    </div>

    {{-- Timeline --}}
    <div class="mt-5">
        @foreach ($activities as $activity)
            <div class="flex gap-3">
                {{-- Garis timeline --}}
                <div class="flex w-4 shrink-0 flex-col items-center">
                    <span
                        class="mt-1 h-3 w-3 shrink-0 rounded-full {{ $activity['color'] }} ring-4 ring-white"
                    ></span>

                    @unless ($loop->last)
                        <span class="w-px flex-1 bg-slate-200"></span>
                    @endunless
                </div>

                {{-- Informasi aktivitas --}}
                <div class="min-w-0 flex-1 pb-6">
                    <h3 class="text-sm font-semibold text-slate-900">
                        {{ $activity['title'] }}
                    </h3>

                    <p class="mt-1 text-sm leading-5 text-slate-500">
                        {{ $activity['description'] }}
                    </p>

                    <p class="mt-2 text-xs text-slate-400">
                        {{ $activity['time'] }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Tombol --}}
    <button
        type="button"
        class="inline-flex w-full items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
    >
        Muat Lebih Banyak
    </button>
</section>