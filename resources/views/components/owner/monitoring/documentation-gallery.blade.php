@props([
    'documentations',
])

@php
    $categoryConfiguration = [
        'progress' => [
            'label' => 'Progress',
            'color' => 'blue',
        ],

        'material' => [
            'label' => 'Material',
            'color' => 'yellow',
        ],

        'safety' => [
            'label' => 'Keselamatan',
            'color' => 'green',
        ],

        'obstacle' => [
            'label' => 'Kendala',
            'color' => 'red',
        ],

        'other' => [
            'label' => 'Lainnya',
            'color' => 'gray',
        ],
    ];
@endphp

<div
    x-data="{
        previewOpen: false,
        previewImage: '',
        previewTitle: '',
        previewDescription: '',
        previewMetadata: '',

        openPreview(data) {
            this.previewImage = data.image;
            this.previewTitle = data.title;
            this.previewDescription = data.description;
            this.previewMetadata = data.metadata;
            this.previewOpen = true;

            document.body.classList.add('overflow-hidden');
        },

        closePreview() {
            this.previewOpen = false;
            this.previewImage = '';
            this.previewTitle = '';
            this.previewDescription = '';
            this.previewMetadata = '';

            document.body.classList.remove('overflow-hidden');
        }
    }"
    x-on:keydown.escape.window="
        if (previewOpen) {
            closePreview();
        }
    "
>
    <x-ui.info-card>
        <div class="p-5 sm:p-6 lg:p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold tracking-tight text-gray-800">
                    Galeri Dokumentasi
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Dokumentasi foto perkembangan pekerjaan selama pelaksanaan Project.
                </p>
            </div>

            @if ($documentations->isNotEmpty())
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($documentations as $documentation)
                        @php
                            $category =
                                $documentation->category
                                ?? 'other';

                            $configuration =
                                $categoryConfiguration[$category]
                                ?? $categoryConfiguration['other'];

                            $title =
                                $documentation->title
                                ?: 'Dokumentasi Project';

                            $description =
                                $documentation->description
                                ?: 'Tidak ada deskripsi tambahan.';

                            $imageUrl =
                                \Illuminate\Support\Facades\Storage::url(
                                    $documentation->photo
                                );

                            $documentationDate =
                                $documentation->documentation_date
                                    ?->translatedFormat('d F Y')
                                ?? '-';

                            $uploader =
                                $documentation->user?->name
                                ?? 'Pengguna tidak tersedia';

                            $taskName =
                                $documentation->task?->title
                                ?? 'Tidak terhubung dengan Task';

                            $metadata = sprintf(
                                '%s • %s',
                                $documentationDate,
                                $uploader
                            );
                        @endphp

                        <article
                            wire:key="documentation-gallery-{{ $documentation->id }}"
                            class="group flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-lg"
                        >
                            <div class="relative aspect-video overflow-hidden bg-gray-100">
                                <img
                                    src="{{ $imageUrl }}"
                                    alt="{{ $title }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >

                                <div class="absolute left-3 top-3">
                                    <x-ui.badge
                                        :color="$configuration['color']"
                                    >
                                        {{ $configuration['label'] }}
                                    </x-ui.badge>
                                </div>

                                <div class="absolute inset-0 flex items-center justify-center bg-black/0 opacity-0 transition duration-300 group-hover:bg-black/40 group-hover:opacity-100">
                                    <button
                                        type="button"
                                        data-image="{{ $imageUrl }}"
                                        data-title="{{ $title }}"
                                        data-description="{{ $description }}"
                                        data-metadata="{{ $metadata }}"
                                        x-on:click="openPreview($el.dataset)"
                                        class="inline-flex min-h-10 items-center justify-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-gray-800 shadow-lg transition hover:bg-gray-100"
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

                            <div class="flex flex-1 flex-col p-5">
                                <div class="flex-1">
                                    <h3 class="font-semibold leading-6 text-gray-900">
                                        {{ $title }}
                                    </h3>

                                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-500">
                                        {{ $description }}
                                    </p>

                                    <div class="mt-4 rounded-xl bg-gray-50 px-4 py-3">
                                        <p class="text-xs font-medium text-gray-400">
                                            Task
                                        </p>

                                        <p class="mt-1 truncate text-sm font-medium text-gray-700">
                                            {{ $taskName }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-5 flex items-end justify-between gap-4 border-t border-gray-100 pt-4">
                                    <div class="min-w-0">
                                        <p class="text-xs font-medium text-gray-500">
                                            {{ $documentationDate }}
                                        </p>

                                        <p class="mt-1 truncate text-xs text-gray-400">
                                            Oleh {{ $uploader }}
                                        </p>
                                    </div>

                                    <button
                                        type="button"
                                        x-on:click='openPreview(
                                            @js($imageUrl),
                                            @js($title),
                                            @js($description),
                                            @js($metadata)
                                        )'
                                        class="shrink-0 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
                                    >
                                        Lihat Foto
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-14 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-200 text-gray-500">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-7 w-7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5A1.5 1.5 0 0 0 21.75 18V6A1.5 1.5 0 0 0 20.25 4.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm12-11.25h.008v.008h-.008V8.25Z"
                            />
                        </svg>
                    </div>

                    <p class="mt-5 font-semibold text-gray-700">
                        Dokumentasi tidak ditemukan
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        Belum ada dokumentasi atau data tidak sesuai dengan filter.
                    </p>

                    <button
                        type="button"
                        wire:click="resetFilters"
                        class="mt-5 inline-flex min-h-10 items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
                    >
                        Reset Filter
                    </button>
                </div>
            @endif
        </div>
    </x-ui.info-card>

    {{-- Preview Modal --}}
    <div
        x-show="previewOpen"
        x-transition.opacity
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
        role="dialog"
        aria-modal="true"
        aria-label="Preview dokumentasi"
    >
        <div
            class="absolute inset-0 bg-black/80"
            x-on:click="closePreview()"
        ></div>

        <div
            x-show="previewOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0"
            x-on:click.stop
            class="relative z-10 flex max-h-[92vh] w-full max-w-5xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <div class="flex items-start justify-between gap-4 border-b border-gray-200 px-5 py-4 sm:px-6">
                <div class="min-w-0">
                    <h3
                        class="truncate text-lg font-bold text-gray-900"
                        x-text="previewTitle"
                    ></h3>

                    <p
                        class="mt-1 text-sm text-gray-500"
                        x-text="previewMetadata"
                    ></p>
                </div>

                <button
                    type="button"
                    x-on:click="closePreview()"
                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-700"
                    aria-label="Tutup preview"
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
            </div>

            <div class="min-h-0 flex-1 overflow-auto bg-black">
                <img
                    x-bind:src="previewImage"
                    x-bind:alt="previewTitle"
                    class="mx-auto max-h-[68vh] w-full object-contain"
                >
            </div>

            <div
                x-show="previewDescription"
                class="border-t border-gray-200 px-5 py-4 sm:px-6"
            >
                <p
                    class="whitespace-pre-line text-sm leading-6 text-gray-600"
                    x-text="previewDescription"
                ></p>
            </div>
        </div>
    </div>
</div>