<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div>

            <h2 class="text-2xl font-bold text-gray-900">

                Related Documents

            </h2>

            <p class="mt-2 text-gray-500">

                Dokumen yang berkaitan dengan quotation ini.

            </p>

        </div>

        <hr class="my-8">

        <div class="grid gap-6 md:grid-cols-2">

            {{-- Invoice --}}
            <div class="rounded-2xl border border-gray-200 p-6">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">

                            Invoice

                        </p>

                        <h3 class="mt-2 text-xl font-bold text-gray-900">

                            Belum Dibuat

                        </h3>

                        <p class="mt-2 text-gray-500">

                            Invoice belum tersedia untuk quotation ini.

                        </p>

                    </div>

                    <x-ui.badge color="yellow">

                        Pending

                    </x-ui.badge>

                </div>

                <div class="mt-6">

                    <x-ui.button>

                        Create Invoice

                    </x-ui.button>

                </div>

            </div>

            {{-- Delivery Order --}}
            <div class="rounded-2xl border border-gray-200 p-6">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">

                            Delivery Order

                        </p>

                        <h3 class="mt-2 text-xl font-bold text-gray-900">

                            Belum Tersedia

                        </h3>

                        <p class="mt-2 text-gray-500">

                            Delivery Order akan tersedia setelah Invoice dibuat.

                        </p>

                    </div>

                    <x-ui.badge color="gray">

                        Waiting

                    </x-ui.badge>

                </div>

                <div class="mt-6">

                    <x-ui.button
                        variant="secondary"
                        disabled
                    >

                        Menunggu Invoice

                    </x-ui.button>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>