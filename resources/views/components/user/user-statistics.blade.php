<div class="grid grid-cols-2 gap-4">

    {{-- Total Projects --}}
    <x-ui.stat-card
        title="Total Projects"
        value="12"
        description="Seluruh proyek">

        <x-slot:icon>
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 7h18M6 3h12a1 1 0 011 1v16H5V4a1 1 0 011-1z"/>

            </svg>
        </x-slot:icon>

    </x-ui.stat-card>

    {{-- Active Projects --}}
    <x-ui.stat-card
        title="Active Projects"
        value="3"
        description="Sedang berjalan">

        <x-slot:icon>
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7"/>

            </svg>
        </x-slot:icon>

    </x-ui.stat-card>

    {{-- Completed Projects --}}
    <x-ui.stat-card
        title="Completed"
        value="9"
        description="Proyek selesai">

        <x-slot:icon>
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <circle
                    cx="12"
                    cy="12"
                    r="9"
                    stroke-width="2" />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12l2 2 4-4"/>

            </svg>
        </x-slot:icon>

    </x-ui.stat-card>

    {{-- Daily Reports --}}
    <x-ui.stat-card
        title="Daily Reports"
        value="148"
        description="Total laporan">

        <x-slot:icon>
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 3h6v4H9z"/>

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 8h6M8 12h8M8 16h5"/>

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>

            </svg>
        </x-slot:icon>

    </x-ui.stat-card>

</div>