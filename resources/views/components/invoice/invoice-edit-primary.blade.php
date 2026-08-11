<x-ui.info-card>

    <div class="p-6">

        {{-- Header --}}
        <div>

            <h2 class="text-xl font-bold text-gray-800">
                Primary Information
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Informasi utama invoice dan project yang terkait.
            </p>

        </div>

        <hr class="my-6">

        <div class="space-y-6">

            {{-- Client & Project --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Client --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Client
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                        <option value="">
                            Pilih Client
                        </option>

                        <option selected>
                            PT Maju Bersama Properti
                        </option>

                        <option>
                            PT ABC Indonesia
                        </option>

                        <option>
                            PT Satria Konstruksi
                        </option>

                    </select>

                </div>

                {{-- Project --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Project
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                        <option value="">
                            Pilih Project
                        </option>

                        <option selected>
                            Pembangunan Gudang Logistik Tahap II
                        </option>

                        <option>
                            Renovasi Gedung PT ABC
                        </option>

                        <option>
                            Pembangunan Ruko Medan
                        </option>

                    </select>

                </div>

            </div>

            {{-- Invoice Number & Status --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Invoice Number --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Invoice Number
                    </label>

                    <input
                        type="text"
                        value="INV-2026-0001"
                        readonly
                        class="w-full rounded-xl border-gray-200 bg-gray-100 px-4 py-3 text-sm text-gray-600"
                    >

                    <p class="mt-2 text-xs text-gray-400">
                        Nomor invoice tidak dapat diubah.
                    </p>

                </div>

                {{-- Payment Status --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Payment Status
                    </label>

                    <div class="flex h-11 items-center rounded-xl border border-gray-200 bg-gray-100 px-4">

                        <x-ui.badge color="yellow">
                            Unpaid
                        </x-ui.badge>

                    </div>

                    <p class="mt-2 text-xs text-gray-400">
                        Status pembayaran dikelola melalui halaman detail invoice.
                    </p>

                </div>

            </div>

            {{-- Dates --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Invoice Date --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Invoice Date
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="date"
                        value="2026-10-12"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>

                {{-- Due Date --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Due Date
                    </label>

                    <input
                        type="date"
                        value="2026-10-26"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    <p class="mt-2 text-xs text-gray-400">
                        Kosongkan jika invoice tidak memiliki batas waktu pembayaran.
                    </p>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>