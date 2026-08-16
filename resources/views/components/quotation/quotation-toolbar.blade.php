<x-ui.toolbar>

    <x-slot:left>

        {{-- Search --}}
        <x-ui.search
            placeholder="Cari Quotation..."
        />

    </x-slot:left>

    <x-slot:right>
                {{-- Status --}}
        <x-ui.dropdown label="Semua Status">

            <x-ui.dropdown-item
                value="Semua Status"
            />

            <x-ui.dropdown-item
                value="Draft"
                color="yellow"
            />

            <x-ui.dropdown-item
                value="Sent"
                color="blue"
            />

            <x-ui.dropdown-item
                value="Approved"
                color="green"
            />

            <x-ui.dropdown-item
                value="Rejected"
                color="red"
            />

        </x-ui.dropdown>

        <button
            type="button"
            class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
        >

            Reset Filter

        </button>

    </x-slot:right>

</x-ui.toolbar>