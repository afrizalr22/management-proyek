@props([
    'report',
])

<x-ui.info-card class="overflow-hidden border-blue-200">

    <div class="border-b border-blue-100 bg-blue-50/50 px-6 py-5">
        <div class="flex items-start gap-3">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white">
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12l2 2 4-4"
                    />

                    <circle cx="12" cy="12" r="9" />
                </svg>
            </span>

            <div>
                <h2 class="text-lg font-bold text-gray-900">
                    Keputusan Validasi
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Berikan catatan pemeriksaan sebelum menentukan
                    hasil laporan.
                </p>
            </div>
        </div>
    </div>

    <div class="p-6">
        @error('decision')
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $message }}
            </div>
        @enderror

        <label
            for="reviewNotes"
            class="mb-2 block text-sm font-semibold text-gray-700"
        >
            Catatan Mandor
        </label>

        <textarea
            id="reviewNotes"
            wire:model.blur="reviewNotes"
            rows="5"
            maxlength="2000"
            placeholder="Tuliskan hasil pemeriksaan atau alasan revisi..."
            @class([
                'block w-full resize-y rounded-xl border bg-white px-4 py-3 text-sm leading-6 text-gray-900 outline-none transition placeholder:text-gray-400 focus:ring-4',

                'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                    $errors->has('reviewNotes'),

                'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                    ! $errors->has('reviewNotes'),
            ])
        ></textarea>

        <div class="mt-2 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                @error('reviewNotes')
                    <p class="text-sm text-red-600">
                        {{ $message }}
                    </p>
                @else
                    <p class="text-xs text-gray-500">
                        Wajib diisi jika laporan perlu dikembalikan untuk revisi.
                    </p>
                @enderror
            </div>

            <p
                class="shrink-0 text-xs text-gray-400"
                x-data
                x-text="($wire.reviewNotes?.length ?? 0) + '/2000 karakter'"
            ></p>
        </div>
    </div>

    <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
        <a
            href="{{ route('mandor.daily-reports.show', $report) }}"
            wire:navigate
            class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
        >
            Kembali ke Detail
        </a>

        <div class="flex flex-col gap-3 sm:flex-row">
            <button
                type="button"
                wire:click="requestRevision"
                wire:confirm="Kembalikan laporan ini kepada Pekerja untuk diperbaiki?"
                wire:loading.attr="disabled"
                wire:target="requestRevision,approveReport"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-5 text-sm font-semibold text-red-600 transition hover:bg-red-50 disabled:cursor-wait disabled:opacity-60"
            >
                <span
                    wire:loading.remove
                    wire:target="requestRevision"
                >
                    Minta Revisi
                </span>

                <span
                    wire:loading
                    wire:target="requestRevision"
                >
                    Memproses...
                </span>
            </button>

            <button
                type="button"
                wire:click="approveReport"
                wire:confirm="Setujui laporan ini dan perbarui progress Task?"
                wire:loading.attr="disabled"
                wire:target="requestRevision,approveReport"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 disabled:cursor-wait disabled:opacity-60"
            >
                <svg
                    wire:loading.remove
                    wire:target="approveReport"
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                    />
                </svg>

                <span
                    wire:loading.remove
                    wire:target="approveReport"
                >
                    Setujui Laporan
                </span>

                <span
                    wire:loading
                    wire:target="approveReport"
                >
                    Menyetujui...
                </span>
            </button>
        </div>
    </div>

</x-ui.info-card>