@props([
    'statistics',
])

@php
    $formatCurrency = static function (
        mixed $amount
    ): string {
        $amount = (float) $amount;

        if ($amount >= 1000000000) {
            return 'Rp '.number_format(
                $amount / 1000000000,
                1,
                ',',
                '.'
            ).' M';
        }

        if ($amount >= 1000000) {
            return 'Rp '.number_format(
                $amount / 1000000,
                1,
                ',',
                '.'
            ).' Jt';
        }

        return 'Rp '.number_format(
            $amount,
            0,
            ',',
            '.'
        );
    };
@endphp

<div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
    {{-- Client Aktif --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between gap-4 p-6">
            <div class="min-w-0">
                <p class="text-sm font-medium text-gray-500">
                    Total Client
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $statistics['total_clients'] }}
                </p>

                <p class="mt-3 text-sm text-gray-500">
                    {{ $statistics['active_clients'] }}
                    Client aktif
                </p>
            </div>

            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                <x-icon.client class="h-7 w-7" />
            </div>
        </div>
    </x-ui.info-card>

    {{-- Project Aktif --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between gap-4 p-6">
            <div class="min-w-0">
                <p class="text-sm font-medium text-gray-500">
                    Project Aktif
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $statistics['active_projects'] }}
                </p>

                <p class="mt-3 text-sm text-gray-500">
                    Dari
                    {{ $statistics['total_projects'] }}
                    total Project
                </p>
            </div>

            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                <x-icon.project class="h-7 w-7" />
            </div>
        </div>
    </x-ui.info-card>

    {{-- Nilai Invoice --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between gap-4 p-6">
            <div class="min-w-0">
                <p class="text-sm font-medium text-gray-500">
                    Nilai Invoice
                </p>

                <p
                    class="mt-2 truncate text-2xl font-bold text-gray-900"
                    title="Rp {{ number_format(
                        $statistics['invoice_grand_total'],
                        0,
                        ',',
                        '.'
                    ) }}"
                >
                    {{ $formatCurrency(
                        $statistics['invoice_grand_total']
                    ) }}
                </p>

                <p class="mt-3 text-sm text-gray-500">
                    {{ $statistics['total_invoices'] }}
                    Invoice aktif
                </p>
            </div>

            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-purple-100 text-purple-600">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-7 w-7"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 14.25 11.25 16.5 15 12.75m-6.75-9h7.5A2.25 2.25 0 0 1 18 6v12a2.25 2.25 0 0 1-2.25 2.25h-7.5A2.25 2.25 0 0 1 6 18V6a2.25 2.25 0 0 1 2.25-2.25Z"
                    />
                </svg>
            </div>
        </div>
    </x-ui.info-card>

    {{-- Sisa Tagihan --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between gap-4 p-6">
            <div class="min-w-0">
                <p class="text-sm font-medium text-gray-500">
                    Sisa Tagihan
                </p>

                <p
                    @class([
                        'mt-2 truncate text-2xl font-bold',
                        'text-red-600' =>
                            $statistics['outstanding_amount'] > 0,
                        'text-green-600' =>
                            $statistics['outstanding_amount'] <= 0,
                    ])
                    title="Rp {{ number_format(
                        $statistics['outstanding_amount'],
                        0,
                        ',',
                        '.'
                    ) }}"
                >
                    {{ $formatCurrency(
                        $statistics['outstanding_amount']
                    ) }}
                </p>

                <p class="mt-3 text-sm text-gray-500">
                    {{ $statistics['unpaid_invoices'] }}
                    Invoice belum lunas
                </p>
            </div>

            <div
                @class([
                    'flex h-12 w-12 shrink-0 items-center justify-center rounded-xl',
                    'bg-red-100 text-red-600' =>
                        $statistics['outstanding_amount'] > 0,
                    'bg-green-100 text-green-600' =>
                        $statistics['outstanding_amount'] <= 0,
                ])
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-7 w-7"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125h17.25c.621 0 1.125.504 1.125 1.125V6m-19.5 0v9m19.5-9v9m0 0v.75c0 .621-.504 1.125-1.125 1.125H3.375A1.125 1.125 0 0 1 2.25 15.75V15m19.5 0H21a.75.75 0 0 0-.75.75v.75M3.75 15H3a.75.75 0 0 1-.75-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                    />
                </svg>
            </div>
        </div>
    </x-ui.info-card>
</div>