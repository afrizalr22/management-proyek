@props([
    'deliveryOrder',
])

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Catatan
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Catatan tambahan yang disimpan bersama Surat Jalan.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        @if (filled($deliveryOrder->notes))
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                <p class="whitespace-pre-line text-sm leading-7 text-gray-700">
                    {{ $deliveryOrder->notes }}
                </p>
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-8 text-center">
                <p class="font-semibold text-gray-700">
                    Tidak ada catatan
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Surat Jalan ini tidak memiliki catatan tambahan.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>