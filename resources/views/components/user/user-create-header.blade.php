<x-ui.info-card>

    <div class="flex flex-col gap-6 p-8 lg:flex-row lg:items-center lg:justify-between">

        <div>

            {{-- Breadcrumb --}}
            <div class="mb-3 flex items-center gap-2 text-sm text-gray-500">

                <a
                    href="{{ route('owner.dashboard') }}"
                    class="transition hover:text-blue-600"
                >
                    Dashboard
                </a>

                <span>/</span>

                <a
                    href="{{ route('owner.users.index') }}"
                    class="transition hover:text-blue-600"
                >
                    User Management
                </a>

                <span>/</span>

                <span class="font-medium text-blue-600">

                    Create User

                </span>

            </div>

            <h1 class="text-4xl font-bold text-gray-800">

                Create New User

            </h1>

            <p class="mt-2 text-gray-500">

                Tambahkan pengguna baru ke dalam sistem manajemen proyek dan tentukan hak aksesnya.

            </p>

        </div>

        <div class="flex items-center gap-3">

            <a href="{{ route('owner.users.index') }}">

                    <x-ui.button variant="danger">

                        Batal

                    </x-ui.button>

                </a>

            <x-ui.button>

                Save User

            </x-ui.button>

        </div>

    </div>

</x-ui.info-card>