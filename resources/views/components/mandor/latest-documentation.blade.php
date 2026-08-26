@php

    $documentations = [

        [
            'title' => 'Pengecoran Kolom Lantai 2',
            'category' => 'Structure Work',
            'date' => '19 August 2026',
            'description' => 'Dokumentasi proses pengecoran kolom area timur.',
        ],

        [
            'title' => 'Pemasangan Bekisting',
            'category' => 'Structure Work',
            'date' => '19 August 2026',
            'description' => 'Dokumentasi pemasangan bekisting lantai 2.',
        ],

        [
            'title' => 'Pemasangan Tulangan',
            'category' => 'Structure Work',
            'date' => '18 August 2026',
            'description' => 'Dokumentasi pekerjaan tulangan lantai 2.',
        ],

    ];

@endphp


<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-2xl font-bold text-gray-800">
                    Latest Documentation
                </h2>

                <p class="mt-2 text-gray-500">
                    Dokumentasi pekerjaan terbaru dari lokasi proyek.
                </p>

            </div>

            <a
                href="#"
                class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
            >

                View All

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 5l7 7-7 7"
                    />

                </svg>

            </a>

        </div>


        {{-- Documentation --}}
        <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-3">

            @foreach($documentations as $documentation)

                <div
                    class="overflow-hidden rounded-2xl border border-gray-200 transition duration-200 hover:-translate-y-1 hover:shadow-lg"
                >

                    {{-- Image Placeholder --}}
                    <div
                        class="flex aspect-video items-center justify-center bg-gray-100"
                    >

                        <div class="text-center">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="mx-auto h-10 w-10 text-gray-300"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.5"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 16l5-5a2 2 0 012.828 0L15 15m-2-2l1.172-1.172a2 2 0 012.828 0L21 14m-6-9h.01M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                />

                            </svg>

                            <p class="mt-2 text-sm text-gray-400">
                                Documentation Photo
                            </p>

                        </div>

                    </div>


                    {{-- Information --}}
                    <div class="p-5">

                        <div class="flex items-start justify-between gap-3">

                            <h3 class="font-semibold text-gray-800">
                                {{ $documentation['title'] }}
                            </h3>

                            <span
                                class="shrink-0 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600"
                            >
                                {{ $documentation['category'] }}
                            </span>

                        </div>

                        <p class="mt-3 text-sm leading-6 text-gray-500">
                            {{ $documentation['description'] }}
                        </p>

                        <div class="mt-4 flex items-center justify-between">

                            <span class="text-xs text-gray-400">
                                {{ $documentation['date'] }}
                            </span>

                            <button
                                type="button"
                                class="text-sm font-semibold text-blue-600 transition hover:text-blue-700"
                            >
                                Preview
                            </button>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</x-ui.info-card>