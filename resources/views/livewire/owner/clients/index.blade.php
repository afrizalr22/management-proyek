<div class="space-y-6">

    <x-ui.page-header
        title="Client Management"
        description="Kelola seluruh data client perusahaan."
    >

        <x-slot:actions>

            <a href="{{ route('owner.clients.create') }}">

                <x-ui.button>

                    Tambah Client

                </x-ui.button>

            </a>

        </x-slot:actions>

    </x-ui.page-header>

    {{-- Toolbar --}}
    <x-ui.toolbar>

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <input
                type="text"
                placeholder="Cari Client..."
                class="w-full md:w-80 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
            >

            <select
                class="rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
            >
                <option>Semua Status</option>
                <option>Active</option>
                <option>Inactive</option>
            </select>

        </div>

    </x-ui.toolbar>

    {{-- Table --}}
    <x-ui.table>

        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">

                <tr>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">No</th>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Client</th>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Company</th>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">City</th>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Phone</th>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Status</th>

                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase">Action</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">

                {{-- Row 1 --}}
                <tr>

                    <td class="px-6 py-4">1</td>

                    <td class="px-6 py-4 font-medium">Ahmad</td>

                    <td class="px-6 py-4">PT ABC</td>

                    <td class="px-6 py-4">Medan</td>

                    <td class="px-6 py-4">081234567890</td>

                    <td class="px-6 py-4">

                        <x-ui.badge color="green">
                            Active
                        </x-ui.badge>

                    </td>

                    <td class="px-6 py-4">

                        <div class="flex items-center justify-center gap-2">

                            <x-ui.icon-button-view
                                :href="route('owner.clients.show', 1)"
                            />

                            <x-ui.icon-button-edit
                                :href="route('owner.clients.edit', 1)"
                            />

                            <x-ui.icon-button-delete 
                                :href="route('owner.clients.delete', 1)"
                            />

                        </div>

                    </td>

                </tr>

                {{-- Row 2 --}}
                <tr>

                    <td class="px-6 py-4">2</td>

                    <td class="px-6 py-4 font-medium">Budi</td>

                    <td class="px-6 py-4">PT XYZ</td>

                    <td class="px-6 py-4">Aceh</td>

                    <td class="px-6 py-4">081398765432</td>

                    <td class="px-6 py-4">

                        <x-ui.badge color="green">
                            Active
                        </x-ui.badge>

                    </td>

                    <td class="px-6 py-4">

                    <div class="flex items-center justify-center gap-2">

                            <x-ui.icon-button-view
                                :href="route('owner.clients.show', 2)"
                            />

                            <x-ui.icon-button-edit
                                :href="route('owner.clients.edit', 2)"
                            />

                            <x-ui.icon-button-delete 
                                :href="route('owner.clients.delete', 2)"
                            />

                        </div>

                    </td>

                </tr>

                {{-- Row 3 --}}
                <tr>

                    <td class="px-6 py-4">3</td>

                    <td class="px-6 py-4 font-medium">Andi</td>

                    <td class="px-6 py-4">PT DEF</td>

                    <td class="px-6 py-4">Jakarta</td>

                    <td class="px-6 py-4">081567890123</td>

                    <td class="px-6 py-4">

                        <x-ui.badge color="red">
                            Inactive
                        </x-ui.badge>

                    </td>

                   <td class="px-6 py-4">

                    <div class="flex items-center justify-center gap-2">

                            <x-ui.icon-button-view
                                :href="route('owner.clients.show', 3)"
                            />

                            <x-ui.icon-button-edit
                                :href="route('owner.clients.edit', 3)"
                            />

                            <x-ui.icon-button-delete 
                                :href="route('owner.clients.delete', 3)"
                            />

                        </div>

                    </td>

                </tr>

            </tbody>

        </table>

    </x-ui.table>

    <div class="flex items-center justify-between text-sm text-gray-500">

        <p>
            Showing 1 - 3 of 3 Clients
        </p>

        <div class="flex gap-2">

            <button class="rounded-lg border px-3 py-1">
                Previous
            </button>

            <button class="rounded-lg border bg-blue-600 px-3 py-1 text-white">
                1
            </button>

            <button class="rounded-lg border px-3 py-1">
                Next
            </button>

        </div>

    </div>

</div>