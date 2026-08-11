<div class="space-y-6">

    {{-- Header --}}
    <x-ui.page-header
        title="Invoice Management"
        description="Kelola dan pantau seluruh invoice proyek konstruksi."
    >

        <x-slot:actions>

            <a href="{{ route('owner.invoices.create') }}">

                <x-ui.button>

                    + Create Invoice

                </x-ui.button>

            </a>

        </x-slot:actions>

    </x-ui.page-header>

    {{-- Statistics --}}
    <x-invoice.invoice-statistics />

    {{-- Toolbar --}}
    <x-invoice.invoice-toolbar />

    {{-- Table --}}
    <x-invoice.invoice-table />

    <livewire:owner.invoices.delete />

</div>