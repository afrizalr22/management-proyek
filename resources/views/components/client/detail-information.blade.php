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