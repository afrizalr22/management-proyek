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
    <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
        {{-- Identitas quotation --}}
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
                    ?: 'Detail penawaran pekerjaan untuk Client.' }}
            </p>
        </div>

        {{-- Aksi --}}
        <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:flex-wrap">
            {{-- Kembali --}}
            <a
                href="{{ route('owner.quotations.index') }}"
                wire:navigate
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
                    />
                </svg>

                Kembali
            </a>

            {{-- Preview PDF --}}
            <a
                href="{{ route('owner.quotations.preview', [
                    'quotation' => $quotation->id,
                ]) }}"
                target="_blank"
                rel="noopener noreferrer"
                title="Buka preview PDF pada tab baru"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-blue-300 bg-white px-4 py-2.5 text-sm font-semibold text-blue-700 transition hover:border-blue-400 hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-blue-100"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                    />
                </svg>

                Preview PDF
            </a>

            {{-- Unduh PDF --}}
            <a
                href="{{ route('owner.quotations.download', [
                    'quotation' => $quotation->id,
                ]) }}"
                title="Unduh quotation dalam format PDF"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v12m0 0 4.5-4.5M12 15l-4.5-4.5"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4.5 15.75v2.625A2.625 2.625 0 0 0 7.125 21h9.75a2.625 2.625 0 0 0 2.625-2.625V15.75"
                    />
                </svg>

                Unduh PDF
            </a>

            {{-- Edit quotation --}}
            @if ($quotation->status === 'draft')
                <a
                    href="{{ route('owner.quotations.edit', [
                        'quotation' => $quotation->id,
                    ]) }}"
                    wire:navigate
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-100"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.5 7.125 16.862 4.487"
                        />
                    </svg>

                    Edit Quotation
                </a>
            @else
                <button
                    type="button"
                    disabled
                    title="Hanya quotation Draft yang dapat diedit"
                    class="inline-flex min-h-11 cursor-not-allowed items-center justify-center gap-2 rounded-xl bg-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-500"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.5 7.125 16.862 4.487"
                        />
                    </svg>

                    Edit Quotation
                </button>
            @endif
        </div>
    </div>
</div>