@props([
    'deliveryOrder',
    'items' => [],
    'totalQuantity' => 0,
])

@php
    $project = $deliveryOrder->project;
    $client = $project?->client;

    $formattedQuantity = rtrim(
        rtrim(
            number_format(
                (float) $totalQuantity,
                2,
                ',',
                '.'
            ),
            '0'
        ),
        ','
    );
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Ringkasan
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Ringkasan perubahan Surat Jalan.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        <div class="space-y-5">
            <div>
                <p class="text-sm text-gray-500">
                    Nomor Surat Jalan
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    {{ $deliveryOrder->delivery_number }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Project
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    {{ $project?->project_code ?? '-' }}
                </p>

                <p class="mt-1 text-sm text-gray-600">
                    {{ $project?->project_name
                        ?? 'Project tidak tersedia' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Client
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    {{ $client?->company_name ?? '-' }}
                </p>
            </div>
        </div>

        <hr class="my-6 border-gray-200">

        <div class="space-y-4">
            <div class="flex items-center justify-between gap-4">
                <span class="text-sm text-gray-500">
                    Total Jenis Item
                </span>

                <span class="font-semibold text-gray-900">
                    {{ count($items) }} Item
                </span>
            </div>

            <div class="flex items-center justify-between gap-4">
                <span class="text-sm text-gray-500">
                    Total Quantity
                </span>

                <span class="font-semibold text-gray-900">
                    {{ $formattedQuantity ?: '0' }}
                </span>
            </div>

            <div class="flex items-center justify-between gap-4">
                <span class="text-sm text-gray-500">
                    Status
                </span>

                <span class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>

                    Draft
                </span>
            </div>
        </div>

        <div class="mt-6 rounded-xl border border-amber-100 bg-amber-50 px-4 py-3">
            <p class="text-sm leading-6 text-amber-700">
                Setelah Surat Jalan dikirim, data tidak dapat diedit kembali.
            </p>
        </div>
    </div>
</x-ui.info-card>