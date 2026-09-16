@props([
    'invoices',
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

<div class="space-y-4">
    <x-ui.table>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            No. Invoice
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Client / Project
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Jatuh Tempo
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Total
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Dokumen
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Pembayaran
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($invoices as $invoice)
                        @php
                            [$documentText, $documentColor] =
                                match ($invoice->status) {
                                    'draft' => ['Draft', 'yellow'],
                                    'issued' => ['Diterbitkan', 'purple'],
                                    'sent' => ['Dikirim', 'blue'],
                                    'cancelled' => ['Dibatalkan', 'red'],
                                    default => ['Tidak Diketahui', 'gray'],
                                };

                            [$paymentText, $paymentColor] =
                                match ($invoice->payment_status) {
                                    'unpaid' => ['Belum Dibayar', 'red'],
                                    'partial' => ['Sebagian', 'yellow'],
                                    'paid' => ['Lunas', 'green'],
                                    default => ['Tidak Diketahui', 'gray'],
                                };

                            $projectName =
                                $invoice->project?->project_name
                                ?? $invoice->quotation?->project_name
                                ?? 'Belum terhubung ke Project';

                            $remainingAmount = max(
                                (float) $invoice->grand_total
                                - (float) $invoice->paid_amount,
                                0
                            );

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

                        <tr
                            wire:key="invoice-row-{{ $invoice->id }}"
                            class="transition hover:bg-gray-50"
                        >
                            <td class="px-6 py-5">
                                <a
                                    href="{{ route('owner.invoices.show', [
                                        'invoice' => $invoice->id,
                                    ]) }}"
                                    wire:navigate
                                    class="font-semibold text-blue-600 transition hover:text-blue-700"
                                >
                                    {{ $invoice->invoice_number }}
                                </a>

                                @if ($invoice->quotation)
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $invoice->quotation->quotation_number }}
                                    </p>
                                @endif
                            </td>

                            <td class="px-6 py-5">
                                <p class="font-semibold text-gray-900">
                                    {{ $invoice->client_name }}
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $projectName }}
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-600">
                                {{ $invoice->invoice_date
                                    ?->translatedFormat('d M Y') ?? '-' }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-5 text-sm">
                                <span
                                    @class([
                                        'font-semibold text-red-600' =>
                                            $isOverdue,
                                        'text-gray-600' => !$isOverdue,
                                    ])
                                >
                                    {{ $invoice->due_date
                                        ?->translatedFormat('d M Y') ?? '-' }}
                                </span>

                                @if ($isOverdue)
                                    <p class="mt-1 text-xs font-medium text-red-600">
                                        Terlambat
                                        {{ $invoice->due_date
                                            ->diffInDays(today()) }}
                                        hari
                                    </p>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-6 py-5 text-right">
                                <p class="font-semibold text-gray-900">
                                    {{ $rupiah($invoice->grand_total) }}
                                </p>

                                @if ($remainingAmount > 0)
                                    <p class="mt-1 text-xs text-gray-500">
                                        Sisa:
                                        {{ $rupiah($remainingAmount) }}
                                    </p>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-center">
                                <x-ui.badge :color="$documentColor">
                                    {{ $documentText }}
                                </x-ui.badge>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <x-ui.badge :color="$paymentColor">
                                    {{ $paymentText }}
                                </x-ui.badge>
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <x-ui.icon-button-view
                                        :href="route(
                                            'owner.invoices.show',
                                            ['invoice' => $invoice->id]
                                        )"
                                    />

                                    @can('update invoices')
                                    @if ($invoice->status === 'draft')
                                        <x-ui.icon-button-edit
                                            :href="route(
                                                'owner.invoices.edit',
                                                ['invoice' => $invoice->id]
                                            )"
                                        />
                                    @else
                                        <button
                                            type="button"
                                            disabled
                                            title="Hanya invoice Draft yang dapat diedit"
                                            class="inline-flex h-9 w-9 cursor-not-allowed items-center justify-center rounded-lg bg-gray-100 text-gray-400 opacity-60"
                                            aria-label="Invoice tidak dapat diedit"
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
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487ZM16.862 4.487 19.5 7.125"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M19.5 13.5v4.125A2.625 2.625 0 0 1 16.875 20.25H6.375A2.625 2.625 0 0 1 3.75 17.625V7.125A2.625 2.625 0 0 1 6.375 4.5H10.5"
                                                />
                                            </svg>
                                        </button>
                                    @endif
                                @endcan

                                    @can('delete invoices')
                                    @php
                                        $canDeleteInvoice =
                                            $invoice->status === 'draft'
                                            && $invoice->payment_status === 'unpaid'
                                            && (float) $invoice->paid_amount <= 0;
                                    @endphp

                                    @if ($canDeleteInvoice)
                                        <x-ui.icon-button-delete
                                            href="javascript:void(0)"
                                            x-on:click="$dispatch(
                                                'open-delete-invoice-modal',
                                                { id: {{ $invoice->id }} }
                                            )"
                                        />
                                    @else
                                        <button
                                            type="button"
                                            disabled
                                            title="Hanya invoice Draft yang belum dibayar yang dapat dihapus"
                                            class="inline-flex h-9 w-9 cursor-not-allowed items-center justify-center rounded-lg bg-gray-100 text-gray-400 opacity-60"
                                            aria-label="Invoice tidak dapat dihapus"
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
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0V4.477c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                                />
                                            </svg>
                                        </button>
                                    @endif
                                @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="8"
                                class="px-6 py-14 text-center"
                            >
                                <p class="font-semibold text-gray-700">
                                    Invoice tidak ditemukan
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Belum ada Invoice atau filter tidak sesuai.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.table>

    @if ($invoices->hasPages())
        <div class="rounded-xl border border-gray-200 bg-white px-4 py-4">
            {{ $invoices->links() }}
        </div>
    @endif

    <p class="px-2 text-sm text-gray-500">
        @if ($invoices->total() > 0)
            Menampilkan
            <span class="font-medium text-gray-700">
                {{ $invoices->firstItem() }}
            </span>
            sampai
            <span class="font-medium text-gray-700">
                {{ $invoices->lastItem() }}
            </span>
            dari
            <span class="font-medium text-gray-700">
                {{ $invoices->total() }}
            </span>
            Invoice
        @else
            Tidak ada Invoice yang ditampilkan
        @endif
    </p>
</div>