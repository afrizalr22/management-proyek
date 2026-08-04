<div class="space-y-8">

    {{-- Header --}}
    <x-ui.page-header
        title="Dashboard"
        description="Ringkasan aktivitas perusahaan."
    >
    </x-ui.page-header>

    {{-- Stat Card --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <x-ui.stat-card
            title="Total Client"
            value="15"
            description="Client aktif"
        />

        <x-ui.stat-card
            title="Project Aktif"
            value="8"
            description="Sedang berjalan"
        />

        <x-ui.stat-card
            title="Mandor"
            value="4"
            description="Aktif bekerja"
        />

        <x-ui.stat-card
            title="Pekerja"
            value="28"
            description="Total pekerja"
        />

    </div>

    {{-- Chart & Activity --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="xl:col-span-2 bg-white rounded-xl shadow p-6">

            <h2 class="text-lg font-semibold">
                Progress Bulanan
            </h2>

            <p class="text-sm text-gray-500 mb-6">
                Grafik akan dibuat pada sprint berikutnya.
            </p>

            <div class="h-72 flex items-center justify-center rounded-lg bg-gray-100">

                <span class="text-gray-400">
                    Chart Placeholder
                </span>

            </div>

        </div>

        <div class="bg-white rounded-xl shadow p-6">

            <div class="flex justify-between items-center mb-5">

                <h2 class="text-lg font-semibold">
                    Aktivitas Terbaru
                </h2>

                <a href="#" class="text-blue-600 text-sm">
                    Lihat Semua
                </a>

            </div>

            <div class="space-y-5">

                <div>
                    <p class="font-medium">
                        Project Rumah Budi dibuat
                    </p>

                    <p class="text-sm text-gray-500">
                        2 jam yang lalu
                    </p>
                </div>

                <div>
                    <p class="font-medium">
                        Client PT Maju Bersama ditambahkan
                    </p>

                    <p class="text-sm text-gray-500">
                        Kemarin
                    </p>
                </div>

                <div>
                    <p class="font-medium">
                        Progress Gudang ABC diperbarui
                    </p>

                    <p class="text-sm text-gray-500">
                        2 hari yang lalu
                    </p>
                </div>

            </div>

        </div>

    </div>

    {{-- Project Pipelines --}}
    <div class="bg-white rounded-xl shadow">

        <div class="flex justify-between items-center p-6 border-b">

            <h2 class="text-lg font-semibold">
                Project Pipelines
            </h2>

            <span class="text-sm text-gray-500">
                Menampilkan 5 project aktif
            </span>

        </div>

                <x-ui.table>

            <x-slot:head>

                <tr>

                    <th class="px-6 py-3 text-left">Project</th>

                    <th class="px-6 py-3 text-left">Client</th>

                    <th class="px-6 py-3 text-left">Mandor</th>

                    <th class="px-6 py-3 text-left">Progress</th>

                    <th class="px-6 py-3 text-left">Status</th>

                    <th class="px-6 py-3 text-left">Deadline</th>

                </tr>

            </x-slot:head>

            <x-slot:body>

                <tr>

                    <td class="px-6 py-4 font-medium">
                        Rumah Tinggal A
                    </td>

                    <td class="px-6 py-4">
                        PT Maju Bersama
                    </td>

                    <td class="px-6 py-4">
                        Ahmad
                    </td>

                    <td class="px-6 py-4 w-64">
                        <x-ui.progress value="80"/>
                    </td>

                    <td class="px-6 py-4">
                        <x-ui.badge color="green">
                            Berjalan
                        </x-ui.badge>
                    </td>

                    <td class="px-6 py-4">
                        30 Juli 2026
                    </td>

                </tr>

                <tr>

                    <td class="px-6 py-4 font-medium">
                        Gudang Logistik
                    </td>

                    <td class="px-6 py-4">
                        PT Nusantara
                    </td>

                    <td class="px-6 py-4">
                        Budi
                    </td>

                    <td class="px-6 py-4 w-64">
                        <x-ui.progress value="45"/>
                    </td>

                    <td class="px-6 py-4">
                        <x-ui.badge color="yellow">
                            Tertunda
                        </x-ui.badge>
                    </td>

                    <td class="px-6 py-4">
                        10 Agustus 2026
                    </td>

                </tr>

                <tr>

                    <td class="px-6 py-4 font-medium">
                        Ruko 3 Lantai
                    </td>

                    <td class="px-6 py-4">
                        CV Sejahtera
                    </td>

                    <td class="px-6 py-4">
                        Andi
                    </td>

                    <td class="px-6 py-4 w-64">
                        <x-ui.progress value="100"/>
                    </td>

                    <td class="px-6 py-4">
                        <x-ui.badge color="gray">
                            Selesai
                        </x-ui.badge>
                    </td>

                    <td class="px-6 py-4">
                        15 Juni 2026
                    </td>

                </tr>

            </x-slot:body>

        </x-ui.table>   

    </div>

</div>