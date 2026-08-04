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

    {{-- Summary --}}
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4"> 

        <x-ui.stat-card
            title="Total Project"
            value="28"
        />

        <x-ui.stat-card
            title="Project Berjalan"
            value="12"
        />

        <x-ui.stat-card
            title="Project Selesai"
            value="16"
        />

        <x-ui.stat-card
            title="Total Nilai"
            value="Rp5,4 M"
        />

    </div>

    {{-- Toolbar --}}
    <x-ui.toolbar>

        <div class="grid gap-4 lg:grid-cols-4">

            <input
                type="text"
                placeholder="Cari Project..."
                class="rounded-xl border-gray-300"
            >

            <select class="rounded-xl border-gray-300">

                <option>Status</option>

            </select>

            <select class="rounded-xl border-gray-300">

                <option>Client</option>

            </select>

            <select class="rounded-xl border-gray-300">

                <option>Mandor</option>

            </select>

        </div>

    </x-ui.toolbar>

    {{-- Card Grid --}}
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        <!-- ini ui yang akan diimplementasikan ketika masuk ke dalam database -->
        <x-ui.project-card 
            code="PRJ-001"
            name="Renovasi Kantor Cabang Medan"
            client="PT Maju Bersama"
            mandor="Ahmad Fauzi"
            progress="72"
            budget="Rp850.000.000"
            target="20 Desember 2026"
            status="Active"

            :showUrl="route('owner.projects.show', 1)"
            :editUrl="route('owner.projects.edit', 1)"
            :deleteUrl="route('owner.projects.delete', 1)"
        />

        <x-ui.project-card
            code="PRJ-002"
            name="Pembangunan Gudang Logistik"
            type="Gudang"
            client="PT Sumber Makmur"
            mandor="Ahmad"
            progress="38"
            budget="Rp1.200.000.000"
            target="15 Januari 2027"
            status="Pending"

            :showUrl="route('owner.projects.show', 2)"
            :editUrl="route('owner.projects.edit', 2)"
            :deleteUrl="route('owner.projects.delete', 2)"
        />

        <x-ui.project-card
            code="PRJ-003"
            name="Renovasi Interior Kantor"
            type="Interior"
            client="PT Citra Abadi"
            mandor="Rudi"
            progress="100"
            budget="Rp450.000.000"
            target="10 Oktober 2026"
            status="Completed"
            
            :showUrl="route('owner.projects.show', 3)"
            :editUrl="route('owner.projects.edit', 3)"
            :deleteUrl="route('owner.projects.delete', 3)"
        />

    </div>

</div>