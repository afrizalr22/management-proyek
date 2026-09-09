<form
    wire:submit.prevent="updateDeliveryOrder"
    class="space-y-6"
    novalidate
>
    {{-- Header --}}
    <div class="flex items-start gap-3">
        <a
            href="{{ route(
                'owner.delivery-orders.show',
                [
                    'deliveryOrder' =>
                        $deliveryOrder->id,
                ]
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
                Edit Surat Jalan
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                {{ $deliveryOrder->delivery_number }}
            </p>
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
            <x-delivery-order.delivery-order-edit-primary
                :delivery-order="$deliveryOrder"
            />

            {{-- Menggunakan form item yang sama dengan Create --}}
            <x-delivery-order.delivery-order-create-items
                :items="$items"
            />

            {{-- Catatan --}}
            <x-ui.info-card>
                <div class="p-5 sm:p-6">
                    <h2 class="text-xl font-bold text-gray-800">
                        Catatan
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Perbarui informasi tambahan terkait pengiriman.
                    </p>

                    <hr class="my-6 border-gray-200">

                    <label
                        for="delivery-order-notes"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Catatan Surat Jalan
                    </label>

                    <textarea
                        id="delivery-order-notes"
                        wire:model="notes"
                        rows="4"
                        maxlength="2000"
                        placeholder="Masukkan catatan jika diperlukan"
                        @class([
                            'w-full resize-y rounded-xl px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500',
                            'border-red-300' => $errors->has('notes'),
                            'border-gray-300' => !$errors->has('notes'),
                        ])
                    ></textarea>

                    @error('notes')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </x-ui.info-card>
        </div>

        <aside class="space-y-6">
            <div class="xl:sticky xl:top-6">
                <x-delivery-order.delivery-order-edit-summary
                    :delivery-order="$deliveryOrder"
                    :items="$items"
                    :total-quantity="$totalQuantity"
                />
            </div>
        </aside>
    </div>

    {{-- Tombol tindakan hanya di bawah --}}
    <div class="flex flex-col-reverse gap-3 rounded-2xl border border-gray-200 bg-white p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
        <p class="text-sm text-gray-500">
            Pastikan informasi penerima dan item pengiriman sudah benar.
        </p>

        <div class="flex flex-col-reverse gap-3 sm:flex-row">
            <a
                href="{{ route(
                    'owner.delivery-orders.show',
                    [
                        'deliveryOrder' =>
                            $deliveryOrder->id,
                    ]
                ) }}"
                wire:navigate
                wire:loading.class="pointer-events-none opacity-60"
                wire:target="updateDeliveryOrder"
                class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
            >
                Batal
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="updateDeliveryOrder"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span
                    wire:loading.remove
                    wire:target="updateDeliveryOrder"
                >
                    Simpan Perubahan
                </span>

                <span
                    wire:loading
                    wire:target="updateDeliveryOrder"
                >
                    Menyimpan...
                </span>
            </button>
        </div>
    </div>
</form>