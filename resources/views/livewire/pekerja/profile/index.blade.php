<div class="space-y-6">
    {{-- Page header --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
            Profil Saya
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Lihat dan kelola informasi profil serta akun Anda.
        </p>
    </div>

    {{-- Identitas pekerja --}}
    <x-pekerja.profile.profile-header
        name="Budi Santoso"
        worker-id="PKR-2026-001"
        role="Pekerja Lapangan"
        specialization="Teknisi Instalasi Listrik"
    />

    {{-- Ringkasan profil --}}
    <x-pekerja.profile.profile-summary
        worker-status="Aktif"
        :active-projects="1"
    />

    {{-- Informasi pekerjaan dan kontak --}}
    <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-2">
        <x-pekerja.profile.work-information
            project-name="Pembangunan Gedung Perkantoran Sudirman"
            project-location="Jakarta Selatan"
            supervisor-name="Agus Hermawan"
            joined-date="10 Januari 2026"
            assignment-status="Sedang Bertugas"
        />

        <x-pekerja.profile.contact-information
            email="budi.santoso@example.com"
            phone="0812-3456-7890"
            address="Jl. Kebagusan Raya, Pasar Minggu, Jakarta Selatan"
        />
    </div>

    {{-- Kontak darurat dan pengaturan akun --}}
    <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-2">
        <x-pekerja.profile.emergency-contact
            primary-name="Siti Aminah"
            primary-relation="Istri"
            primary-phone="0812-3456-7890"
            secondary-name="Andi Santoso"
            secondary-relation="Saudara"
            secondary-phone="0812-9876-5432"
        />

        <x-pekerja.profile.account-settings />
    </div>
</div>