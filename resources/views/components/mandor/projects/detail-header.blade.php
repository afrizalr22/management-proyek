<x-ui.info-card class="overflow-hidden">

    <div class="relative overflow-hidden rounded-2xl">

        {{-- Project Image --}}
        <div class="h-64 w-full bg-gray-200">

            <img
                src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1600&q=80"
                alt="Jakarta Sky Tower"
                class="h-full w-full object-cover"
            >

        </div>


        {{-- Overlay --}}
        <div
            class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"
        ></div>


        {{-- Project Information --}}
        <div class="absolute inset-x-0 bottom-0 p-6">

            <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

                {{-- Information --}}
                <div class="space-y-2">

                    {{-- Status & Location --}}
                    <div class="flex flex-wrap items-center gap-2">

                        <span
                            class="rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-bold uppercase tracking-wide text-white"
                        >
                            Ongoing
                        </span>

                        <span class="text-sm font-medium text-white">
                            📍 Sudirman, Jakarta Pusat
                        </span>

                    </div>


                    {{-- Project Name --}}
                    <h1 class="text-2xl font-bold text-white lg:text-3xl">

                        Jakarta Sky Tower

                    </h1>

                </div>


                {{-- Actions --}}
                <div class="flex flex-wrap gap-3">

                    <x-ui.button
                        variant="primary"
                    >
                        + New Daily Report
                    </x-ui.button>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>