@php

$activities = [

    [

        'time' => '08:10',

        'title' => 'Progress diperbarui',

        'description' => 'Mandor mengubah progress menjadi 75%.',

        'color' => 'bg-blue-500',

    ],

    [

        'time' => '09:20',

        'title' => 'Dokumentasi ditambahkan',

        'description' => '3 foto pekerjaan struktur berhasil diunggah.',

        'color' => 'bg-green-500',

    ],

    [

        'time' => '10:45',

        'title' => 'Issue dibuat',

        'description' => 'Material WF belum diterima dari supplier.',

        'color' => 'bg-red-500',

    ],

    [

        'time' => '13:30',

        'title' => 'Laporan Harian dikirim',

        'description' => 'Mandor mengirim laporan pekerjaan hari ini.',

        'color' => 'bg-indigo-500',

    ],

];

@endphp

<x-ui.info-card>

    <div class="p-8">

        <h2 class="text-2xl font-bold text-gray-800">

            Recent Activity

        </h2>

        <p class="mt-2 text-gray-500">

            Aktivitas terbaru pada proyek.

        </p>

        <div class="mt-8 space-y-6">

            @foreach($activities as $activity)

                <div class="flex gap-4">

                    <div class="flex flex-col items-center">

                        <div class="h-4 w-4 rounded-full {{ $activity['color'] }}"></div>

                        @unless($loop->last)

                            <div class="mt-2 h-16 w-px bg-gray-300"></div>

                        @endunless

                    </div>

                    <div class="flex-1">

                        <div class="flex items-center justify-between">

                            <h4 class="font-semibold text-gray-800">

                                {{ $activity['title'] }}

                            </h4>

                            <span class="text-sm text-gray-400">

                                {{ $activity['time'] }}

                            </span>

                        </div>

                        <p class="mt-2 text-sm text-gray-500">

                            {{ $activity['description'] }}

                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</x-ui.info-card>