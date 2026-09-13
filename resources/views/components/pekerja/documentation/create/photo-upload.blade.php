@props([
    'photos' => [],
])
<section>
    <div class="mb-3 flex items-center justify-between gap-3">
        <div>
            <h2 class="text-base font-semibold text-slate-900">
                Foto Dokumentasi
                <span class="text-red-500">*</span>
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Pilih foto pekerjaan dengan kondisi yang terlihat jelas.
            </p>
        </div>

        <span class="shrink-0 text-xs font-medium text-slate-400">
            {{ count($photos ?? []) }}/5 foto
        </span>
    </div>

    <label
        for="documentationPhotos"
        @class([
            'group flex min-h-48 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed px-6 py-6 text-center transition',
            'border-red-300 bg-red-50/40' => $errors->has('photos') || $errors->has('photos.*'),
            'border-slate-300 bg-slate-50 hover:border-blue-400 hover:bg-blue-50/60' => ! $errors->has('photos') && ! $errors->has('photos.*'),
        ])
    >
        <div
            wire:loading.remove
            wire:target="photos"
            class="flex flex-col items-center"
        >
            <div
                class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 transition group-hover:bg-blue-600 group-hover:text-white"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.7"
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
            class="flex flex-col items-center"
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
    </label>

    <input
        id="documentationPhotos"
        wire:model="photos"
        type="file"
        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
        multiple
        class="sr-only"
    >

    @error('photos')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror

    @error('photos.*')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror

    @if (count($photos ?? []) > 0)
        <div class="mt-5">
            <h3 class="text-sm font-semibold text-slate-700">
                Foto yang akan disimpan
            </h3>

            <div class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-3">
                @foreach ($photos as $index => $photo)
                    <article
                        wire:key="documentation-photo-{{ $index }}"
                        class="relative overflow-hidden rounded-xl border border-slate-200 bg-slate-100"
                    >
                        <div class="aspect-square">
                            <img
                                src="{{ $photo->temporaryUrl() }}"
                                alt="Pratinjau foto {{ $index + 1 }}"
                                class="h-full w-full object-cover"
                            >
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

                        <div class="border-t border-slate-200 bg-white px-3 py-2">
                            <p class="truncate text-xs font-medium text-slate-600">
                                {{ $photo->getClientOriginalName() }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif

    <div
        class="mt-4 flex items-start gap-2 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs leading-5 text-amber-700"
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
                d="M12 9v3.75m9-1.5a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM12 16.5h.008v.008H12V16.5Z"
            />
        </svg>

        <p>
            Pastikan foto tidak buram, memiliki pencahayaan cukup, dan sesuai dengan Task yang dipilih.
        </p>
    </div>
</section>