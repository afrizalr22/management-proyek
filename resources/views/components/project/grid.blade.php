<div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">

    <x-ui.project-card
        code="PRJ-001"
        name="Renovasi Kantor Cabang Medan"
        client="PT Maju Bersama"
        mandor="Ahmad Fauzi"
        progress="72"
        budget="Rp850.000.000"
        target="20 Desember 2026"
        status="Active"

        :showUrl="route('owner.projects.show',1)"
        :editUrl="route('owner.projects.edit',1)"

    />

    <x-ui.project-card
        code="PRJ-002"
        name="Pembangunan Gudang Logistik"
        client="PT Sumber Makmur"
        mandor="Ahmad"
        progress="38"
        budget="Rp1.200.000.000"
        target="15 Januari 2027"
        status="Pending"

        :showUrl="route('owner.projects.show',2)"
        :editUrl="route('owner.projects.edit',2)"
    />

    <x-ui.project-card
        code="PRJ-003"
        name="Renovasi Interior Kantor"
        client="PT Citra Abadi"
        mandor="Rudi"
        progress="100"
        budget="Rp450.000.000"
        target="10 Oktober 2026"
        status="Completed"

        :showUrl="route('owner.projects.show',3)"
        :editUrl="route('owner.projects.edit',3)"
    />

</div>