<x-ui.info-card>

    <div class="p-8">

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">

            {{-- Client --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Client
                </p>

                <h3 class="mt-2 text-xl font-bold text-gray-900">
                    PT Maju Bersama
                </h3>

                <p class="mt-2 text-gray-500">
                    Jakarta Selatan, Indonesia
                </p>

            </div>


            {{-- Project --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Project
                </p>

                <h3 class="mt-2 text-xl font-semibold text-gray-900">
                    Pembangunan Gudang Logistik
                </h3>

                <p class="mt-2 text-gray-500">
                    Mandor: Ir. Haryono Kusuma
                </p>

            </div>


            {{-- Invoice Date --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Invoice
                </p>

                <div class="mt-2 space-y-2">

                    <p class="text-lg font-semibold text-gray-900">
                        20 Juli 2026
                    </p>

                    <p class="text-gray-500">
                        Jatuh tempo: 27 Juli 2026
                    </p>

                </div>

            </div>


            {{-- Total --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Total Invoice
                </p>

                <h3 class="mt-2 text-3xl font-bold text-blue-600">
                    Rp 450.000.000
                </h3>

                <div class="mt-3">

                    <x-ui.badge color="yellow">
                        Unpaid
                    </x-ui.badge>

                </div>

            </div>

        </div>


        {{-- Client Contact --}}
        <div class="mt-10">

            <h3 class="text-xl font-bold text-gray-800">
                Client Information
            </h3>

            <p class="mt-2 text-gray-500">
                Informasi kontak client yang terkait dengan invoice.
            </p>

            <hr class="my-6">


            <div class="grid grid-cols-1 gap-6 rounded-2xl border border-gray-200 bg-gray-50 p-6 md:grid-cols-2">

                {{-- Contact Person --}}
                <div>

                    <p class="text-sm text-gray-500">
                        Contact Person
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        Ahmad Fauzi
                    </p>

                </div>


                {{-- Phone --}}
                <div>

                    <p class="text-sm text-gray-500">
                        Phone
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        0812-3456-7890
                    </p>

                </div>


                {{-- Email --}}
                <div>

                    <p class="text-sm text-gray-500">
                        Email
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        admin@maju-bersama.co.id
                    </p>

                </div>


                {{-- Address --}}
                <div>

                    <p class="text-sm text-gray-500">
                        Address
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        Jl. Gatot Subroto No. 123, Jakarta Selatan
                    </p>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>