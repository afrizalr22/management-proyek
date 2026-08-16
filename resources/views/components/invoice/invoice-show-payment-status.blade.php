<x-ui.info-card>

    <div class="p-6">

        {{-- Header --}}
        <div>

            <h2 class="text-xl font-bold text-gray-800">
                Payment Status
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Informasi status pembayaran invoice.
            </p>

        </div>

        <hr class="my-6">

        {{-- Current Status --}}
        <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5">

            <div class="flex items-start gap-4">

                {{-- Icon --}}
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-yellow-100 text-yellow-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />

                    </svg>

                </div>

                {{-- Status Information --}}
                <div class="min-w-0">

                    <div class="flex flex-wrap items-center gap-2">

                        <p class="font-semibold text-yellow-800">
                            Pembayaran Belum Lunas
                        </p>

                        <x-ui.badge color="yellow">
                            Unpaid
                        </x-ui.badge>

                    </div>

                    <p class="mt-1 text-sm leading-relaxed text-yellow-700">
                        Invoice belum dinyatakan lunas.
                    </p>

                </div>

            </div>

        </div>

        {{-- Payment Summary --}}
        <div class="mt-6 space-y-5">

            {{-- Invoice Total --}}
            <div class="flex items-center justify-between gap-4">

                <span class="text-gray-500">
                    Invoice Total
                </span>

                <span class="text-right font-semibold text-gray-800">
                    Rp 1.470.000.000
                </span>

            </div>

            {{-- Payment Status --}}
            <div class="flex items-center justify-between gap-4">

                <span class="text-gray-500">
                    Status Pembayaran
                </span>

                <x-ui.badge color="yellow">
                    Unpaid
                </x-ui.badge>

            </div>

        </div>

        <hr class="my-6">

        {{-- Action --}}
        <div>

            <x-ui.button class="w-full" variant="success">
                Tandai Sudah Dibayar
            </x-ui.button>

        </div>

    </div>

</x-ui.info-card>