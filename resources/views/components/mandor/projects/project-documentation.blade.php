<x-ui.info-card class="overflow-hidden">

    {{-- Header --}}
    <div
        class="flex flex-col gap-4 border-b border-gray-200
               px-6 py-5 sm:flex-row sm:items-center
               sm:justify-between"
    >

        <div>
            <h2 class="text-base font-bold text-gray-900">
                Dokumentasi Proyek
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Foto perkembangan pekerjaan di lokasi proyek
            </p>
        </div>

        <div class="flex items-center gap-3">

            {{-- Photo Counter --}}
            <span
                class="rounded-full bg-blue-50 px-3 py-1.5
                       text-xs font-semibold text-blue-700"
            >
                6 Foto
            </span>



        </div>

    </div>

    {{-- Documentation Gallery --}}
    <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 lg:grid-cols-3">

        {{-- Photo 1 --}}
        <article
            class="group relative aspect-[4/3] overflow-hidden
                   rounded-xl bg-gray-200"
        >

            <img
                src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=800&q=80"
                alt="Pekerjaan konstruksi proyek"
                class="h-full w-full object-cover transition
                       duration-300 group-hover:scale-105"
            >

            <div
                class="absolute inset-0 bg-gradient-to-t
                       from-black/80 via-black/10 to-transparent"
            ></div>

            <div class="absolute inset-x-0 bottom-0 p-4">

                <h3 class="text-sm font-semibold text-white">
                    Pekerjaan Struktur
                </h3>

                <p class="mt-1 text-xs text-white/70">
                    24 Mei 2026
                </p>

            </div>

        </article>

        {{-- Photo 2 --}}
        <article
            class="group relative aspect-[4/3] overflow-hidden
                   rounded-xl bg-gray-200"
        >

            <img
                src="https://images.unsplash.com/photo-1541971875076-8f970d573be6?auto=format&fit=crop&w=800&q=80"
                alt="Pemasangan struktur bangunan"
                class="h-full w-full object-cover transition
                       duration-300 group-hover:scale-105"
            >

            <div
                class="absolute inset-0 bg-gradient-to-t
                       from-black/80 via-black/10 to-transparent"
            ></div>

            <div class="absolute inset-x-0 bottom-0 p-4">

                <h3 class="text-sm font-semibold text-white">
                    Pemasangan Tulangan
                </h3>

                <p class="mt-1 text-xs text-white/70">
                    23 Mei 2026
                </p>

            </div>

        </article>

        {{-- Photo 3 --}}
        <article
            class="group relative aspect-[4/3] overflow-hidden
                   rounded-xl bg-gray-200"
        >

            <img
                src="https://images.unsplash.com/photo-1590644365607-1c5a38e88a8c?auto=format&fit=crop&w=800&q=80"
                alt="Aktivitas pekerja lapangan"
                class="h-full w-full object-cover transition
                       duration-300 group-hover:scale-105"
            >

            <div
                class="absolute inset-0 bg-gradient-to-t
                       from-black/80 via-black/10 to-transparent"
            ></div>

            <div class="absolute inset-x-0 bottom-0 p-4">

                <h3 class="text-sm font-semibold text-white">
                    Aktivitas Lapangan
                </h3>

                <p class="mt-1 text-xs text-white/70">
                    22 Mei 2026
                </p>

            </div>

        </article>

        {{-- Photo 4 --}}
        <article
            class="group relative aspect-[4/3] overflow-hidden
                   rounded-xl bg-gray-200"
        >

            <img
                src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=800&q=80"
                alt="Bangunan dalam proses konstruksi"
                class="h-full w-full object-cover transition
                       duration-300 group-hover:scale-105"
            >

            <div
                class="absolute inset-0 bg-gradient-to-t
                       from-black/80 via-black/10 to-transparent"
            ></div>

            <div class="absolute inset-x-0 bottom-0 p-4">

                <h3 class="text-sm font-semibold text-white">
                    Perkembangan Bangunan
                </h3>

                <p class="mt-1 text-xs text-white/70">
                    21 Mei 2026
                </p>

            </div>

        </article>

        {{-- Photo 5 --}}
        <article
            class="group relative aspect-[4/3] overflow-hidden
                   rounded-xl bg-gray-200"
        >

            <img
                src="https://images.unsplash.com/photo-1487958449943-2429e8be8625?auto=format&fit=crop&w=800&q=80"
                alt="Pemeriksaan lokasi proyek"
                class="h-full w-full object-cover transition
                       duration-300 group-hover:scale-105"
            >

            <div
                class="absolute inset-0 bg-gradient-to-t
                       from-black/80 via-black/10 to-transparent"
            ></div>

            <div class="absolute inset-x-0 bottom-0 p-4">

                <h3 class="text-sm font-semibold text-white">
                    Pemeriksaan Lokasi
                </h3>

                <p class="mt-1 text-xs text-white/70">
                    20 Mei 2026
                </p>

            </div>

        </article>

        {{-- View All Photos --}}
        <button
            type="button"
            class="group relative flex aspect-[4/3]
                   items-center justify-center overflow-hidden
                   rounded-xl bg-slate-900 transition
                   hover:bg-slate-800"
        >

            <div class="text-center">

                <div
                    class="mx-auto flex h-12 w-12 items-center
                           justify-center rounded-full bg-white/10
                           text-white transition group-hover:bg-white/20"
                >
                    <svg
                        class="h-6 w-6"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <rect
                            x="3"
                            y="3"
                            width="18"
                            height="18"
                            rx="2"
                        />

                        <circle cx="8.5" cy="8.5" r="1.5" />

                        <path d="M21 15l-5-5L5 21" />
                    </svg>
                </div>

                <p class="mt-3 text-sm font-semibold text-white">
                    Lihat Semua Foto
                </p>

                <p class="mt-1 text-xs text-white/60">
                    Buka galeri proyek
                </p>

            </div>

        </button>

    </div>

</x-ui.info-card>