<form
    wire:submit="updateInvoice"
    class="space-y-6"
>
    <div class="flex items-start gap-3">
    <a
        href="{{ route(
            'owner.invoices.show',
            $invoice
        ) }}"
        wire:navigate
        class="mt-1 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-700"
        title="Kembali"
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
                d="M15 19 8 12l7-7"
            />
        </svg>
    </a>

    <div>
        <h1 class="text-2xl font-bold text-gray-800 sm:text-3xl">
            Edit Invoice
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            {{ $invoice->invoice_number }}
        </p>
    </div>
</div>

    @error('save')
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
            role="alert"
        >
            {{ $message }}
        </div>
    @enderror

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="space-y-6 xl:col-span-2">
            <x-invoice.invoice-edit-primary
                :invoice="$invoice"
            />

            <x-invoice.invoice-edit-items
                :items="$items"
            />
        </div>

        <aside class="space-y-6">
            <x-invoice.invoice-edit-summary
                :items="$items"
                :subtotal="$subtotal"
                :total-quantity="$totalQuantity"
            />
        </aside>
    </div>

    <div class="flex flex-col-reverse gap-3 rounded-2xl border border-gray-200 bg-white p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
        <p class="text-sm text-gray-500">
            Pastikan tanggal, item, dan nilai invoice sudah benar.
        </p>

        <div class="flex flex-col-reverse gap-3 sm:flex-row">
            <a
                href="{{ route(
                    'owner.invoices.show',
                    $invoice
                ) }}"
                wire:navigate
                class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
            >
                Batal
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="updateInvoice"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span
                    wire:loading.remove
                    wire:target="updateInvoice"
                >
                    Simpan Perubahan
                </span>

                <span
                    wire:loading
                    wire:target="updateInvoice"
                >
                    Menyimpan...
                </span>
            </button>
        </div>
    </div>
</form>