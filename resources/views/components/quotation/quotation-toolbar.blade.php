<x-ui.toolbar>

    <x-slot:left>

        {{-- Search --}}
        <x-ui.search
            placeholder="Cari Quotation..."
        />

        {{-- Status --}}
        <x-ui.dropdown label="Semua Status">

            <x-ui.dropdown-item
                value="Semua Status"
            />

            <x-ui.dropdown-item
                value="Draft"
            />

            <x-ui.dropdown-item
                value="Sent"
            />

            <x-ui.dropdown-item
                value="Approved"
            />

            <x-ui.dropdown-item
                value="Rejected"
            />

        </x-ui.dropdown>

        {{-- Project --}}
        <x-ui.dropdown label="Semua Project">

            <x-ui.dropdown-item
                value="Semua Project"
            />

            <x-ui.dropdown-item
                value="Renovasi Gudang"
            />

            <x-ui.dropdown-item
                value="Pembangunan Ruko"
            />

            <x-ui.dropdown-item
                value="Renovasi Kantor"
            />

        </x-ui.dropdown>

    </x-slot:left>

    <x-slot:right>

        <button
            type="button"
            class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
        >

            Reset Filter

        </button>

    </x-slot:right>

</x-ui.toolbar>