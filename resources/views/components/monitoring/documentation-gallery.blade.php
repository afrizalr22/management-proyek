@php

$photos = range(1, 12);

@endphp

<x-ui.info-card>

    <div class="grid grid-cols-1 gap-6 p-8 md:grid-cols-2 xl:grid-cols-3">

        @foreach($photos as $photo)

            <div
                class="overflow-hidden rounded-2xl border border-gray-200 transition hover:-translate-y-1 hover:shadow-lg"
            >

                <div class="flex aspect-video items-center justify-center bg-gray-200">

                    <span class="text-gray-400">

                        Photo {{ $photo }}

                    </span>

                </div>

                <div class="space-y-2 p-5">

                    <h3 class="font-semibold text-gray-800">

                        Progress Documentation

                    </h3>

                    <p class="text-sm text-gray-500">

                        Structure Work

                    </p>

                    <div class="flex items-center justify-between">

                        <span class="text-xs text-gray-400">

                            27 July 2026

                        </span>

                        <button
                            class="text-sm font-semibold text-blue-600 hover:text-blue-700"
                        >
                            Preview
                        </button>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</x-ui.info-card>