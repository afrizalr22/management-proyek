<div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

    {{-- Total Quotation --}}
    <x-ui.stat-card
        title="Total Quotation"
        value="25"
        description="+5 quotation bulan ini"
    >

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
                    d="M9 12h6m-6 4h6M9 8h6m-7 12h8a2 2 0 002-2V6l-4-4H8a2 2 0 00-2 2v14a2 2 0 002 2z"
                />

            </svg>

        </x-slot:icon>

    </x-ui.stat-card>

    {{-- Draft --}}
    <x-ui.stat-card
        title="Draft"
        value="8"
        description="Belum dikirim ke client"
    >

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
                    stroke-width="2"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 8v4l3 3"
                />

            </svg>

        </x-slot:icon>

    </x-ui.stat-card>

    {{-- Sent --}}
    <x-ui.stat-card
        title="Sent"
        value="6"
        description="Menunggu respon client"
    >

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
                    d="M3 10l9-6 9 6-9 6-9-6z"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 10v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8"
                />

            </svg>

        </x-slot:icon>

    </x-ui.stat-card>

    {{-- Approved --}}
    <x-ui.stat-card
        title="Approved"
        value="11"
        description="Siap dibuat invoice"
    >

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
                    d="M5 13l4 4L19 7"
                />

            </svg>

        </x-slot:icon>

    </x-ui.stat-card>

</div>