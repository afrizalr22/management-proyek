<x-ui.info-card>

    <div class="flex flex-col gap-6 p-8 lg:flex-row lg:items-center lg:justify-between">

        {{-- Header Information --}}
        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                User Management
            </h1>

            <p class="mt-2 max-w-2xl text-gray-500">
                Kelola akun pengguna, hak akses, dan peran pengguna
                dalam sistem manajemen proyek konstruksi.
            </p>

        </div>


        {{-- Action --}}
        <div class="shrink-0">

            <a
                href="{{ route('owner.users.create') }}"
            >

                <x-ui.button variant="primary">

                    + Create User

                </x-ui.button>

            </a>

        </div>

    </div>

</x-ui.info-card>