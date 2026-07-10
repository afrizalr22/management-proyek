<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500">

        <a
            href="{{ route('owner.clients.index') }}"
            class="hover:text-blue-600"
        >
            Clients
        </a>

        <span class="mx-2">></span>

        <span class="font-medium text-gray-700">
            Budi Santoso
        </span>

    </div>

    {{-- Header --}}
    <x-ui.page-header
        title="Detail Client"
        description="Informasi lengkap client."
    >

        <x-slot:actions>

            <div class="flex gap-3">

<a href="{{ route('owner.clients.edit', 1) }}">

    <x-ui.button color="gray">

        Ubah Data

    </x-ui.button>

</a>

                <x-ui.button>

                    Buat Project

                </x-ui.button>
                <a href="{{ route('owner.clients.delete',1) }}">

    <x-ui.button variant="danger">

        Hapus Client

    </x-ui.button>

</a>

            </div>

        </x-slot:actions>

    </x-ui.page-header>

    {{-- Layout --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- LEFT --}}
        <div class="xl:col-span-2">

            <x-ui.info-card>

                <div class="p-8">

                    {{-- Header --}}
                    <div class="flex items-start gap-5">

                        <div
                            class="flex h-16 w-16 items-center justify-center rounded-xl bg-blue-600 text-3xl text-white"
                        >

                            🏢

                        </div>

                        <div>

                            <h2 class="text-2xl font-bold">

                                PT Tekno Konstruksi Utama

                            </h2>

                            <div class="mt-2">

                                <x-ui.badge color="green">

                                    Active

                                </x-ui.badge>

                            </div>

                        </div>

                    </div>

                    <hr class="my-8">

                    {{-- Information --}}
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">

                        <div>

                            <p class="text-xs font-semibold uppercase text-gray-500">

                                Nama Client

                            </p>

                            <p class="mt-2 text-lg">

                                Budi Santoso

                            </p>

                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase text-gray-500">

                                Nomor Telepon

                            </p>

                            <p class="mt-2 text-lg">

                                +62 812 3456 7890

                            </p>

                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase text-gray-500">

                                Email

                            </p>

                            <p class="mt-2 text-lg">

                                budi.santoso@tekno-utama.com

                            </p>

                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase text-gray-500">

                                Kota

                            </p>

                            <p class="mt-2 text-lg">

                                Jakarta Selatan

                            </p>

                        </div>

                    </div>

                    <div class="mt-8">

                        <p class="text-xs font-semibold uppercase text-gray-500">

                            Alamat Lengkap

                        </p>

                        <p class="mt-2 text-lg leading-8">

                            Jl. Jenderal Sudirman No.45,
                            Menara Mandiri Lt.12,
                            Senayan,
                            Kebayoran Baru,
                            Jakarta Selatan,
                            12190

                        </p>

                    </div>

                </div>

            </x-ui.info-card>

        </div>

        {{-- RIGHT --}}
        <div class="space-y-6">

            {{-- Project Summary --}}
            <x-ui.summary-card>

                <div class="p-6">

                    <h3 class="text-lg font-bold text-gray-800">
                        Project Summary
                    </h3>

                    <div class="mt-6 space-y-5">

                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Total Project</span>
                            <span class="text-xl font-bold">12</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Project Aktif</span>
                            <span class="font-semibold text-blue-600">4</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Project Selesai</span>
                            <span class="font-semibold text-green-600">8</span>
                        </div>

                    </div>

                </div>

            </x-ui.summary-card>

            {{-- Total Nilai Project --}}
            <x-ui.summary-card>

                <div class="rounded-2xl bg-gray-900 p-6 text-white">

                    <p class="text-sm uppercase tracking-wide text-gray-300">
                        Total Nilai Project
                    </p>

                    <h2 class="mt-4 text-3xl font-bold">
                        Rp 4,5 M
                    </h2>

                    <p class="mt-2 text-sm text-gray-400">
                        Akumulasi seluruh nilai kontrak project client.
                    </p>

                </div>

            </x-ui.summary-card>

        </div>

    </div>
    {{-- ===== GRID SELESAI DI SINI ===== --}}

    {{-- Lokasi Client --}}
    <x-ui.map-card>

        <div class="p-6">

            <h3 class="text-lg font-bold text-gray-800">
                Lokasi Client
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Lokasi perusahaan client.
            </p>

        </div>

        <div class="relative flex h-96 items-center justify-center border-y bg-gradient-to-br from-gray-100 to-gray-200">

            <div
                class="absolute inset-0 opacity-30"
                style="
                    background-image:
                        linear-gradient(#d1d5db 1px, transparent 1px),
                        linear-gradient(90deg,#d1d5db 1px, transparent 1px);
                    background-size:40px 40px;
                "
            ></div>

            <div class="relative z-10 flex flex-col items-center">

                <div class="text-5xl">
                    📍
                </div>

                <span class="mt-2 rounded-full bg-white px-4 py-1 shadow">
                    PT Tekno Konstruksi Utama
                </span>

            </div>

        </div>

        <div class="p-6">

            <p class="font-semibold">
                Jl. Jenderal Sudirman No.45
            </p>

            <p class="mt-1 text-gray-500">
                Kebayoran Baru, Jakarta Selatan, DKI Jakarta
            </p>

        </div>

    </x-ui.map-card>

    {{-- Recent Project --}}
<x-ui.info-card>

    <div class="p-6 border-b">

        <h3 class="text-lg font-bold text-gray-800">

            Recent Projects

        </h3>

        <p class="mt-1 text-sm text-gray-500">

            Daftar proyek terakhir milik client.

        </p>

    </div>

    <div class="space-y-4 p-6">

        <x-ui.project-item
            title="Pembangunan Gudang A"
            progress="80"
            status="Active"
            date="20 Januari 2026"
        />

        <x-ui.project-item
            title="Renovasi Kantor Pusat"
            progress="100"
            status="Finished"
            date="10 Desember 2025"
        />

        <x-ui.project-item
            title="Instalasi Panel Surya"
            progress="45"
            status="Active"
            date="5 Februari 2026"
        />

    </div>

</x-ui.info-card>

</div>