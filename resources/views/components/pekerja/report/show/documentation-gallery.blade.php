@props([
    'documentations' => [],
])

<section
    x-data="{
        photoOpen: false,
        activePhoto: '',
        activeTitle: '',

        openPhoto(photo, title) {
            this.activePhoto = photo;
            this.activeTitle = title;
            this.photoOpen = true;
        },

        closePhoto() {
            this.photoOpen = false;
            this.activePhoto = '';
            this.activeTitle = '';
        }
    }"
    x-on:keydown.escape.window="closePhoto()"
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    <div
        class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6"
    >
        <div class="flex items-start gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Dokumentasi Pendukung
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Foto yang dilampirkan bersama laporan.
                </p>
            </div>
        </div>

        <span
            class="inline-flex w-fit rounded-lg bg-violet-50 px-3 py-1.5 text-xs font-semibold text-violet-600"
        >
            {{ count($documentations) }} foto
        </span>
    </div>

    <div
        class="grid grid-cols-1 gap-4 px-5 py-5 sm:grid-cols-2 sm:px-6 lg:grid-cols-3"
    >
        @forelse ($documentations as $documentation)
            @php
                $photoTitle =
                    $documentation->title
                    ?? 'Dokumentasi laporan';

                $takenAt = $documentation->taken_at
                    ? $documentation->taken_at
                        ->copy()
                        ->timezone('Asia/Jakarta')
                        ->locale('id')
                        ->translatedFormat('d F Y, H.i')
                        . ' WIB'
                    : null;
            @endphp

            <article
                class="overflow-hidden rounded-xl border border-slate-200 bg-white"
            >
                @if ($documentation->photo_exists)
                    <button
                        type="button"
                        x-on:click="openPhoto(
                            @js($documentation->photo_url),
                            @js($photoTitle)
                        )"
                        class="group relative block h-52 w-full overflow-hidden bg-slate-100 text-left focus:outline-none focus:ring-4 focus:ring-inset focus:ring-blue-100"
                        aria-label="Buka foto {{ $photoTitle }}"
                    >
                        <img
                            src="{{ $documentation->photo_url }}"
                            alt="{{ $photoTitle }}"
                            class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                        >

                        <span
                            class="absolute inset-0 flex items-center justify-center bg-slate-950/0 transition group-hover:bg-slate-950/30"
                        >
                            <span
                                class="flex h-11 w-11 scale-90 items-center justify-center rounded-full bg-white/90 text-slate-700 opacity-0 shadow-lg transition group-hover:scale-100 group-hover:opacity-100"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.8"
                                    stroke="currentColor"
                                    class="h-5 w-5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                    />
                                </svg>
                            </span>
                        </span>
                    </button>
                @else
                    <div
                        class="flex h-52 flex-col items-center justify-center bg-slate-100 text-slate-400"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-10 w-10"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909"
                            />
                        </svg>

                        <p class="mt-2 text-xs font-medium">
                            File foto tidak tersedia
                        </p>
                    </div>
                @endif

                <div class="p-4">
                    <h3 class="text-sm font-semibold text-slate-900">
                        {{ $photoTitle }}
                    </h3>

                    <p
                        class="mt-1 truncate text-xs text-slate-500"
                        title="{{ $documentation->original_name }}"
                    >
                        {{
                            $documentation->original_name
                            ?? 'Nama file tidak tersedia'
                        }}
                    </p>

                    @if ($takenAt)
                        <p class="mt-2 text-xs font-medium text-slate-500">
                            {{ $takenAt }}
                        </p>
                    @endif
                </div>
            </article>
        @empty
            <div
                class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center sm:col-span-2 lg:col-span-3"
            >
                <p class="text-sm font-semibold text-slate-700">
                    Tidak ada dokumentasi
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Laporan ini tidak memiliki foto pendukung.
                </p>
            </div>
        @endforelse
    </div>

    {{-- Modal pratinjau foto --}}
    <template x-teleport="body">
        <div
            x-cloak
            x-show="photoOpen"
            x-transition.opacity
            x-on:click.self="closePhoto()"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/80 p-4 backdrop-blur-sm sm:p-6"
            role="dialog"
            aria-modal="true"
            aria-label="Pratinjau foto dokumentasi"
        >
            <div
    class="relative flex max-h-[90vh] w-full max-w-5xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl"
>
                <div
                    class="flex items-center justify-between gap-4 border-b border-slate-200 px-4 py-3 sm:px-5"
                >
                    <h3
                        x-text="activeTitle"
                        class="truncate text-sm font-semibold text-slate-900 sm:text-base"
                    ></h3>

                    <button
                        type="button"
                        x-on:click="closePhoto()"
                        class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-red-600 focus:outline-none focus:ring-4 focus:ring-slate-100"
                        aria-label="Tutup pratinjau foto"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18 18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <div
                    class="flex min-h-0 flex-1 items-center justify-center overflow-auto bg-slate-950 p-3 sm:p-5"
                >
                    <img
                        x-bind:src="activePhoto"
                        x-bind:alt="activeTitle"
                        class="max-h-[75vh] max-w-full object-contain"
                    >
                </div>
            </div>
        </div>
    </template>
</section>