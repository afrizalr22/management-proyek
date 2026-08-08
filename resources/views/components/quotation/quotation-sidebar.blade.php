<x-ui.info-card>

    <div class="space-y-6 p-6">

        {{-- Header --}}
        <div>

            <h2 class="text-xl font-bold text-gray-900">

                Quotation Summary

            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500">

                Ringkasan informasi quotation yang sedang dibuat.

            </p>

        </div>

        <hr>

        {{-- Status --}}
        <div>

            <p class="text-sm text-gray-500">

                Status

            </p>

            <div class="mt-2">

                <x-ui.badge color="yellow">

                    Draft

                </x-ui.badge>

            </div>

        </div>

        {{-- Project --}}
        <div>

            <p class="text-sm text-gray-500">

                Project

            </p>

            <p class="mt-1 font-semibold text-gray-900">

                Renovasi Gedung PT ABC

            </p>

        </div>

        {{-- Client --}}
        <div>

            <p class="text-sm text-gray-500">

                Client

            </p>

            <p class="mt-1 font-semibold text-gray-900">

                PT ABC Indonesia

            </p>

        </div>

        {{-- Date --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

            {{-- Quotation Date --}}
            <div>

                <p class="text-sm text-gray-500">

                    Date

                </p>

                <p class="mt-1 font-semibold text-gray-900">

                    20 Jul 2026

                </p>

            </div>

            {{-- Valid Until --}}
            <div>

                <p class="text-sm text-gray-500">

                    Valid Until

                </p>

                <p class="mt-1 font-semibold text-gray-900">

                    27 Jul 2026

                </p>

            </div>

        </div>

        <hr>

        {{-- Items Summary --}}
        <div>

            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">

                Summary

            </h3>

            <div class="space-y-4">

                {{-- Total Item --}}
                <div class="flex items-center justify-between">

                    <span class="text-gray-500">

                        Total Item

                    </span>

                    <span class="font-semibold text-gray-900">

                        1

                    </span>

                </div>

                {{-- Total Qty --}}
                <div class="flex items-center justify-between">

                    <span class="text-gray-500">

                        Total Qty

                    </span>

                    <span class="font-semibold text-gray-900">

                        1

                    </span>

                </div>

                {{-- Subtotal --}}
                <div class="flex items-center justify-between">

                    <span class="text-gray-500">

                        Subtotal

                    </span>

                    <span class="font-semibold text-gray-900">

                        Rp 0

                    </span>

                </div>

            </div>

        </div>

        <hr>

        {{-- Grand Total --}}
        <div class="rounded-2xl bg-blue-50 p-5">

            <p class="text-sm font-medium text-gray-500">

                Grand Total

            </p>

            <h2 class="mt-2 text-3xl font-bold text-blue-600">

                Rp 0

            </h2>

            <p class="mt-2 text-xs leading-5 text-gray-500">

                Total nilai quotation berdasarkan seluruh item yang ditambahkan.

            </p>

        </div>

        {{-- Action --}}
        <div class="space-y-3">

            {{-- Save --}}
            <x-ui.button class="w-full">

                Simpan Quotation

            </x-ui.button>

            {{-- Cancel --}}
            <a
                href="{{ route('owner.quotations.index') }}"
                class="block"
            >

                <x-ui.button
                    variant="secondary"
                    class="w-full"
                >

                    Batal

                </x-ui.button>

            </a>

        </div>

    </div>

</x-ui.info-card>