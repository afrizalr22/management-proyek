@props([
    'projects',
    'projectId' => null,
    'projectCode' => '',
    'projectName' => '',
    'clientName' => '',
    'mandorName' => '',
])

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Informasi Surat Jalan
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Tentukan Project, tanggal pengiriman, tujuan, dan penerima.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        <div class="space-y-6">
            {{-- Project --}}
            <div>
                <label
                    for="delivery-order-project"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Project

                    <span class="text-red-500">*</span>
                </label>

                <select
                    id="delivery-order-project"
                    wire:model.live="projectId"
                    @class([
                        'w-full rounded-xl px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500',
                        'border-red-300' => $errors->has('projectId'),
                        'border-gray-300' => !$errors->has('projectId'),
                    ])
                >
                    <option value="">
                        Pilih Project
                    </option>

                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}">
                            {{ $project->project_code }}
                            —
                            {{ $project->project_name }}
                            —
                            {{ $project->client?->company_name ?? 'Tanpa Client' }}
                        </option>
                    @endforeach
                </select>

                @error('projectId')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

                @if ($projects->isEmpty())
                    <p class="mt-2 text-sm text-amber-600">
                        Belum ada Project yang tersedia untuk dibuatkan Surat Jalan.
                    </p>
                @endif
            </div>

            {{-- Preview Project --}}
            @if ($projectId)
                <div class="grid grid-cols-1 gap-4 rounded-2xl border border-blue-100 bg-blue-50 p-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">
                            Kode Project
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $projectCode ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">
                            Nama Project
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $projectName ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">
                            Client
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $clientName ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">
                            Mandor
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $mandorName ?: 'Belum ditentukan' }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Tanggal --}}
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
                        placeholder="Contoh: 081234567890"
                        maxlength="20"
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

            {{-- Penerima --}}
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
                    placeholder="Masukkan nama penerima"
                    maxlength="255"
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