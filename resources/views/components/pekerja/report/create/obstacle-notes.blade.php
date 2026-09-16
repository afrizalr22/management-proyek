@props([
    'obstacles' => '',
    'notes' => '',
])

<section
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
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
                        d="M12 9v3.75m9-1.5a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM12 16.5h.008v.008H12V16.5Z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Kendala dan Catatan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Tambahkan informasi lain yang perlu diketahui Mandor.
                </p>
            </div>
        </div>
    </div>

    <div
        class="grid grid-cols-1 gap-5 px-5 py-5 sm:px-6 lg:grid-cols-2"
    >
        <div class="min-w-0">
            <label
                for="workObstacle"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Kendala Pekerjaan
            </label>

            <textarea
                id="workObstacle"
                wire:model.live.debounce.300ms="obstacles"
                rows="4"
                maxlength="1000"
                placeholder="Tuliskan kendala yang ditemukan selama pekerjaan..."
                @class([
                    'block w-full resize-none rounded-xl bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100',
                    'border-red-300' => $errors->has('obstacles'),
                    'border-slate-300' => ! $errors->has('obstacles'),
                ])
            ></textarea>

            <div class="mt-2 flex items-start justify-between gap-4">
                <div>
                    @error('obstacles')
                        <p class="text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @else
                        <p class="text-xs text-slate-500">
                            Kosongkan jika tidak terdapat kendala.
                        </p>
                    @enderror
                </div>

                <p class="shrink-0 text-xs text-slate-400">
                    {{ mb_strlen($obstacles) }}/1.000
                </p>
            </div>
        </div>

        <div class="min-w-0">
            <label
                for="additionalNotes"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Catatan Tambahan
            </label>

            <textarea
                id="additionalNotes"
                wire:model.live.debounce.300ms="notes"
                rows="4"
                maxlength="1000"
                placeholder="Tambahkan informasi penting lainnya..."
                @class([
                    'block w-full resize-none rounded-xl bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100',
                    'border-red-300' => $errors->has('notes'),
                    'border-slate-300' => ! $errors->has('notes'),
                ])
            ></textarea>

            <div class="mt-2 flex items-start justify-between gap-4">
                <div>
                    @error('notes')
                        <p class="text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @else
                        <p class="text-xs text-slate-500">
                            Bagian ini bersifat opsional.
                        </p>
                    @enderror
                </div>

                <p class="shrink-0 text-xs text-slate-400">
                    {{ mb_strlen($notes) }}/1.000
                </p>
            </div>
        </div>
    </div>
</section>