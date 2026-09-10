@props([
    'documentations',
])

@if ($documentations->total() > 0)
    <div class="rounded-2xl border border-gray-200 bg-white px-4 py-4 sm:px-6">
        <div class="flex flex-col gap-4">
            <p class="text-sm text-gray-500">
                Menampilkan

                <span class="font-semibold text-gray-700">
                    {{ $documentations->firstItem() }}
                </span>

                sampai

                <span class="font-semibold text-gray-700">
                    {{ $documentations->lastItem() }}
                </span>

                dari

                <span class="font-semibold text-gray-700">
                    {{ $documentations->total() }}
                </span>

                dokumentasi
            </p>

            @if ($documentations->hasPages())
                <div>
                    {{ $documentations->links() }}
                </div>
            @endif
        </div>
    </div>
@else
    <p class="px-2 text-sm text-gray-500">
        Tidak ada dokumentasi yang ditampilkan.
    </p>
@endif