@props([
    'statistics' => [],
])

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
    <x-ui.stat-card
        title="Total Surat Jalan"
        :value="$statistics['total'] ?? 0"
        description="Seluruh dokumen pengiriman"
    >
        <x-slot:icon>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H6.75A2.25 2.25 0 0 0 4.5 4.5v15A2.25 2.25 0 0 0 6.75 21h10.5a2.25 2.25 0 0 0 2.25-2.25v-4.5Z"
                />
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        title="Draft"
        :value="$statistics['draft'] ?? 0"
        description="Belum dikirim"
    >
        <x-slot:icon>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"
                />
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        title="Dalam Pengiriman"
        :value="$statistics['sent'] ?? 0"
        description="Sudah dikirim"
    >
        <x-slot:icon>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8.25 18.75a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6.75m-9.75 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m13.5 4.5a1.5 1.5 0 1 1 3 0m-3 0a1.5 1.5 0 0 0 3 0m-3 0h-1.5V5.25A2.25 2.25 0 0 0 12 3H4.5A2.25 2.25 0 0 0 2.25 5.25v9m12 0h4.192c.323 0 .637.139.854.379l2.454 2.727V18.75h-3m-4.5-4.5V6.75h3.879c.409 0 .787.221.987.578l2.634 4.703v2.219h-7.5Z"
                />
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        title="Diterima"
        :value="$statistics['received'] ?? 0"
        description="Pengiriman selesai"
    >
        <x-slot:icon>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m4.5 12.75 6 6 9-13.5"
                />
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>
</div>