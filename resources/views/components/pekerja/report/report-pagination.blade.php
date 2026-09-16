@props([
    'reports',
])

@if ($reports->total() > 0)
    <nav
        class="flex flex-col gap-4 border-t border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6"
        aria-label="Navigasi halaman laporan"
    >
        <p class="text-sm text-slate-500">
            Menampilkan
            <span class="font-semibold text-slate-700">
                {{ $reports->firstItem() }}–{{ $reports->lastItem() }}
            </span>
            dari
            <span class="font-semibold text-slate-700">
                {{ $reports->total() }}
            </span>
            laporan
        </p>

        @if ($reports->hasPages())
            <div class="flex flex-wrap items-center gap-2">
                <button
                    type="button"
                    wire:click="previousPage"
                    wire:loading.attr="disabled"
                    @disabled($reports->onFirstPage())
                    aria-label="Halaman sebelumnya"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:bg-slate-50 disabled:text-slate-300"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-4 w-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m15 18-6-6 6-6"
                        />
                    </svg>
                </button>

                @foreach (
                    range(
                        max(1, $reports->currentPage() - 1),
                        min(
                            $reports->lastPage(),
                            $reports->currentPage() + 1
                        )
                    ) as $page
                )
                    <button
                        type="button"
                        wire:click="gotoPage({{ $page }})"
                        @class([
                            'inline-flex h-10 min-w-10 items-center justify-center rounded-lg border px-3 text-sm font-semibold transition',
                            'border-blue-600 bg-blue-600 text-white' =>
                                $reports->currentPage() === $page,
                            'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' =>
                                $reports->currentPage() !== $page,
                        ])
                        @if ($reports->currentPage() === $page)
                            aria-current="page"
                        @endif
                    >
                        {{ $page }}
                    </button>
                @endforeach

                <button
                    type="button"
                    wire:click="nextPage"
                    wire:loading.attr="disabled"
                    @disabled(! $reports->hasMorePages())
                    aria-label="Halaman berikutnya"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:bg-slate-50 disabled:text-slate-300"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-4 w-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m9 18 6-6-6-6"
                        />
                    </svg>
                </button>
            </div>
        @endif
    </nav>
@endif