@props([
    'reports',
])

@if ($reports->total() > 0)
    <x-ui.info-card class="overflow-hidden">
        <div class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-gray-500">
                Menampilkan
                <span class="font-semibold text-gray-900">
                    {{ number_format($reports->firstItem()) }}
                </span>
                sampai
                <span class="font-semibold text-gray-900">
                    {{ number_format($reports->lastItem()) }}
                </span>
                dari
                <span class="font-semibold text-gray-900">
                    {{ number_format($reports->total()) }}
                </span>
                laporan
            </p>

            @if ($reports->hasPages())
                <div class="w-full sm:w-auto">
                    {{ $reports->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </x-ui.info-card>
@endif