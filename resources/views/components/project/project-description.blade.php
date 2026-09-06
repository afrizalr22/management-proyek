@props([
    'project',
    'sourceQuotation' => null,
])

@php
    $quotationItems =
        $sourceQuotation?->items
        ?? collect();

    $hasProjectDescription =
        filled($project->description);

    $hasQuotationNotes =
        $sourceQuotation
        && filled($sourceQuotation->notes);

    /*
     * Hindari menampilkan catatan yang sama dua kali apabila
     * deskripsi Project sebelumnya disalin dari quotation.
     */
    $showQuotationNotes =
        $hasQuotationNotes
        && trim((string) $sourceQuotation->notes)
            !== trim((string) $project->description);
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">
        {{-- Header --}}
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                Deskripsi Project
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Gambaran umum dan ruang lingkup pekerjaan Project.
            </p>
        </div>

        <hr class="my-6 border-gray-200 sm:my-8">

        {{-- Deskripsi Project --}}
        <section>
            <h3 class="font-semibold text-gray-900">
                Gambaran Umum
            </h3>

            @if ($hasProjectDescription)
                <div
                    class="mt-4 whitespace-pre-line break-words text-sm leading-7 text-gray-700 sm:text-base sm:leading-8"
                >{{ trim($project->description) }}</div>
            @else
                <div
                    class="mt-4 rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 py-6 text-center"
                >
                    <p class="font-semibold text-gray-700">
                        Deskripsi belum tersedia
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Deskripsi Project dapat dilengkapi melalui halaman Edit Project.
                    </p>
                </div>
            @endif
        </section>

        {{-- Ruang lingkup berdasarkan quotation --}}
        @if ($quotationItems->isNotEmpty())
            <hr class="my-6 border-gray-200 sm:my-8">

            <section>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-900">
                            Ruang Lingkup Pekerjaan
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Diambil dari item quotation
                            {{ $sourceQuotation->quotation_number }}.
                        </p>
                    </div>

                    <span class="text-sm font-medium text-gray-500">
                        {{ $quotationItems->count() }} item
                    </span>
                </div>

                <div class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-2">
                    @foreach ($quotationItems as $item)
                        <article
                            wire:key="project-scope-item-{{ $item->id }}"
                            class="rounded-xl border border-gray-200 bg-gray-50 p-4"
                        >
                            <div class="flex items-start gap-3">
                                <div
                                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-700"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        class="h-4 w-4"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m4.5 12.75 6 6 9-13.5"
                                        />
                                    </svg>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h4 class="break-words font-semibold text-gray-900">
                                        {{ $item->item_name }}
                                    </h4>

                                    @if ($item->description)
                                        <p class="mt-2 whitespace-pre-line break-words text-sm leading-6 text-gray-600">
                                            {{ $item->description }}
                                        </p>
                                    @endif

                                    <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-500">
                                        <span>
                                            Volume:
                                            <strong class="text-gray-700">
                                                {{ number_format(
                                                    (float) $item->qty,
                                                    2,
                                                    ',',
                                                    '.'
                                                ) }}
                                                {{ $item->unit }}
                                            </strong>
                                        </span>

                                        <span>
                                            Nilai:
                                            <strong class="text-gray-700">
                                                Rp{{ number_format(
                                                    (float) $item->total,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}
                                            </strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @else
            <hr class="my-6 border-gray-200 sm:my-8">

            <section>
                <h3 class="font-semibold text-gray-900">
                    Ruang Lingkup Pekerjaan
                </h3>

                <div
                    class="mt-4 rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 py-6 text-center"
                >
                    <p class="font-semibold text-gray-700">
                        Ruang lingkup belum tersedia
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Project ini belum mempunyai item quotation sebagai ruang lingkup awal.
                    </p>
                </div>
            </section>
        @endif

        {{-- Catatan quotation --}}
        @if ($showQuotationNotes)
            <hr class="my-6 border-gray-200 sm:my-8">

            <section
                class="rounded-xl border border-blue-200 bg-blue-50 p-5"
            >
                <h3 class="font-semibold text-blue-900">
                    Catatan Quotation
                </h3>

                <p class="mt-3 whitespace-pre-line break-words text-sm leading-7 text-blue-800">
                    {{ $sourceQuotation->notes }}
                </p>
            </section>
        @endif

        {{-- Informasi sumber --}}
        @if ($sourceQuotation)
            <div class="mt-6 flex flex-col gap-2 border-t border-gray-200 pt-5 text-sm sm:flex-row sm:items-center sm:justify-between">
                <span class="text-gray-500">
                    Sumber ruang lingkup
                </span>

                <a
                    href="{{ route('owner.quotations.show', [
                        'quotation' => $sourceQuotation->id,
                    ]) }}"
                    wire:navigate
                    class="font-semibold text-blue-600 transition hover:text-blue-700"
                >
                    {{ $sourceQuotation->quotation_number }}
                </a>
            </div>
        @endif
    </div>
</x-ui.info-card>