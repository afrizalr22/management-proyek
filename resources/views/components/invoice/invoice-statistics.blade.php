<div class="grid grid-cols-1 gap-6 md:grid-cols-3">

    {{-- Total Invoice --}}
    <x-ui.stat-card
        title="Total Invoice"
        value="Rp 4,5 M"
        description="+12% bulan ini"
    >

        <x-slot:icon>

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12h6m-6 4h6M9 8h6m-7 12h8a2 2 0 002-2V6l-4-4H8a2 2 0 00-2 2v14a2 2 0 002 2z"
                />

            </svg>

        </x-slot:icon>

    </x-ui.stat-card>


    {{-- Menunggu Pembayaran --}}
    <x-ui.stat-card
        title="Menunggu Pembayaran"
        value="Rp 1,2 M"
        description="5 invoice belum lunas"
    >

        <x-slot:icon>

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >

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
                    d="M12 7v5l3 2"
                />

            </svg>

        </x-slot:icon>

    </x-ui.stat-card>


    {{-- Invoice Terbayar --}}
    <x-ui.stat-card
        title="Invoice Terbayar"
        value="Rp 3,3 M"
        description="24 invoice telah lunas"
    >

        <x-slot:icon>

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >

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