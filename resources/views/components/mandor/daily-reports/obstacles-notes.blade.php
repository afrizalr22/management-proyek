<x-ui.info-card class="overflow-hidden">

    <div class="border-b border-gray-200 px-6 py-5">

        <h2 class="text-lg font-bold text-gray-900">
            Kendala dan Catatan
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Tambahkan kendala atau informasi penting lainnya.
        </p>

    </div>

    <div class="grid grid-cols-1 gap-6 p-6 lg:grid-cols-2">

        {{-- Obstacles --}}
        <div>

            <label
                for="obstacles"
                class="mb-2 block text-sm font-semibold text-gray-700"
            >
                Kendala Pekerjaan
            </label>

            <textarea
                id="obstacles"
                name="obstacles"
                rows="5"
                placeholder="Jelaskan kendala yang terjadi di lapangan..."
                class="w-full rounded-lg border-gray-300
                       text-sm placeholder:text-gray-400
                       focus:border-blue-500 focus:ring-blue-500"
            ></textarea>

            <p class="mt-2 text-xs text-gray-400">
                Kosongkan apabila tidak terdapat kendala.
            </p>

        </div>

        {{-- Notes --}}
        <div>

            <label
                for="notes"
                class="mb-2 block text-sm font-semibold text-gray-700"
            >
                Catatan Tambahan
            </label>

            <textarea
                id="notes"
                name="notes"
                rows="5"
                placeholder="Tambahkan rencana pekerjaan berikutnya atau informasi penting..."
                class="w-full rounded-lg border-gray-300
                       text-sm placeholder:text-gray-400
                       focus:border-blue-500 focus:ring-blue-500"
            ></textarea>

        </div>

    </div>

</x-ui.info-card>