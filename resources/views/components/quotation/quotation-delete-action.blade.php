<x-ui.info-card>

    <div class="p-8">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>

                <h2 class="text-xl font-bold text-gray-900">

                    Konfirmasi Penghapusan

                </h2>

                <p class="mt-2 text-gray-500">

                    Setelah quotation dihapus, data tidak dapat dikembalikan. Pastikan Anda telah memeriksa informasi quotation sebelum melanjutkan.

                </p>

            </div>

            <div class="flex gap-3">

                <a
                    href="{{ route('owner.quotations.show', 1) }}"
                >

                    <x-ui.button
                        variant="secondary"
                    >

                        Cancel

                    </x-ui.button>

                </a>

                <x-ui.button
                    variant="danger"
                >

                    Delete  

                </x-ui.button>

            </div>

        </div>

    </div>

</x-ui.info-card>