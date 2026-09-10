@props([
    'summary',
])

@php
    $totalAttention =
        $summary['delayed_projects']
        + $summary['overdue_invoices']
        + $summary['project_issues']
        + $summary['pending_delivery_orders'];
@endphp

<div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">
                Perlu Perhatian
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Ringkasan kondisi yang perlu diperiksa oleh Owner.
            </p>
        </div>

        <x-ui.badge
            :color="$totalAttention > 0
                ? 'red'
                : 'green'"
        >
            {{ $totalAttention }}
            Perhatian
        </x-ui.badge>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <a
            href="{{ route('owner.monitoring.index', [
                'status' => 'delayed',
            ]) }}"
            wire:navigate
            class="group rounded-2xl border border-red-100 bg-red-50 p-5 transition hover:border-red-200 hover:shadow-sm"
        >
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-red-700">
                        Project Terlambat
                    </p>

                    <p class="mt-2 text-3xl font-bold text-red-700">
                        {{ $summary['delayed_projects'] }}
                    </p>
                </div>

                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-100 text-red-600">
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
                            d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"
                        />
                    </svg>
                </span>
            </div>

            <p class="mt-3 text-xs text-red-600">
                Lihat Project
            </p>
        </a>

        <a
            href="{{ route('owner.invoices.index') }}"
            wire:navigate
            class="group rounded-2xl border border-orange-100 bg-orange-50 p-5 transition hover:border-orange-200 hover:shadow-sm"
        >
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-orange-700">
                        Invoice Jatuh Tempo
                    </p>

                    <p class="mt-2 text-3xl font-bold text-orange-700">
                        {{ $summary['overdue_invoices'] }}
                    </p>
                </div>

                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-100 text-orange-600">
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
                            d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>
                </span>
            </div>

            <p class="mt-3 text-xs text-orange-600">
                Lihat Invoice
            </p>
        </a>

        <a
            href="{{ route('owner.monitoring.index') }}"
            wire:navigate
            class="group rounded-2xl border border-amber-100 bg-amber-50 p-5 transition hover:border-amber-200 hover:shadow-sm"
        >
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-amber-700">
                        Kendala Project
                    </p>

                    <p class="mt-2 text-3xl font-bold text-amber-700">
                        {{ $summary['project_issues'] }}
                    </p>
                </div>

                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
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
                            d="M11.25 11.25 12 10.5m0 0 .75.75M12 10.5v4.125m8.25-2.625a8.25 8.25 0 1 1-16.5 0 8.25 8.25 0 0 1 16.5 0Z"
                        />
                    </svg>
                </span>
            </div>

            <p class="mt-3 text-xs text-amber-600">
                Lihat Monitoring
            </p>
        </a>

        <a
            href="{{ route('owner.delivery-orders.index') }}"
            wire:navigate
            class="group rounded-2xl border border-blue-100 bg-blue-50 p-5 transition hover:border-blue-200 hover:shadow-sm"
        >
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-blue-700">
                        Surat Jalan Tertunda
                    </p>

                    <p class="mt-2 text-3xl font-bold text-blue-700">
                        {{ $summary['pending_delivery_orders'] }}
                    </p>
                </div>

                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
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
                            d="M8.25 18.75a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6.75m-9.75 0H3.75V6.75A2.25 2.25 0 0 1 6 4.5h7.5v14.25m1.5 0a1.5 1.5 0 1 0 3 0m-3 0a1.5 1.5 0 0 1 3 0m0 0h2.25v-6.75l-3-3H13.5"
                        />
                    </svg>
                </span>
            </div>

            <p class="mt-3 text-xs text-blue-600">
                Lihat Surat Jalan
            </p>
        </a>
    </div>
</div>