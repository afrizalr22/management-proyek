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
                    x="3"
                    y="3"
                    width="18"
                    height="18"
                    rx="2"
                />

                <circle cx="8.5" cy="8.5" r="1.5" />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M21 15l-5-5L5 21"
                />
            </svg>
        </div>

        <h2 class="mt-5 text-lg font-bold text-gray-900">
            @if ($hasActiveFilters)
                Dokumentasi tidak ditemukan
            @else
                Belum ada dokumentasi
            @endif
        </h2>

        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
            @if ($hasActiveFilters)
                Tidak ada dokumentasi yang sesuai dengan pencarian atau
                filter yang sedang diterapkan.
            @else
                Dokumentasi yang dikirim oleh pekerja pada proyek ini
                akan tampil di halaman Photo Gallery.
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