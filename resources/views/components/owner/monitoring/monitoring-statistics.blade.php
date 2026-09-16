@props([
    'statistics',
])

<div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
    {{-- Total Project --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between p-6">
            <div>
                <p class="text-sm font-medium text-gray-500">
                    Total Project
                </p>

                <h3 class="mt-2 text-3xl font-bold text-gray-900">
                    {{ number_format(
                        $statistics['total'] ?? 0
                    ) }}
                </h3>

                <p class="mt-3 text-sm text-gray-500">
                    Seluruh Project
                </p>
            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
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
                        d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h4.379a2.25 2.25 0 0 1 1.59.659l1.122 1.122a2.25 2.25 0 0 0 1.59.659H19.5A2.25 2.25 0 0 1 21.75 9v8.25A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75Z"
                    />
                </svg>
            </div>
        </div>
    </x-ui.info-card>

    {{-- Berjalan --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between p-6">
            <div>
                <p class="text-sm font-medium text-gray-500">
                    Sedang Berjalan
                </p>

                <h3 class="mt-2 text-3xl font-bold text-gray-900">
                    {{ number_format(
                        $statistics['in_progress'] ?? 0
                    ) }}
                </h3>

                <p class="mt-3 text-sm text-gray-500">
                    Project dalam pengerjaan
                </p>
            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
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
                        d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                    />
                </svg>
            </div>
        </div>
    </x-ui.info-card>

    {{-- Selesai --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between p-6">
            <div>
                <p class="text-sm font-medium text-gray-500">
                    Project Selesai
                </p>

                <h3 class="mt-2 text-3xl font-bold text-gray-900">
                    {{ number_format(
                        $statistics['completed'] ?? 0
                    ) }}
                </h3>

                <p class="mt-3 text-sm text-gray-500">
                    Pengerjaan telah selesai
                </p>
            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600">
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
                        d="m9 12.75 2.25 2.25L15 9.75m6 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                    />
                </svg>
            </div>
        </div>
    </x-ui.info-card>

    {{-- Terlambat --}}
    <x-ui.info-card>
        <div class="flex items-start justify-between p-6">
            <div>
                <p class="text-sm font-medium text-gray-500">
                    Terlambat
                </p>

                <h3 class="mt-2 text-3xl font-bold text-gray-900">
                    {{ number_format(
                        $statistics['delayed'] ?? 0
                    ) }}
                </h3>

                <p class="mt-3 text-sm text-gray-500">
                    Membutuhkan perhatian
                </p>
            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 text-red-600">
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
                        d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H4.645c-1.73 0-2.813-1.874-1.948-3.374L10.052 3.376c.866-1.5 3.03-1.5 3.896 0l7.355 12.75ZM12 15.75h.008v.008H12v-.008Z"
                    />
                </svg>
            </div>
        </div>
    </x-ui.info-card>
</div>