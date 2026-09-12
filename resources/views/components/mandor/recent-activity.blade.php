@props([
    'activities' => collect(),
])

@php
    $typeConfiguration = [
        'task' => [
            'label' => 'Task',
            'dot' => 'bg-blue-500',
            'icon_background' => 'bg-blue-50',
            'icon_text' => 'text-blue-600',
        ],

        'report' => [
            'label' => 'Laporan',
            'dot' => 'bg-indigo-500',
            'icon_background' => 'bg-indigo-50',
            'icon_text' => 'text-indigo-600',
        ],

        'documentation' => [
            'label' => 'Dokumentasi',
            'dot' => 'bg-green-500',
            'icon_background' => 'bg-green-50',
            'icon_text' => 'text-green-600',
        ],
    ];
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6">
        {{-- Header --}}
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                Aktivitas Terbaru
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Pembaruan terakhir pada Project Anda.
            </p>
        </div>

        @if ($activities->isNotEmpty())
            {{-- Timeline --}}
            <div class="relative mt-6">
                <div class="absolute bottom-5 left-5 top-5 w-px bg-gray-200"></div>

                <div class="space-y-5">
                    @foreach ($activities as $activity)
                        @php
                            $configuration =
                                $typeConfiguration[
                                    $activity['type']
                                ] ?? [
                                    'label' => 'Aktivitas',
                                    'dot' => 'bg-gray-500',
                                    'icon_background' =>
                                        'bg-gray-100',
                                    'icon_text' =>
                                        'text-gray-600',
                                ];
                        @endphp

                        <a
                            href="{{ $activity['href'] }}"
                            wire:navigate
                            wire:key="mandor-dashboard-activity-{{ $activity['key'] }}"
                            class="group relative flex items-start gap-4"
                        >
                            {{-- Ikon --}}
                            <div class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full ring-4 ring-white {{ $configuration['icon_background'] }} {{ $configuration['icon_text'] }}">
                                @if ($activity['type'] === 'task')
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor"
                                        class="h-5 w-5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                        />
                                    </svg>
                                @elseif ($activity['type'] === 'report')
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor"
                                        class="h-5 w-5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m0 12.75h7.5m-7.5 3h4.5m-7.5 3h9a2.25 2.25 0 0 0 2.25-2.25V8.108a2.25 2.25 0 0 0-.659-1.591l-3.108-3.108a2.25 2.25 0 0 0-1.591-.659H5.25A2.25 2.25 0 0 0 3 5v13.75A2.25 2.25 0 0 0 5.25 21Z"
                                        />
                                    </svg>
                                @else
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor"
                                        class="h-5 w-5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Z"
                                        />
                                    </svg>
                                @endif
                            </div>

                            {{-- Informasi --}}
                            <div class="min-w-0 flex-1 pb-1">
                                <div class="flex flex-col gap-1">
                                    <h3 class="line-clamp-1 font-semibold text-gray-900 transition group-hover:text-blue-600">
                                        {{ $activity['title'] }}
                                    </h3>

                                    <p class="line-clamp-2 text-sm leading-5 text-gray-500">
                                        {{ $activity['description'] }}
                                    </p>
                                </div>

                                <div class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1">
                                    <span class="text-xs font-semibold {{ $configuration['icon_text'] }}">
                                        {{ $configuration['label'] }}
                                    </span>

                                    <span
                                        class="h-1 w-1 rounded-full {{ $configuration['dot'] }}"
                                        aria-hidden="true"
                                    ></span>

                                    <time
                                        datetime="{{ $activity['occurred_at']->toIso8601String() }}"
                                        class="text-xs text-gray-400"
                                        title="{{ $activity['occurred_at']->translatedFormat(
                                            'd F Y H:i'
                                        ) }}"
                                    >
                                        {{ $activity['occurred_at']->diffForHumans() }}
                                    </time>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <a
                href="{{ route('mandor.daily-reports.index') }}"
                wire:navigate
                class="mt-6 inline-flex min-h-10 w-full items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700"
            >
                Lihat Laporan Harian
            </a>
        @else
            {{-- Kondisi kosong --}}
            <div class="mt-6 rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 py-10 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-white text-gray-400 shadow-sm">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-6 w-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>
                </div>

                <p class="mt-4 font-semibold text-gray-700">
                    Belum ada aktivitas
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Aktivitas Project terbaru akan muncul di sini.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>