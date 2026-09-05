@props([
    'statistics',
])

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">

    {{-- Total quotation --}}
    <x-ui.stat-card
        title="Total Quotation"
        :value="$statistics['total'] ?? 0"
        description="Seluruh quotation"
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
                    d="M9 12h6m-6 4h6M9 8h6m-7 12h8a2 2 0 0 0 2-2V6l-4-4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z"
                />
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>

    {{-- Draft --}}
    <x-ui.stat-card
        title="Draft"
        :value="$statistics['draft'] ?? 0"
        description="Belum dikirim ke client"
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
                    d="M12 8v4l3 3"
                />
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>

    {{-- Dikirim --}}
    <x-ui.stat-card
        title="Dikirim"
        :value="$statistics['sent'] ?? 0"
        description="Menunggu respons client"
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
                    d="M3 10l9-6 9 6-9 6-9-6Z"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 10v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-8"
                />
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>

    {{-- Disetujui --}}
    <x-ui.stat-card
        title="Disetujui"
        :value="$statistics['approved'] ?? 0"
        description="Siap diproses menjadi proyek"
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
                    d="m5 13 4 4L19 7"
                />
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>

</div>