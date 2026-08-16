<div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

    <div>

        <nav class="mb-3 flex items-center gap-2 text-sm text-gray-500">

            <a href="{{ route('owner.dashboard') }}"
                class="hover:text-blue-600">

                Dashboard

            </a>

            <span>/</span>

            <a href="{{ route('owner.users.index') }}"
                class="hover:text-blue-600">

                User Management

            </a>

            <span>/</span>

            <span class="font-medium text-gray-700">

                Edit User

            </span>

        </nav>

        <div class="flex items-center gap-4">

            <h1 class="text-4xl font-bold text-gray-800">

                Edit User

            </h1>

            <span class="rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">

                Active

            </span>

        </div>

        <p class="mt-2 text-gray-500">

            Perbarui informasi akun pengguna.

        </p>

    </div>

    <div class="flex gap-3">

    <a href="{{ route('owner.users.index') }}">
        <x-ui.button
            variant="outline"
            :href="route('owner.users.index')">

            Batal

        </x-ui.button>
        </a>

        <x-ui.button variant="success">

            Simpan Perubahan

        </x-ui.button>

    </div>

</div>