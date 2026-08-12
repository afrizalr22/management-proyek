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

        {{-- Header --}}
        <div>

            <h2 class="text-2xl font-bold text-gray-800">
                Recent Activity
            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500">
                Aktivitas terbaru pada proyek.
            </p>

        </div>


        {{-- Activity Timeline --}}
        <div class="mt-8 space-y-6">

            @foreach ($activities as $activity)

                <div class="flex gap-4">

                    {{-- Timeline --}}
                    <div class="relative flex w-4 shrink-0 justify-center">

                        {{-- Timeline Line --}}
                        @unless ($loop->last)

                            <div
                                class="absolute left-1/2 top-3.5 h-[calc(100%+24px)] w-px -translate-x-1/2 bg-gray-200"
                            ></div>

                        @endunless


                        {{-- Timeline Dot --}}
                        <span
                            class="relative z-10 h-3.5 w-3.5 shrink-0 rounded-full {{ $activity['color'] }}"
                        ></span>

                    </div>


                    {{-- Activity Content --}}
                    <div class="min-w-0 flex-1 pb-1">

                        {{-- Title & Time --}}
                        <div class="flex items-start justify-between gap-4">

                            <h4 class="font-semibold text-gray-800">
                                {{ $activity['title'] }}
                            </h4>

                            <span
                                class="shrink-0 text-xs font-medium text-gray-400"
                            >
                                {{ $activity['time'] }}
                            </span>

                        </div>


                        {{-- Description --}}
                        <p class="mt-1.5 text-sm leading-6 text-gray-500">
                            {{ $activity['description'] }}
                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</x-ui.info-card>