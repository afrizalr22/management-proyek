<x-ui.toolbar>

    <x-slot:left>

        {{-- Search --}}
        <x-ui.search
            placeholder="Cari nama atau email..."
        />

    </x-slot:left>


    <x-slot:right>

        {{-- Role --}}
        <x-ui.dropdown
            label="Semua Role"
        >

            <x-ui.dropdown-item
                value="Semua Role"
            />

            <x-ui.dropdown-item
                value="Owner"
            />

            <x-ui.dropdown-item
                value="Mandor"
            />

            <x-ui.dropdown-item
                value="Pekerja"
            />

        </x-ui.dropdown>


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