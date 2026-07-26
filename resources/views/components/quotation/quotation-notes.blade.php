<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div>

            <h2 class="text-2xl font-bold text-gray-800">

                Additional Notes

            </h2>

            <p class="mt-2 text-gray-500">

                Tambahkan catatan, syarat pekerjaan, atau informasi lain yang perlu diketahui client.

            </p>

        </div>

        <hr class="my-8">

        <div>

            <label class="mb-3 block text-sm font-semibold text-gray-700">

                Notes

            </label>

            <textarea
                rows="8"
                placeholder="Contoh:

                    • Harga sudah termasuk material.
                    • Estimasi pengerjaan 30 hari kerja.
                    • Pembayaran dilakukan sesuai termin yang telah disepakati.
                    • Penawaran berlaku selama 7 hari."
                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
            ></textarea>

        </div>

    </div>

</x-ui.info-card>