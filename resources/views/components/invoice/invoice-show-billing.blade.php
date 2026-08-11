<x-ui.info-card>

    <div class="p-6">

        {{-- Header --}}
        <div>

            <h2 class="text-xl font-bold text-gray-800">
                Billing Information
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Informasi client yang terkait dengan invoice ini.
            </p>

        </div>

        <hr class="my-6">

        {{-- Client Information --}}
        <div class="space-y-6">

            {{-- Client --}}
            <div>

                <p class="text-sm text-gray-500">
                    Client
                </p>

                <p class="mt-1 text-lg font-semibold text-gray-800">
                    PT Maju Bersama Properti
                </p>

            </div>

            {{-- Contact Person --}}
            <div>

                <p class="text-sm text-gray-500">
                    Contact Person
                </p>

                <p class="mt-1 font-semibold text-gray-800">
                    Ahmad Fauzi
                </p>

            </div>

            {{-- Contact --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                <div>

                    <p class="text-sm text-gray-500">
                        Phone
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        0812-3456-7890
                    </p>

                </div>

                <div>

                    <p class="text-sm text-gray-500">
                        Email
                    </p>

                    <p class="mt-1 break-all font-semibold text-gray-800">
                        admin@ptmaju.co.id
                    </p>

                </div>

            </div>

            {{-- Address --}}
            <div>

                <p class="text-sm text-gray-500">
                    Address
                </p>

                <p class="mt-1 font-semibold leading-relaxed text-gray-800">
                    Jl. Gatot Subroto No. 123,
                    Jakarta Selatan, DKI Jakarta
                </p>

            </div>

        </div>

    </div>

</x-ui.info-card>