<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div class="mb-8 flex items-start justify-between gap-4">

            <div class="min-w-0">

                <h2 class="text-2xl font-bold text-gray-800">
                    Latest Documentation
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Dokumentasi terbaru dari lokasi proyek.
                </p>

            </div>


            {{-- View All --}}
            <a
                href="{{ route('owner.monitoring.documentation', 1) }}"
                class="inline-flex shrink-0 items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
            >

                <span>
                    View All
                </span>

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 5l7 7-7 7"
                    />

                </svg>

            </a>

        </div>


        {{-- Documentation List --}}
        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

            @foreach (range(1, 3) as $photo)

                <div
                    class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-lg"
                >

                    {{-- Image --}}
                    <div class="aspect-video overflow-hidden bg-gray-100">

                        <img
                            src="..."
                            alt="Progress Documentation"
                            class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                        >

                    </div>


                    {{-- Information --}}
                    <div class="p-4">

                        <h4 class="text-sm font-semibold text-gray-900">
                            Progress Documentation
                        </h4>

                        <p class="mt-1.5 text-xs text-gray-500">
                            27 Juli 2026
                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</x-ui.info-card>