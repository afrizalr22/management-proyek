<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500">

        <a href="{{ route('owner.dashboard') }}" class="hover:text-blue-600">
            Dashboard
        </a>

        <span class="mx-2">></span>

        <a href="{{ route('owner.clients.index') }}" class="hover:text-blue-600">
            Clients
        </a>

        <span class="mx-2">></span>

        <span class="font-medium text-blue-600">
            Tambah Client
        </span>

    </div>

    {{-- Header --}}
    <x-ui.page-header
        :title="$pageTitle"
        :description="$pageDescription"
    >

        <x-slot:actions>

            <div class="flex gap-3">

                <a href="{{ route('owner.clients.index') }}">

                    <x-ui.button variant="danger">

                        Batal

                    </x-ui.button>

                </a>

                <x-ui.button>

                    Tambah Client

                </x-ui.button>

            </div>

        </x-slot:actions>

    </x-ui.page-header>

    {{-- FORM --}}
    <x-ui.info-card>

        <div class="space-y-10 p-8">

            {{-- ================= IDENTITAS ================= --}}
            <div>

                <div class="mb-8 flex items-center gap-3">

                    <div class="h-1 w-10 rounded bg-blue-600"></div>

                    <h3 class="text-lg font-bold uppercase tracking-wide text-blue-600">

                        Identitas Utama

                    </h3>

                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Nama Lengkap Client
                            <span class="text-red-500">*</span>

                        </label>

                            <input
                                type="text"
                                wire:model="name"
                                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            />

                    </div>

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Nama Perusahaan
                            <span class="text-red-500">*</span>

                        </label>

                            <input
                                type="text"
                                wire:model="company"
                                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            />

                    </div>

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Email Bisnis
                            <span class="text-red-500">*</span>

                        </label>

                            <input
                                type="email"
                                wire:model="email"
                                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            />

                    </div>

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Nomor Telepon

                        </label>

                        <div class="flex">

                            <span class="flex items-center rounded-l-xl border border-r-0 border-gray-300 bg-gray-100 px-4 text-gray-600">

                                +62

                            </span>

                            <input
                                type="text"
                                wire:model="phone"
                                class="w-full rounded-r-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            />

                        </div>

                    </div>

                </div>

            </div>

            {{-- ================= DETAIL LOKASI ================= --}}
            <div>

                <div class="mb-8 flex items-center gap-3">

                    <div class="h-1 w-10 rounded bg-blue-600"></div>

                    <h3 class="text-lg font-bold uppercase tracking-wide text-blue-600">

                        Detail Lokasi

                    </h3>

                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Kota
                            <span class="text-red-500">*</span>

                        </label>

                        <select
                            wire:model="city"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Pilih Kota</option>
                            <option>Jakarta</option>
                            <option>Bandung</option>
                            <option>Surabaya</option>
                            <option>Medan</option>
                        </select>

                    </div>

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Status Client
                            <span class="text-red-500">*</span>

                        </label>

                        <div class="flex overflow-hidden rounded-xl border border-gray-300">

                            <button
                                type="button"
                                class="flex-1 bg-blue-600 py-3 text-sm font-semibold text-white"
                            >
                                Aktif
                            </button>

                            <button
                                type="button"
                                class="flex-1 bg-gray-100 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-200"
                            >
                                Lead
                            </button>

                            <button
                                type="button"
                                class="flex-1 bg-gray-100 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-200"
                            >
                                Nonaktif
                            </button>

                        </div>

                    </div>

                </div>

                <div class="mt-6">

                    <label class="mb-2 block text-sm font-semibold text-gray-700">

                        Alamat Lengkap

                    </label>

                        <textarea
                            wire:model="address"
                            rows="5"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        ></textarea>

                </div>

            </div>

        </div>

    </x-ui.info-card>

    {{-- Information --}}
    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5">

        <div class="flex items-start gap-4">

            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-xl">

                ℹ️

            </div>

            <div>

                <h4 class="font-semibold text-blue-700">

                    Informasi

                </h4>

                <p class="mt-1 text-sm leading-7 text-blue-600">

                    Seluruh data yang Anda masukkan akan tersimpan ke dalam sistem
                    dan masih dapat diperbarui melalui menu Client Management.

                </p>

            </div>

        </div>

    </div>

    {{-- Bottom Card --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        <x-ui.info-card class="transition duration-300 hover:-translate-y-1 hover:shadow-md">

            <div class="p-6">

                <h3 class="text-lg font-bold">

                    Kenapa mendaftarkan Client?

                </h3>

                <ul class="mt-5 space-y-3 text-gray-600">

                    <li>✔ Memudahkan pengelolaan proyek.</li>
                    <li>✔ Seluruh riwayat transaksi tersimpan.</li>
                    <li>✔ Monitoring progress lebih mudah.</li>
                    <li>✔ Data siap digunakan pada Quotation & Invoice.</li>

                </ul>

            </div>

        </x-ui.info-card>

        <x-ui.info-card class="transition duration-300 hover:-translate-y-1 hover:shadow-md">

            <div class="p-6">

                <h3 class="text-lg font-bold">

                    Client Terverifikasi

                </h3>

                <ul class="mt-5 space-y-3 text-gray-600">

                    <li>✔ Data client tersimpan dengan aman.</li>
                    <li>✔ Terhubung dengan seluruh proyek.</li>
                    <li>✔ Siap digunakan pada Surat Jalan.</li>
                    <li>✔ Mendukung pelaporan perusahaan.</li>

                </ul>

            </div>

        </x-ui.info-card>

    </div>

</div>