@props([
    'quotationNumber' => '',
    'clientName' => '',
    'projectName' => '',
    'subtotal' => 0,
    'grandTotal' => 0,
])

@php
    $rupiah = fn ($value): string =>
        'Rp '.number_format(
            (float) $value,
            0,
            ',',
            '.'
        );
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Ringkasan
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Ringkasan Invoice yang akan dibuat.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        <div class="space-y-4">
            <div class="flex items-start justify-between gap-4">
                <span class="text-sm text-gray-500">
                    Quotation
                </span>

                <span class="text-right text-sm font-semibold text-gray-800">
                    {{ $quotationNumber ?: '-' }}
                </span>
            </div>

            <div class="flex items-start justify-between gap-4">
                <span class="text-sm text-gray-500">
                    Client
                </span>

                <span class="break-words text-right text-sm font-semibold text-gray-800">
                    {{ $clientName ?: '-' }}
                </span>
            </div>

            <div class="flex items-start justify-between gap-4">
                <span class="text-sm text-gray-500">
                    Project
                </span>

                <span class="break-words text-right text-sm font-semibold text-gray-800">
                    {{ $projectName ?: '-' }}
                </span>
            </div>

            <div class="flex items-center justify-between gap-4 border-t border-gray-100 pt-4">
                <span class="text-sm text-gray-500">
                    Subtotal
                </span>

                <span class="font-semibold text-gray-800">
                    {{ $rupiah($subtotal) }}
                </span>
            </div>
        </div>

        <div class="mt-6 rounded-2xl bg-blue-50 p-5">
            <p class="text-sm font-medium text-blue-700">
                Grand Total
            </p>

            <p class="mt-2 break-words text-3xl font-bold text-blue-900">
                {{ $rupiah($grandTotal) }}
            </p>

            <p class="mt-2 text-xs text-blue-600">
                Pajak dan diskon belum diterapkan.
            </p>
        </div>

        <div class="mt-6">
            <label
                for="invoice-notes"
                class="mb-2 block text-sm font-medium text-gray-700"
            >
                Catatan
            </label>

            <textarea
                id="invoice-notes"
                wire:model="notes"
                rows="5"
                maxlength="2000"
                placeholder="Tambahkan catatan Invoice jika diperlukan..."
                class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
            ></textarea>

            @error('notes')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
</x-ui.info-card>