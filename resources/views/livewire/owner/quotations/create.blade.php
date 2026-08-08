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
            {{ $pageTitle }}
        </span>

    </div>

    {{-- Header --}}
    <x-ui.page-header
        :title="$pageTitle"
        :description="$pageDescription"
    >

        <x-slot:actions>

            <div class="flex gap-3">

                {{-- Cancel --}}
                <a href="{{ route('owner.quotations.index') }}">

                    <x-ui.button
                        variant="outline"
                    >
                        Batal
                    </x-ui.button>

                </a>

                {{-- Submit --}}
                <x-ui.button>

                    {{ $buttonText }}

                </x-ui.button>

            </div>

        </x-slot:actions>

    </x-ui.page-header>

    {{-- Content --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Left Side --}}
        <div class="space-y-6 xl:col-span-2">

            {{-- General Information --}}
            <x-quotation.quotation-general-information />

            {{-- Items --}}
            <x-quotation.quotation-items />

            {{-- Notes --}}
            <x-quotation.quotation-notes />

        </div>

        {{-- Right Side --}}
        <div class="space-y-6">

            {{-- Sidebar --}}
            <x-quotation.quotation-sidebar />

            {{-- Summary --}}
            <x-quotation.quotation-summary />

            {{-- Preview --}}
            <x-quotation.quotation-preview />

        </div>

    </div>

</div>