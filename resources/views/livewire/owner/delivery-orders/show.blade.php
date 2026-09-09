<div class="space-y-6">
    {{-- Header --}}
    <x-delivery-order.delivery-order-show-header
        :delivery-order="$deliveryOrder"
    />
    {{-- Kesalahan perubahan status --}}
@error('statusAction')
    <div
        class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
        role="alert"
    >
        {{ $message }}
    </div>
@enderror

    {{-- Notifikasi --}}
    @if (session()->has('notification'))
        @php
            $notification = session('notification');

            $notificationType =
                $notification['type']
                ?? 'success';

            $notificationClasses = match (
                $notificationType
            ) {
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
                    ?? 'Surat Jalan berhasil diperbarui.' }}
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

    {{-- Informasi pengiriman dan Project --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <x-delivery-order.delivery-order-show-information
            :delivery-order="$deliveryOrder"
        />

        <x-delivery-order.delivery-order-show-project
            :delivery-order="$deliveryOrder"
        />
    </div>

    {{-- Item --}}
    <x-delivery-order.delivery-order-show-items
        :items="$deliveryOrder->items"
    />

    {{-- Catatan --}}
    <x-delivery-order.delivery-order-show-notes
        :delivery-order="$deliveryOrder"
    />
</div>