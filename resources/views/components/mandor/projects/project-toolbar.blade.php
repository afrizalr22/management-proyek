<x-ui.toolbar>

    {{-- Search --}}
    <x-slot:left>

        <x-ui.search
            placeholder="Cari proyek..."
        />

    </x-slot:left>


    {{-- Filter & Sort --}}
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
                color="green"
            />

            <x-ui.dropdown-item
                value="On Hold"
                color="yellow"
            />

            <x-ui.dropdown-item
                value="Completed"
                color="blue"
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

            <x-ui.dropdown-item
                value="Progress Tertinggi"
            />

            <x-ui.dropdown-item
                value="Progress Terendah"
            />

        </x-ui.dropdown>

    </x-slot:right>

</x-ui.toolbar>