<div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

    <x-ui.stat-card
        title="Total Client"
        value="15"
        description="Client aktif"
        trend="+2"
    >
        <x-slot:icon>
            <x-icon.client class="h-7 w-7"/>
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        title="Project Aktif"
        value="8"
        description="Sedang berjalan"
        trend="Aktif"
    >
        <x-slot:icon>
            <x-icon.project class="h-7 w-7"/>
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        title="Mandor"
        value="4"
        description="Semua aktif"
        trend="100%"
    >
        <x-slot:icon>
            <x-icon.users class="h-7 w-7"/>
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        title="Pekerja"
        value="28"
        description="24 hadir hari ini"
        trend="24"
    >
        <x-slot:icon>
            <x-icon.worker class="h-7 w-7"/>
        </x-slot:icon>
    </x-ui.stat-card>

</div>