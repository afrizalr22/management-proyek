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

        <a
            href="{{ route('owner.quotations.show', [
                'quotation' => $quotation->id,
            ]) }}"
            wire:navigate
            class="transition hover:text-blue-600"
        >
            {{ $quotation->quotation_number }}
        </a>

        <span>/</span>

        <span class="font-medium text-gray-700">
            Edit
        </span>
    </nav>

    {{-- Header --}}
    <x-ui.page-header
        :title="$pageTitle"
        :description="$pageDescription"
    />

    {{-- Informasi status --}}
    <div
        class="flex flex-col gap-4 rounded-2xl border border-yellow-200 bg-yellow-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
    >
        <div class="flex items-start gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-yellow-100 text-yellow-700"
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
                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                    />
                </svg>
            </div>

            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <p class="font-semibold text-yellow-900">
                        Quotation masih berupa Draft
                    </p>

                    <x-ui.badge color="yellow">
                        Draft
                    </x-ui.badge>
                </div>

                <p class="mt-1 text-sm leading-6 text-yellow-700">
                    Data masih dapat diperbarui sebelum quotation ditandai sudah dikirim kepada Client.
                </p>
            </div>
        </div>

        <p class="shrink-0 text-sm font-semibold text-yellow-800">
            {{ $quotation->quotation_number }}
        </p>
    </div>

    {{-- Form Edit --}}
    <form
        wire:submit="updateQuotation"
        class="space-y-6"
    >
        {{-- Error penyimpanan --}}
        @error('save')
            <div
                class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700"
                role="alert"
            >
                {{ $message }}
            </div>
        @enderror

        {{-- Ringkasan seluruh error validasi --}}
        @if ($errors->any())
            <div
                class="rounded-xl border border-red-200 bg-red-50 px-5 py-4"
                role="alert"
            >
                <div class="flex items-start gap-3">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="mt-0.5 h-5 w-5 shrink-0 text-red-600"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v3.75m9-3.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 7.5h.008v.008H12V16.5Z"
                        />
                    </svg>

                    <div>
                        <p class="font-semibold text-red-800">
                            Quotation belum dapat diperbarui:
                        </p>

                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

            {{-- Konten utama --}}
            <div class="space-y-6 xl:col-span-2">
                <x-quotation.quotation-general-information
                    :clients="$clients"
                    :selected-client="$selectedClient"
                    :quotation-number="$quotationNumber"
                    :quotation-date="$quotationDate"
                />

                <x-quotation.quotation-items
                    :items="$items"
                    :subtotal="$subtotal"
                    :total-quantity="$totalQuantity"
                />

                <x-quotation.quotation-notes />
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6">
                <x-quotation.quotation-sidebar
                    :selected-client="$selectedClient"
                    :project-name="$projectName"
                    :quotation-date="$quotationDate"
                    :valid-until="$validUntil"
                    :items="$items"
                    :subtotal="$subtotal"
                    :grand-total="$grandTotal"
                />

                <x-quotation.quotation-summary
                    :items="$items"
                    :subtotal="$subtotal"
                    :grand-total="$grandTotal"
                />

                <x-quotation.quotation-preview
                    mode="edit"
                />
            </aside>
        </div>

        {{-- Tombol aksi --}}
        <div
            class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5"
        >
            <p class="text-sm text-gray-500">
                Pastikan seluruh perubahan sudah sesuai sebelum disimpan.
            </p>

            <div class="flex flex-col-reverse gap-3 sm:flex-row">
                {{-- Batal --}}
                <a
                    href="{{ route('owner.quotations.show', [
                        'quotation' => $quotation->id,
                    ]) }}"
                    wire:navigate
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100"
                >
                    Batal
                </a>

                {{-- Simpan --}}
                <button
                    type="button"
                    wire:click="updateQuotation"
                    wire:loading.attr="disabled"
                    wire:target="updateQuotation"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <svg
                        wire:loading.remove
                        wire:target="updateQuotation"
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
                            d="M16.5 3.75H5.625A1.875 1.875 0 0 0 3.75 5.625v12.75a1.875 1.875 0 0 0 1.875 1.875h12.75a1.875 1.875 0 0 0 1.875-1.875V7.5L16.5 3.75Z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14.25 3.75v4.5h-6v-4.5m.75 16.5v-6h6v6"
                        />
                    </svg>

                    <span
                        wire:loading.remove
                        wire:target="updateQuotation"
                    >
                        Simpan Perubahan
                    </span>

                    <span
                        wire:loading.flex
                        wire:target="updateQuotation"
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