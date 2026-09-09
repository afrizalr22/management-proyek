<div
    x-data="{ open: false }"
    x-on:open-delete-delivery-order-modal.window="
        open = true;
        $wire.openModal($event.detail.id);
    "
    x-on:keydown.escape.window="
        if (open) {
            open = false;
            $wire.closeModal();
        }
    "
    x-show="open"
    x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display: none;"
    role="dialog"
    aria-modal="true"
    aria-labelledby="delete-delivery-order-title"
>
    {{-- Overlay --}}
    <div
        class="absolute inset-0 bg-black/50"
        x-on:click="
            open = false;
            $wire.closeModal();
        "
    ></div>

    {{-- Modal --}}
    <div
        x-on:click.stop
        x-transition.scale
        class="relative z-10 max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-3xl bg-white shadow-2xl"
    >
        {{-- Header --}}
        <div class="border-b border-gray-200 px-6 py-5 sm:px-8 sm:py-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2
                        id="delete-delivery-order-title"
                        class="text-2xl font-bold text-gray-900"
                    >
                        Hapus Surat Jalan
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Periksa kembali Surat Jalan yang akan dihapus.
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

        {{-- Loading --}}
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
                    Memuat data Surat Jalan...
                </p>
            </div>
        </div>

        {{-- Konten --}}
        <div
            wire:loading.remove
            wire:target="openModal"
        >
            @if ($deliveryOrderId)
                <div class="space-y-6 p-6 sm:p-8">
                    {{-- Peringatan --}}
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
                                    Surat Jalan yang dihapus tidak dapat dikembalikan. Seluruh item pengiriman juga akan ikut terhapus.
                                </p>

                                <p class="mt-2 text-sm leading-6 text-red-600">
                                    Project dan data Client tidak ikut dihapus.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Error --}}
                    @error('delete')
                        <div
                            class="rounded-xl border border-red-300 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
                            role="alert"
                        >
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- Preview --}}
                    <div class="rounded-2xl bg-gray-50 p-5 sm:p-6">
                        <dl class="space-y-4">
                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Nomor Surat Jalan
                                </dt>

                                <dd class="text-right font-semibold text-gray-900">
                                    {{ $deliveryNumber }}
                                </dd>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Project
                                </dt>

                                <dd class="max-w-[65%] text-right">
                                    <p class="font-semibold text-gray-900">
                                        {{ $projectName }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $projectCode }}
                                    </p>
                                </dd>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Client
                                </dt>

                                <dd class="max-w-[65%] text-right font-semibold text-gray-900">
                                    {{ $clientName }}
                                </dd>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Tujuan
                                </dt>

                                <dd class="max-w-[65%] whitespace-pre-line text-right font-semibold text-gray-900">
                                    {{ $destination }}
                                </dd>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Penerima
                                </dt>

                                <dd class="max-w-[65%] text-right font-semibold text-gray-900">
                                    {{ $receiverName }}
                                </dd>
                            </div>

                            <div class="flex items-center justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Tanggal
                                </dt>

                                <dd class="font-semibold text-gray-900">
                                    {{ $deliveryDate }}
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

                            <div class="flex items-center justify-between gap-4 border-t border-gray-200 pt-4">
                                <dt class="text-sm font-medium text-gray-600">
                                    Status
                                </dt>

                                <dd>
                                    <x-ui.badge
                                        :color="match ($status) {
                                            'draft' => 'yellow',
                                            'sent' => 'blue',
                                            'received' => 'green',
                                            'cancelled' => 'red',
                                            default => 'gray',
                                        }"
                                    >
                                        {{ match ($status) {
                                            'draft' => 'Draft',
                                            'sent' => 'Dikirim',
                                            'received' => 'Diterima',
                                            'cancelled' => 'Dibatalkan',
                                            default => 'Tidak Diketahui',
                                        } }}
                                    </x-ui.badge>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- Footer --}}
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
                        wire:click="deleteDeliveryOrder"
                        wire:loading.attr="disabled"
                        wire:target="deleteDeliveryOrder"
                        @disabled($errors->has('delete'))
                        class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <span
                            wire:loading.remove
                            wire:target="deleteDeliveryOrder"
                        >
                            Hapus Surat Jalan
                        </span>

                        <span
                            wire:loading
                            wire:target="deleteDeliveryOrder"
                        >
                            Menghapus...
                        </span>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>