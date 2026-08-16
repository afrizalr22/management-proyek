<x-ui.toolbar>

    <x-slot:left>

        <x-ui.search
            placeholder="Cari Proyek..."
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
                value="On progress"
                color="yellow"
            />

            <x-ui.dropdown-item
                value="Completed"
                color="green"
            />

            <x-ui.dropdown-item
                value="Delayded"
                color="red"
            />

        </x-ui.dropdown>

        {{-- Sort --}}
    <x-ui.dropdown label="Semua Mandor">

    <x-ui.dropdown-item value="Mandor A"/>

    <x-ui.dropdown-item value="Mandor B"/>

</x-ui.dropdown>

    </x-slot:right>

</x-ui.toolbar>