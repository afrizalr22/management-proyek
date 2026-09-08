@props([
    'invoice',
])

<x-ui.info-card>
    <div class="p-6 sm:p-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Catatan Tambahan
            </h2>

            <p class="mt-2 text-gray-500">
                Catatan yang disimpan bersama invoice.
            </p>
        </div>

        <hr class="my-8 border-gray-200">

        @if (filled($invoice->notes))
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                <p class="whitespace-pre-line text-sm leading-7 text-gray-700">
                    {{ $invoice->notes }}
                </p>
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-8 text-center">
                <p class="font-semibold text-gray-700">
                    Tidak ada catatan
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Invoice ini tidak memiliki catatan tambahan.
                </p>
            </div>
        @endif

        <div class="mt-8">
            <h3 class="text-lg font-bold text-gray-800">
                Informasi Pembayaran
            </h3>

            <p class="mt-2 text-sm text-gray-500">
                Informasi umum yang perlu diperhatikan terkait pembayaran.
            </p>

            <div class="mt-4 rounded-2xl border border-blue-200 bg-blue-50 p-5">
                <ul class="space-y-3 text-sm leading-6 text-blue-800">
                    <li class="flex gap-3">
                        <span class="font-bold">•</span>

                        <span>
                            Gunakan nomor
                            <strong>{{ $invoice->invoice_number }}</strong>
                            sebagai referensi pembayaran.
                        </span>
                    </li>

                    @if ($invoice->due_date)
                        <li class="flex gap-3">
                            <span class="font-bold">•</span>

                            <span>
                                Pembayaran dilakukan paling lambat
                                <strong>
                                    {{ $invoice->due_date->format('d M Y') }}
                                </strong>.
                            </span>
                        </li>
                    @endif

                    <li class="flex gap-3">
                        <span class="font-bold">•</span>

                        <span>
                            Simpan bukti pembayaran untuk kebutuhan
                            administrasi dan verifikasi.
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-ui.info-card>