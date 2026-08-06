@props([
    'mode' => 'create',
])

<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div>

            <h2 class="text-2xl font-bold text-gray-800">

    Timeline & Budget

</h2>

<p class="mt-2 text-gray-500">

    Tentukan jadwal pelaksanaan serta estimasi nilai proyek.

</p>

        </div>

        <hr class="my-8">

        <div class="space-y-6">

            {{-- Tanggal --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Tanggal Mulai --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-gray-700">

                        Tanggal Mulai
                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="date"
                        value="{{ $mode === 'edit' ? '2026-07-15' : '' }}"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >

                    <p class="mt-2 text-xs text-gray-500">

                        Tanggal dimulainya pelaksanaan proyek.

                    </p>

                </div>

                {{-- Tanggal Selesai --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-gray-700">

                        Tanggal Selesai
                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="date"
                        value="{{ $mode === 'edit' ? '2026-12-20' : '' }}"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >
                    <p class="mt-2 text-xs text-gray-500">

                        Target penyelesaian proyek.

                    </p>

                </div>

            </div>

            {{-- Budget --}}
            <div>

                <label class="mb-2 block text-sm font-semibold text-gray-700">

                    Estimasi Nilai Project

                    <span class="text-red-500">*</span>

                </label>

                <div class="flex">

                    <span class="flex items-center rounded-l-xl border border-r-0 border-gray-300 bg-gray-100 px-4 text-gray-600">

                        Rp

                    </span>

                    <input
                        type="text"
                        value="{{ $mode === 'edit' ? '850.000.000' : '' }}"
                        placeholder="Contoh: 850.000.000"
                        class="w-full rounded-r-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>

                <p class="mt-2 text-xs text-gray-500">

                    Masukkan estimasi nilai kontrak proyek.

                </p>

            </div>

        </div>

    </div>

</x-ui.info-card>