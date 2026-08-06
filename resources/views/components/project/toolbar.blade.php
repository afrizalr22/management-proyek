<x-ui.toolbar>

    <x-slot:left>

        <x-ui.search
            placeholder="Cari Project..."
        />

    </x-slot:left>

    <x-slot:right>

        <x-ui.dropdown label="All">

            <x-ui.dropdown-item
                value="All"
            />

            <x-ui.dropdown-item
                value="Active"
                color="green"
            />

            <x-ui.dropdown-item
                value="Completed"
                color="blue"
            />

            <x-ui.dropdown-item
                value="Pending"
                color="yellow"
            />

        </x-ui.dropdown>

    </x-slot:right>

</x-ui.toolbar>