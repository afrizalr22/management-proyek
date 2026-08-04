<div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

    <div>

        <nav class="mb-3 flex items-center gap-2 text-sm text-gray-500">

            <a
                href="{{ route('owner.dashboard') }}"
                class="hover:text-blue-600">

                Dashboard

            </a>

            <span>/</span>

            <a
                href="{{ route('owner.users.index') }}"
                class="hover:text-blue-600">

                User Management

            </a>

            <span>/</span>

            <span class="font-medium text-gray-700">

                Detail User

            </span>

        </nav>

        <div class="flex items-center gap-4">

            <h1 class="text-4xl font-bold text-gray-800">

                Ahmad Subarjo

            </h1>

            <span
                class="rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">

                Active

            </span>

        </div>

        <div class="mt-3 flex flex-wrap items-center gap-4 text-gray-500">

            <span>

                Mandor

            </span>

            <span>

                •

            </span>

            <span>

                Bergabung 27 Juli 2026

            </span>

        </div>

    </div>

    <div class="flex gap-3">

        <x-ui.button
            variant="outline"
            :href="route('owner.users.index')">

            Kembali

        </x-ui.button>

        <x-ui.button
            :href="route('owner.users.edit',1)">

            Edit User

        </x-ui.button>

    </div>

</div>