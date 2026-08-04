<div class="space-y-6">

    {{-- Header --}}
    <x-ui.page-header
        title="Quotation Management"
        description="Kelola seluruh quotation proyek konstruksi perusahaan."
    >

        <x-slot:actions>

            <a href="{{ route('owner.quotations.create') }}">

                <x-ui.button>

                    Create Quotation

                </x-ui.button>

            </a>

        </x-slot:actions>

    </x-ui.page-header>

    {{-- Statistics --}}
    <x-quotation.quotation-statistics />

    {{-- Toolbar --}}
    <x-quotation.quotation-toolbar />

    {{-- Table --}}
    <x-quotation.quotation-table />

</div>