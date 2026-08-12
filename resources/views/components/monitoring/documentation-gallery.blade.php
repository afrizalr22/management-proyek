@php

    $photos = range(1, 12);

@endphp


<div
    x-data="{
        previewOpen: false,
        previewImage: null,
        previewTitle: '',

        openPreview(image, title) {
            this.previewImage = image;
            this.previewTitle = title;
            this.previewOpen = true;
        },

        closePreview() {
            this.previewOpen = false;
            this.previewImage = null;
            this.previewTitle = '';
        }
    }"
    x-on:keydown.escape.window="closePreview()"
>

    <x-ui.info-card>

        <div class="p-8">

            {{-- Header --}}
            <div class="mb-8">

                <h2 class="text-2xl font-bold tracking-tight text-gray-800">
                    Project Documentation
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Dokumentasi foto perkembangan pekerjaan selama proses konstruksi.
                </p>

            </div>


            {{-- Gallery --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

                @foreach ($photos as $photo)

                    @php
                        $imageUrl = 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1200&q=80';
                    @endphp

                    <div
                        class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-lg"
                    >

                        {{-- Image --}}
                        <div class="relative aspect-video overflow-hidden bg-gray-100">

                            <img
                                src="{{ $imageUrl }}"
                                alt="Progress Documentation {{ $photo }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            >


                            {{-- Preview Overlay --}}
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-black/0 opacity-0 transition duration-300 group-hover:bg-black/30 group-hover:opacity-100"
                            >

                                <button
                                    type="button"
                                    x-on:click="openPreview(
                                        '{{ $imageUrl }}',
                                        'Progress Documentation'
                                    )"
                                    class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-gray-800 shadow-lg transition hover:bg-gray-50"
                                >

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
                                            d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6-9.75-6-9.75-6Z"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="2.5"
                                        />
                                    </svg>

                                    Preview

                                </button>

                            </div>

                        </div>


                        {{-- Information --}}
                        <div class="space-y-4 p-5">

                            <div>

                                <h3 class="font-semibold text-gray-800">
                                    Progress Documentation
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Structure Work
                                </p>

                            </div>


                            {{-- Footer --}}
                            <div
                                class="flex items-center justify-between border-t border-gray-100 pt-4"
                            >

                                <div class="flex items-center gap-2 text-xs text-gray-400">

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
                                            d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 5.25h13.5a1.5 1.5 0 0 1 1.5 1.5v12a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-12a1.5 1.5 0 0 1 1.5-1.5Z"
                                        />
                                    </svg>

                                    <span>
                                        27 July 2026
                                    </span>

                                </div>


                                <button
                                    type="button"
                                    x-on:click="openPreview(
                                        '{{ $imageUrl }}',
                                        'Progress Documentation'
                                    )"
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


    {{-- Preview Modal --}}
    <div
        x-show="previewOpen"
        x-transition.opacity
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
    >

        {{-- Overlay --}}
        <div
            class="absolute inset-0 bg-black/80"
            x-on:click="closePreview()"
        ></div>


        {{-- Modal --}}
        <div
            x-show="previewOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0"
            class="relative z-10 w-full max-w-5xl"
        >

            {{-- Close Button --}}
            <button
                type="button"
                x-on:click="closePreview()"
                class="absolute -right-2 -top-12 flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/20"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18 18 6M6 6l12 12"
                    />
                </svg>

            </button>


            {{-- Image Container --}}
            <div class="overflow-hidden rounded-2xl bg-black shadow-2xl">

                <img
                    x-bind:src="previewImage"
                    x-bind:alt="previewTitle"
                    class="max-h-[80vh] w-full object-contain"
                >

            </div>


            {{-- Caption --}}
            <div class="mt-4 text-center">

                <h3
                    class="text-lg font-semibold text-white"
                    x-text="previewTitle"
                ></h3>

                <p class="mt-1 text-sm text-gray-300">
                    Structure Work · 27 July 2026
                </p>

            </div>

        </div>

    </div>

</div>