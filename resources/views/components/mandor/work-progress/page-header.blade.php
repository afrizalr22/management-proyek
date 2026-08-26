<div
    class="flex flex-col gap-5
           lg:flex-row lg:items-end lg:justify-between"
>

    {{-- Page Information --}}
    <div>

        {{-- Breadcrumb --}}
        <div class="flex flex-wrap items-center gap-2 text-sm">

            <a
                href="{{ route('mandor.projects.index') }}"
                class="font-medium text-blue-600 transition
                       hover:text-blue-700"
            >
                Proyek Saya
            </a>

            <svg
                class="h-4 w-4 text-gray-400"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 18l6-6-6-6"
                />
            </svg>

            <span class="font-medium text-gray-500">
                Jakarta Sky Tower
            </span>

        </div>

        {{-- Title --}}
        <h1 class="mt-3 text-2xl font-bold text-gray-900 sm:text-3xl">
            Progress Pekerjaan
        </h1>

        {{-- Description --}}
        <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-500">
            Pantau perkembangan, tahapan, dan status pekerjaan proyek
            secara terstruktur.
        </p>

    </div>

    {{-- Actions --}}
    <div class="flex flex-wrap items-center gap-3">

        {{-- Export --}}
        <button
            type="button"
            class="inline-flex h-11 items-center justify-center gap-2
                   rounded-lg border border-gray-300 bg-white px-4
                   text-sm font-semibold text-gray-700 transition
                   hover:bg-gray-50"
        >
            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 3v12m0 0l-4-4m4 4l4-4"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5 15v4h14v-4"
                />
            </svg>

            Export PDF
        </button>

    </div>

</div>