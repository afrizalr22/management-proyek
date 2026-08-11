<div class="space-y-6">

    {{-- Breadcrumb & Header --}}
    <x-invoice.invoice-show-header />

    {{-- Billing & Invoice Summary --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

        <x-invoice.invoice-show-billing />

        <x-invoice.invoice-show-summary />

    </div>

    {{-- Invoice Items --}}
    <x-invoice.invoice-show-items />

    {{-- Financial & Payment --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

        <x-invoice.invoice-show-total />

        <x-invoice.invoice-show-payment-status />

    </div>

</div>