<x-ui.info-card class="overflow-hidden">

    {{-- Header --}}
    <div class="border-b border-gray-200 px-6 py-5">

        <h2 class="text-base font-bold text-gray-900">
            Penyelesaian Keseluruhan
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Perbandingan progres aktual dan rencana proyek
        </p>

    </div>

    {{-- Progress Content --}}
    <div class="flex flex-col items-center justify-center px-6 py-8">

        {{-- Circular Progress --}}
        <div
            class="relative flex h-48 w-48 shrink-0
                   items-center justify-center rounded-full"
            style="
                background:
                conic-gradient(
                    #2563eb 0%,
                    #2563eb 75%,
                    #e5e7eb 75%,
                    #e5e7eb 100%
                );
            "
        >

            {{-- Inner Circle --}}
            <div
                class="flex h-40 w-40 flex-col items-center
                       justify-center rounded-full bg-white"
            >

                <span class="text-4xl font-bold text-gray-900">
                    75%
                </span>

                <span
                    class="mt-1 text-xs font-semibold
                           uppercase tracking-wide text-emerald-600"
                >
                    Sesuai Target
                </span>

            </div>

        </div>

        {{-- Progress Information --}}
        <div class="mt-8 grid w-full grid-cols-2 gap-4">

            {{-- Planned Progress --}}
            <div class="rounded-xl bg-gray-50 p-5 text-center">

                <p class="text-sm font-medium text-gray-500">
                    Rencana
                </p>

                <p class="mt-2 text-2xl font-bold text-gray-900">
                    72%
                </p>

            </div>

            {{-- Variance --}}
            <div class="rounded-xl bg-blue-50 p-5 text-center">

                <p class="text-sm font-medium text-gray-500">
                    Selisih
                </p>

                <p class="mt-2 text-2xl font-bold text-blue-600">
                    +3%
                </p>

            </div>

        </div>

    </div>

</x-ui.info-card>