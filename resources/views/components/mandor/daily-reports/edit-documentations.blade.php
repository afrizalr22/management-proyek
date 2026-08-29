@props([
    'existingDocumentations' => [],
    'newPhotos' => [],
])

@php
    $storedDocumentations = is_array($existingDocumentations)
        ? $existingDocumentations
        : [];

    $uploadedPhotos = is_array($newPhotos)
        ? $newPhotos
        : [];

    $totalDocumentations = count($storedDocumentations)
        + count($uploadedPhotos);
@endphp
<section
    class="w-full min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
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
                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 19.5h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"
                        />
                    </svg>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-slate-900">
                        Dokumentasi Lapangan
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Pertahankan foto lama atau tambahkan dokumentasi baru.
                    </p>
                </div>
            </div>

            <span class="text-sm text-slate-500">
                {{ count($existingDocumentations)}}/5 foto
            </span>
        </div>
    </div>

    <div class="space-y-6 px-5 py-6 sm:px-6">
        {{-- Dokumentasi lama --}}
        @if (count($storedDocumentations) > 0)
            <div>
                <h3 class="mb-3 text-sm font-semibold text-slate-700">
                    Dokumentasi Tersimpan
                </h3>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($storedDocumentations as $documentation)
                        <article
                            wire:key="existing-documentation-{{ $documentation['id'] }}"
                            class="overflow-hidden rounded-xl border border-slate-200 bg-white"
                        >
                            <div class="relative flex aspect-video items-center justify-center bg-slate-100">
                                @if (!empty($documentation['photo']))
                                    <img
                                        src="{{ asset('storage/' . $documentation['photo']) }}"
                                        alt="{{ $documentation['description'] }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="h-10 w-10 text-slate-400"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909"
                                        />
                                    </svg>
                                @endif

                                <button
                                    type="button"
                                    wire:click="removeExistingDocumentation({{ $documentation['id'] }})"
                                    wire:confirm="Hapus dokumentasi ini dari laporan?"
                                    class="absolute right-2 top-2 inline-flex h-9 w-9 items-center justify-center rounded-lg bg-white text-red-600 shadow transition hover:bg-red-50"
                                    aria-label="Hapus dokumentasi"
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
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M18.16 5.79 17.67 19.673A2.25 2.25 0 0 1 15.421 21.75H8.58a2.25 2.25 0 0 1-2.25-2.077L5.84 5.79"
                                        />
                                    </svg>
                                </button>
                            </div>

                            <div class="p-4">
                                <p class="text-sm font-medium leading-5 text-slate-800">
                                    {{ $documentation['description'] }}
                                </p>

                                <p class="mt-2 text-xs text-slate-500">
                                    {{ $documentation['time'] }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Preview foto baru --}}
        @if (count($uploadedPhotos) > 0)
            <div>
                <h3 class="mb-3 text-sm font-semibold text-slate-700">
                    Foto Baru
                </h3>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($uploadedPhotos as $index => $photo)
                        <article
                            wire:key="new-photo-{{ $index }}"
                            class="overflow-hidden rounded-xl border border-blue-200 bg-white"
                        >
                            <div class="relative aspect-video bg-slate-100">
                                <img
                                    src="{{ $photo->temporaryUrl() }}"
                                    alt="Preview dokumentasi baru"
                                    class="h-full w-full object-cover"
                                >

                                <button
                                    type="button"
                                    wire:click="removeNewPhoto({{ $index }})"
                                    class="absolute right-2 top-2 inline-flex h-9 w-9 items-center justify-center rounded-lg bg-white text-red-600 shadow transition hover:bg-red-50"
                                    aria-label="Hapus foto baru"
                                >
                                    &times;
                                </button>
                            </div>

                            <div class="p-3">
                                <p class="truncate text-xs text-slate-500">
                                    {{ $photo->getClientOriginalName() }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Upload --}}
        @if ($totalDocumentations < 5)
            <div>
                <label
                    for="newPhotos"
                    class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-center transition hover:border-blue-400 hover:bg-blue-50"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.6"
                        stroke="currentColor"
                        class="h-8 w-8 text-blue-600"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175A2.25 2.25 0 0 0 2.25 9.624V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.624a2.25 2.25 0 0 0-1.802-2.219"
                        />
                    </svg>

                    <span class="mt-3 text-sm font-semibold text-slate-800">
                        Tambah Foto Dokumentasi
                    </span>

                    <span class="mt-1 text-xs text-slate-500">
                        JPG, PNG, atau WEBP. Maksimal 5 MB per foto.
                    </span>
                </label>

                <input
                    id="newPhotos"
                    type="file"
                    wire:model="newPhotos"
                    accept=".jpg,.jpeg,.png,.webp"
                    multiple
                    class="sr-only"
                >
            </div>
        @endif

        <div wire:loading wire:target="newPhotos" class="text-sm text-blue-600">
            Memproses foto...
        </div>

        @error('newPhotos')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror

        @error('newPhotos.*')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror

        {{-- Keterangan dokumentasi baru --}}
        <div>
            <label
                for="documentationDescription"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Keterangan Foto Baru
            </label>

            <input
                id="documentationDescription"
                type="text"
                wire:model.blur="documentationDescription"
                maxlength="500"
                placeholder="Contoh: Pengecoran kolom lantai dua zona A."
                class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            >

            @error('documentationDescription')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
</section>