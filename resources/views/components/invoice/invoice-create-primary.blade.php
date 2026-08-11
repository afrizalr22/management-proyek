<x-ui.info-card>

    <div class="p-6">

        {{-- Header --}}
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Informasi Utama
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Lengkapi informasi utama invoice yang akan dibuat.
            </p>
        </div>

        <hr class="my-6">

        <div class="space-y-6">

            {{-- Client & Project --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Client --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Klien / Customer
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">
                            Pilih Klien
                        </option>

                        <option>
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
                        Proyek
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">
                            Pilih Proyek
                        </option>

                        <option>
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


            {{-- Invoice Number --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Nomor Invoice
                </label>

                <input
                    type="text"
                    value="INV-2026-0001"
                    readonly
                    class="w-full rounded-xl border-gray-200 bg-gray-100 px-4 py-3 text-sm text-gray-600"
                >

                <p class="mt-2 text-xs text-gray-400">
                    Nomor invoice akan dihasilkan secara otomatis.
                </p>

            </div>


            {{-- Dates --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Invoice Date --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Tanggal Terbit
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="date"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>


                {{-- Due Date --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Jatuh Tempo
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="date"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>