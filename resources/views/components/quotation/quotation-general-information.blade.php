@props([
    'mode' => 'create',
])  
<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div>

            <h2 class="text-2xl font-bold text-gray-800">

                General Information

            </h2>

            <p class="mt-2 text-gray-500">

                Informasi utama quotation beserta data project dan client yang dipilih.

            </p>

        </div>

        <hr class="my-8">

        {{-- General Information --}}
        <div class="space-y-6">

            {{-- Project --}}
            <div>

                <label class="mb-2 block text-sm font-semibold text-gray-700">

                    Project
                    <span class="text-red-500">*</span>

                </label>

                <select
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                >

                    <option>Pilih Project</option>

                    <option>Renovasi Gedung PT ABC</option>

                    <option>Pembangunan Gudang PT XYZ</option>

                    <option>Pembangunan Ruko Medan</option>

                </select>

            </div>

            {{-- Quotation Number --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                <div>

                    <label class="mb-2 block text-sm font-semibold text-gray-700">

                        Quotation Number

                    </label>

                    <input
                        type="text"
                        value="QT-2026-0001"
                        readonly
                        class="w-full rounded-xl border-gray-200 bg-gray-100 px-4 py-3 text-gray-600"
                    >

                </div>

                <div>

                    <label class="mb-2 block text-sm font-semibold text-gray-700">

                        Status

                    </label>

                    <input
                        type="text"
                        value="Draft"
                        readonly
                        class="w-full rounded-xl border-gray-200 bg-yellow-50 px-4 py-3 font-medium text-yellow-700"
                    >

                </div>

            </div>

            {{-- Date --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                <div>

                    <label class="mb-2 block text-sm font-semibold text-gray-700">

                        Quotation Date
                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="date"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>

                <div>

                    <label class="mb-2 block text-sm font-semibold text-gray-700">

                        Valid Until
                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="date"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>

            </div>

        </div>

        {{-- Client Information --}}
        <div class="mt-10">

            <h3 class="text-xl font-bold text-gray-800">

                Client Information

            </h3>

            <p class="mt-2 text-gray-500">

                Data client akan terisi otomatis berdasarkan project yang dipilih.

            </p>

            <hr class="my-6">

            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6">

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div>

                        <p class="text-sm text-gray-500">

                            Client

                        </p>

                        <p class="mt-1 font-semibold text-gray-800">

                            PT ABC Indonesia

                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-gray-500">

                            Contact Person

                        </p>

                        <p class="mt-1 font-semibold text-gray-800">

                            Ahmad Fauzi

                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-gray-500">

                            Phone

                        </p>

                        <p class="mt-1 font-semibold text-gray-800">

                            0812-3456-7890

                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-gray-500">

                            Email

                        </p>

                        <p class="mt-1 font-semibold text-gray-800">

                            admin@ptabc.co.id

                        </p>

                    </div>

                    <div class="md:col-span-2">

                        <p class="text-sm text-gray-500">

                            Address

                        </p>

                        <p class="mt-1 font-semibold text-gray-800">

                            Jl. Gatot Subroto No. 123, Medan, Sumatera Utara

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>