@props([
    'deliveryOrder',
])

@php
    $client =
        $deliveryOrder->project?->client;

    $mandor =
        $deliveryOrder->project?->mandor;
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Informasi Pengiriman
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Informasi tujuan dan penerima barang.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        <div class="space-y-5">
            <div>
                <p class="text-sm text-gray-500">
                    Tujuan Pengiriman
                </p>

                <p class="mt-1 whitespace-pre-line font-semibold leading-7 text-gray-900">
                    {{ $deliveryOrder->destination ?: '-' }}
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-gray-500">
                        Nama Penerima
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $deliveryOrder->receiver_name ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Telepon Penerima
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $deliveryOrder->receiver_phone ?: '-' }}
                    </p>
                </div>
            </div>

            <hr class="border-gray-200">

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-gray-500">
                        Client
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $client?->company_name ?? '-' }}
                    </p>

                    @if ($client?->contact_person)
                        <p class="mt-1 text-sm text-gray-500">
                            PIC: {{ $client->contact_person }}
                        </p>
                    @endif
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Mandor Project
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $mandor?->name ?? 'Belum ditentukan' }}
                    </p>

                    @if ($mandor?->phone)
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $mandor->phone }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-ui.info-card>