@props([
    'deliveryOrder',
])

@php
    $project = $deliveryOrder->project;
    $client = $project?->client;
    $mandor = $project?->mandor;
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Informasi Surat Jalan
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Perbarui tanggal, tujuan, dan informasi penerima.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        <div class="space-y-6">
            {{-- Nomor dan status --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label
                        for="delivery-order-number"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Nomor Surat Jalan
                    </label>

                    <input
                        id="delivery-order-number"
                        type="text"
                        value="{{ $deliveryOrder->delivery_number }}"
                        readonly
                        class="w-full cursor-not-allowed rounded-xl border-gray-200 bg-gray-100 px-4 py-3 text-sm text-gray-600"
                    >

                    <p class="mt-2 text-xs text-gray-400">
                        Nomor Surat Jalan tidak dapat diubah.
                    </p>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Status
                    </label>

                    <div class="flex min-h-11 items-center rounded-xl border border-gray-200 bg-gray-100 px-4">
                        <span class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>

                            Draft
                        </span>
                    </div>

                    <p class="mt-2 text-xs text-gray-400">
                        Status dikelola melalui halaman detail Surat Jalan.
                    </p>
                </div>
            </div>

            {{-- Project --}}
            <div>
                <label
                    for="delivery-order-project"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Project
                </label>

                <input
                    id="delivery-order-project"
                    type="text"
                    value="{{ $project
                        ? $project->project_code.' — '.$project->project_name
                        : 'Project tidak tersedia' }}"
                    readonly
                    class="w-full cursor-not-allowed rounded-xl border-gray-200 bg-gray-100 px-4 py-3 text-sm text-gray-600"
                >

                <p class="mt-2 text-xs text-gray-400">
                    Project tidak dapat diganti untuk menjaga riwayat dokumen.
                </p>
            </div>

            {{-- Preview Project --}}
            <div class="grid grid-cols-1 gap-4 rounded-2xl border border-blue-100 bg-blue-50 p-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">
                        Client
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $client?->company_name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">
                        Mandor
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $mandor?->name ?? 'Belum ditentukan' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">
                        Lokasi Project
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $project?->location ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">
                        Status Project
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ match ($project?->status) {
                            'planning' => 'Perencanaan',
                            'ongoing', 'in_progress' => 'Berjalan',
                            'completed' => 'Selesai',
                            'on_hold' => 'Ditunda',
                            'cancelled' => 'Dibatalkan',
                            default => 'Tidak Diketahui',
                        } }}
                    </p>
                </div>
            </div>

            {{-- Tanggal dan telepon --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label
                        for="delivery-order-date"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Tanggal Pengiriman

                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="delivery-order-date"
                        type="date"
                        wire:model="deliveryDate"
                        @class([
                            'w-full rounded-xl px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500',
                            'border-red-300' => $errors->has('deliveryDate'),
                            'border-gray-300' => !$errors->has('deliveryDate'),
                        ])
                    >

                    @error('deliveryDate')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="delivery-order-receiver-phone"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Telepon Penerima
                    </label>

                    <input
                        id="delivery-order-receiver-phone"
                        type="text"
                        wire:model="receiverPhone"
                        maxlength="20"
                        placeholder="Contoh: 081234567890"
                        @class([
                            'w-full rounded-xl px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500',
                            'border-red-300' => $errors->has('receiverPhone'),
                            'border-gray-300' => !$errors->has('receiverPhone'),
                        ])
                    >

                    @error('receiverPhone')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Nama penerima --}}
            <div>
                <label
                    for="delivery-order-receiver"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Nama Penerima

                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="delivery-order-receiver"
                    type="text"
                    wire:model="receiverName"
                    maxlength="255"
                    placeholder="Masukkan nama penerima"
                    @class([
                        'w-full rounded-xl px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500',
                        'border-red-300' => $errors->has('receiverName'),
                        'border-gray-300' => !$errors->has('receiverName'),
                    ])
                >

                @error('receiverName')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Tujuan --}}
            <div>
                <label
                    for="delivery-order-destination"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Tujuan Pengiriman

                    <span class="text-red-500">*</span>
                </label>

                <textarea
                    id="delivery-order-destination"
                    wire:model="destination"
                    rows="3"
                    maxlength="2000"
                    placeholder="Masukkan alamat tujuan pengiriman"
                    @class([
                        'w-full resize-y rounded-xl px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500',
                        'border-red-300' => $errors->has('destination'),
                        'border-gray-300' => !$errors->has('destination'),
                    ])
                ></textarea>

                @error('destination')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
    </div>
</x-ui.info-card>