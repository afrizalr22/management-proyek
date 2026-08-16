<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500">

        <a
            href="{{ route('owner.clients.index') }}"
            class="hover:text-blue-600"
        >
            Clients
        </a>

        <span class="mx-2">></span>

        <span class="font-medium text-gray-700">
            Budi Santoso
        </span>

    </div>

    {{-- Header --}}
    <x-ui.page-header
        title="Detail Client"
        description="Informasi lengkap client."
    >

        <x-slot:actions>

            <div class="flex gap-3">

            <a href="{{ route('owner.clients.index') }}">

                    <x-ui.button variant="outline">
                        Kembali
                    </x-ui.button>

                </a>

                <a href="{{ route('owner.clients.edit',1) }}">

                    <x-ui.button variant="warning">
                        Ubah Data
                    </x-ui.button>

                </a>

            </div>

        </x-slot:actions>

    </x-ui.page-header>

    <x-client.detail-information />

    <x-client.recent-project />

</div>