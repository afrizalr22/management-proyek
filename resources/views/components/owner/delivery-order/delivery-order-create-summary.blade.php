@props([
    'projectId' => null,
    'projectCode' => '',
    'projectName' => '',
    'clientName' => '',
    'mandorName' => '',
    'items' => [],
])

@php
    $totalQuantity = collect($items)->sum(
        fn ($item) => is_numeric($item['qty'] ?? null)
            ? (float) $item['qty']
            : 0
    );

    $formattedQuantity = rtrim(
        rtrim(
            number_format($totalQuantity, 2, ',', '.'),
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
                Ringkasan Project dan item pengiriman.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        @if ($projectId)
            <div class="space-y-5">
                <div>
                    <p class="text-sm text-gray-500">
                        Project
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $projectCode ?: '-' }}
                    </p>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ $projectName ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Client
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $clientName ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Mandor
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $mandorName ?: 'Belum ditentukan' }}
                    </p>
                </div>
            </div>
        @else
            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-4 py-8 text-center">
                <p class="text-sm font-medium text-gray-600">
                    Belum ada Project yang dipilih
                </p>

                <p class="mt-1 text-xs text-gray-500">
                    Pilih Project untuk menampilkan ringkasan.
                </p>
            </div>
        @endif

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
                    Status Awal
                </span>

                <span class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>

                    Draft
                </span>
            </div>
        </div>

        <div class="mt-6 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3">
            <p class="text-sm leading-6 text-blue-700">
                Nomor Surat Jalan dibuat otomatis setelah data berhasil disimpan.
            </p>
        </div>
    </div>
</x-ui.info-card>