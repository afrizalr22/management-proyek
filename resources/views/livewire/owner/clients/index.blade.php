<div class="space-y-6">

    <x-ui.page-header
        title="Client Management"
        description="Kelola seluruh data client perusahaan."
    >
        <x-slot:actions>
            <a
                href="{{ route('owner.clients.create') }}"
                wire:navigate
            >
                <x-ui.button>
                    Tambah Client
                </x-ui.button>
            </a>
        </x-slot:actions>
    </x-ui.page-header>

    <x-client.toolbar
        :search="$search"
        :status="$status"
        :sort="$sort"
    />

    <x-client.table :clients="$clients" />

    <x-client.pagination :clients="$clients" />

    <livewire:owner.clients.delete />

</div>