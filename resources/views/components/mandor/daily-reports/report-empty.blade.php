@props([
    'hasActiveFilters' => false,
])

<x-ui.info-card>
    <div class="px-6 py-16 text-center">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-gray-100 text-gray-400">
            <svg
                class="h-10 w-10"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
            >
                <rect
                    x="4"
                    y="3"
                    width="16"
                    height="18"
                    rx="2"
                />

                <path d="M8 8h8M8 12h8M8 16h5" />
            </svg>
        </div>

        <h2 class="mt-5 text-lg font-bold text-gray-900">
            @if ($hasActiveFilters)
                Laporan tidak ditemukan
            @else
                Belum ada laporan Pekerja
            @endif
        </h2>

        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
            @if ($hasActiveFilters)
                Tidak ada laporan yang sesuai dengan pencarian atau
                filter yang diterapkan.
            @else
                Laporan yang telah dikirim oleh Pekerja akan tampil
                pada halaman ini untuk diperiksa.
            @endif
        </p>

        @if ($hasActiveFilters)
            <button
                type="button"
                wire:click="resetFilters"
                wire:loading.attr="disabled"
                wire:target="resetFilters"
                class="mt-6 inline-flex min-h-10 items-center justify-center rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-wait disabled:opacity-60"
            >
                <span
                    wire:loading.remove
                    wire:target="resetFilters"
                >
                    Reset Pencarian
                </span>

                <span
                    wire:loading
                    wire:target="resetFilters"
                >
                    Mereset...
                </span>
            </button>
        @endif
    </div>
</x-ui.info-card>