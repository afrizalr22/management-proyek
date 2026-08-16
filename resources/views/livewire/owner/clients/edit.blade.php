<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500">

        <a
            href="{{ route('owner.dashboard') }}"
            class="hover:text-blue-600"
        >
            Dashboard
        </a>

        <span class="mx-2">></span>

        <a
            href="{{ route('owner.clients.index') }}"
            class="hover:text-blue-600"
        >
            Clients
        </a>

        <span class="mx-2">></span>

        <span class="font-medium text-blue-600">
            Edit Client
        </span>

    </div>

    {{-- Header --}}
    <x-ui.page-header
        :title="$pageTitle"
        :description="$pageDescription"
    >

        <x-slot:actions>

            <div class="flex gap-3">

                <a href="{{ route('owner.clients.index') }}">

                    <x-ui.button variant="outline">

                        Batal

                    </x-ui.button>

                </a>

                <x-ui.button variant="success">

                    {{ $buttonText }}

                </x-ui.button>

            </div>

        </x-slot:actions>

    </x-ui.page-header>

    {{-- Form --}}
    <x-client.form />

    {{-- Information --}}
    <x-client.information />

</div>