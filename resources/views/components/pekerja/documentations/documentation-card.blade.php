@props([
    'title',
    'task',
    'project',
    'location',
    'date',
    'description',
    'category' => 'Pekerjaan',
    'photoCount' => 1,
    'photo' => null,
])

<article
    class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-lg"
>
    {{-- Foto dokumentasi --}}
    <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
        @if ($photo)
            <img
                src="{{ asset($photo) }}"
                alt="Dokumentasi {{ $title }}"
                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
            >
        @else
            <div
                class="flex h-full w-full flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-12 w-12"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 19.5h16.5A1.5 1.5 0 0 0 21.75 18V6A1.5 1.5 0 0 0 20.25 4.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"
                    />
                </svg>

                <p class="mt-2 text-sm">
                    Foto dokumentasi
                </p>
            </div>
        @endif

        {{-- Kategori --}}
        <span
            class="absolute left-3 top-3 inline-flex rounded-full bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm"
        >
            {{ $category }}
        </span>

        {{-- Jumlah foto --}}
        <span
            class="absolute bottom-3 right-3 inline-flex items-center gap-1.5 rounded-lg bg-slate-900/75 px-2.5 py-1.5 text-xs font-semibold text-white backdrop-blur-sm"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-4 w-4"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909"
                />
            </svg>

            {{ $photoCount }}
        </span>
    </div>

    {{-- Informasi --}}
    <div class="p-5">
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-slate-500">
            <span class="inline-flex items-center gap-1.5">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-4 w-4"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6.75 3v2.25M17.25 3v2.25M3.75 9.75h16.5M5.25 5.25h13.5A1.5 1.5 0 0 1 20.25 6.75v12a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-12a1.5 1.5 0 0 1 1.5-1.5Z"
                    />
                </svg>

                {{ $date }}
            </span>

            <span class="inline-flex items-center gap-1.5">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-4 w-4"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 21s6-4.35 6-10.5a6 6 0 1 0-12 0C6 16.65 12 21 12 21Z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 12.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z"
                    />
                </svg>

                {{ $location }}
            </span>
        </div>

        <h2 class="mt-4 text-lg font-bold leading-6 text-slate-900">
            {{ $title }}
        </h2>

        <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">
            {{ $description }}
        </p>

        {{-- Tugas terkait --}}
        <div class="mt-4 rounded-xl bg-slate-50 p-3">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Tugas terkait
            </p>

            <p class="mt-1 text-sm font-semibold text-slate-700">
                {{ $task }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                {{ $project }}
            </p>
        </div>

        <a
            href="#"
            class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
        >
            Lihat Dokumentasi

            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-4 w-4"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m9 18 6-6-6-6"
                />
            </svg>
        </a>
    </div>
</article>