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
            Buat Quotation
        </span>
    </nav>

    {{-- Header --}}
    <x-ui.page-header
        :title="$pageTitle"
        :description="$pageDescription"
    />

    {{-- Error penyimpanan --}}
    @error('save')
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
            role="alert"
        >
            {{ $message }}
        </div>
    @enderror

    <form
        wire:submit="save"
        class="space-y-6"
    >
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

                <x-quotation.quotation-preview />
            </aside>
        </div>

        {{-- Tombol aksi --}}
        <div class="flex flex-col-reverse gap-3 rounded-2xl border border-gray-200 bg-white p-4 sm:flex-row sm:justify-end sm:p-5">
            <a
                href="{{ route('owner.quotations.index') }}"
                wire:navigate
                class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100"
            >
                Batal
            </a>
            @if ($errors->any())
    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700">
        <p class="font-semibold">
            Quotation belum dapat disimpan:
        </p>

        <ul class="mt-2 list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <button
            type="button"
            wire:click="save"
            wire:loading.attr="disabled"
            wire:target="save"
            class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-60"
        >
            <span wire:loading.remove wire:target="save">
                Simpan Quotation
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
    </form>
</div>