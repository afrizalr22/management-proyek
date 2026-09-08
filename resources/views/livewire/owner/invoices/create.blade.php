<form
    wire:submit.prevent="createInvoice"
    class="space-y-6"
    novalidate
>
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-start gap-3">
            <a
                href="{{ route('owner.invoices.index') }}"
                wire:navigate
                class="mt-1 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-700"
                title="Kembali"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19 8 12l7-7"
                    />
                </svg>
            </a>

            <div>
                <h1 class="text-2xl font-bold text-gray-800 sm:text-3xl">
                    Buat Invoice Baru
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Buat Invoice berdasarkan Quotation yang telah disetujui.
                </p>
            </div>
        </div>
    </div>

    {{-- Kesalahan penyimpanan --}}
    @error('save')
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
            role="alert"
        >
            {{ $message }}
        </div>
    @enderror

    {{-- Konten --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="space-y-6 xl:col-span-2">
            <x-invoice.invoice-create-primary
                :quotations="$quotations"
                :quotation-id="$quotationId"
                :quotation-number="$quotationNumber"
                :client-name="$clientName"
                :client-contact-person="$clientContactPerson"
                :client-phone="$clientPhone"
                :client-email="$clientEmail"
                :client-address="$clientAddress"
                :project-name="$projectName"
            />

            <x-invoice.invoice-create-items
                :items="$items"
            />
        </div>

        <aside class="space-y-6">
            <x-invoice.invoice-create-summary
                :quotation-number="$quotationNumber"
                :client-name="$clientName"
                :project-name="$projectName"
                :subtotal="$subtotal"
                :grand-total="$grandTotal"
            />
        </aside>
    </div>

    {{-- Tombol tindakan --}}
    <div class="flex flex-col-reverse gap-4 rounded-2xl border border-gray-200 bg-white p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
        <p class="text-sm text-gray-500">
            Data Client dan item disalin dari Quotation yang dipilih.
        </p>

        <div class="flex flex-col-reverse gap-3 sm:flex-row">
            <a
                href="{{ route('owner.invoices.index') }}"
                wire:navigate
                wire:loading.class="pointer-events-none opacity-60"
                wire:target="createInvoice"
                class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
            >
                Batal
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="createInvoice"
                @disabled(!$quotationId)
                class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-gray-300 disabled:text-gray-500"
            >
                <span
                    wire:loading.remove
                    wire:target="createInvoice"
                >
                    Simpan Invoice
                </span>

                <span
                    wire:loading
                    wire:target="createInvoice"
                >
                    Menyimpan...
                </span>
            </button>
        </div>
    </div>
</form>