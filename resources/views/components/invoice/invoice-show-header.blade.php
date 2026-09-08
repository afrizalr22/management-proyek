@props([
    'invoice',
])

@php
    [$documentText, $documentColor] = match ($invoice->status) {
        'draft' => ['Draft', 'yellow'],
        'issued' => ['Diterbitkan', 'purple'],
        'sent' => ['Dikirim', 'blue'],
        'cancelled' => ['Dibatalkan', 'red'],
        default => ['Tidak Diketahui', 'gray'],
    };

    [$paymentText, $paymentColor] =
        match ($invoice->payment_status) {
            'unpaid' => ['Belum Dibayar', 'red'],
            'partial' => ['Dibayar Sebagian', 'yellow'],
            'paid' => ['Lunas', 'green'],
            default => ['Tidak Diketahui', 'gray'],
        };

    $projectName =
        $invoice->project?->project_name
        ?? $invoice->quotation?->project_name
        ?? 'Belum terhubung ke Project';

    $isOverdue =
        $invoice->due_date
        && in_array(
            $invoice->status,
            ['issued', 'sent'],
            true
        )
        && $invoice->payment_status !== 'paid'
        && $invoice->due_date->lt(today());
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
            <a
                href="{{ route('owner.invoices.index') }}"
                wire:navigate
                class="transition hover:text-blue-600"
            >
                Invoice Management
            </a>

            <span>/</span>

            <span class="font-medium text-gray-700">
                {{ $invoice->invoice_number }}
            </span>
        </nav>

        <div class="mt-6 flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="break-words text-2xl font-bold text-gray-900 sm:text-3xl">
                        {{ $invoice->invoice_number }}
                    </h1>

                    <x-ui.badge :color="$documentColor">
                        {{ $documentText }}
                    </x-ui.badge>

                    <x-ui.badge :color="$paymentColor">
                        {{ $paymentText }}
                    </x-ui.badge>

                    @if ($isOverdue)
                        <x-ui.badge color="red">
                            Terlambat
                        </x-ui.badge>
                    @endif
                </div>

                <p class="mt-2 break-words text-gray-500">
                    {{ $projectName }}
                </p>

                <div class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-sm text-gray-500">
                    <span>
                        Tanggal Invoice:

                        <span class="font-medium text-gray-700">
                            {{ $invoice->invoice_date
                                ?->translatedFormat('d F Y') ?? '-' }}
                        </span>
                    </span>

                    <span>
                        Jatuh Tempo:

                        <span
                            @class([
                                'font-semibold text-red-600' => $isOverdue,
                                'font-medium text-gray-700' => ! $isOverdue,
                            ])
                        >
                            {{ $invoice->due_date
                                ?->translatedFormat('d F Y') ?? '-' }}
                        </span>
                    </span>
                </div>

                @if ($invoice->issued_at || $invoice->sent_at)
                    <div class="mt-3 flex flex-wrap gap-x-6 gap-y-2 text-xs text-gray-400">
                        @if ($invoice->issued_at)
                            <span>
                                Diterbitkan:
                                {{ $invoice->issued_at
                                    ->translatedFormat('d F Y, H:i') }}
                            </span>
                        @endif

                        @if ($invoice->sent_at)
                            <span>
                                Dikirim:
                                {{ $invoice->sent_at
                                    ->translatedFormat('d F Y, H:i') }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                <a
                    href="{{ route('owner.invoices.index') }}"
                    wire:navigate
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
                >
                    Kembali
                </a>

                <a
                    href="{{ route('owner.invoices.preview', [
                        'invoice' => $invoice->id,
                    ]) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-blue-300 bg-white px-5 py-2.5 text-sm font-semibold text-blue-600 transition hover:bg-blue-50"
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
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m.75 12 3 3m0 0 3-3m-3 3V10.5M6.75 2.25H5.625A1.875 1.875 0 0 0 3.75 4.125v15.75c0 1.036.84 1.875 1.875 1.875h12.75a1.875 1.875 0 0 0 1.875-1.875V11.25a9 9 0 0 0-9-9H6.75Z"
                        />
                    </svg>

                    Preview PDF
                </a>

                <a
                    href="{{ route('owner.invoices.download', [
                        'invoice' => $invoice->id,
                    ]) }}"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
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
                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-6L12 15m0 0 4.5-4.5M12 15V3"
                        />
                    </svg>

                    Download PDF
                </a>

                @can('update invoices')
                    @if ($invoice->status === 'draft')
                        <a
                            href="{{ route('owner.invoices.edit', [
                                'invoice' => $invoice->id,
                            ]) }}"
                            wire:navigate
                            class="inline-flex min-h-11 items-center justify-center rounded-xl bg-amber-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-amber-600"
                        >
                            Edit Invoice
                        </a>

                        <button
                            type="button"
                            wire:click="issueInvoice"
                            wire:loading.attr="disabled"
                            wire:target="issueInvoice"
                            class="inline-flex min-h-11 items-center justify-center rounded-xl bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            <span
                                wire:loading.remove
                                wire:target="issueInvoice"
                            >
                                Terbitkan Invoice
                            </span>

                            <span
                                wire:loading
                                wire:target="issueInvoice"
                            >
                                Memproses...
                            </span>
                        </button>
                    @endif

                    @if ($invoice->status === 'issued')
                        <button
                            type="button"
                            wire:click="markAsSent"
                            wire:confirm="Tandai invoice ini sebagai sudah dikirim kepada klien?"
                            wire:loading.attr="disabled"
                            wire:target="markAsSent"
                            class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            <span
                                wire:loading.remove
                                wire:target="markAsSent"
                            >
                                Tandai Dikirim
                            </span>

                            <span
                                wire:loading
                                wire:target="markAsSent"
                            >
                                Memproses...
                            </span>
                        </button>
                    @endif

                    @if (
                        in_array(
                            $invoice->status,
                            ['draft', 'issued', 'sent'],
                            true
                        )
                        && (float) $invoice->paid_amount <= 0
                        && $invoice->payment_status === 'unpaid'
                    )
                        <button
                            type="button"
                            wire:click="cancelInvoice"
                            wire:confirm="Batalkan invoice ini? Tindakan ini tidak dapat dibatalkan."
                            wire:loading.attr="disabled"
                            wire:target="cancelInvoice"
                            class="inline-flex min-h-11 items-center justify-center rounded-xl border border-red-300 bg-white px-5 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            <span
                                wire:loading.remove
                                wire:target="cancelInvoice"
                            >
                                Batalkan
                            </span>

                            <span
                                wire:loading
                                wire:target="cancelInvoice"
                            >
                                Membatalkan...
                            </span>
                        </button>
                    @endif
                @endcan
            </div>
        </div>

        @error('action')
            <div
                class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
                role="alert"
            >
                {{ $message }}
            </div>
        @enderror
    </div>
</x-ui.info-card>