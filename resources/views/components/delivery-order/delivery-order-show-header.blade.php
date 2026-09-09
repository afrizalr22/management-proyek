@props([
    'deliveryOrder',
])

@php
    [$statusText, $statusColor] = match (
        $deliveryOrder->status
    ) {
        'draft' => [
            'Draft',
            'yellow',
        ],
        'sent' => [
            'Dikirim',
            'blue',
        ],
        'received' => [
            'Diterima',
            'green',
        ],
        'cancelled' => [
            'Dibatalkan',
            'red',
        ],
        default => [
            'Tidak Diketahui',
            'gray',
        ],
    };

    $projectName =
        $deliveryOrder->project?->project_name
        ?? 'Project tidak tersedia';
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        {{-- Breadcrumb --}}
        <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
            <a
                href="{{ route('owner.delivery-orders.index') }}"
                wire:navigate
                class="transition hover:text-blue-600"
            >
                Surat Jalan
            </a>

            <span>/</span>

            <span class="font-medium text-gray-700">
                {{ $deliveryOrder->delivery_number }}
            </span>
        </nav>

        {{-- Header --}}
        <div class="mt-6 flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
            {{-- Informasi --}}
            <div class="min-w-0 xl:flex-1">
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="break-words text-2xl font-bold text-gray-900 sm:text-3xl">
                        {{ $deliveryOrder->delivery_number }}
                    </h1>

                    <x-ui.badge :color="$statusColor">
                        {{ $statusText }}
                    </x-ui.badge>
                </div>

                <p class="mt-2 break-words text-gray-500">
                    {{ $projectName }}
                </p>

                <div class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-sm text-gray-500">
                    <span>
                        Tanggal Pengiriman:

                        <span class="font-medium text-gray-700">
                            {{ $deliveryOrder->delivery_date
                                ?->translatedFormat('d F Y') ?? '-' }}
                        </span>
                    </span>

                    <span>
                        Total Item:

                        <span class="font-medium text-gray-700">
                            {{ $deliveryOrder->items_count }} Item
                        </span>
                    </span>

                    <span>
                        Dibuat oleh:

                        <span class="font-medium text-gray-700">
                            {{ $deliveryOrder->creator?->name
                                ?? 'Pengguna tidak tersedia' }}
                        </span>
                    </span>
                </div>

                @if (
                    $deliveryOrder->sent_at
                    || $deliveryOrder->received_at
                )
                    <div class="mt-3 flex flex-wrap gap-x-6 gap-y-2 text-xs text-gray-400">
                        @if ($deliveryOrder->sent_at)
                            <span>
                                Dikirim:

                                {{ $deliveryOrder->sent_at
                                    ->translatedFormat('d F Y, H:i') }}
                            </span>
                        @endif

                        @if ($deliveryOrder->received_at)
                            <span>
                                Diterima:

                                {{ $deliveryOrder->received_at
                                    ->translatedFormat('d F Y, H:i') }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>


{{-- Tombol tindakan --}}
<div class="flex w-full flex-col gap-3 sm:flex-row sm:flex-wrap lg:w-auto lg:shrink-0 lg:flex-nowrap lg:justify-end">
    {{-- Kembali --}}
    <a
        href="{{ route('owner.delivery-orders.index') }}"
        wire:navigate
        class="inline-flex min-h-11 items-center justify-center whitespace-nowrap rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
    >
        Kembali
    </a>
    {{-- Preview PDF --}}
<a
    href="{{ route(
        'owner.delivery-orders.preview',
        [
            'deliveryOrder' =>
                $deliveryOrder->id,
        ]
    ) }}"
    target="_blank"
    rel="noopener noreferrer"
    class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-xl border border-blue-300 bg-white px-4 py-2.5 text-sm font-semibold text-blue-600 transition hover:bg-blue-50"
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
            d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"
        />

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
        />
    </svg>

    Preview PDF
</a>

{{-- Download PDF --}}
<a
    href="{{ route(
        'owner.delivery-orders.download',
        [
            'deliveryOrder' =>
                $deliveryOrder->id,
        ]
    ) }}"
    class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
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

    @can('update delivery orders')
        {{-- Edit --}}
        @if ($deliveryOrder->status === 'draft')
            <a
                href="{{ route(
                    'owner.delivery-orders.edit',
                    [
                        'deliveryOrder' =>
                            $deliveryOrder->id,
                    ]
                ) }}"
                wire:navigate
                class="inline-flex min-h-11 items-center justify-center whitespace-nowrap rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-amber-600"
            >
                Edit Surat Jalan
            </a>
        @else
            <button
                type="button"
                disabled
                title="Hanya Surat Jalan Draft yang dapat diedit"
                class="inline-flex min-h-11 cursor-not-allowed items-center justify-center whitespace-nowrap rounded-xl bg-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-500"
            >
                Edit Surat Jalan
            </button>
        @endif

        {{-- Draft menjadi Dikirim --}}
        @if ($deliveryOrder->status === 'draft')
            <button
                type="button"
                wire:click="markAsSent"
                wire:loading.attr="disabled"
                wire:target="markAsSent"
                class="inline-flex min-h-11 items-center justify-center whitespace-nowrap rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-wait disabled:opacity-60"
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

        {{-- Dikirim menjadi Diterima --}}
        @if ($deliveryOrder->status === 'sent')
            <button
                type="button"
                wire:click="markAsReceived"
                wire:loading.attr="disabled"
                wire:target="markAsReceived"
                class="inline-flex min-h-11 items-center justify-center whitespace-nowrap rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700 disabled:cursor-wait disabled:opacity-60"
            >
                <span
                    wire:loading.remove
                    wire:target="markAsReceived"
                >
                    Tandai Diterima
                </span>

                <span
                    wire:loading
                    wire:target="markAsReceived"
                >
                    Memproses...
                </span>
            </button>
        @endif

        {{-- Batalkan --}}
        @if (
            in_array(
                $deliveryOrder->status,
                [
                    'draft',
                    'sent',
                ],
                true
            )
        )
            <button
                type="button"
                wire:click="cancelDeliveryOrder"
                wire:loading.attr="disabled"
                wire:target="cancelDeliveryOrder"
                class="inline-flex min-h-11 items-center justify-center whitespace-nowrap rounded-xl border border-red-300 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50 disabled:cursor-wait disabled:opacity-60"
            >
                <span
                    wire:loading.remove
                    wire:target="cancelDeliveryOrder"
                >
                    Batalkan
                </span>

                <span
                    wire:loading
                    wire:target="cancelDeliveryOrder"
                >
                    Membatalkan...
                </span>
            </button>
        @endif
    @endcan
</div>
        </div>

        {{-- Informasi status akhir --}}
        @if ($deliveryOrder->status === 'received')
            <div class="mt-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3">
                <div class="flex items-start gap-3">
                    <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-700">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2.5"
                            stroke="currentColor"
                            class="h-4 w-4"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m4.5 12.75 6 6 9-13.5"
                            />
                        </svg>
                    </span>

                    <p class="text-sm leading-6 text-green-700">
                        Pengiriman telah diterima dan Surat Jalan ini sudah selesai.
                    </p>
                </div>
            </div>
        @elseif ($deliveryOrder->status === 'cancelled')
            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                <p class="text-sm leading-6 text-red-700">
                    Surat Jalan ini telah dibatalkan dan tidak dapat diproses kembali.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>