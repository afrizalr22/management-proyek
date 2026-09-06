@props([
    'mode' => 'create',
    'sourceQuotation' => null,
])

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Timeline, Kontrak & Anggaran
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Tentukan kontrak, jadwal pelaksanaan, dan anggaran internal Project.
            </p>
        </div>

        <hr class="my-6 border-gray-200 lg:my-8">

        <div class="space-y-6">
            {{-- Informasi kontrak --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label
                        for="contractNumber"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Nomor Kontrak
                    </label>

                    <input
                        id="contractNumber"
                        type="text"
                        wire:model.blur="contractNumber"
                        placeholder="Contoh: SPK/001/IX/2026"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('contractNumber')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="contractDate"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Tanggal Kontrak
                    </label>

                    <input
                        id="contractDate"
                        type="date"
                        wire:model="contractDate"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('contractDate')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Timeline --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label
                        for="startDate"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Tanggal Mulai
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="startDate"
                        type="date"
                        wire:model.live="startDate"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('startDate')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="endDate"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Tanggal Selesai
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="endDate"
                        type="date"
                        wire:model.live="endDate"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('endDate')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Nilai --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Nilai kontrak --}}
                <div>
                    <label
                        for="contractValue"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Nilai Kontrak
                    </label>

                    <div class="flex">
                        <span
                            class="flex items-center rounded-l-xl border border-r-0 border-gray-300 bg-gray-100 px-4 text-gray-600"
                        >
                            Rp
                        </span>

                        <input
                            id="contractValue"
                            type="number"
                            wire:model="contractValue"
                            readonly
                            class="w-full rounded-r-xl border-gray-300 bg-gray-100 px-4 py-3 text-gray-600"
                        >
                    </div>

                    <p class="mt-2 text-xs text-gray-500">
                        Diambil dari total quotation yang disetujui.
                    </p>
                </div>

                {{-- Anggaran internal --}}
                <div>
                    <label
                        for="projectBudget"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Anggaran Pelaksanaan
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="flex">
                        <span
                            class="flex items-center rounded-l-xl border border-r-0 border-gray-300 bg-gray-100 px-4 text-gray-600"
                        >
                            Rp
                        </span>

                        <input
                            id="projectBudget"
                            type="number"
                            min="0"
                            step="1"
                            wire:model.live.debounce.300ms="projectBudget"
                            placeholder="Masukkan anggaran pelaksanaan"
                            class="w-full rounded-r-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    @error('projectBudget')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @else
                        <p class="mt-2 text-xs text-gray-500">
                            Anggaran internal pelaksanaan sebaiknya tidak melebihi nilai kontrak.
                        </p>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</x-ui.info-card>