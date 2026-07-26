<x-ui.info-card>

    <div class="p-6 space-y-6">

        {{-- Header --}}
        <div>

            <h2 class="text-xl font-bold text-gray-800">

                Quotation Summary

            </h2>

            <p class="mt-2 text-sm text-gray-500">

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

            <p class="mt-1 font-semibold text-gray-800">

                Renovasi Gedung PT ABC

            </p>

        </div>

        {{-- Client --}}
        <div>

            <p class="text-sm text-gray-500">

                Client

            </p>

            <p class="mt-1 font-semibold text-gray-800">

                PT ABC Indonesia

            </p>

        </div>

        {{-- Date --}}
        <div class="grid grid-cols-2 gap-4">

            <div>

                <p class="text-sm text-gray-500">

                    Date

                </p>

                <p class="mt-1 font-semibold">

                    20 Jul 2026

                </p>

            </div>

            <div>

                <p class="text-sm text-gray-500">

                    Valid Until

                </p>

                <p class="mt-1 font-semibold">

                    27 Jul 2026

                </p>

            </div>

        </div>

        <hr>

        {{-- Summary --}}
        <div class="space-y-4">

            <div class="flex items-center justify-between">

                <span class="text-gray-500">

                    Total Item

                </span>

                <span class="font-semibold">

                    1

                </span>

            </div>

            <div class="flex items-center justify-between">

                <span class="text-gray-500">

                    Total Qty

                </span>

                <span class="font-semibold">

                    1

                </span>

            </div>

            <div class="flex items-center justify-between">

                <span class="text-gray-500">

                    Subtotal

                </span>

                <span class="font-semibold">

                    Rp 0

                </span>

            </div>

        </div>

        <hr>

        {{-- Grand Total --}}
        <div class="rounded-2xl bg-blue-50 p-5">

            <p class="text-sm text-gray-500">

                Grand Total

            </p>

            <h2 class="mt-2 text-3xl font-bold text-blue-600">

                Rp 0

            </h2>

        </div>

        {{-- Action --}}
        <div class="space-y-3">

            <x-ui.button
                class="w-full"
            >

                Simpan Quotation

            </x-ui.button>

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