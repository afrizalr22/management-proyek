@props([
    'selectedClient' => null,
    'projectName' => '',
    'quotationDate' => '',
    'validUntil' => '',
    'items' => [],
    'subtotal' => 0,
    'grandTotal' => 0,
])

@php
    $quotationItems = is_array($items)
        ? $items
        : [];

    $totalItems = count($quotationItems);

    $totalQuantity = collect($quotationItems)
        ->sum(function ($item) {
            return (float) ($item['qty'] ?? 0);
        });

    $projectNameText = filled($projectName)
        ? $projectName
        : 'Belum diisi';

    $clientName = $selectedClient?->company_name
        ?? 'Belum dipilih';

    $formattedQuotationDate = filled($quotationDate)
        ? \Illuminate\Support\Carbon::parse(
            $quotationDate
        )->translatedFormat('d M Y')
        : '-';

    $formattedValidUntil = filled($validUntil)
        ? \Illuminate\Support\Carbon::parse(
            $validUntil
        )->translatedFormat('d M Y')
        : '-';

    $subtotalValue = (float) $subtotal;
    $grandTotalValue = (float) $grandTotal;
@endphp

<x-ui.info-card>
    <div class="space-y-6 p-6">

        {{-- Header --}}
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                Quotation Summary
            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500">
                Ringkasan informasi quotation yang sedang dibuat.
            </p>
        </div>

        <hr class="border-gray-200">

        {{-- Status --}}
        <div>
            <p class="text-sm text-gray-500">
                Status
            </p>

            <div class="mt-2">
                <x-ui.badge color="yellow">
                    Draft
                </x-ui.badge>
            </div>
        </div>

        {{-- Project --}}
        <div>
            <p class="text-sm text-gray-500">
                Calon Project
            </p>

            <p
                @class([
                    'mt-1 break-words font-semibold',
                    'text-gray-900' => filled($projectName),
                    'text-gray-400' => blank($projectName),
                ])
            >
                {{ $projectNameText }}
            </p>
        </div>

        {{-- Client --}}
        <div>
            <p class="text-sm text-gray-500">
                Client
            </p>

            <p
                @class([
                    'mt-1 break-words font-semibold',
                    'text-gray-900' => $selectedClient,
                    'text-gray-400' => !$selectedClient,
                ])
            >
                {{ $clientName }}
            </p>

            @if ($selectedClient?->contact_person)
                <p class="mt-1 text-xs text-gray-500">
                    {{ $selectedClient->contact_person }}
                </p>
            @endif
        </div>

        {{-- Tanggal --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <p class="text-sm text-gray-500">
                    Tanggal
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    {{ $formattedQuotationDate }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Berlaku Sampai
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    {{ $formattedValidUntil }}
                </p>
            </div>
        </div>

        <hr class="border-gray-200">

        {{-- Ringkasan item --}}
        <div>
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">
                Ringkasan Item
            </h3>

            <div class="space-y-4">
                <div class="flex items-center justify-between gap-4">
                    <span class="text-gray-500">
                        Total Item
                    </span>

                    <span class="font-semibold text-gray-900">
                        {{ $totalItems }}
                    </span>
                </div>

                <div class="flex items-center justify-between gap-4">
                    <span class="text-gray-500">
                        Total Kuantitas
                    </span>

                    <span class="font-semibold text-gray-900">
                        {{ number_format(
                            $totalQuantity,
                            $totalQuantity == floor($totalQuantity)
                                ? 0
                                : 2,
                            ',',
                            '.'
                        ) }}
                    </span>
                </div>

                <div class="flex items-center justify-between gap-4">
                    <span class="text-gray-500">
                        Subtotal
                    </span>

                    <span class="font-semibold text-gray-900">
                        Rp {{ number_format(
                            $subtotalValue,
                            0,
                            ',',
                            '.'
                        ) }}
                    </span>
                </div>
            </div>
        </div>

        <hr class="border-gray-200">

        {{-- Grand Total --}}
        <div class="rounded-2xl bg-blue-50 p-5">
            <p class="text-sm font-medium text-gray-500">
                Grand Total
            </p>

            <h2 class="mt-2 break-words text-2xl font-bold text-blue-600">
                Rp {{ number_format(
                    $grandTotalValue,
                    0,
                    ',',
                    '.'
                ) }}
            </h2>

            <p class="mt-2 text-xs leading-5 text-gray-500">
                Total nilai quotation berdasarkan seluruh item yang ditambahkan.
            </p>
        </div>
    </div>
</x-ui.info-card>