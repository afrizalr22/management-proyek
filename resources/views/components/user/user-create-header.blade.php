<x-ui.info-card>
    <div class="flex flex-col gap-6 p-5 sm:p-6 lg:flex-row lg:items-center lg:justify-between lg:p-8">
        <div>
            <nav class="mb-3 flex flex-wrap items-center gap-2 text-sm text-gray-500">
                <a
                    href="{{ route('owner.dashboard') }}"
                    wire:navigate
                    class="transition hover:text-blue-600"
                >
                    Dashboard
                </a>

                <span>/</span>

                <a
                    href="{{ route('owner.users.index') }}"
                    wire:navigate
                    class="transition hover:text-blue-600"
                >
                    User Management
                </a>

                <span>/</span>

                <span class="font-medium text-blue-600">
                    Tambah Pengguna
                </span>
            </nav>

            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                Tambah Pengguna Baru
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500 sm:text-base">
                Tambahkan akun baru dan tentukan aksesnya dalam sistem manajemen proyek.
            </p>
        </div>

        <div class="flex shrink-0 flex-col-reverse gap-3 sm:flex-row">
            <a
                href="{{ route('owner.users.index') }}"
                wire:navigate
                class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
            >
                Batal
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="createUser"
                class="inline-flex min-h-11 items-center justify-center rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span
                    wire:loading.remove
                    wire:target="createUser"
                >
                    Save User
                </span>

                <span
                    wire:loading
                    wire:target="createUser"
                >
                    Menyimpan...
                </span>
            </button>
        </div>
    </div>
</x-ui.info-card>