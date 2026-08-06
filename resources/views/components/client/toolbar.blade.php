<x-ui.toolbar>

    <x-slot:left>

        <x-ui.search
            placeholder="Cari Client..."
        />

    </x-slot:left>

    <x-slot:right>

        {{-- Status --}}
        <x-ui.dropdown
            label="Semua Status"
        >

            <x-ui.dropdown-item
                value="Semua Status"
            />

            <x-ui.dropdown-item
                value="Active"
            />

            <x-ui.dropdown-item
                value="Inactive"
            />

        </x-ui.dropdown>

        {{-- Sort --}}
        <x-ui.dropdown
    label="Terbaru"
>

    <x-ui.dropdown-item
        value="Terbaru"
    />

    <x-ui.dropdown-item
        value="Terlama"
    />

</x-ui.dropdown>

    </x-slot:right>

</x-ui.toolbar>