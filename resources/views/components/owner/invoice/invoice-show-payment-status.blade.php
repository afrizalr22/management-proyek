@props([
    'invoice',
])

@php
    $grandTotal = (float) $invoice->grand_total;
    $paidAmount = (float) $invoice->paid_amount;
    $remainingAmount = max(
        $grandTotal - $paidAmount,
        0
    );

    $isOverdue = $invoice->due_date
        && $invoice->due_date->isPast()
        && $invoice->payment_status !== 'paid'
        && in_array(
            $invoice->status,
            ['issued', 'sent'],
            true
        );

    $canReceivePayment = in_array(
        $invoice->status,
        ['issued', 'sent'],
        true
    ) && $invoice->payment_status !== 'paid';

    $payment = match ($invoice->payment_status) {
        'paid' => [
            'label' => 'Lunas',
            'title' => 'Pembayaran Lunas',
            'description' =>
                'Seluruh nilai invoice telah dibayarkan.',
            'color' => 'green',
            'border' => 'border-green-200',
            'background' => 'bg-green-50',
            'icon_background' => 'bg-green-100',
            'text' => 'text-green-800',
            'muted' => 'text-green-700',
        ],

        'partial' => [
            'label' => 'Sebagian',
            'title' => 'Pembayaran Sebagian',
            'description' =>
                'Sebagian nilai invoice telah dibayarkan.',
            'color' => 'yellow',
            'border' => 'border-yellow-200',
            'background' => 'bg-yellow-50',
            'icon_background' => 'bg-yellow-100',
            'text' => 'text-yellow-800',
            'muted' => 'text-yellow-700',
        ],

        default => [
            'label' => 'Belum Dibayar',
            'title' => 'Pembayaran Belum Diterima',
            'description' =>
                'Belum ada pembayaran yang dicatat.',
            'color' => 'red',
            'border' => 'border-red-200',
            'background' => 'bg-red-50',
            'icon_background' => 'bg-red-100',
            'text' => 'text-red-800',
            'muted' => 'text-red-700',
        ],
    };
@endphp

<x-ui.info-card>
    <div class="p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Status Pembayaran
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Informasi dan pencatatan pembayaran invoice.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        <div
            @class([
                'rounded-2xl border p-5',
                $payment['border'],
                $payment['background'],
            ])
        >
            <div class="flex items-start gap-4">
                <div
                    @class([
                        'flex h-11 w-11 shrink-0 items-center justify-center rounded-full',
                        $payment['icon_background'],
                        $payment['text'],
                    ])
                >
                    @if ($invoice->payment_status === 'paid')
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m4.5 12.75 6 6 9-13.5"
                            />
                        </svg>
                    @else
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                            />
                        </svg>
                    @endif
                </div>

                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <p
                            @class([
                                'font-semibold',
                                $payment['text'],
                            ])
                        >
                            {{ $payment['title'] }}
                        </p>

                        <x-ui.badge :color="$payment['color']">
                            {{ $payment['label'] }}
                        </x-ui.badge>

                        @if ($isOverdue)
                            <x-ui.badge color="red">
                                Terlambat
                            </x-ui.badge>
                        @endif
                    </div>

                    <p
                        @class([
                            'mt-1 text-sm leading-relaxed',
                            $payment['muted'],
                        ])
                    >
                        {{ $payment['description'] }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6 space-y-5">
            <div class="flex items-center justify-between gap-4">
                <span class="text-gray-500">
                    Total Invoice
                </span>

                <span class="text-right font-semibold text-gray-800">
                    Rp {{ number_format(
                        $grandTotal,
                        0,
                        ',',
                        '.'
                    ) }}
                </span>
            </div>

            <div class="flex items-center justify-between gap-4">
                <span class="text-gray-500">
                    Sudah Dibayar
                </span>

                <span class="text-right font-semibold text-green-600">
                    Rp {{ number_format(
                        $paidAmount,
                        0,
                        ',',
                        '.'
                    ) }}
                </span>
            </div>

            <div class="flex items-center justify-between gap-4">
                <span class="text-gray-500">
                    Sisa Tagihan
                </span>

                <span
                    @class([
                        'text-right font-semibold',
                        'text-green-600' =>
                            $remainingAmount <= 0,
                        'text-red-600' =>
                            $remainingAmount > 0,
                    ])
                >
                    Rp {{ number_format(
                        $remainingAmount,
                        0,
                        ',',
                        '.'
                    ) }}
                </span>
            </div>

            <div class="flex items-center justify-between gap-4">
                <span class="text-gray-500">
                    Tanggal Pelunasan
                </span>

                <span class="text-right font-semibold text-gray-800">
                    {{ $invoice->paid_at
                        ?->translatedFormat('d F Y, H:i')
                        ?? '-' }}
                </span>
            </div>
        </div>

        @can('update invoices')
            @if ($canReceivePayment)
                <hr class="my-6 border-gray-200">

                <form
                    wire:submit="recordPayment"
                    class="space-y-4"
                >
                    <div>
                        <label
                            for="paymentAmount"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Jumlah Pembayaran
                            <span class="text-red-500">*</span>
                        </label>

                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">
                                Rp
                            </span>

                            <input
                                id="paymentAmount"
                                type="number"
                                wire:model="paymentAmount"
                                min="0.01"
                                step="0.01"
                                max="{{ $remainingAmount }}"
                                placeholder="0"
                                @class([
                                    'w-full rounded-xl py-3 pl-12 pr-4 text-sm focus:ring-blue-500',
                                    'border-red-300 focus:border-red-500' =>
                                        $errors->has('paymentAmount'),
                                    'border-gray-300 focus:border-blue-500' =>
                                        ! $errors->has('paymentAmount'),
                                ])
                            >
                        </div>

                        @error('paymentAmount')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <p class="mt-2 text-xs text-gray-500">
                            Maksimal pembayaran:
                            <strong>
                                Rp {{ number_format(
                                    $remainingAmount,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </strong>
                        </p>
                    </div>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="recordPayment"
                        class="inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-100 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <span
                            wire:loading.remove
                            wire:target="recordPayment"
                        >
                            Catat Pembayaran
                        </span>

                        <span
                            wire:loading
                            wire:target="recordPayment"
                        >
                            Menyimpan Pembayaran...
                        </span>
                    </button>
                </form>
            @elseif ($invoice->status === 'draft')
                <hr class="my-6 border-gray-200">

                <div class="rounded-xl border border-yellow-200 bg-yellow-50 p-4">
                    <p class="text-sm text-yellow-700">
                        Invoice harus diterbitkan terlebih dahulu
                        sebelum pembayaran dapat dicatat.
                    </p>
                </div>
            @elseif ($invoice->status === 'cancelled')
                <hr class="my-6 border-gray-200">

                <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                    <p class="text-sm text-red-700">
                        Pembayaran tidak dapat dicatat karena
                        invoice telah dibatalkan.
                    </p>
                </div>
            @endif
        @endcan
    </div>
</x-ui.info-card>