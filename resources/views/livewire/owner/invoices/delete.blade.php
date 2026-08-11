<div
    x-data="{ open: false }"
    x-on:open-delete-invoice-modal.window="open = true"
    x-show="open"
    x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center"
    style="display: none;"
>

    {{-- Overlay --}}
    <div
        class="absolute inset-0 bg-black/50"
        x-on:click="open = false"
    ></div>


    {{-- Modal --}}
    <div
        class="relative z-10 w-full max-w-lg rounded-3xl bg-white shadow-2xl"
    >

        {{-- Header --}}
        <div
            class="border-b border-gray-200 px-8 py-6"
        >

            <h2
                class="text-2xl font-bold text-gray-900"
            >
                Delete Invoice
            </h2>

            <p
                class="mt-2 text-gray-500"
            >
                Apakah Anda yakin ingin menghapus invoice ini?
            </p>

        </div>


        {{-- Body --}}
        <div
            class="space-y-6 p-8"
        >

            {{-- Warning --}}
            <div
                class="rounded-2xl border border-red-200 bg-red-50 p-5"
            >

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-500 text-white"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77-1.33.19-3 1.73 3z"
                            />

                        </svg>

                    </div>


                    <div>

                        <h3
                            class="font-semibold text-red-700"
                        >
                            Warning
                        </h3>

                        <p
                            class="mt-2 text-sm leading-6 text-red-600"
                        >
                            Invoice yang dihapus tidak dapat dikembalikan.
                            Seluruh item yang terdapat pada invoice ini juga
                            akan ikut terhapus.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Preview Invoice --}}
            <div
                class="rounded-2xl bg-gray-50 p-6"
            >

                <div class="space-y-4">

                    {{-- Invoice Number --}}
                    <div class="flex items-center justify-between gap-4">

                        <span class="text-gray-500">
                            Nomor Invoice
                        </span>

                        <span class="font-semibold text-gray-900">
                            INV-2026-0001
                        </span>

                    </div>


                    {{-- Client --}}
                    <div class="flex items-center justify-between gap-4">

                        <span class="text-gray-500">
                            Client
                        </span>

                        <span class="text-right font-semibold text-gray-900">
                            PT Maju Bersama Properti
                        </span>

                    </div>


                    {{-- Project --}}
                    <div class="flex items-center justify-between gap-4">

                        <span class="text-gray-500">
                            Project
                        </span>

                        <span class="text-right font-semibold text-gray-900">
                            Pembangunan Gudang Logistik Tahap II
                        </span>

                    </div>


                    {{-- Payment Status --}}
                    <div class="flex items-center justify-between gap-4">

                        <span class="text-gray-500">
                            Payment Status
                        </span>

                        <x-ui.badge color="yellow">
                            Unpaid
                        </x-ui.badge>

                    </div>


                    {{-- Total --}}
                    <div class="flex items-center justify-between gap-4">

                        <span class="text-gray-500">
                            Total
                        </span>

                        <span class="font-semibold text-gray-900">
                            Rp 1.470.000.000
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- Footer --}}
        <div
            class="flex justify-end gap-3 border-t border-gray-200 px-8 py-6"
        >

            <x-ui.button
                variant="outline"
                x-on:click="open = false"
            >
                Cancel
            </x-ui.button>


            <x-ui.button
                variant="danger"
            >
                Delete Invoice
            </x-ui.button>

        </div>

    </div>

</div>