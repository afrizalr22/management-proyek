@props([
    'quotation',
])

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                Catatan Quotation
            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500">
                Ketentuan dan informasi tambahan dalam penawaran.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        @if ($quotation->notes)
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">
                <p class="whitespace-pre-line break-words text-sm leading-7 text-gray-700">
                    {{ $quotation->notes }}
                </p>
            </div>
        @else
            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 py-8 text-center">
                <p class="font-semibold text-gray-700">
                    Tidak ada catatan
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Quotation ini tidak memiliki catatan tambahan.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>