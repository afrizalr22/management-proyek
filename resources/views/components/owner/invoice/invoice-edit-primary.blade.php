@props([
    'invoice',
])

@php
    $paymentStatus = match ($invoice->payment_status) {
        'paid' => [
            'label' => 'Lunas',
            'color' => 'green',
        ],
        'partial' => [
            'label' => 'Sebagian',
            'color' => 'yellow',
        ],
        default => [
            'label' => 'Belum Dibayar',
            'color' => 'red',
        ],
    };

    $projectName = $invoice->project?->project_name
        ?? $invoice->quotation?->project_name
        ?? 'Belum terhubung dengan proyek';
@endphp

<x-ui.info-card>
    <div class="p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Informasi Utama
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Informasi sumber invoice tidak dapat diganti.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        <div class="space-y-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Klien
                    </label>

                    <input
                        type="text"
                        value="{{ $invoice->client_name }}"
                        readonly
                        class="w-full rounded-xl border-gray-200 bg-gray-100 px-4 py-3 text-sm text-gray-600"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Proyek
                    </label>

                    <input
                        type="text"
                        value="{{ $projectName }}"
                        readonly
                        class="w-full rounded-xl border-gray-200 bg-gray-100 px-4 py-3 text-sm text-gray-600"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Nomor Invoice
                    </label>

                    <input
                        type="text"
                        value="{{ $invoice->invoice_number }}"
                        readonly
                        class="w-full rounded-xl border-gray-200 bg-gray-100 px-4 py-3 text-sm text-gray-600"
                    >

                    <p class="mt-2 text-xs text-gray-400">
                        Nomor invoice tidak dapat diubah.
                    </p>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Quotation Sumber
                    </label>

                    <input
                        type="text"
                        value="{{ $invoice->quotation?->quotation_number
                            ?: 'Tidak tersedia' }}"
                        readonly
                        class="w-full rounded-xl border-gray-200 bg-gray-100 px-4 py-3 text-sm text-gray-600"
                    >

                    <p class="mt-2 text-xs text-gray-400">
                        Quotation sumber tidak dapat diganti.
                    </p>
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Status Pembayaran
                </label>

                <div class="flex min-h-11 items-center rounded-xl border border-gray-200 bg-gray-100 px-4">
                    <x-ui.badge :color="$paymentStatus['color']">
                        {{ $paymentStatus['label'] }}
                    </x-ui.badge>
                </div>

                <p class="mt-2 text-xs text-gray-400">
                    Status pembayaran tidak diubah melalui form ini.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label
                        for="invoiceDate"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Tanggal Invoice
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="invoiceDate"
                        type="date"
                        wire:model="invoiceDate"
                        @class([
                            'w-full rounded-xl px-4 py-3 text-sm focus:ring-blue-500',
                            'border-red-300 focus:border-red-500' =>
                                $errors->has('invoiceDate'),
                            'border-gray-300 focus:border-blue-500' =>
                                ! $errors->has('invoiceDate'),
                        ])
                    >

                    @error('invoiceDate')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="dueDate"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Jatuh Tempo
                    </label>

                    <input
                        id="dueDate"
                        type="date"
                        wire:model="dueDate"
                        @class([
                            'w-full rounded-xl px-4 py-3 text-sm focus:ring-blue-500',
                            'border-red-300 focus:border-red-500' =>
                                $errors->has('dueDate'),
                            'border-gray-300 focus:border-blue-500' =>
                                ! $errors->has('dueDate'),
                        ])
                    >

                    @error('dueDate')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="mt-2 text-xs text-gray-400">
                        Kosongkan jika tidak memiliki jatuh tempo.
                    </p>
                </div>
            </div>

            <div>
                <label
                    for="notes"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Catatan
                </label>

                <textarea
                    id="notes"
                    wire:model="notes"
                    rows="5"
                    placeholder="Tambahkan catatan invoice..."
                    @class([
                        'w-full rounded-xl px-4 py-3 text-sm focus:ring-blue-500',
                        'border-red-300 focus:border-red-500' =>
                            $errors->has('notes'),
                        'border-gray-300 focus:border-blue-500' =>
                            ! $errors->has('notes'),
                    ])
                ></textarea>

                @error('notes')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
    </div>
</x-ui.info-card>