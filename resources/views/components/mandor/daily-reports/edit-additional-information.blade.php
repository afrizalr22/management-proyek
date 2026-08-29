<section
    class="w-full min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
        <div class="flex items-start gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600"
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
                        d="M11.25 9.75h1.5v5.25h-1.5V9.75Zm0 7.5h1.5v1.5h-1.5v-1.5ZM10.29 3.86 1.82 18a2.25 2.25 0 0 0 1.93 3.41h16.5A2.25 2.25 0 0 0 22.18 18L13.71 3.86a2 2 0 0 0-3.42 0Z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Kendala dan Catatan Tambahan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Perbarui kendala pekerjaan dan informasi tambahan pada laporan.
                </p>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="grid gap-6 px-5 py-6 sm:px-6 lg:grid-cols-2">
        {{-- Kendala pekerjaan --}}
        <div class="min-w-0">
            <label
                for="obstacles"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Kendala Pekerjaan
            </label>

            <textarea
                id="obstacles"
                wire:model.blur="obstacles"
                rows="6"
                maxlength="1000"
                placeholder="Contoh: Pengiriman material mengalami keterlambatan karena kondisi lalu lintas."
                class="block w-full resize-y rounded-xl border bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:ring-4
                    @error('obstacles')
                        border-red-400 focus:border-red-500 focus:ring-red-100
                    @else
                        border-slate-300 focus:border-blue-500 focus:ring-blue-100
                    @enderror"
            ></textarea>

            <div class="mt-2 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    @error('obstacles')
                        <p class="text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @else
                        <p class="text-xs text-slate-500">
                            Kosongkan apabila tidak terdapat kendala pekerjaan.
                        </p>
                    @enderror
                </div>

                <p
                    class="shrink-0 text-xs text-slate-400"
                    x-data
                    x-text="($wire.obstacles?.length ?? 0) + '/1000 karakter'"
                ></p>
            </div>
        </div>

        {{-- Catatan tambahan --}}
        <div class="min-w-0">
            <label
                for="notes"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Catatan Tambahan
            </label>

            <textarea
                id="notes"
                wire:model.blur="notes"
                rows="6"
                maxlength="1000"
                placeholder="Contoh: Persiapan pekerjaan berikutnya akan dilakukan di zona B."
                class="block w-full resize-y rounded-xl border bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:ring-4
                    @error('notes')
                        border-red-400 focus:border-red-500 focus:ring-red-100
                    @else
                        border-slate-300 focus:border-blue-500 focus:ring-blue-100
                    @enderror"
            ></textarea>

            <div class="mt-2 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    @error('notes')
                        <p class="text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @else
                        <p class="text-xs text-slate-500">
                            Tambahkan informasi penting yang belum tercantum.
                        </p>
                    @enderror
                </div>

                <p
                    class="shrink-0 text-xs text-slate-400"
                    x-data
                    x-text="($wire.notes?.length ?? 0) + '/1000 karakter'"
                ></p>
            </div>
        </div>
    </div>
</section>