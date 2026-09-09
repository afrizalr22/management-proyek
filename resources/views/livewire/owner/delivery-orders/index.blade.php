<div class="space-y-6">
    <x-ui.page-header
        title="Surat Jalan"
        description="Kelola dan pantau pengiriman barang untuk setiap Project."
    >
        <x-slot:actions>
            @can('create delivery orders')
                <a
                    href="{{ route(
                        'owner.delivery-orders.create'
                    ) }}"
                    wire:navigate
                >
                    <x-ui.button variant="primary">
                        Buat Surat Jalan
                    </x-ui.button>
                </a>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    @if (session()->has('notification'))
        @php
            $notification = session('notification');

            $notificationType =
                $notification['type']
                ?? 'success';

            $notificationClasses =
                match ($notificationType) {
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
                    ?? 'Data Surat Jalan berhasil diproses.' }}
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

    <x-delivery-order.delivery-order-statistics
        :statistics="$statistics"
    />

    <x-delivery-order.delivery-order-toolbar
        :search="$search"
        :status="$status"
        :sort="$sort"
    />

    <x-delivery-order.delivery-order-table
        :delivery-orders="$deliveryOrders"
    />

    {{-- Modal hapus --}}
<livewire:owner.delivery-orders.delete />
</div>