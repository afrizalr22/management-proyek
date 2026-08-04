<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-gray-200 p-6">

        <div>

            <h2 class="text-lg font-semibold text-gray-900">
                Project Pipelines
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Monitoring proyek yang sedang berjalan.
            </p>

        </div>

        <span class="rounded-lg bg-gray-100 px-3 py-1 text-sm font-medium text-gray-600">
            5 Project Aktif
        </span>

    </div>

    <div class="overflow-x-auto">

        <table class="min-w-full">

            {{-- Header --}}
            <thead class="bg-gray-50">

                <tr class="border-b border-gray-200">

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Project
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Client
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Mandor
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Progress
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Status
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Deadline
                    </th>

                </tr>

            </thead>

            {{-- Body --}}
            <tbody class="divide-y divide-gray-100 bg-white">

             <tr
                onclick="window.location='#'"
                class="group cursor-pointer transition duration-200 hover:bg-blue-50"
            >

             <td class="px-6 py-5">

                <div class="flex items-start justify-between">

                    <div class="space-y-1">

                        <p class="font-semibold text-gray-900 transition group-hover:text-blue-600">
                            Rumah Tinggal A
                        </p>

                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            PRJ-001
                        </p>

                    </div>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 text-gray-400 transition group-hover:translate-x-1 group-hover:text-blue-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7"/>

                    </svg>

                </div>

            </td>

            <td class="px-6 py-5">

                <div class="space-y-1">

                    <p class="font-medium text-gray-900">
                        PT Maju Bersama
                    </p>

                    <p class="text-sm text-gray-500">
                        Jakarta Selatan
                    </p>

                </div>

            </td>

            <td class="px-6 py-5">

                <div class="space-y-1">

                    <p class="font-medium text-gray-900">
                        Ahmad
                    </p>

                    <p class="text-sm text-gray-500">
                        Mandor Lapangan
                    </p>

                </div>

            </td>

                <td class="w-72 px-6 py-5">
                        <x-ui.progress value="80"/>
                    </td>

                    <td class="px-6 py-5">
                        <x-ui.badge color="green">
                            Berjalan
                        </x-ui.badge>
                    </td>

                  <td class="px-6 py-5">

                    <div class="space-y-1">

                        <p class="font-medium text-gray-900">
                            30 Juli 2026
                        </p>

                        <p class="text-xs font-medium text-amber-600">
                            Sisa 3 Hari
                        </p>

                    </div>

                </td>

                </tr>

                    <tr
                        onclick="window.location='#'"
                        class="group cursor-pointer transition duration-200 hover:bg-blue-50"
                    >
            <td class="px-6 py-5">

                <div class="flex items-start justify-between">

                    <div class="space-y-1">

                        <p class="font-semibold text-gray-900 transition group-hover:text-blue-600">
                            Gudang Logistik
                        </p>

                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            PRJ-002
                        </p>

                    </div>

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-gray-400 transition group-hover:translate-x-1 group-hover:text-blue-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"/>

                        </svg>

                    </div>
            </td>

                <td class="px-6 py-5">

                    <div class="space-y-1">

                        <p class="font-medium text-gray-900">
                            PT Nusantara
                        </p>

                        <p class="text-sm text-gray-500">
                            Bandung
                        </p>

                    </div>

                </td>

                    <td class="px-6 py-5">

                        <div class="space-y-1">

                            <p class="font-medium text-gray-900">
                                Budi
                            </p>

                            <p class="text-sm text-gray-500">
                                Mandor Lapangan
                            </p>

                        </div>

                    </td>

                    <td class="w-72 px-6 py-5">
                        <x-ui.progress value="45"/>
                    </td>

                    <td class="px-6 py-5">
                        <x-ui.badge color="yellow">
                            Tertunda
                        </x-ui.badge>
                    </td>

                    <td class="px-6 py-5">

                        <div class="space-y-1">

                            <p class="font-medium text-gray-900">
                                10 Agustus 2026
                            </p>

                            <p class="text-xs font-medium text-green-600">
                                Sisa 14 Hari
                            </p>

                        </div>

                    </td>

                </tr>

                    <tr
                        onclick="window.location='#'"
                        class="group cursor-pointer transition duration-200 hover:bg-blue-50"
                    >

                    <td class="px-6 py-5">

                <div class="flex items-start justify-between">

                            <div class="space-y-1">

                                <p class="font-semibold text-gray-900 transition group-hover:text-blue-600">
                                    Ruko 3 Lantai
                                </p>

                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    PRJ-003
                                </p>

                            </div>

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 text-gray-400 transition group-hover:translate-x-1 group-hover:text-blue-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"/>

                            </svg>

                        </div>

                    </td>

                        <td class="px-6 py-5">

                            <div class="space-y-1">

                                <p class="font-medium text-gray-900">
                                    CV Sejahtera
                                </p>

                                <p class="text-sm text-gray-500">
                                    Tangerang
                                </p>

                            </div>

                        </td>   

                    <td class="px-6 py-5">

                        <div class="space-y-1">

                            <p class="font-medium text-gray-900">
                                Andi
                            </p>

                            <p class="text-sm text-gray-500">
                                Mandor Lapangan
                            </p>

                        </div>

                    </td>

                    <td class="w-80 px-6 py-5 align-middle">
                        <x-ui.progress value="100"/>
                    </td>

                    <td class="px-6 py-5">
                        <x-ui.badge color="gray">
                            Selesai
                        </x-ui.badge>
                    </td>

                   <td class="px-6 py-5">

                        <div class="space-y-1">

                            <p class="font-medium text-gray-900">
                                15 Juni 2026
                            </p>

                            <p class="text-xs font-medium text-blue-600">
                                Project Selesai
                            </p>

                        </div>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>