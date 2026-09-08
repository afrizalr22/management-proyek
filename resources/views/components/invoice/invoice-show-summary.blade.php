@props([
    'invoice',
])

@php
    $documentStatus = match ($invoice->status) {
        'draft' => [
            'label' => 'Draft',
            'color' => 'yellow',
        ],
        'issued' => [
            'label' => 'Diterbitkan',
            'color' => 'purple',
        ],
        'sent' => [
            'label' => 'Dikirim',
            'color' => 'blue',
        ],
        'cancelled' => [
            'label' => 'Dibatalkan',
            'color' => 'red',
        ],
        default => [
            'label' => ucfirst($invoice->status),
            'color' => 'gray',
        ],
    };

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
                Ringkasan Invoice
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Informasi utama dan dokumen sumber invoice.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        <dl class="space-y-6">
            <div>
                <dt class="text-sm text-gray-500">
                    Nomor Invoice
                </dt>

                <dd class="mt-1 text-lg font-semibold text-gray-800">
                    {{ $invoice->invoice_number }}
                </dd>
            </div>

            <div>
                <dt class="text-sm text-gray-500">
                    Proyek
                </dt>

                <dd class="mt-1 font-semibold leading-relaxed text-gray-800">
                    {{ $projectName }}
                </dd>

                @if ($invoice->project?->project_code)
                    <p class="mt-1 text-sm text-gray-500">
                        {{ $invoice->project->project_code }}
                    </p>
                @endif
            </div>

            <div>
                <dt class="text-sm text-gray-500">
                    Quotation
                </dt>

                <dd class="mt-1 font-semibold text-gray-800">
                    {{ $invoice->quotation?->quotation_number ?: '-' }}
                </dd>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm text-gray-500">
                        Tanggal Invoice
                    </dt>

                    <dd class="mt-1 font-semibold text-gray-800">
                        {{ $invoice->invoice_date?->format('d M Y') ?? '-' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-sm text-gray-500">
                        Jatuh Tempo
                    </dt>

                    <dd class="mt-1 font-semibold text-gray-800">
                        {{ $invoice->due_date?->format('d M Y') ?? '-' }}
                    </dd>
                </div>
            </div>

            <div>
                <dt class="text-sm text-gray-500">
                    Dibuat Oleh
                </dt>

                <dd class="mt-1 font-semibold text-gray-800">
                    {{ $invoice->creator?->name ?: 'Pengguna tidak tersedia' }}
                </dd>
            </div>

            <div class="flex flex-wrap gap-6">
                <div>
                    <dt class="mb-2 text-sm text-gray-500">
                        Status Dokumen
                    </dt>

                    <dd>
                        <x-ui.badge :color="$documentStatus['color']">
                            {{ $documentStatus['label'] }}
                        </x-ui.badge>
                    </dd>
                </div>

                <div>
                    <dt class="mb-2 text-sm text-gray-500">
                        Status Pembayaran
                    </dt>

                    <dd>
                        <x-ui.badge :color="$paymentStatus['color']">
                            {{ $paymentStatus['label'] }}
                        </x-ui.badge>
                    </dd>
                </div>
            </div>
        </dl>
    </div>
</x-ui.info-card>