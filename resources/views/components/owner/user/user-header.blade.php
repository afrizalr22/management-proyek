<x-ui.info-card>
    <div class="flex flex-col gap-6 p-5 sm:p-6 lg:flex-row lg:items-center lg:justify-between lg:p-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                User Management
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500 sm:text-base">
                Kelola akun, status, hak akses, dan peran pengguna dalam sistem manajemen proyek.
            </p>
        </div>

        <div class="shrink-0">
            <a
                href="{{ route('owner.users.create') }}"
                wire:navigate
            >
                <x-ui.button variant="primary">
                    Tambah Pengguna
                </x-ui.button>
            </a>
        </div>
    </div>
</x-ui.info-card>