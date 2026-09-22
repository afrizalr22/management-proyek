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
            <div x-data="{ showRevisionConfirmation: false }">
    <button
        type="button"
        x-on:click="showRevisionConfirmation = true"
        wire:loading.attr="disabled"
        wire:target="requestRevision,approveReport"
        class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-5 text-sm font-semibold text-red-600 transition hover:bg-red-50 disabled:cursor-wait disabled:opacity-60 sm:w-auto"
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

    {{-- Modal Konfirmasi Revisi --}}
    <div
        x-cloak
        x-show="showRevisionConfirmation"
        x-transition.opacity
        x-on:keydown.escape.window="showRevisionConfirmation = false"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
    >
        {{-- Backdrop --}}
        <div
            x-on:click="showRevisionConfirmation = false"
            class="absolute inset-0 bg-slate-950/50 backdrop-blur-sm"
        ></div>

        {{-- Modal --}}
        <div
            x-show="showRevisionConfirmation"
            x-transition
            x-on:click.stop
            class="relative w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-600">
                        <svg
                            class="h-6 w-6"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v4m0 4h.01"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"
                            />
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-slate-900">
                            Minta revisi laporan?
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Laporan akan dikembalikan kepada Pekerja untuk diperbaiki.
                            Pastikan catatan revisi sudah menjelaskan bagian yang perlu diperbaiki.
                        </p>

                        <div class="mt-4 rounded-xl border border-red-100 bg-red-50 px-4 py-3">
                            <p class="text-sm text-red-800">
                                Setelah dikirim untuk revisi, Pekerja perlu memperbaiki dan mengirim ulang laporan sebelum dapat disetujui.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
                <button
                    type="button"
                    x-on:click="showRevisionConfirmation = false"
                    wire:loading.attr="disabled"
                    wire:target="requestRevision"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 disabled:opacity-60"
                >
                    Batal
                </button>

                <button
                    type="button"
                    x-on:click="
                        showRevisionConfirmation = false;
                        $wire.requestRevision();
                    "
                    wire:loading.attr="disabled"
                    wire:target="requestRevision"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-red-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 disabled:cursor-wait disabled:opacity-60"
                >
                    <span
                        wire:loading.remove
                        wire:target="requestRevision"
                    >
                        Ya, Minta Revisi
                    </span>

                    <span
                        wire:loading
                        wire:target="requestRevision"
                    >
                        Memproses...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

            <div x-data="{ showApproveConfirmation: false }">
    <button
        type="button"
        x-on:click="showApproveConfirmation = true"
        wire:loading.attr="disabled"
        wire:target="requestRevision,approveReport"
        class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 disabled:cursor-wait disabled:opacity-60 sm:w-auto"
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

    {{-- Modal Konfirmasi Persetujuan --}}
    <div
        x-cloak
        x-show="showApproveConfirmation"
        x-transition.opacity
        x-on:keydown.escape.window="showApproveConfirmation = false"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
    >
        {{-- Backdrop --}}
        <div
            x-on:click="showApproveConfirmation = false"
            class="absolute inset-0 bg-slate-950/50 backdrop-blur-sm"
        ></div>

        {{-- Modal --}}
        <div
            x-show="showApproveConfirmation"
            x-transition
            x-on:click.stop
            class="relative w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                        <svg
                            class="h-6 w-6"
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

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-slate-900">
                            Setujui laporan pekerjaan?
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Laporan akan disetujui dan progress Task serta Project
                            akan diperbarui berdasarkan progress yang dilaporkan Pekerja.
                        </p>

                        <div class="mt-4 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3">
                            <p class="text-sm text-emerald-800">
                                Pastikan hasil pekerjaan dan dokumentasi sudah sesuai sebelum laporan disetujui.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
                <button
                    type="button"
                    x-on:click="showApproveConfirmation = false"
                    wire:loading.attr="disabled"
                    wire:target="approveReport"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 disabled:opacity-60"
                >
                    Batal
                </button>

                <button
                    type="button"
                    x-on:click="
                        showApproveConfirmation = false;
                        $wire.approveReport();
                    "
                    wire:loading.attr="disabled"
                    wire:target="approveReport"
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
                        Ya, Setujui Laporan
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
    </div>
</div>
        </div>
    </div>

</x-ui.info-card>