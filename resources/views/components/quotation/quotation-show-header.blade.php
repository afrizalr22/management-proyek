@props([
    'quotation',
    'statusText',
    'statusColor',
])

<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
        <a
            href="{{ route('owner.quotations.index') }}"
            wire:navigate
            class="transition hover:text-blue-600"
        >
            Quotation
        </a>

        <span>/</span>

        <span class="font-medium text-gray-700">
            {{ $quotation->quotation_number }}
        </span>
    </nav>

    {{-- Header --}}
    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
        <div class="min-w-0">
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="break-words text-2xl font-bold text-gray-900 sm:text-3xl">
                    {{ $quotation->quotation_number }}
                </h1>

                <x-ui.badge :color="$statusColor">
                    {{ $statusText }}
                </x-ui.badge>
            </div>

            <p class="mt-2 break-words text-sm leading-6 text-gray-500 sm:text-base">
                {{ $quotation->project_name
                    ?: 'Detail penawaran pekerjaan untuk client.' }}
            </p>
        </div>

        {{-- Aksi --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap">
            <a
                href="{{ route('owner.quotations.index') }}"
                wire:navigate
                class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100"
            >
                Kembali
            </a>

            @if ($quotation->status === 'draft')
                <a
                    href="{{ route('owner.quotations.edit', [
                        'quotation' => $quotation->id,
                    ]) }}"
                    wire:navigate
                    class="inline-flex min-h-11 items-center justify-center rounded-xl bg-amber-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-100"
                >
                    Edit Quotation
                </a>
            @else
                <button
                    type="button"
                    disabled
                    title="Hanya quotation Draft yang dapat diedit"
                    class="inline-flex min-h-11 cursor-not-allowed items-center justify-center rounded-xl bg-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-500"
                >
                    Edit Quotation
                </button>
            @endif
        </div>
    </div>
</div>