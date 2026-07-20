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

                Tentukan jadwal pelaksanaan dan estimasi anggaran proyek.

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

                </div>

            </div>

            {{-- Budget --}}
            <div>

                <label class="mb-2 block text-sm font-semibold text-gray-700">

                    Estimasi Budget
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

                    Masukkan estimasi nilai kontrak atau anggaran proyek.

                </p>

            </div>

            {{-- Status & Prioritas --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Status --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-gray-700">

                        Status Awal

                    </label>

                    <select
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >

                        <option {{ $mode === 'edit' ? 'selected' : '' }}>

                            Perencanaan

                        </option>

                        <option>

                            Berjalan

                        </option>

                        <option>

                            Ditunda

                        </option>

                    </select>

                </div>

                {{-- Prioritas --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-gray-700">

                        Prioritas

                    </label>

                    <select
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >

                        <option>

                            Tinggi

                        </option>

                        <option {{ $mode === 'edit' ? 'selected' : '' }}>

                            Sedang

                        </option>

                        <option>

                            Rendah

                        </option>

                    </select>

                </div>

            </div>

            {{-- Catatan Timeline --}}
            <div>

                <label class="mb-2 block text-sm font-semibold text-gray-700">

                    Catatan Timeline

                </label>

                <textarea
                    rows="4"
                    placeholder="Tambahkan informasi mengenai jadwal proyek..."
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                >{{ $mode === 'edit'
                    ? 'Pekerjaan dimulai setelah material tiba di lokasi dan ditargetkan selesai dalam waktu 5 bulan.'
                    : '' }}</textarea>

                <p class="mt-2 text-xs text-gray-500">

                    Catatan ini bersifat opsional dan digunakan sebagai informasi tambahan.

                </p>

            </div>

        </div>

    </div>

</x-ui.info-card>