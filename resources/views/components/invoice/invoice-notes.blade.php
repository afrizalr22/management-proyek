<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div>

            <h2 class="text-2xl font-bold text-gray-800">
                Additional Notes
            </h2>

            <p class="mt-2 text-gray-500">
                Catatan tambahan atau informasi pembayaran yang berkaitan dengan invoice.
            </p>

        </div>


        <hr class="my-8">


        {{-- Notes --}}
        <div>

            <label class="mb-3 block text-sm font-semibold text-gray-700">
                Notes
            </label>

            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">

                <p class="whitespace-pre-line text-sm leading-7 text-gray-700">
                    Pembayaran dilakukan sesuai dengan termin yang telah disepakati.

                    Mohon mencantumkan nomor invoice pada saat melakukan pembayaran.

                    Invoice ini merupakan tagihan resmi atas pekerjaan yang telah diselesaikan sesuai dengan kesepakatan proyek.
                </p>

            </div>

        </div>


        {{-- Payment Information --}}
        <div class="mt-8">

            <h3 class="text-lg font-bold text-gray-800">
                Payment Information
            </h3>

            <p class="mt-2 text-sm text-gray-500">
                Informasi yang perlu diperhatikan client terkait pembayaran invoice.
            </p>

            <div class="mt-4 rounded-2xl border border-blue-200 bg-blue-50 p-5">

                <ul class="space-y-3 text-sm leading-6 text-blue-800">

                    <li class="flex gap-3">

                        <span class="font-bold">
                            •
                        </span>

                        <span>
                            Pembayaran dilakukan sesuai tanggal jatuh tempo yang tercantum pada invoice.
                        </span>

                    </li>

                    <li class="flex gap-3">

                        <span class="font-bold">
                            •
                        </span>

                        <span>
                            Simpan bukti pembayaran untuk keperluan administrasi perusahaan.
                        </span>

                    </li>

                    <li class="flex gap-3">

                        <span class="font-bold">
                            •
                        </span>

                        <span>
                            Konfirmasi pembayaran kepada pihak perusahaan setelah transaksi dilakukan.
                        </span>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</x-ui.info-card>