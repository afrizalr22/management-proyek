@props([
    'statistics' => [],
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

<div class="grid grid-cols-1 gap-6 md:grid-cols-3">
    {{-- Total Invoice --}}
    <x-ui.stat-card
        title="Total Invoice"
        :value="$rupiah($statistics['total_amount'] ?? 0)"
        :description="sprintf(
            '%d Invoice tercatat',
            $statistics['total_count'] ?? 0
        )"
    >
        <x-slot:icon>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12h6m-6 4h6M9 8h6m-7 12h8a2 2 0 0 0 2-2V6l-4-4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z"
                />
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>

    {{-- Menunggu pembayaran --}}
    <x-ui.stat-card
        title="Menunggu Pembayaran"
        :value="$rupiah(
            $statistics['outstanding_amount'] ?? 0
        )"
        :description="sprintf(
            '%d Invoice belum lunas',
            $statistics['unpaid_count'] ?? 0
        )"
    >
        <x-slot:icon>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <circle
                    cx="12"
                    cy="12"
                    r="9"
                    stroke-width="2"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 7v5l3 2"
                />
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>

    {{-- Terbayar --}}
    <x-ui.stat-card
        title="Pembayaran Diterima"
        :value="$rupiah(
            $statistics['paid_amount'] ?? 0
        )"
        :description="sprintf(
            '%d Invoice telah lunas',
            $statistics['paid_count'] ?? 0
        )"
    >
        <x-slot:icon>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7"
                />
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>
</div>