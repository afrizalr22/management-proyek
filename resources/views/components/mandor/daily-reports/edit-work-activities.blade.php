<section
    class="w-full min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
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
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Aktivitas Pekerjaan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Perbarui uraian pekerjaan yang dilakukan pada tanggal laporan.
                </p>
            </div>
        </div>
    </div>

    {{-- Input --}}
    <div class="px-5 py-6 sm:px-6">
        <div class="min-w-0">
            <label
                for="activities"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Pekerjaan yang Dilaksanakan
                <span class="text-red-500">*</span>
            </label>

            <textarea
                id="activities"
                wire:model.blur="activities"
                rows="7"
                maxlength="2000"
                placeholder="Contoh: Pengecoran kolom lantai dua zona A telah diselesaikan dan dilanjutkan dengan persiapan bekisting zona B."
                class="block w-full resize-y rounded-xl border bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:ring-4
                    @error('activities')
                        border-red-400 focus:border-red-500 focus:ring-red-100
                    @else
                        border-slate-300 focus:border-blue-500 focus:ring-blue-100
                    @enderror"
            ></textarea>

            <div class="mt-2 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    @error('activities')
                        <p class="text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @else
                        <p class="text-xs text-slate-500">
                            Jelaskan pekerjaan secara ringkas, jelas, dan sesuai kondisi lapangan.
                        </p>
                    @enderror
                </div>

                <p
                    class="shrink-0 text-xs text-slate-400"
                    x-data
                    x-text="($wire.activities?.length ?? 0) + '/2000 karakter'"
                ></p>
            </div>
        </div>
    </div>
</section>