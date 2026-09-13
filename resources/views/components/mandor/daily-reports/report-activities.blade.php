@props([
    'report',
])

<x-ui.info-card class="overflow-hidden">
    <div class="border-b border-gray-200 px-6 py-5">
        <div class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
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
                        d="M9 11l3 3L22 4"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"
                    />
                </svg>
            </span>

            <div>
                <h2 class="text-lg font-bold text-gray-900">
                    Aktivitas Pekerjaan
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Aktivitas yang dilaporkan oleh Pekerja.
                </p>
            </div>
        </div>
    </div>

    <div class="p-6">
        @if (filled($report->activities))
            <p class="whitespace-pre-line text-sm leading-7 text-gray-700">{{ $report->activities }}</p>
        @else
            <p class="text-sm italic text-gray-400">
                Aktivitas pekerjaan tidak tersedia.
            </p>
        @endif
    </div>
</x-ui.info-card>