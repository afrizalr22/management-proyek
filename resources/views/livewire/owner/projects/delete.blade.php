<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500">

        <a
            href="{{ route('owner.projects.index') }}"
            class="hover:text-blue-600"
        >
            Project Management
        </a>

        <span class="mx-2">></span>

        <span class="font-medium text-gray-700">

            Delete Project

        </span>

    </div>

    {{-- Header --}}
    <x-ui.page-header
        title="Delete Project"
        description="Konfirmasi penghapusan project sebelum data dihapus dari sistem."
    >

        <x-slot:actions>

            <div class="flex gap-3">

                <a href="{{ route('owner.projects.index') }}">

                    <x-ui.button variant="secondary">

                        Batal

                    </x-ui.button>

                </a>

                <x-ui.button variant="danger">

                    Ya, Hapus Project

                </x-ui.button>

            </div>

        </x-slot:actions>

    </x-ui.page-header>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Left --}}
        <div class="space-y-6 xl:col-span-2">

            <x-ui.info-card>

                <div class="p-8">

                    <div class="flex items-center gap-4">

                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-red-100">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-8 w-8 text-red-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                                />
                            </svg>

                        </div>

                        <div>

                            <h2 class="text-2xl font-bold text-gray-800">

                                Delete Project

                            </h2>

                            <p class="mt-2 text-gray-500">

                                Anda akan menghapus project berikut secara permanen.

                            </p>

                        </div>

                    </div>

                    <hr class="my-8">

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                        <div>

                            <label class="text-sm font-semibold text-gray-500">

                                Nama Project

                            </label>

                            <p class="mt-2 font-semibold text-gray-800">

                                Renovasi Gedung Kantor PT ABC

                            </p>

                        </div>

                        <div>

                            <label class="text-sm font-semibold text-gray-500">

                                Client

                            </label>

                            <p class="mt-2">

                                PT Tekno Konstruksi Utama

                            </p>

                        </div>

                        <div>

                            <label class="text-sm font-semibold text-gray-500">

                                Mandor

                            </label>

                            <p class="mt-2">

                                Ahmad Fauzi

                            </p>

                        </div>

                        <div>

                            <label class="text-sm font-semibold text-gray-500">

                                Status

                            </label>

                            <div class="mt-2">

                                <x-ui.badge color="green">

                                    Active

                                </x-ui.badge>

                            </div>

                        </div>

                        <div>

                            <label class="text-sm font-semibold text-gray-500">

                                Budget

                            </label>

                            <p class="mt-2">

                                Rp 850.000.000

                            </p>

                        </div>

                        <div>

                            <label class="text-sm font-semibold text-gray-500">

                                Progress

                            </label>

                            <p class="mt-2">

                                35%

                            </p>

                        </div>

                    </div>

                </div>

            </x-ui.info-card>

            <x-ui.info-card>

                <div class="rounded-2xl border border-red-200 bg-red-50 p-6">

                    <div class="flex gap-4">

                        <div class="text-2xl">

                            ⚠️

                        </div>

                        <div>

                            <h3 class="font-semibold text-red-700">

                                Peringatan

                            </h3>

                            <p class="mt-2 leading-7 text-red-600">

                                Menghapus project akan menghilangkan data project
                                dari sistem. Nantinya data yang telah memiliki
                                transaksi seperti quotation, invoice, laporan
                                harian, maupun dokumentasi sebaiknya tidak dapat
                                dihapus dan hanya dapat dinonaktifkan.

                            </p>

                        </div>

                    </div>

                </div>

            </x-ui.info-card>

        </div>

        {{-- Right --}}
        <div class="space-y-6">

            <x-ui.summary-card>

                <div class="p-6">

                    <h3 class="text-lg font-bold">

                        Ringkasan

                    </h3>

                    <div class="mt-6 space-y-5">

                        <div class="flex justify-between">

                            <span class="text-gray-500">

                                Project Code

                            </span>

                            <span>

                                PRJ-2026-001

                            </span>

                        </div>

                        <div class="flex justify-between">

                            <span class="text-gray-500">

                                Dibuat

                            </span>

                            <span>

                                12 Jul 2026

                            </span>

                        </div>

                        <div class="flex justify-between">

                            <span class="text-gray-500">

                                Terakhir Diubah

                            </span>

                            <span>

                                15 Jul 2026

                            </span>

                        </div>

                    </div>

                </div>

            </x-ui.summary-card>

            <x-ui.summary-card>

                <div class="p-6">

                    <h3 class="text-lg font-bold">

                        Dampak Penghapusan

                    </h3>

                    <ul class="mt-5 space-y-3 text-sm text-gray-600">

                        <li>• Project tidak dapat dikembalikan.</li>

                        <li>• Riwayat project akan hilang.</li>

                        <li>• Data terkait harus dipastikan tidak digunakan.</li>

                        <li>• Disarankan melakukan backup sebelum menghapus.</li>

                    </ul>

                </div>

            </x-ui.summary-card>

        </div>

    </div>

</div>