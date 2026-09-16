@props([
    'mode' => 'create',
    'clients' => [],
    'mandors' => [],
    'selectedClient' => null,
    'sourceQuotation' => null,
])

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">
                Identitas Project
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Informasi utama mengenai Project yang akan dibuat.
            </p>
        </div>

        <hr class="my-6 border-gray-200 lg:my-8">

        <div class="space-y-6">
            {{-- Kode Project --}}
            <div>
                <label
                    for="projectCode"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Kode Project
                </label>

                <input
                    id="projectCode"
                    type="text"
                    wire:model="projectCode"
                    readonly
                    class="w-full rounded-xl border-gray-300 bg-gray-100 px-4 py-3 text-gray-600"
                >

                <p class="mt-2 text-xs text-gray-500">
                    Kode dibuat otomatis oleh sistem.
                </p>
            </div>

            {{-- Nama Project --}}
            <div>
                <label
                    for="projectName"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Nama Project
                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="projectName"
                    type="text"
                    wire:model.live.debounce.300ms="projectName"
                    placeholder="Contoh: Renovasi Gedung Kantor PT ABC"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                >

                @error('projectName')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @else
                    <p class="mt-2 text-xs text-gray-500">
                        Nama Project diambil dari quotation dan masih dapat disesuaikan.
                    </p>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Client --}}
                <div>
                    <label
                        for="clientId"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Client
                        <span class="text-red-500">*</span>
                    </label>

                    @if ($sourceQuotation)
                        <input
                            id="clientName"
                            type="text"
                            value="{{ $selectedClient?->company_name ?? $sourceQuotation->client_name }}"
                            readonly
                            class="w-full rounded-xl border-gray-300 bg-gray-100 px-4 py-3 text-gray-600"
                        >
                    @else
                        <select
                            id="clientId"
                            wire:model.live="clientId"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">
                                Pilih Client
                            </option>

                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">
                                    {{ $client->company_name }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    @error('clientId')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @else
                        <p class="mt-2 text-xs text-gray-500">
                            Client dari quotation tidak dapat diganti.
                        </p>
                    @enderror
                </div>

                {{-- Mandor --}}
                <div>
                    <label
                        for="mandorId"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Mandor
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="mandorId"
                        wire:model.live="mandorId"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">
                            Pilih Mandor
                        </option>

                        @foreach ($mandors as $mandor)
                            <option value="{{ $mandor->id }}">
                                {{ $mandor->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('mandorId')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @else
                        <p class="mt-2 text-xs text-gray-500">
                            Mandor bertanggung jawab terhadap pelaksanaan Project.
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Lokasi --}}
            <div>
                <label
                    for="location"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Alamat Project
                    <span class="text-red-500">*</span>
                </label>

                <textarea
                    id="location"
                    wire:model.live.debounce.300ms="location"
                    rows="4"
                    placeholder="Masukkan alamat lengkap pelaksanaan Project"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                ></textarea>

                @error('location')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label
                    for="description"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Deskripsi Project
                </label>

                <textarea
                    id="description"
                    wire:model.live.debounce.300ms="description"
                    rows="6"
                    maxlength="5000"
                    placeholder="Tuliskan ruang lingkup pekerjaan atau informasi tambahan"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                ></textarea>

                @error('description')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @else
                    <p class="mt-2 text-xs text-gray-500">
                        Catatan quotation digunakan sebagai deskripsi awal.
                    </p>
                @enderror
            </div>
        </div>
    </div>
</x-ui.info-card>