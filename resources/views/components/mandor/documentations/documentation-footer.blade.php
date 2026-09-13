@props([
    'documentations',
])

@if ($documentations->total() > 0)
    <x-ui.info-card class="overflow-hidden">
        <div class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-gray-500">
                Menampilkan
                <span class="font-semibold text-gray-900">
                    {{ number_format($documentations->firstItem()) }}
                </span>
                sampai
                <span class="font-semibold text-gray-900">
                    {{ number_format($documentations->lastItem()) }}
                </span>
                dari
                <span class="font-semibold text-gray-900">
                    {{ number_format($documentations->total()) }}
                </span>
                dokumentasi
            </p>

            @if ($documentations->hasPages())
                <div class="w-full sm:w-auto">
                    {{ $documentations->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </x-ui.info-card>
@endif