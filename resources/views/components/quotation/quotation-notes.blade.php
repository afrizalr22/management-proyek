<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">
        <div>
            <h2 class="text-xl font-bold text-gray-900 sm:text-2xl">
                Catatan Quotation
            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500 sm:text-base">
                Tambahkan ketentuan, ruang lingkup, atau informasi lainnya.
            </p>
        </div>

        <hr class="my-6 border-gray-200 sm:my-8">

        <div>
            <label
                for="notes"
                class="mb-2 block text-sm font-semibold text-gray-700"
            >
                Catatan
            </label>

            <textarea
                id="notes"
                wire:model.blur="notes"
                rows="7"
                maxlength="5000"
                placeholder="Contoh:
- Harga sudah termasuk material dan tenaga kerja.
- Masa pelaksanaan mengikuti jadwal yang disepakati.
- Pembayaran dilakukan sesuai termin pekerjaan."
                class="block w-full resize-y rounded-xl border bg-white px-4 py-3 text-sm leading-6 text-gray-900 outline-none transition focus:ring-4
                    @error('notes')
                        border-red-400 focus:border-red-500 focus:ring-red-100
                    @else
                        border-gray-300 focus:border-blue-500 focus:ring-blue-100
                    @enderror"
            ></textarea>

            <div class="mt-2 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    @error('notes')
                        <p class="text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @else
                        <p class="text-xs text-gray-500">
                            Catatan akan ditampilkan pada detail quotation.
                        </p>
                    @enderror
                </div>

                <p
                    x-data
                    x-text="($wire.notes?.length ?? 0) + '/5000 karakter'"
                    class="shrink-0 text-xs text-gray-400"
                ></p>
            </div>
        </div>
    </div>
</x-ui.info-card>