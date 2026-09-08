<div
    x-data="{ open: false }"
    x-on:open-delete-invoice-modal.window="
        open = true;
        $wire.openModal($event.detail.id);
    "
    x-on:keydown.escape.window="
        open = false;
        $wire.closeModal();
    "
    x-show="open"
    x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display: none;"
    role="dialog"
    aria-modal="true"
    aria-labelledby="delete-invoice-title"
>
    <div
        class="absolute inset-0 bg-black/50"
        x-on:click="
            open = false;
            $wire.closeModal();
        "
    ></div>

    <div
        x-on:click.stop
        x-transition.scale
        class="relative z-10 max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-3xl bg-white shadow-2xl"
    >
        <div class="border-b border-gray-200 px-6 py-5 sm:px-8 sm:py-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2
                        id="delete-invoice-title"
                        class="text-2xl font-bold text-gray-900"
                    >
                        Hapus Invoice
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Periksa kembali invoice yang akan dihapus.
                    </p>
                </div>

                <button
                    type="button"
                    x-on:click="
                        open = false;
                        $wire.closeModal();
                    "
                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-2xl leading-none text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                    aria-label="Tutup modal"
                >
                    &times;
                </button>
            </div>
        </div>

        <div
            wire:loading.flex
            wire:target="openModal"
            class="min-h-64 items-center justify-center p-8"
        >
            <div class="text-center">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    class="mx-auto h-8 w-8 animate-spin text-blue-600"
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

                <p class="mt-3 text-sm text-gray-500">
                    Memuat data invoice...
                </p>
            </div>
        </div>

        <div
            wire:loading.remove
            wire:target="openModal"
        >
            @if ($invoiceId)
                <div class="space-y-6 p-6 sm:p-8">
                    <div class="rounded-2xl border border-red-200 bg-red-50 p-5">
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-500 text-white">
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
                                        d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H4.645c-1.73 0-2.813-1.874-1.948-3.374L10.052 3.376c.866-1.5 3.03-1.5 3.896 0l7.355 12.75ZM12 15.75h.008v.008H12v-.008Z"
                                    />
                                </svg>
                            </div>

                            <div>
                                <h3 class="font-semibold text-red-700">
                                    Tindakan permanen
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-red-600">
                                    Invoice yang dihapus tidak dapat
                                    dikembalikan. Seluruh item invoice
                                    juga akan ikut terhapus.
                                </p>

                                <p class="mt-2 text-sm leading-6 text-red-600">
                                    Quotation sumber tidak ikut dihapus
                                    dan dapat digunakan kembali.
                                </p>
                            </div>
                        </div>
                    </div>

                    @error('delete')
                        <div
                            class="rounded-xl border border-red-300 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
                            role="alert"
                        >
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="rounded-2xl bg-gray-50 p-5 sm:p-6">
                        <dl class="space-y-4">
                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Nomor Invoice
                                </dt>

                                <dd class="text-right font-semibold text-gray-900">
                                    {{ $invoiceNumber }}
                                </dd>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Klien
                                </dt>

                                <dd class="max-w-[65%] text-right font-semibold text-gray-900">
                                    {{ $clientName }}
                                </dd>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Proyek
                                </dt>

                                <dd class="max-w-[65%] text-right font-semibold text-gray-900">
                                    {{ $projectName }}
                                </dd>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Quotation
                                </dt>

                                <dd class="text-right font-semibold text-gray-900">
                                    {{ $quotationNumber }}
                                </dd>
                            </div>

                            <div class="flex items-center justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Jumlah Item
                                </dt>

                                <dd class="font-semibold text-gray-900">
                                    {{ $itemsCount }} Item
                                </dd>
                            </div>

                            <div class="flex items-center justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Status Pembayaran
                                </dt>

                                <dd>
                                    <x-ui.badge
                                        :color="$paymentStatus === 'unpaid'
                                            ? 'red'
                                            : 'yellow'"
                                    >
                                        {{ match ($paymentStatus) {
                                            'unpaid' => 'Belum Dibayar',
                                            'partial' => 'Sebagian',
                                            'paid' => 'Lunas',
                                            default => '-',
                                        } }}
                                    </x-ui.badge>
                                </dd>
                            </div>

                            <div class="flex items-center justify-between gap-4 border-t border-gray-200 pt-4">
                                <dt class="font-medium text-gray-600">
                                    Total Invoice
                                </dt>

                                <dd class="text-right text-lg font-bold text-gray-900">
                                    Rp {{ number_format(
                                        $grandTotal,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-gray-200 px-6 py-5 sm:flex-row sm:justify-end sm:px-8 sm:py-6">
                    <button
                        type="button"
                        x-on:click="
                            open = false;
                            $wire.closeModal();
                        "
                        class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
                    >
                        Batal
                    </button>

                    <button
                        type="button"
                        wire:click="deleteInvoice"
                        wire:loading.attr="disabled"
                        wire:target="deleteInvoice"
                        @disabled($errors->has('delete'))
                        class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <span
                            wire:loading.remove
                            wire:target="deleteInvoice"
                        >
                            Hapus Invoice
                        </span>

                        <span
                            wire:loading
                            wire:target="deleteInvoice"
                        >
                            Menghapus...
                        </span>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>