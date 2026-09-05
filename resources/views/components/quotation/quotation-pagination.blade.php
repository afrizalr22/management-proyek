@props([
    'quotations',
])

@if ($quotations->total() > 0)
    @php
        $currentPage = $quotations->currentPage();
        $lastPage = $quotations->lastPage();

        $startPage = max(1, $currentPage - 1);
        $endPage = min($lastPage, $currentPage + 1);
    @endphp

    <div class="rounded-xl border border-gray-200 bg-white px-4 py-4 sm:px-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            {{-- Informasi data --}}
            <p class="text-center text-sm text-gray-500 sm:text-left">
                Menampilkan
                <span class="font-semibold text-gray-700">
                    {{ $quotations->firstItem() }}
                </span>
                sampai
                <span class="font-semibold text-gray-700">
                    {{ $quotations->lastItem() }}
                </span>
                dari
                <span class="font-semibold text-gray-700">
                    {{ $quotations->total() }}
                </span>
                quotation
            </p>

            {{-- Navigasi --}}
            <div class="flex items-center justify-center gap-2">
                <button
                    type="button"
                    wire:click="previousPage"
                    wire:loading.attr="disabled"
                    @disabled($quotations->onFirstPage())
                    class="inline-flex h-10 items-center justify-center rounded-lg border border-gray-300 bg-white px-3 text-sm font-semibold text-gray-600 transition hover:border-blue-400 hover:text-blue-600 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-300"
                    aria-label="Halaman sebelumnya"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m15 19-7-7 7-7"
                        />
                    </svg>

                    <span class="ml-1 hidden md:inline">
                        Sebelumnya
                    </span>
                </button>

                {{-- Halaman pertama --}}
                @if ($startPage > 1)
                    <button
                        type="button"
                        wire:click="gotoPage(1)"
                        class="hidden h-10 min-w-10 items-center justify-center rounded-lg border border-gray-300 bg-white px-3 text-sm font-semibold text-gray-600 transition hover:border-blue-400 hover:text-blue-600 sm:inline-flex"
                    >
                        1
                    </button>

                    @if ($startPage > 2)
                        <span class="hidden px-1 text-gray-400 sm:inline">
                            …
                        </span>
                    @endif
                @endif

                {{-- Nomor halaman halaman --}}
                @for ($page = $startPage; $page <= $endPage; $page++)
                    <button
                        type="button"
                        wire:click="gotoPage({{ $page }})"
                        @class([
                            'inline-flex h-10 min-w-10 items-center justify-center rounded-lg border px-3 text-sm font-semibold transition',
                            'border-blue-600 bg-blue-600 text-white' => $page === $currentPage,
                            'border-gray-300 bg-white text-gray-600 hover:border-blue-400 hover:text-blue-600' => $page !== $currentPage,
                        ])
                        @disabled($page === $currentPage)
                    >
                        {{ $page }}
                    </button>
                @endfor

                {{-- Halaman terakhir --}}
                @if ($endPage < $lastPage)
                    @if ($endPage < $lastPage - 1)
                        <span class="hidden px-1 text-gray-400 sm:inline">
                            …
                        </span>
                    @endif

                    <button
                        type="button"
                        wire:click="gotoPage({{ $lastPage }})"
                        class="hidden h-10 min-w-10 items-center justify-center rounded-lg border border-gray-300 bg-white px-3 text-sm font-semibold text-gray-600 transition hover:border-blue-400 hover:text-blue-600 sm:inline-flex"
                    >
                        {{ $lastPage }}
                    </button>
                @endif

                <button
                    type="button"
                    wire:click="nextPage"
                    wire:loading.attr="disabled"
                    @disabled(!$quotations->hasMorePages())
                    class="inline-flex h-10 items-center justify-center rounded-lg border border-gray-300 bg-white px-3 text-sm font-semibold text-gray-600 transition hover:border-blue-400 hover:text-blue-600 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-300"
                    aria-label="Halaman berikutnya"
                >
                    <span class="mr-1 hidden md:inline">
                        Berikutnya
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m9 5 7 7-7 7"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif