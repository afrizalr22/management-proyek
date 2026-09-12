@php
    $authenticatedMandor = auth()->user();

    /*
     * Mengambil Project dari URL ketika Mandor sedang
     * membuka detail, progress, atau dokumentasi.
     */
    $routeProject = request()->route('project');

    $routeProjectId = $routeProject instanceof \App\Models\Project
        ? $routeProject->id
        : (
            is_numeric($routeProject)
                ? (int) $routeProject
                : null
        );

    /*
     * Project dari URL hanya digunakan jika memang
     * menjadi milik Mandor yang sedang login.
     */
    $selectedProjectId = null;

    if ($authenticatedMandor && $routeProjectId) {
        $selectedProjectId = $authenticatedMandor
            ->managedProjects()
            ->whereKey($routeProjectId)
            ->value('id');
    }

    /*
     * Jika belum berada di halaman Project tertentu,
     * gunakan Project aktif pertama milik Mandor.
     */
    if (
        !$selectedProjectId
        && $authenticatedMandor
    ) {
        $selectedProjectId = $authenticatedMandor
            ->managedProjects()
            ->whereIn('status', [
                'planning',
                'on_progress',
                'in_progress',
                'ongoing',
            ])
            ->oldest('id')
            ->value('id');
    }

    /*
     * Jika Mandor belum memiliki Project, arahkan
     * menu terkait Project ke halaman Proyek Saya.
     */
    $workProgressHref = $selectedProjectId
        ? route(
            'mandor.projects.work-progress.index',
            [
                'project' => $selectedProjectId,
            ]
        )
        : route('mandor.projects.index');

    $documentationHref = $selectedProjectId
        ? route(
            'mandor.projects.documentations.index',
            [
                'project' => $selectedProjectId,
            ]
        )
        : route('mandor.projects.index');
@endphp

<div class="flex h-full min-h-0 flex-col overflow-hidden bg-white">
    {{-- Logo --}}
    <x-sidebar.logo
        :href="route('mandor.dashboard')"
        panel="Mandor Panel"
    />

    {{-- Navigasi --}}
    <nav
        class="min-h-0 flex-1 space-y-4 overflow-y-auto overscroll-contain px-3 py-4"
        aria-label="Navigasi Mandor"
    >
        {{-- Utama --}}
        <x-sidebar.group label="Utama">
            <x-sidebar.item
                :href="route('mandor.dashboard')"
                :active="request()->routeIs(
                    'mandor.dashboard'
                )"
            >
                <x-slot:icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 13.5h8V3H3v10.5Zm10 7.5h8V10.5h-8V21ZM3 21h8v-5.5H3V21Zm10-12.5h8V3h-8v5.5Z"
                        />
                    </svg>
                </x-slot:icon>

                Dashboard
            </x-sidebar.item>
        </x-sidebar.group>

        {{-- Pekerjaan --}}
        <x-sidebar.group label="Pekerjaan">
            {{-- Proyek Saya --}}
            <x-sidebar.item
                :href="route('mandor.projects.index')"
                :active="request()->routeIs(
                    'mandor.projects.index',
                    'mandor.projects.show'
                )"
            >
                <x-slot:icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 20.25h18M5.25 20.25V8.25L12 3l6.75 5.25v12M9 20.25v-6h6v6"
                        />
                    </svg>
                </x-slot:icon>

                Proyek Saya
            </x-sidebar.item>

            {{-- Progress Pekerjaan --}}
            <x-sidebar.item
                :href="$workProgressHref"
                :active="request()->routeIs(
                    'mandor.projects.work-progress.*'
                )"
            >
                <x-slot:icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 20.25h18M6.75 17.25v-4.5M12 17.25V9M17.25 17.25V5.25"
                        />
                    </svg>
                </x-slot:icon>

                Progress Pekerjaan
            </x-sidebar.item>

            {{-- Photo Gallery --}}
            <x-sidebar.item
                :href="$documentationHref"
                :active="request()->routeIs(
                    'mandor.projects.documentations.*'
                )"
            >
                <x-slot:icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"
                        />
                    </svg>
                </x-slot:icon>

                Photo Gallery
            </x-sidebar.item>
        </x-sidebar.group>

        {{-- Pelaporan --}}
        <x-sidebar.group label="Pelaporan">
            <x-sidebar.item
                :href="route(
                    'mandor.daily-reports.index'
                )"
                :active="request()->routeIs(
                    'mandor.daily-reports.*'
                )"
            >
                <x-slot:icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m0 12.75h7.5m-7.5 3h4.5m-7.5 3h9a2.25 2.25 0 0 0 2.25-2.25V8.108a2.25 2.25 0 0 0-.659-1.591l-3.108-3.108a2.25 2.25 0 0 0-1.591-.659H5.25A2.25 2.25 0 0 0 3 5v13.75A2.25 2.25 0 0 0 5.25 21Z"
                        />
                    </svg>
                </x-slot:icon>

                Laporan Harian
            </x-sidebar.item>
        </x-sidebar.group>
    </nav>

    {{-- Menu akun --}}
    <div class="shrink-0 border-t border-gray-200 bg-white px-3 py-3">
        <p class="px-3 pb-2 text-[11px] font-bold uppercase tracking-[0.16em] text-gray-400">
            Akun
        </p>

        <form
            method="POST"
            action="{{ route('logout') }}"
        >
            @csrf

            <button
                type="submit"
                class="group flex min-h-11 w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-semibold text-red-600 transition hover:bg-red-50"
            >
                <span class="flex h-5 w-5 shrink-0 items-center justify-center text-red-400 transition group-hover:text-red-600">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l3-3m-3 3 3 3m0-3H21"
                        />
                    </svg>
                </span>

                <span>Logout</span>
            </button>
        </form>
    </div>
</div>