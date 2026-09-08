<div class="space-y-6">
    {{-- Header --}}
    <x-invoice.invoice-show-header
        :invoice="$invoice"
    />

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
                    ?? 'Invoice berhasil diperbarui.' }}
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

    {{-- Informasi Client dan Invoice --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <x-invoice.invoice-show-billing
            :invoice="$invoice"
        />

        <x-invoice.invoice-show-summary
            :invoice="$invoice"
        />
    </div>

    {{-- Item Invoice --}}
    <x-invoice.invoice-show-items
        :invoice="$invoice"
        :items="$invoice->items"
    />

    {{-- Total dan pembayaran --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <x-invoice.invoice-show-total
            :invoice="$invoice"
            :items="$invoice->items"
        />

        <x-invoice.invoice-show-payment-status
            :invoice="$invoice"
        />
    </div>

    {{-- Catatan --}}
    <x-invoice.invoice-notes
        :invoice="$invoice"
    />

    {{-- Dokumen terkait --}}
    <x-invoice.invoice-related-documents
        :invoice="$invoice"
    />
</div>