<div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

    <x-ui.stat-card
        title="Active Workers"
        value="15"
        description="Workers aktif"
        trend="+2"
    >
        <x-slot:icon>
            <x-icon.client class="h-7 w-7"/>
        </x-slot:icon>
        </x-ui.stat-card>

    <x-ui.stat-card
        title="Today's Tasks"
        value="8"
        description="Tasks berjalan"
        trend="Aktif"
    >
        <x-slot:icon>
            <x-icon.project class="h-7 w-7"/>
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        title="Daily Reports"
        value="4"
        description="Daily reports"
        trend="100%"
    >
        <x-slot:icon>
            <x-icon.users class="h-7 w-7"/>
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        title="Safety alert"
        value="28"
        description="Safety alerts"
        trend="24"
    >
        <x-slot:icon>
            <x-icon.worker class="h-7 w-7"/>
        </x-slot:icon>
    </x-ui.stat-card>

</div>