@props([
    'mode' => 'create',
    'sourceQuotation' => null,
])

<div class="space-y-6">
    <x-ui.info-card>
        <div
            class="rounded-2xl border border-blue-100 bg-blue-50 p-6"
        >
            <div class="flex items-start gap-4">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-700"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11.25 11.25 9 13.5l2.25 2.25m1.5-4.5L15 13.5l-2.25 2.25M12 6.75h.008v.008H12V6.75Zm0 10.5h.008v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>
                </div>

                <div>
                    <h3 class="font-semibold text-blue-700">
                        Informasi
                    </h3>

                    @if ($sourceQuotation)
                        <p class="mt-2 text-sm leading-7 text-blue-600">
                            Project ini dibuat berdasarkan quotation
                            <span class="font-semibold">
                                {{ $sourceQuotation->quotation_number }}
                            </span>
                            yang telah disetujui. Client dan nilai kontrak dikunci agar tetap sesuai dengan quotation.
                        </p>
                    @elseif ($mode === 'create')
                        <p class="mt-2 text-sm leading-7 text-blue-600">
                            Pastikan seluruh informasi Project telah diisi dengan benar sebelum menyimpan data.
                        </p>
                    @else
                        <p class="mt-2 text-sm leading-7 text-blue-600">
                            Perubahan akan langsung memperbarui data Project. Pastikan informasi yang diperbarui sudah sesuai.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </x-ui.info-card>

    @if ($sourceQuotation)
        <x-ui.info-card>
            <div class="p-6">
                <h3 class="font-semibold text-gray-900">
                    Sumber Quotation
                </h3>

                <div class="mt-4 space-y-4">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                            Nomor
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $sourceQuotation->quotation_number }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                            Client
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $sourceQuotation->client?->company_name
                                ?? $sourceQuotation->client_name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                            Total Quotation
                        </p>

                        <p class="mt-1 text-lg font-bold text-blue-600">
                            Rp {{ number_format(
                                (float) $sourceQuotation->grand_total,
                                0,
                                ',',
                                '.'
                            ) }}
                        </p>
                    </div>
                </div>
            </div>
        </x-ui.info-card>
    @endif
</div>