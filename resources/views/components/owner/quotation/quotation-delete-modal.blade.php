@props([
    'show' => false,
    'quotation',
])

@if ($show)
    <div
        wire:key="quotation-delete-modal-{{ $quotation->id }}"
        wire:keydown.escape.window="closeDeleteModal"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
        aria-labelledby="quotation-delete-modal-title"
    >
        {{-- Backdrop --}}
        <button
            type="button"
            wire:click="closeDeleteModal"
            class="absolute inset-0 h-full w-full cursor-default bg-gray-950/50 backdrop-blur-sm"
            aria-label="Tutup modal"
        ></button>

        {{-- Modal --}}
        <div
            class="relative z-10 w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-700"
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
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M18.16 5.79 17.67 19.673A2.25 2.25 0 0 1 15.421 21.75H8.58a2.25 2.25 0 0 1-2.25-2.077L5.84 5.79m12.32 0a48.108 48.108 0 0 0-3.478-.397m-12.562.562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0V4.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.438"
                            />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <h2
                            id="quotation-delete-modal-title"
                            class="text-lg font-semibold text-gray-900"
                        >
                            Hapus Quotation?
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Quotation dan seluruh item pekerjaan di dalamnya akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>

                <div
                    class="mt-5 rounded-xl border border-red-100 bg-red-50 px-4 py-3"
                >
                    <p class="text-xs font-semibold uppercase tracking-wide text-red-600">
                        Quotation yang akan dihapus
                    </p>

                    <p class="mt-1 font-semibold text-red-900">
                        {{ $quotation->quotation_number }}
                    </p>

                    <p class="mt-1 break-words text-sm text-red-700">
                        {{ $quotation->project_name ?? '-' }}
                    </p>

                    <p class="mt-1 text-sm text-red-700">
                        {{ $quotation->client?->company_name
                            ?? $quotation->client_name
                            ?? '-' }}
                    </p>
                </div>

                @error('deleteQuotation')
                    <div
                        class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
                    >
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div
                class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end"
            >
                <button
                    type="button"
                    wire:click="closeDeleteModal"
                    wire:loading.attr="disabled"
                    wire:target="deleteQuotation"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    Batal
                </button>

                <button
                    type="button"
                    wire:click="deleteQuotation"
                    wire:loading.attr="disabled"
                    wire:target="deleteQuotation"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-100 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span
                        wire:loading.remove
                        wire:target="deleteQuotation"
                    >
                        Ya, Hapus Quotation
                    </span>

                    <span
                        wire:loading.flex
                        wire:target="deleteQuotation"
                        class="items-center gap-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            class="h-4 w-4 animate-spin"
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
                                d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"
                            ></path>
                        </svg>

                        Menghapus...
                    </span>
                </button>
            </div>
        </div>
    </div>
@endif