<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500">

        <a
            href="{{ route('owner.quotations.index') }}"
            class="transition hover:text-blue-600"
        >
            Quotation Management
        </a>    

        <span class="mx-2">></span>

        <span class="font-medium text-gray-700">

            Edit Quotation

        </span>

    </div>

    {{-- Header --}}
    <x-ui.page-header
        title="Edit Quotation"
        description="Perbarui informasi quotation yang telah dibuat."
    >

        <x-slot:actions>

            <div class="flex gap-3">

                <a
                    href="{{ route('owner.quotations.index') }}"
                >

                    <x-ui.button
                        variant="outline"
                    >

                        Batal

                    </x-ui.button>

                </a>

                <x-ui.button>

                    Update Quotation

                </x-ui.button>

            </div>

        </x-slot:actions>

    </x-ui.page-header>

    {{-- Content --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Left --}}
        <div class="space-y-6 xl:col-span-2">

            <x-quotation.quotation-general-information />

            <x-quotation.quotation-items/>

        </div>

        {{-- Right --}}
        <div class="space-y-6">

            <x-quotation.quotation-summary />

            <x-quotation.quotation-preview  />

        </div>

    </div>

</div>