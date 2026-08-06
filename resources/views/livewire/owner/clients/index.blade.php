<div class="space-y-6">

    <x-ui.page-header
        title="Client Management"
        description="Kelola seluruh data client perusahaan."
    >

        <x-slot:actions>

            <a href="{{ route('owner.clients.create') }}">
                <x-ui.button>
                    Tambah Client
                </x-ui.button>
            </a>

        </x-slot:actions>

    </x-ui.page-header>

    <x-client.toolbar />

    <x-client.table />

    <x-client.pagination />

    <livewire:owner.clients.delete />

</div>