<section
    class="rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
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
                    Unggah foto sebagai bukti hasil pekerjaan.
                </p>
            </div>
        </div>
    </div>

    {{-- Area unggah --}}
    <div class="px-5 py-5 sm:px-6">
        <label
            for="reportDocumentations"
            class="flex min-h-44 cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-5 py-6 text-center transition hover:border-blue-400 hover:bg-blue-50/60"
        >
            <div
                class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600"
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

            <h3 class="mt-3 text-sm font-semibold text-slate-900">
                Pilih Foto Dokumentasi
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Klik atau seret foto ke area ini
            </p>

            <span
                class="mt-3 inline-flex items-center justify-center rounded-lg border border-blue-200 bg-white px-4 py-2 text-sm font-semibold text-blue-600"
            >
                Pilih Foto
            </span>

            <p class="mt-3 text-xs text-slate-400">
                JPG, JPEG, PNG, atau WEBP. Maksimal 5 foto.
            </p>
        </label>

        <input
            id="reportDocumentations"
            name="reportDocumentations[]"
            type="file"
            accept=".jpg,.jpeg,.png,.webp"
            multiple
            class="sr-only"
        >

        <div
            class="mt-3 flex items-start gap-2 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-xs leading-5 text-blue-700"
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
                Dokumentasi bersifat opsional. Pastikan foto sesuai dengan tugas dan hasil pekerjaan yang dilaporkan.
            </p>
        </div>
    </div>
</section>