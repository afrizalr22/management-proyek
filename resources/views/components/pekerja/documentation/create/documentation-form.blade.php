<section
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    {{-- Header form --}}
    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
        <div class="flex items-start gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
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
                        d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175A2.25 2.25 0 0 0 2.25 9.624V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.624a2.25 2.25 0 0 0-1.802-2.219"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M14.25 10.5a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Form Dokumentasi Lapangan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Lengkapi foto dan informasi pekerjaan yang didokumentasikan.
                </p>
            </div>
        </div>
    </div>

    {{-- Isi form --}}
    <div class="space-y-8 px-5 py-6 sm:px-6">
        {{-- Area unggah --}}
        <x-pekerja.documentation.create.photo-upload />

        <div class="border-t border-slate-200"></div>

        {{-- Informasi dokumentasi --}}
        <x-pekerja.documentation.create.documentation-information />

        {{-- Tombol aksi --}}
        <x-pekerja.documentation.create.form-actions />
    </div>
</section>