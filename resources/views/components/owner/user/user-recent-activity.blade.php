@props([
    'activities' => collect(),
])

<x-ui.info-card>
    <div class="p-6 sm:p-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">
                Aktivitas Terbaru
            </h2>

            <p class="mt-2 text-gray-500">
                Riwayat aktivitas akun dan penugasan.
            </p>
        </div>

        @if ($activities->isNotEmpty())
            <div class="relative">
                <div class="absolute bottom-5 left-[17px] top-5 w-px bg-gray-200"></div>

                <div class="space-y-7">
                    @foreach ($activities as $activity)
                        @php
                            $iconClasses = match ($activity['color']) {
                                'green' => 'bg-green-600 text-white',
                                'red' => 'bg-red-600 text-white',
                                'gray' => 'bg-gray-500 text-white',
                                default => 'bg-blue-600 text-white',
                            };
                        @endphp

                        <div class="relative flex gap-4">
                            <div class="relative z-10 flex h-9 w-9 shrink-0 items-center justify-center rounded-full shadow {{ $iconClasses }}">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="h-4 w-4"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m4.5 12.75 6 6 9-13.5"
                                    />
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <h4 class="break-words font-semibold text-gray-900">
                                    {{ $activity['title'] }}
                                </h4>

                                <p class="mt-1 break-words text-sm text-gray-500">
                                    {{ $activity['description'] }}
                                </p>

                                <span class="mt-2 block text-xs text-gray-400">
                                    {{ \Illuminate\Support\Carbon::parse($activity['date'])
                                        ->translatedFormat('d F Y, H:i') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 py-10 text-center">
                <p class="font-semibold text-gray-700">
                    Belum ada aktivitas
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>