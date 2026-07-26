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

        <a
            href="{{ route('owner.quotations.show', 1) }}"
            class="transition hover:text-blue-600"
        >
            QTN-2026-0001
        </a>

        <span class="mx-2">></span>

        <span class="font-medium text-gray-700">

            Delete

        </span>

    </div>

    {{-- Header --}}
    <x-ui.page-header
        title="Delete Quotation"
        description="Hapus quotation dari sistem. Tindakan ini tidak dapat dibatalkan."
    >

        <x-slot:actions>

            <div class="flex gap-3">

                <a
                    href="{{ route('owner.quotations.show', 1) }}"
                >

                    <x-ui.button
                        variant="secondary"
                    >

                        Cancel

                    </x-ui.button>

                </a>

                <x-ui.button
                    variant="danger"
                >

                    Delete

                </x-ui.button>

            </div>

        </x-slot:actions>

    </x-ui.page-header>

</div>