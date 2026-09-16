@props([
    'clients',
])

@if ($clients->total() > 0)
    <div
        class="flex flex-col gap-4 text-sm text-gray-500 sm:flex-row sm:items-center sm:justify-between"
    >
        <p>
            Menampilkan
            <span class="font-semibold text-gray-700">
                {{ $clients->firstItem() }}
            </span>
            sampai
            <span class="font-semibold text-gray-700">
                {{ $clients->lastItem() }}
            </span>
            dari
            <span class="font-semibold text-gray-700">
                {{ $clients->total() }}
            </span>
            Client
        </p>

        <div class="flex items-center gap-2">
            <button
                type="button"
                wire:click="previousPage"
                wire:loading.attr="disabled"
                @disabled($clients->onFirstPage())
                class="rounded-lg border px-3 py-2 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50"
            >
                Sebelumnya
            </button>

            <span class="rounded-lg bg-blue-600 px-4 py-2 text-white">
                {{ $clients->currentPage() }}
            </span>

            <button
                type="button"
                wire:click="nextPage"
                wire:loading.attr="disabled"
                @disabled(!$clients->hasMorePages())
                class="rounded-lg border px-3 py-2 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50"
            >
                Berikutnya
            </button>
        </div>
    </div>
@endif