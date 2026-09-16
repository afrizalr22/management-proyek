@props([
    'photos' => [],
])

@php
    $selectedPhotos = is_array($photos)
        ? $photos
        : [];
@endphp

<section
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    <div
        class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-start sm:justify-between sm:px-6"
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
                    Tambahkan foto sebagai bukti hasil pekerjaan.
                </p>
            </div>
        </div>

        <span class="shrink-0 text-xs font-medium text-slate-400">
            {{ count($selectedPhotos) }}/5 foto
        </span>
    </div>

    <div class="px-5 py-5 sm:px-6">
        <div
            @class([
                'relative min-h-48 overflow-hidden rounded-2xl border-2 border-dashed transition',
                'border-red-300 bg-red-50/40' =>
                    $errors->has('photos')
                    || $errors->has('photos.*'),
                'group border-slate-300 bg-slate-50 hover:border-blue-400' =>
                    ! $errors->has('photos')
                    && ! $errors->has('photos.*'),
            ])
        >
            <input
                id="reportDocumentations"
                wire:model="photos"
                type="file"
                accept="image/jpeg,image/png,image/webp"
                multiple
                class="absolute inset-0 z-20 h-full w-full cursor-pointer opacity-0"
                aria-label="Pilih foto dokumentasi"
            >

            <div
                wire:loading.remove
                wire:target="photos"
                class="pointer-events-none flex min-h-48 flex-col items-center justify-center px-6 py-6 text-center"
            >
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 transition duration-200 group-hover:bg-blue-600 group-hover:text-white"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-6 w-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 16.5V9.75m0 0 2.625 2.625M12 9.75l-2.625 2.625M6.75 18.75A4.5 4.5 0 0 1 6.11 9.796 6 6 0 0 1 17.9 8.25h.1a3.75 3.75 0 0 1 .75 7.425"
                        />
                    </svg>
                </div>

                <h3 class="mt-3 text-base font-semibold text-slate-900">
                    Pilih Foto Dokumentasi
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Klik untuk memilih maksimal lima foto dari perangkat.
                </p>

                <span
                    class="mt-3 inline-flex items-center justify-center rounded-xl border border-blue-200 bg-white px-4 py-2 text-sm font-semibold text-blue-600 shadow-sm"
                >
                    Pilih Foto
                </span>

                <p class="mt-3 text-xs text-slate-400">
                    JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB per foto.
                </p>
            </div>

            <div
                wire:loading.flex
                wire:target="photos"
                class="pointer-events-none min-h-48 flex-col items-center justify-center px-6 py-6 text-center"
            >
                <svg
                    class="h-8 w-8 animate-spin text-blue-600"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    ></circle>

                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z"
                    ></path>
                </svg>

                <p class="mt-3 text-sm font-semibold text-blue-600">
                    Memproses foto...
                </p>
            </div>
        </div>

        @error('photos')
            <p class="mt-2 text-sm font-medium text-red-600">
                {{ $message }}
            </p>
        @enderror

        @error('photos.*')
            <p class="mt-2 text-sm font-medium text-red-600">
                {{ $message }}
            </p>
        @enderror

        @if (count($selectedPhotos) > 0)
            <div class="mt-5">
                <h3 class="text-sm font-semibold text-slate-700">
                    Foto yang akan dilampirkan
                </h3>

                <div
                    class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5"
                >
                    @foreach ($selectedPhotos as $index => $photo)
                        <article
                            wire:key="report-photo-{{ $index }}"
                            class="relative overflow-hidden rounded-xl border border-slate-200 bg-white"
                        >
                            <div
                                class="flex aspect-square items-center justify-center bg-slate-100 text-slate-400"
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
                            </div>

                            <button
                                type="button"
                                wire:click="removePhoto({{ $index }})"
                                wire:loading.attr="disabled"
                                wire:target="removePhoto({{ $index }})"
                                class="absolute right-2 top-2 inline-flex h-8 w-8 items-center justify-center rounded-full bg-slate-900/75 text-white shadow-sm backdrop-blur-sm transition hover:bg-red-600 disabled:cursor-not-allowed disabled:opacity-60"
                                aria-label="Hapus foto {{ $index + 1 }}"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="h-4 w-4"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18 18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>

                            <div
                                class="border-t border-slate-200 bg-white px-3 py-2"
                            >
                                <p
                                    class="truncate text-xs font-medium text-slate-600"
                                    title="{{ $photo->getClientOriginalName() }}"
                                >
                                    {{ $photo->getClientOriginalName() }}
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    {{
                                        number_format(
                                            $photo->getSize() / 1024,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }} KB
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        <div
            class="mt-4 flex items-start gap-2 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-xs leading-5 text-blue-700"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="mt-0.5 h-4 w-4 shrink-0"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M11.25 11.25 12 10.5m0 0 .75.75M12 10.5v6.75m9-5.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />
            </svg>

            <p>
                Dokumentasi bersifat opsional dan akan langsung terhubung
                dengan laporan ini.
            </p>
        </div>
    </div>
</section>