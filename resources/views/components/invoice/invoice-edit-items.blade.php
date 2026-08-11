<x-ui.info-card>

    <div class="p-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-xl font-bold text-gray-800">
                    Invoice Items
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Kelola item pekerjaan yang tercantum dalam invoice.
                </p>

            </div>

            <x-ui.button variant="secondary">

                + Tambah Item

            </x-ui.button>

        </div>

        <hr class="my-6">

        {{-- Items --}}
        <div class="space-y-4">

            {{-- Item 1 --}}
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                <div class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:items-end">

                    {{-- Item Name --}}
                    <div class="lg:col-span-4">

                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Item Name
                        </label>

                        <input
                            type="text"
                            value="Pekerjaan Pondasi Tiang Pancang"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500"
                        >

                    </div>

                    {{-- Quantity --}}
                    <div class="lg:col-span-2">

                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Quantity
                        </label>

                        <input
                            type="number"
                            value="120"
                            min="0"
                            step="0.01"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500"
                        >

                    </div>

                    {{-- Unit --}}
                    <div class="lg:col-span-2">

                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Unit
                        </label>

                        <input
                            type="text"
                            value="Titik"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500"
                        >

                    </div>

                    {{-- Price --}}
                    <div class="lg:col-span-3">

                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Unit Price
                        </label>

                        <input
                            type="number"
                            value="8500000"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500"
                        >

                    </div>

                    {{-- Delete --}}
                    <div class="flex justify-end lg:col-span-1">

                        <x-ui.icon-button-delete
                            href="#"
                        />

                    </div>

                </div>

                {{-- Total --}}
                <div class="mt-4 flex items-center justify-between border-t border-gray-200 pt-4">

                    <span class="text-sm text-gray-500">
                        Total
                    </span>

                    <span class="font-semibold text-gray-800">
                        Rp 1.020.000.000
                    </span>

                </div>

            </div>


            {{-- Item 2 --}}
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                <div class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:items-end">

                    {{-- Item Name --}}
                    <div class="lg:col-span-4">

                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Item Name
                        </label>

                        <input
                            type="text"
                            value="Struktur Baja Atap"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500"
                        >

                    </div>

                    {{-- Quantity --}}
                    <div class="lg:col-span-2">

                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Quantity
                        </label>

                        <input
                            type="number"
                            value="15"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500"
                        >

                    </div>

                    {{-- Unit --}}
                    <div class="lg:col-span-2">

                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Unit
                        </label>

                        <input
                            type="text"
                            value="Ton"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500"
                        >

                    </div>

                    {{-- Price --}}
                    <div class="lg:col-span-3">

                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Unit Price
                        </label>

                        <input
                            type="number"
                            value="18000000"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500"
                        >

                    </div>

                    {{-- Delete --}}
                    <div class="flex justify-end lg:col-span-1">

                        <x-ui.icon-button-delete
                            href="#"
                        />

                    </div>

                </div>

                {{-- Total --}}
                <div class="mt-4 flex items-center justify-between border-t border-gray-200 pt-4">

                    <span class="text-sm text-gray-500">
                        Total
                    </span>

                    <span class="font-semibold text-gray-800">
                        Rp 270.000.000
                    </span>

                </div>

            </div>


            {{-- Item 3 --}}
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                <div class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:items-end">

                    {{-- Item Name --}}
                    <div class="lg:col-span-4">

                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Item Name
                        </label>

                        <input
                            type="text"
                            value="Pemasangan Lantai Beton Precast"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500"
                        >

                    </div>

                    {{-- Quantity --}}
                    <div class="lg:col-span-2">

                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Quantity
                        </label>

                        <input
                            type="number"
                            value="400"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500"
                        >

                    </div>

                    {{-- Unit --}}
                    <div class="lg:col-span-2">

                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Unit
                        </label>

                        <input
                            type="text"
                            value="m²"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500"
                        >

                    </div>

                    {{-- Price --}}
                    <div class="lg:col-span-3">

                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Unit Price
                        </label>

                        <input
                            type="number"
                            value="450000"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500"
                        >

                    </div>

                    {{-- Delete --}}
                    <div class="flex justify-end lg:col-span-1">

                        <x-ui.icon-button-delete
                            href="#"
                        />

                    </div>

                </div>

                {{-- Total --}}
                <div class="mt-4 flex items-center justify-between border-t border-gray-200 pt-4">

                    <span class="text-sm text-gray-500">
                        Total
                    </span>

                    <span class="font-semibold text-gray-800">
                        Rp 180.000.000
                    </span>

                </div>

            </div>

        </div>

        {{-- Information --}}
        <div class="mt-5 rounded-xl bg-blue-50 px-4 py-3">

            <p class="text-sm text-blue-700">
                Total item akan dihitung berdasarkan quantity dan harga satuan.
            </p>

        </div>

    </div>

</x-ui.info-card>