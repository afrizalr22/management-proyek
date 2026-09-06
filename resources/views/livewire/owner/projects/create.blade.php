<div class="space-y-6">
    {{-- Breadcrumb --}}
    <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
        <a
            href="{{ route('owner.projects.index') }}"
            wire:navigate
            class="transition hover:text-blue-600"
        >
            Project
        </a>

        @if ($sourceQuotation)
            <span>/</span>

            <a
                href="{{ route('owner.quotations.show', [
                    'quotation' => $sourceQuotation->id,
                ]) }}"
                wire:navigate
                class="transition hover:text-blue-600"
            >
                {{ $sourceQuotation->quotation_number }}
            </a>
        @endif

        <span>/</span>

        <span class="font-medium text-gray-700">
            Buat Project
        </span>
    </nav>

    {{-- Header --}}
    <x-ui.page-header
        :title="$pageTitle"
        :description="$pageDescription"
    />

    {{-- Informasi sumber quotation --}}
    @if ($sourceQuotation)
        <div
            class="flex flex-col gap-4 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div class="flex items-start gap-3">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-700"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m4.5 12.75 6 6 9-13.5"
                        />
                    </svg>
                </div>

                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <p class="font-semibold text-green-900">
                            Quotation telah disetujui
                        </p>

                        <x-ui.badge color="green">
                            Disetujui
                        </x-ui.badge>
                    </div>

                    <p class="mt-1 text-sm leading-6 text-green-700">
                        Project ini akan terhubung dengan quotation
                        {{ $sourceQuotation->quotation_number }}.
                    </p>
                </div>
            </div>

            <p class="shrink-0 font-semibold text-green-800">
                Rp {{ number_format(
                    (float) $sourceQuotation->grand_total,
                    0,
                    ',',
                    '.'
                ) }}
            </p>
        </div>
    @endif

    {{-- Error penyimpanan --}}
    @error('save')
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
            role="alert"
        >
            {{ $message }}
        </div>
    @enderror

    <form
        wire:submit="save"
        class="space-y-6"
    >
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- Bagian kiri --}}
            <div class="space-y-6 lg:col-span-2">
                <x-project.project-general-information
                    mode="create"
                    :clients="$clients"
                    :mandors="$mandors"
                    :selected-client="$selectedClient"
                    :source-quotation="$sourceQuotation"
                />

                <x-project.project-timeline-budget
                    mode="create"
                    :source-quotation="$sourceQuotation"
                />
            </div>

            {{-- Bagian kanan --}}
            <div class="space-y-6">
                <x-project.project-administrative-note
                    mode="create"
                    :source-quotation="$sourceQuotation"
                />
            </div>
        </div>

        {{-- Tombol aksi --}}
        <div
            class="flex flex-col-reverse gap-3 rounded-2xl border border-gray-200 bg-white p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5"
        >
            <p class="text-sm text-gray-500">
                Setelah disimpan, Project akan terhubung dengan quotation dan tidak dapat dibuat ulang.
            </p>

            <div class="flex flex-col-reverse gap-3 sm:flex-row">
                @if ($sourceQuotation)
                    <a
                        href="{{ route('owner.quotations.show', [
                            'quotation' => $sourceQuotation->id,
                        ]) }}"
                        wire:navigate
                        class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100"
                    >
                        Batal
                    </a>
                @else
                    <a
                        href="{{ route('owner.projects.index') }}"
                        wire:navigate
                        class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
                    >
                        Batal
                    </a>
                @endif

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="save"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <svg
                        wire:loading.remove
                        wire:target="save"
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
                            d="M12 6v12m6-6H6"
                        />
                    </svg>

                    <span
                        wire:loading.remove
                        wire:target="save"
                    >
                        Simpan Project
                    </span>

                    <span
                        wire:loading.flex
                        wire:target="save"
                        class="items-center gap-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            class="h-4 w-4 animate-spin"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>

                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"
                            ></path>
                        </svg>

                        Menyimpan...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>