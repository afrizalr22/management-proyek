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
            Maksimal 5 foto
        </span>
    </div>

    <label
        for="documentationPhotos"
        class="group flex min-h-48 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-6 text-center transition hover:border-blue-400 hover:bg-blue-50/60"
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
            Seret dan Lepaskan Foto
        </h3>

        <p class="mt-1 text-sm text-slate-500">
            atau klik untuk memilih foto dari perangkat
        </p>

        <span
            class="mt-3 inline-flex items-center justify-center rounded-xl border border-blue-200 bg-white px-4 py-2 text-sm font-semibold text-blue-600 shadow-sm transition group-hover:border-blue-300"
        >
            Pilih Foto
        </span>

        <p class="mt-3 text-xs text-slate-400">
            JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB per foto.
        </p>
    </label>

    <input
        id="documentationPhotos"
        name="documentationPhotos[]"
        type="file"
        accept=".jpg,.jpeg,.png,.webp"
        multiple
        class="sr-only"
    >

    <div
        class="mt-3 flex items-start gap-2 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs leading-5 text-amber-700"
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
            Pastikan foto tidak buram, memiliki pencahayaan cukup, dan sesuai dengan tugas yang dipilih.
        </p>
    </div>
</section>