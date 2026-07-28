<x-ui.info-card>

    <div class="p-8">

        <div class="mb-8 flex items-center justify-between">

            <div>

                <h2 class="text-2xl font-bold text-gray-800">

                    Latest Documentation

                </h2>

                <p class="mt-2 text-gray-500">

                    Dokumentasi terbaru dari lokasi proyek.

                </p>

            </div>

           <a
                href="{{ route('owner.monitoring.documentation', 1) }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 transition"
            >

                View All

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 5l7 7-7 7"/>

                </svg>

            </a>

        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

            @foreach(range(1,3) as $photo)

                <div
                    class="overflow-hidden rounded-2xl border border-gray-200 transition duration-300 hover:-translate-y-1 hover:shadow-lg"
                >

                    <div class="aspect-video overflow-hidden bg-gray-200">

                        <img
                            src="..."
                            class="h-full w-full object-cover transition duration-300 hover:scale-105"
                        >

                    </div>

                    <div class="p-4">

                        <h4 class="font-semibold">

                            Progress Documentation

                        </h4>

                        <p class="mt-2 text-sm text-gray-500">

                            27 Juli 2026

                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</x-ui.info-card>