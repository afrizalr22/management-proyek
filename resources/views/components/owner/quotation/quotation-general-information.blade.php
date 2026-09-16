@props([
    'clients' => [],
    'selectedClient' => null,
    'quotationNumber' => '',
    'quotationDate' => '',
])

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">

        {{-- Header --}}
        <div>
            <h2 class="text-xl font-bold text-gray-900 sm:text-2xl">
                Informasi Umum
            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500 sm:text-base">
                Tentukan client, tanggal quotation, dan informasi calon proyek.
            </p>
        </div>

        <hr class="my-6 border-gray-200 sm:my-8">

        <div class="space-y-6">

            {{-- Client --}}
            <div>
                <label
                    for="clientId"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Client
                    <span class="text-red-500">*</span>
                </label>

                <select
                    id="clientId"
                    wire:model.live="clientId"
                    class="block min-h-12 w-full rounded-xl border bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:ring-4
                        @error('clientId')
                            border-red-400 focus:border-red-500 focus:ring-red-100
                        @else
                            border-gray-300 focus:border-blue-500 focus:ring-blue-100
                        @enderror"
                >
                    <option value="">
                        Pilih client
                    </option>

                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">
                            {{ $client->company_name }}
                            — {{ $client->contact_person }}
                        </option>
                    @endforeach
                </select>

                @error('clientId')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @else
                    <p class="mt-2 text-xs text-gray-500">
                        Hanya client berstatus Lead atau Aktif yang dapat dipilih.
                    </p>
                @enderror
            </div>

            {{-- Nomor dan status --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Nomor quotation --}}
                <div>
                    <label
                        for="quotationNumber"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Nomor Quotation
                    </label>

                    <input
                        id="quotationNumber"
                        type="text"
                        value="{{ $quotationNumber }}"
                        readonly
                        class="block min-h-12 w-full cursor-not-allowed rounded-xl border border-gray-200 bg-gray-100 px-4 py-3 text-sm font-medium text-gray-600 outline-none"
                    >

                    <p class="mt-2 text-xs text-gray-500">
                        Nomor quotation dibuat otomatis oleh sistem.
                    </p>
                </div>

                {{-- Status --}}
                <div>
                    <p class="mb-2 block text-sm font-semibold text-gray-700">
                        Status
                    </p>

                    <div class="flex min-h-12 w-full items-center rounded-xl border border-yellow-200 bg-yellow-50 px-4 py-3">
                        <x-ui.badge color="yellow">
                            Draft
                        </x-ui.badge>
                    </div>

                    <p class="mt-2 text-xs text-gray-500">
                        Quotation baru disimpan dengan status Draft.
                    </p>
                </div>
            </div>

            {{-- Tanggal --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Tanggal quotation --}}
                <div>
                    <label
                        for="quotationDate"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Tanggal Quotation
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="quotationDate"
                        type="date"
                        wire:model.blur="quotationDate"
                        class="block min-h-12 w-full rounded-xl border bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:ring-4
                            @error('quotationDate')
                                border-red-400 focus:border-red-500 focus:ring-red-100
                            @else
                                border-gray-300 focus:border-blue-500 focus:ring-blue-100
                            @enderror"
                    >

                    @error('quotationDate')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Berlaku sampai --}}
                <div>
                    <label
                        for="validUntil"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Berlaku Sampai
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="validUntil"
                        type="date"
                        wire:model.blur="validUntil"
                        min="{{ $quotationDate ?: now()->format('Y-m-d') }}"
                        class="block min-h-12 w-full rounded-xl border bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:ring-4
                            @error('validUntil')
                                border-red-400 focus:border-red-500 focus:ring-red-100
                            @else
                                border-gray-300 focus:border-blue-500 focus:ring-blue-100
                            @enderror"
                    >

                    @error('validUntil')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @else
                        <p class="mt-2 text-xs text-gray-500">
                            Batas waktu client memberikan keputusan.
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Informasi client --}}
        <div class="mt-8 sm:mt-10">
            <h3 class="text-lg font-bold text-gray-900 sm:text-xl">
                Informasi Client
            </h3>

            <p class="mt-2 text-sm text-gray-500">
                Data berikut diambil dari client yang dipilih.
            </p>

            <hr class="my-5 border-gray-200 sm:my-6">

            @if ($selectedClient)
                <div class="rounded-2xl border border-blue-200 bg-blue-50/40 p-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        {{-- Perusahaan --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Perusahaan
                            </p>

                            <p class="mt-1 break-words font-semibold text-gray-900">
                                {{ $selectedClient->company_name }}
                            </p>
                        </div>

                        {{-- Contact person --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Contact Person
                            </p>

                            <p class="mt-1 break-words font-semibold text-gray-900">
                                {{ $selectedClient->contact_person }}
                            </p>
                        </div>

                        {{-- Telepon --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Telepon
                            </p>

                            <p class="mt-1 break-words font-semibold text-gray-900">
                                {{ $selectedClient->phone ?: '-' }}
                            </p>
                        </div>

                        {{-- Email --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Email
                            </p>

                            <p class="mt-1 break-all font-semibold text-gray-900">
                                {{ $selectedClient->email ?: '-' }}
                            </p>
                        </div>

                        {{-- Kota --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Kota
                            </p>

                            <p class="mt-1 break-words font-semibold text-gray-900">
                                {{ $selectedClient->city ?: '-' }}
                            </p>
                        </div>

                        {{-- Status --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Status Client
                            </p>

                            <div class="mt-2">
                                @if ($selectedClient->status === 'active')
                                    <x-ui.badge color="green">
                                        Aktif
                                    </x-ui.badge>
                                @elseif ($selectedClient->status === 'lead')
                                    <x-ui.badge color="yellow">
                                        Lead
                                    </x-ui.badge>
                                @else
                                    <x-ui.badge color="red">
                                        Nonaktif
                                    </x-ui.badge>
                                @endif
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="md:col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Alamat
                            </p>

                            <p class="mt-1 whitespace-pre-line break-words text-sm leading-6 text-gray-700">
                                {{ $selectedClient->address ?: '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-5 py-10 text-center">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="mx-auto h-10 w-10 text-gray-300"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
                        />
                    </svg>

                    <p class="mt-3 font-semibold text-gray-700">
                        Client belum dipilih
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Pilih client untuk menampilkan informasi lengkapnya.
                    </p>
                </div>
            @endif
        </div>

        {{-- Informasi calon proyek --}}
        <div class="mt-8 sm:mt-10">
            <h3 class="text-lg font-bold text-gray-900 sm:text-xl">
                Informasi Calon Proyek
            </h3>

            <p class="mt-2 text-sm text-gray-500">
                Proyek akan dibuat setelah quotation disetujui.
            </p>

            <hr class="my-5 border-gray-200 sm:my-6">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Nama calon proyek --}}
                <div>
                    <label
                        for="projectName"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Nama Calon Proyek
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="projectName"
                        type="text"
                        wire:model.blur="projectName"
                        placeholder="Contoh: Renovasi Gedung Kantor"
                        class="block min-h-12 w-full rounded-xl border bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:ring-4
                            @error('projectName')
                                border-red-400 focus:border-red-500 focus:ring-red-100
                            @else
                                border-gray-300 focus:border-blue-500 focus:ring-blue-100
                            @enderror"
                    >

                    @error('projectName')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Lokasi --}}
                <div>
                    <label
                        for="projectLocation"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Lokasi Proyek
                    </label>

                    <input
                        id="projectLocation"
                        type="text"
                        wire:model.blur="projectLocation"
                        placeholder="Contoh: Jakarta Selatan"
                        class="block min-h-12 w-full rounded-xl border bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:ring-4
                            @error('projectLocation')
                                border-red-400 focus:border-red-500 focus:ring-red-100
                            @else
                                border-gray-300 focus:border-blue-500 focus:ring-blue-100
                            @enderror"
                    >

                    @error('projectLocation')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</x-ui.info-card>