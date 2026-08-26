@php

    $activities = [

        [
            'time' => '08:10',
            'title' => 'Progress diperbarui',
            'description' => 'Progress pengecoran kolom lantai 2 diperbarui menjadi 75%.',
            'color' => 'bg-blue-500',
        ],

        [
            'time' => '09:20',
            'title' => 'Dokumentasi ditambahkan',
            'description' => '3 foto dokumentasi pekerjaan struktur berhasil ditambahkan.',
            'color' => 'bg-emerald-500',
        ],

        [
            'time' => '10:45',
            'title' => 'Issue dibuat',
            'description' => 'Material WF belum diterima sesuai jadwal dari supplier.',
            'color' => 'bg-red-500',
        ],

        [
            'time' => '13:30',
            'title' => 'Laporan harian dikirim',
            'description' => 'Laporan pekerjaan harian berhasil dikirim.',
            'color' => 'bg-indigo-500',
        ],

        [
            'time' => '15:15',
            'title' => 'Task diselesaikan',
            'description' => 'Pemasangan tulangan lantai 2 telah selesai.',
            'color' => 'bg-green-500',
        ],

    ];

@endphp


<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div>

            <h2 class="text-2xl font-bold text-gray-800">
                Recent Activity
            </h2>

            <p class="mt-2 text-gray-500">
                Aktivitas terbaru pada proyek.
            </p>

        </div>


        {{-- Activity Timeline --}}
        <div class="mt-8">

            @foreach($activities as $activity)

                <div class="flex gap-4">

                    {{-- Timeline --}}
                    <div class="flex w-5 shrink-0 flex-col items-center">

                        {{-- Dot --}}
                        <div
                            class="h-3.5 w-3.5 shrink-0 rounded-full {{ $activity['color'] }} ring-4 ring-white"
                        ></div>

                        {{-- Line --}}
                        @unless($loop->last)

                            <div
                                class="w-px flex-1 bg-gray-200"
                            ></div>

                        @endunless

                    </div>


                    {{-- Activity Content --}}
                    <div class="min-w-0 flex-1 pb-8">

                        <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between">

                            <h3 class="font-semibold text-gray-800">
                                {{ $activity['title'] }}
                            </h3>

                            <span class="shrink-0 text-xs font-medium text-gray-400">
                                {{ $activity['time'] }}
                            </span>

                        </div>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            {{ $activity['description'] }}
                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</x-ui.info-card>