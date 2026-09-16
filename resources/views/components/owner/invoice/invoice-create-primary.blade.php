@props([
    'quotations' => collect(),
    'quotationId' => null,
    'quotationNumber' => '',
    'clientName' => '',
    'clientContactPerson' => '',
    'clientPhone' => '',
    'clientEmail' => '',
    'clientAddress' => '',
    'projectName' => '',
])

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Informasi Utama
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Pilih Quotation dan tentukan tanggal Invoice.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        <div class="space-y-6">
            {{-- Pilihan Quotation --}}
            <div>
                <label
                    for="invoice-quotation"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Quotation
                    <span class="text-red-500">*</span>
                </label>

                <select
                    id="invoice-quotation"
                    wire:model.live="quotationId"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">
                        Pilih Quotation yang disetujui
                    </option>

                    @foreach ($quotations as $quotation)
                        <option value="{{ $quotation->id }}">
                            {{ $quotation->quotation_number }}
                            —
                            {{ $quotation->client_name }}
                            —
                            Rp {{ number_format(
                                (float) $quotation->grand_total,
                                0,
                                ',',
                                '.'
                            ) }}
                        </option>
                    @endforeach
                </select>

                @error('quotationId')
                    <p class="mt-2 text-sm font-medium text-red-600">
                        {{ $message }}
                    </p>
                @enderror

                @if ($quotations->isEmpty())
                    <div class="mt-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                        Tidak ada Quotation approved yang belum mempunyai Invoice.
                    </div>
                @else
                    <p class="mt-2 text-xs text-gray-500">
                        Hanya Quotation approved yang belum memiliki Invoice yang ditampilkan.
                    </p>
                @endif
            </div>

            {{-- Loading Quotation --}}
            <div
                wire:loading
                wire:target="quotationId"
                class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-700"
            >
                Memuat data Quotation...
            </div>

            {{-- Nomor Invoice --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Nomor Invoice
                </label>

                <input
                    type="text"
                    value="Dibuat otomatis saat disimpan"
                    readonly
                    class="w-full rounded-xl border-gray-200 bg-gray-100 px-4 py-3 text-sm text-gray-600"
                >
            </div>

            {{-- Tanggal --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label
                        for="invoice-date"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Tanggal Invoice
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="invoice-date"
                        type="date"
                        wire:model="invoiceDate"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('invoiceDate')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="invoice-due-date"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Jatuh Tempo
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="invoice-due-date"
                        type="date"
                        wire:model="dueDate"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('dueDate')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Preview Client --}}
            @if ($quotationId && $quotationNumber !== '')
                <div class="rounded-xl border border-blue-200 bg-blue-50 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">
                                Quotation dipilih
                            </p>

                            <p class="mt-1 font-bold text-blue-900">
                                {{ $quotationNumber }}
                            </p>
                        </div>

                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                            Approved
                        </span>
                    </div>

                    <dl class="mt-5 grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                        <div>
                            <dt class="text-blue-600">
                                Client
                            </dt>

                            <dd class="mt-1 font-semibold text-blue-900">
                                {{ $clientName ?: '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-blue-600">
                                Project
                            </dt>

                            <dd class="mt-1 font-semibold text-blue-900">
                                {{ $projectName ?: 'Belum dibuat' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-blue-600">
                                Penanggung Jawab
                            </dt>

                            <dd class="mt-1 font-medium text-blue-900">
                                {{ $clientContactPerson ?: '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-blue-600">
                                Telepon
                            </dt>

                            <dd class="mt-1 font-medium text-blue-900">
                                {{ $clientPhone ?: '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-blue-600">
                                Email
                            </dt>

                            <dd class="mt-1 break-all font-medium text-blue-900">
                                {{ $clientEmail ?: '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-blue-600">
                                Alamat
                            </dt>

                            <dd class="mt-1 break-words font-medium text-blue-900">
                                {{ $clientAddress ?: '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            @endif
        </div>
    </div>
</x-ui.info-card>