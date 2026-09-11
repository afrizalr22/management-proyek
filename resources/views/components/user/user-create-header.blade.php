<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">
        <nav
            class="mb-3 flex flex-wrap items-center gap-2 text-sm text-gray-500"
            aria-label="Breadcrumb"
        >
            <a
                href="{{ route('owner.dashboard') }}"
                wire:navigate
                class="transition hover:text-blue-600"
            >
                Dashboard
            </a>

            <span aria-hidden="true">/</span>

            <a
                href="{{ route('owner.users.index') }}"
                wire:navigate
                class="transition hover:text-blue-600"
            >
                User Management
            </a>

            <span aria-hidden="true">/</span>

            <span class="font-medium text-blue-600">
                Tambah Pengguna
            </span>
        </nav>

        <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
            Tambah Pengguna Baru
        </h1>

        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500 sm:text-base">
            Tambahkan akun baru dan tentukan aksesnya dalam sistem
            manajemen proyek.
        </p>
    </div>
</x-ui.info-card>