<x-ui.info-card>

    <div class="p-6">

        {{-- Breadcrumb --}}
        <div class="text-sm text-gray-500">

            <a
                href="{{ route('owner.invoices.index') }}"
                class="transition hover:text-blue-600"
            >
                Invoice Management
            </a>

            <span class="mx-2">></span>

            <span class="font-medium text-gray-700">
                INV-2026-0001
            </span>

        </div>

        {{-- Header --}}
        <div class="mt-6 flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">

            {{-- Invoice Information --}}
            <div>

                <div class="flex flex-wrap items-center gap-3">

                    <h1 class="text-3xl font-bold text-gray-900">
                        INV-2026-0001
                    </h1>

                    <x-ui.badge color="yellow">
                        Unpaid
                    </x-ui.badge>

                </div>

                <p class="mt-2 text-gray-500">
                    Invoice pekerjaan pembangunan Gudang Logistik Tahap II.
                </p>

                <div class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-sm text-gray-500">

                    <span>
                        Invoice Date:
                        <span class="font-medium text-gray-700">
                            12 Oktober 2026
                        </span>
                    </span>

                    <span>
                        Due Date:
                        <span class="font-medium text-gray-700">
                            26 Oktober 2026
                        </span>
                    </span>

                </div>

            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap gap-3">

                <a
                    href="{{ route('owner.invoices.index') }}"
                >

                    <x-ui.button variant="secondary">
                        Kembali
                    </x-ui.button>

                </a>

                <a
                    href="{{ route('owner.invoices.edit', 1) }}"
                >

                    <x-ui.button variant="secondary">
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

</x-ui.info-card>