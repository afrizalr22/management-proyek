<div class="space-y-6">

    <x-ui.page-header
        title="Project Monitoring"
        description="Monitor perkembangan seluruh proyek konstruksi perusahaan."
    >   

    </x-ui.page-header>

    <x-monitoring.monitoring-statistics />

    <x-monitoring.monitoring-toolbar />

    <div class="grid gap-6 xl:grid-cols-2">

       <x-monitoring.monitoring-card
            project="Pembangunan Gudang"
            client="PT Maju Bersama"
            mandor="Ahmad"
            location="Jakarta Selatan"
            phase="Pekerjaan Struktur"
            progress="75"
            deadline="30 September 2026"
            status="On Progress"
            issues="2"
            photos="58"
            reports="24"
            :href="route('owner.monitoring.show',1)"
        />

        <x-monitoring.monitoring-card
            project="Renovasi Kantor"
            client="PT Nusantara"
            mandor="Budi"
            phase="Pondasi"
            progress="40"
            deadline="10 Oktober 2026"
            status="Delayed"
            issues="5"
            photos="30"
            reports="12"
            :href="route('owner.monitoring.show',2)"
        />

    </div>

    <x-monitoring.monitoring-pagination />

</div>