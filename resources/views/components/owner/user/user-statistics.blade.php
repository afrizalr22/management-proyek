@props([
    'statistics',
])

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <x-ui.stat-card
        title="Total Pengguna"
        :value="$statistics['total']"
        description="Seluruh akun sistem"
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
                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72M18 18.72v-.75c0-.956-.22-1.861-.612-2.666M18 18.72a9.094 9.094 0 0 1-6 2.28c-2.305 0-4.408-.867-6-2.292m0 .012v-.75c0-.956.22-1.861.612-2.666m0 0a5.985 5.985 0 0 1 10.776 0M15 7.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                />
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        title="Akun Aktif"
        :value="$statistics['active']"
        description="Dapat mengakses sistem"
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

    <x-ui.stat-card
        title="Mandor"
        :value="$statistics['mandors']"
        description="Pengelola pekerjaan"
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
                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0"
                />
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>

    <x-ui.stat-card
        title="Pekerja"
        :value="$statistics['workers']"
        description="Pelaksana pekerjaan"
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
                    d="M18 7.5V6a6 6 0 0 0-12 0v1.5M3.75 9.75h16.5v9a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25v-9Z"
                />
            </svg>
        </x-slot:icon>
    </x-ui.stat-card>
</div>