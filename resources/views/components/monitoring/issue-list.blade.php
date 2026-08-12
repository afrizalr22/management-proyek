<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-4">

            <div class="min-w-0">

                <h2 class="text-2xl font-bold text-gray-800">
                    Active Issues
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Daftar kendala yang membutuhkan perhatian.
                </p>

            </div>


            {{-- Issue Count --}}
            <x-ui.badge color="red">
                2 Issues
            </x-ui.badge>

        </div>


        {{-- Issue List --}}
        <div class="mt-8 space-y-4">

            {{-- High Priority Issue --}}
            <div
                class="rounded-2xl border border-red-200 bg-red-50 p-5 transition duration-200 hover:shadow-sm"
            >

                <div class="flex items-start justify-between gap-4">

                    <div class="min-w-0">

                        <h3 class="font-semibold text-red-700">
                            Keterlambatan Material Baja
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Supplier belum mengirim material WF sesuai jadwal.
                        </p>

                    </div>


                    <div class="shrink-0">

                        <x-ui.badge color="red">
                            High
                        </x-ui.badge>

                    </div>

                </div>

            </div>


            {{-- Medium Priority Issue --}}
            <div
                class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5 transition duration-200 hover:shadow-sm"
            >

                <div class="flex items-start justify-between gap-4">

                    <div class="min-w-0">

                        <h3 class="font-semibold text-yellow-700">
                            Cuaca Hujan
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Aktivitas pengecoran dihentikan sementara.
                        </p>

                    </div>


                    <div class="shrink-0">

                        <x-ui.badge color="yellow">
                            Medium
                        </x-ui.badge>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>