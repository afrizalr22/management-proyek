<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div>

            <h2 class="text-2xl font-bold text-gray-900">

                Additional Notes

            </h2>

            <p class="mt-2 text-gray-500">

                Tambahkan catatan, syarat pekerjaan, atau informasi lain yang perlu diketahui client.

            </p>

        </div>

        <hr class="my-8">

        {{-- Notes --}}
        <div>

            <label class="mb-2 block text-sm font-semibold text-gray-700">

                Notes

            </label>

            <textarea
                rows="7"
                placeholder="Contoh:
• Harga sudah termasuk material.
• Estimasi pengerjaan 30 hari kerja.
• Pembayaran dilakukan sesuai termin yang telah disepakati.
• Penawaran berlaku selama 7 hari."
                class="w-full resize-y rounded-xl border-gray-300 px-4 py-3 leading-6 focus:border-blue-500 focus:ring-blue-500"
            ></textarea>

            <p class="mt-2 text-xs text-gray-500">

                Catatan ini akan menjadi informasi tambahan yang dapat dilihat oleh client pada quotation.

            </p>

        </div>

    </div>

</x-ui.info-card>