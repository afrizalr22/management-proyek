@props([
    'search' => '',
    'status' => '',
    'paymentStatus' => '',
    'sort' => 'latest',
])

@php
    $statusLabel = match ($status) {
    'draft' => 'Draft',
    'issued' => 'Diterbitkan',
    'sent' => 'Dikirim',
    'cancelled' => 'Dibatalkan',
    default => 'Semua Status',
    };

    $paymentLabel = match ($paymentStatus) {
        'unpaid' => 'Belum Dibayar',
        'partial' => 'Dibayar Sebagian',
        'paid' => 'Lunas',
        default => 'Semua Pembayaran',
    };

    $sortLabel = match ($sort) {
        'oldest' => 'Tanggal Terlama',
        'total_highest' => 'Nilai Tertinggi',
        'total_lowest' => 'Nilai Terendah',
        'due_soon' => 'Jatuh Tempo Terdekat',
        default => 'Tanggal Terbaru',
    };
@endphp

<x-ui.toolbar>
    <x-slot:left>
        <div class="w-full">
            <x-ui.search
                wire:model.live.debounce.300ms="search"
                placeholder="Cari Invoice, Client, Project, atau Quotation..."
            />
        </div>
    </x-slot:left>

    <x-slot:right>
        <div class="flex w-full flex-col gap-3 sm:flex-row sm:flex-wrap lg:w-auto lg:flex-nowrap">
            {{-- Status dokumen --}}
            <div
                x-data="{ open: false }"
                class="relative w-full sm:w-52"
            >
                <button
                    type="button"
                    x-on:click="open = !open"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <span class="truncate">
                        {{ $statusLabel }}
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-4 w-4 shrink-0 transition"
                        :class="{ 'rotate-180': open }"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m19.5 8.25-7.5 7.5-7.5-7.5"
                        />
                    </svg>
                </button>

                <div
                    x-cloak
                    x-show="open"
                    x-transition.origin.top
                    x-on:click.outside="open = false"
                    class="absolute right-0 z-50 mt-2 w-full overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                >
                    @foreach ([
                        '' => [
                            'label' => 'Semua Status',
                            'color' => 'bg-gray-300',
                        ],
                        'draft' => [
                            'label' => 'Draft',
                            'color' => 'bg-yellow-400',
                        ],
                        'issued' => [
                            'label' => 'Diterbitkan',
                            'color' => 'bg-purple-500',
                        ],
                        'sent' => [
                            'label' => 'Dikirim',
                            'color' => 'bg-blue-500',
                        ],
                        'cancelled' => [
                            'label' => 'Dibatalkan',
                            'color' => 'bg-red-500',
                        ],
                    ] as $value => $option)
                        <button
                            type="button"
                            wire:key="invoice-status-{{ $value ?: 'all' }}"
                            wire:click="$set('status', '{{ $value }}')"
                            x-on:click="open = false"
                            class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                        >
                            <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $option['color'] }}"></span>
                            <span>{{ $option['label'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Status pembayaran --}}
            <div
                x-data="{ open: false }"
                class="relative w-full sm:w-52"
            >
                <button
                    type="button"
                    x-on:click="open = !open"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <span class="truncate">
                        {{ $paymentLabel }}
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-4 w-4 shrink-0 transition"
                        :class="{ 'rotate-180': open }"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m19.5 8.25-7.5 7.5-7.5-7.5"
                        />
                    </svg>
                </button>

                <div
                    x-cloak
                    x-show="open"
                    x-transition.origin.top
                    x-on:click.outside="open = false"
                    class="absolute right-0 z-50 mt-2 w-full overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                >
                    @foreach ([
                        '' => [
                            'label' => 'Semua Pembayaran',
                            'color' => 'bg-gray-300',
                        ],
                        'unpaid' => [
                            'label' => 'Belum Dibayar',
                            'color' => 'bg-red-500',
                        ],
                        'partial' => [
                            'label' => 'Dibayar Sebagian',
                            'color' => 'bg-yellow-400',
                        ],
                        'paid' => [
                            'label' => 'Lunas',
                            'color' => 'bg-green-500',
                        ],
                    ] as $value => $option)
                        <button
                            type="button"
                            wire:key="payment-status-{{ $value ?: 'all' }}"
                            wire:click="$set('paymentStatus', '{{ $value }}')"
                            x-on:click="open = false"
                            class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                        >
                            <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $option['color'] }}"></span>
                            <span>{{ $option['label'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Pengurutan --}}
            <div
                x-data="{ open: false }"
                class="relative w-full sm:w-52"
            >
                <button
                    type="button"
                    x-on:click="open = !open"
                    class="flex min-h-11 w-full items-center justify-between gap-3 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <span class="truncate">
                        {{ $sortLabel }}
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-4 w-4 shrink-0 transition"
                        :class="{ 'rotate-180': open }"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m19.5 8.25-7.5 7.5-7.5-7.5"
                        />
                    </svg>
                </button>

                <div
                    x-cloak
                    x-show="open"
                    x-transition.origin.top
                    x-on:click.outside="open = false"
                    class="absolute right-0 z-50 mt-2 w-full overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-xl"
                >
                    @foreach ([
                        'latest' => 'Tanggal Terbaru',
                        'oldest' => 'Tanggal Terlama',
                        'total_highest' => 'Nilai Tertinggi',
                        'total_lowest' => 'Nilai Terendah',
                        'due_soon' => 'Jatuh Tempo Terdekat',
                    ] as $value => $label)
                        <button
                            type="button"
                            wire:key="invoice-sort-{{ $value }}"
                            wire:click="$set('sort', '{{ $value }}')"
                            x-on:click="open = false"
                            class="block w-full px-4 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-100"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Reset --}}
            <button
                type="button"
                wire:click="resetFilters"
                wire:loading.attr="disabled"
                wire:target="resetFilters"
                class="inline-flex min-h-11 w-full items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-600 shadow-sm transition hover:border-blue-400 hover:bg-gray-50 hover:text-blue-600 disabled:opacity-50 sm:w-auto"
            >
                <span
                    wire:loading.remove
                    wire:target="resetFilters"
                >
                    Reset
                </span>

                <span
                    wire:loading
                    wire:target="resetFilters"
                >
                    Mereset...
                </span>
            </button>
        </div>
    </x-slot:right>
</x-ui.toolbar>