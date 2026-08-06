<div class="space-y-6">

    <x-ui.page-header
        title="Project Management"
        description="Kelola seluruh proyek konstruksi perusahaan."
    >

        <x-slot:actions>

            <a href="{{ route('owner.projects.create') }}">

                <x-ui.button>

                    Tambah Project

                </x-ui.button>

            </a>

        </x-slot:actions>

    </x-ui.page-header>

    <x-project.toolbar />

    <x-project.grid />

    <livewire:owner.projects.delete />

</div>