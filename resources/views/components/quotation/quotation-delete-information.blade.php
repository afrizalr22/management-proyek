<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div>

            <h2 class="text-2xl font-bold text-gray-900">

                Quotation Information

            </h2>

            <p class="mt-2 text-gray-500">

                Pastikan quotation yang akan dihapus sudah benar.

            </p>

        </div>

        <hr class="my-8">

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3">

            {{-- Quotation Number --}}
            <div>

                <p class="text-sm font-semibold text-gray-500">

                    Quotation Number

                </p>

                <p class="mt-2 text-lg font-semibold text-gray-900">

                    QTN-2026-0001

                </p>

            </div>

            {{-- Project --}}
            <div>

                <p class="text-sm font-semibold text-gray-500">

                    Project

                </p>

                <p class="mt-2 text-lg font-semibold text-gray-900">

                    Renovasi Gedung Kantor

                </p>

            </div>

            {{-- Client --}}
            <div>

                <p class="text-sm font-semibold text-gray-500">

                    Client

                </p>

                <p class="mt-2 text-lg font-semibold text-gray-900">

                    PT Maju Bersama

                </p>

            </div>

            {{-- Quotation Date --}}
            <div>

                <p class="text-sm font-semibold text-gray-500">

                    Quotation Date

                </p>

                <p class="mt-2 text-lg font-semibold text-gray-900">

                    15 Juli 2026

                </p>

            </div>

            {{-- Status --}}
            <div>

                <p class="text-sm font-semibold text-gray-500">

                    Status

                </p>

                <div class="mt-2">

                    <x-ui.badge color="green">

                        Approved

                    </x-ui.badge>

                </div>

            </div>

            {{-- Grand Total --}}
            <div>

                <p class="text-sm font-semibold text-gray-500">

                    Grand Total

                </p>

                <p class="mt-2 text-lg font-bold text-blue-600">

                    Rp 150.000.000

                </p>

            </div>

        </div>

    </div>

</x-ui.info-card>