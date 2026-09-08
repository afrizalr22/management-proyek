<div class="space-y-6">
    {{-- Header --}}
    <x-ui.page-header
        title="Invoice Management"
        description="Kelola dan pantau seluruh Invoice Project."
    >
        <x-slot:actions>
            @can('create invoices')
                <a
                    href="{{ route('owner.invoices.create') }}"
                    wire:navigate
                >
                    <x-ui.button variant="primary">
                        Buat Invoice
                    </x-ui.button>
                </a>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    {{-- Notifikasi --}}
    @if (session()->has('notification'))
        @php
            $notification = session('notification');
            $notificationType = $notification['type'] ?? 'success';

            $notificationClasses = match ($notificationType) {
                'delete' =>
                    'border-red-200 bg-red-50 text-red-700',
                'warning' =>
                    'border-amber-200 bg-amber-50 text-amber-700',
                'update' =>
                    'border-blue-200 bg-blue-50 text-blue-700',
                default =>
                    'border-green-200 bg-green-50 text-green-700',
            };
        @endphp

        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            x-transition.opacity.duration.300ms
            class="flex items-start justify-between gap-4 rounded-xl border px-4 py-3 text-sm {{ $notificationClasses }}"
            role="alert"
        >
            <span>
                {{ $notification['message']
                    ?? 'Data Invoice berhasil diproses.' }}
            </span>

            <button
                type="button"
                x-on:click="show = false"
                class="shrink-0 text-xl leading-none"
                aria-label="Tutup notifikasi"
            >
                &times;
            </button>
        </div>
    @endif

    {{-- Statistik --}}
    <x-invoice.invoice-statistics
        :statistics="$statistics"
    />

    {{-- Toolbar --}}
    <x-invoice.invoice-toolbar
        :search="$search"
        :status="$status"
        :payment-status="$paymentStatus"
        :sort="$sort"
    />

    {{-- Tabel --}}
    <x-invoice.invoice-table
        :invoices="$invoices"
    />

    {{-- Modal hapus --}}
    <livewire:owner.invoices.delete />
</div>