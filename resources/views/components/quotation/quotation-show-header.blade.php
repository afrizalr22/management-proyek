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

            QTN-2026-0001

        </span>

    </div>

    {{-- Header --}}
    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">

        <div>

            <div class="flex items-center gap-3">

                <h1 class="text-3xl font-bold text-gray-900">

                    QTN-2026-0001

                </h1>

                <x-ui.badge color="green">

                    Approved

                </x-ui.badge>

            </div>

            <p class="mt-2 text-gray-500">

                Detail quotation proyek pembangunan gudang logistik.

            </p>

        </div>

        {{-- Action --}}
        <div class="flex flex-wrap gap-3">

            <a href="{{ route('owner.quotations.index') }}">

                <x-ui.button variant="secondary">

                    Kembali

                </x-ui.button>

            </a>

            <a href="{{ route('owner.quotations.edit',1) }}">

                <x-ui.button>

                    Edit

                </x-ui.button>

            </a>
            <x-ui.button variant="secondary">

                Print PDF

            </x-ui.button>

            <x-ui.button variant="secondary">

                Download PDF

            </x-ui.button>

        </div>

    </div>

</div>