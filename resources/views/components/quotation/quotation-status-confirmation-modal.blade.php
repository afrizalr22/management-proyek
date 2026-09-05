@props([
    'action' => null,
    'quotation',
])

@php
    $title = match ($action) {
        'send' => 'Tandai Quotation Sudah Dikirim?',
        'approve' => 'Setujui Quotation?',
        'reject' => 'Tolak Quotation?',
        default => 'Konfirmasi Perubahan Status',
    };

    $description = match ($action) {
        'send' =>
            'Pastikan quotation telah diserahkan kepada Client melalui email, WhatsApp, cetak, atau pertemuan langsung.',

        'approve' =>
            'Gunakan tindakan ini apabila Client telah menyetujui quotation. Quotation selanjutnya dapat diproses menjadi Project.',

        'reject' =>
            'Gunakan tindakan ini apabila Client telah menolak quotation. Status quotation akan berubah menjadi Ditolak.',

        default =>
            'Pastikan perubahan status quotation sudah sesuai.',
    };

    $confirmText = match ($action) {
        'send' => 'Ya, Tandai Dikirim',
        'approve' => 'Ya, Setujui',
        'reject' => 'Ya, Tolak',
        default => 'Konfirmasi',
    };

    $buttonColor = match ($action) {
        'approve' =>
            'bg-green-600 hover:bg-green-700 focus:ring-green-100',

        'reject' =>
            'bg-red-600 hover:bg-red-700 focus:ring-red-100',

        default =>
            'bg-blue-600 hover:bg-blue-700 focus:ring-blue-100',
    };

    $iconColor = match ($action) {
        'approve' =>
            'bg-green-100 text-green-700',

        'reject' =>
            'bg-red-100 text-red-700',

        default =>
            'bg-blue-100 text-blue-700',
    };
@endphp

@if ($action)
    <div
        wire:key="quotation-status-confirmation-{{ $action }}"
        wire:keydown.escape.window="closeStatusConfirmation"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
        aria-labelledby="quotation-status-modal-title"
    >
        {{-- Backdrop --}}
        <button
            type="button"
            wire:click="closeStatusConfirmation"
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
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl {{ $iconColor }}"
                    >
                        @if ($action === 'approve')
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                                class="h-6 w-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m4.5 12.75 6 6 9-13.5"
                                />
                            </svg>
                        @elseif ($action === 'reject')
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                                class="h-6 w-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18 18 6M6 6l12 12"
                                />
                            </svg>
                        @else
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
                                    d="m6 12 3.269 3.269a2.25 2.25 0 0 0 3.182 0L18 9.75M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"
                                />
                            </svg>
                        @endif
                    </div>

                    <div class="min-w-0">
                        <h2
                            id="quotation-status-modal-title"
                            class="text-lg font-semibold text-gray-900"
                        >
                            {{ $title }}
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            {{ $description }}
                        </p>
                    </div>
                </div>

                <div class="mt-5 rounded-xl bg-gray-50 px-4 py-3">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                        Quotation
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $quotation->quotation_number }}
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $quotation->client?->company_name
                            ?? $quotation->client_name
                            ?? '-' }}
                    </p>
                </div>
            </div>

            <div
                class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end"
            >
                <button
                    type="button"
                    wire:click="closeStatusConfirmation"
                    wire:loading.attr="disabled"
                    wire:target="confirmStatusAction"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    Batal
                </button>

                <button
                    type="button"
                    wire:click="confirmStatusAction"
                    wire:loading.attr="disabled"
                    wire:target="confirmStatusAction"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition focus:outline-none focus:ring-4 disabled:cursor-not-allowed disabled:opacity-60 {{ $buttonColor }}"
                >
                    <span
                        wire:loading.remove
                        wire:target="confirmStatusAction"
                    >
                        {{ $confirmText }}
                    </span>

                    <span
                        wire:loading.flex
                        wire:target="confirmStatusAction"
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

                        Memproses...
                    </span>
                </button>
            </div>
        </div>
    </div>
@endif