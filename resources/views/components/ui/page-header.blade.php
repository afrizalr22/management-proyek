@props([
    'title',
    'description' => null,
])

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">
            {{ $title }}
        </h1>

        @if($description)
            <p class="text-gray-500 mt-1">
                {{ $description }}
            </p>
        @endif
    </div>

    <div>
        {{ $actions ?? '' }}
    </div>

</div>

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">

    <x-ui.stat-card
        title="Total Client"
        value="0"
        description="Belum ada data"
    />

    <x-ui.stat-card
        title="Project Aktif"
        value="0"
        description="Belum ada data"
    />

    <x-ui.stat-card
        title="Project Selesai"
        value="0"
        description="Belum ada data"
    />

    <x-ui.stat-card
        title="Invoice Belum Dibayar"
        value="0"
        description="Belum ada data"
    />

</div>

<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

    <div class="xl:col-span-2">

        <x-ui.card>

            Chart Area

        </x-ui.card>

    </div>

    <div>

        <x-ui.card>

            Recent Activity

        </x-ui.card>

    </div>

</div>

<x-ui.card>

    <h2 class="mb-4 text-lg font-semibold">
        Project Pipeline
    </h2>

    <x-ui.table>

        <x-slot:head>

            <tr>

                <th class="px-6 py-3 text-left">
                    Project
                </th>

                <th class="px-6 py-3 text-left">
                    Client
                </th>

                <th class="px-6 py-3 text-left">
                    Mandor
                </th>

                <th class="px-6 py-3 text-left">
                    Progress
                </th>

                <th class="px-6 py-3 text-left">
                    Status
                </th>

            </tr>

        </x-slot:head>

        <x-slot:body>

            <tr>

                <td colspan="5" class="px-6 py-10 text-center text-gray-500">

                    Belum ada data project

                </td>

            </tr>

        </x-slot:body>

    </x-ui.table>

</x-ui.card>