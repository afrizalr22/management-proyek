@props([
    'project',
    'activities' => [],
])

@php
    $activityStyles = [
        'project' => [
            'icon' => 'bg-blue-100 text-blue-700',
            'label' => 'bg-blue-50 text-blue-700',
        ],

        'quotation' => [
            'icon' => 'bg-green-100 text-green-700',
            'label' => 'bg-green-50 text-green-700',
        ],

        'mandor' => [
            'icon' => 'bg-purple-100 text-purple-700',
            'label' => 'bg-purple-50 text-purple-700',
        ],

        'worker' => [
            'icon' => 'bg-cyan-100 text-cyan-700',
            'label' => 'bg-cyan-50 text-cyan-700',
        ],

        'task' => [
            'icon' => 'bg-yellow-100 text-yellow-700',
            'label' => 'bg-yellow-50 text-yellow-700',
        ],

        'report' => [
            'icon' => 'bg-orange-100 text-orange-700',
            'label' => 'bg-orange-50 text-orange-700',
        ],

        'review' => [
            'icon' => 'bg-red-100 text-red-700',
            'label' => 'bg-red-50 text-red-700',
        ],

        'documentation' => [
            'icon' => 'bg-indigo-100 text-indigo-700',
            'label' => 'bg-indigo-50 text-indigo-700',
        ],

        'progress' => [
            'icon' => 'bg-blue-100 text-blue-700',
            'label' => 'bg-blue-50 text-blue-700',
        ],

        'completed' => [
            'icon' => 'bg-green-100 text-green-700',
            'label' => 'bg-green-50 text-green-700',
        ],
    ];
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">
        {{-- Header --}}
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Aktivitas Terbaru
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Riwayat aktivitas terbaru pada Project ini.
                </p>
            </div>

            <span class="text-sm text-gray-500">
                Menampilkan {{ count($activities) }} aktivitas
            </span>
        </div>

        <hr class="my-6 border-gray-200 sm:my-8">

        @if (count($activities) > 0)
            <div>
                @foreach ($activities as $activity)
                    @php
                        $style = $activityStyles[
                            $activity['type']
                        ] ?? [
                            'icon' =>
                                'bg-gray-100 text-gray-600',
                            'label' =>
                                'bg-gray-50 text-gray-700',
                        ];
                    @endphp

                    <article class="relative flex gap-4 pb-7 last:pb-0 sm:gap-5">
                        @if (!$loop->last)
                            <div
                                class="absolute left-5 top-10 h-full w-px bg-gray-200"
                            ></div>
                        @endif

                        <div
                            class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $style['icon'] }}"
                        >
                            @if ($activity['type'] === 'completed')
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="h-5 w-5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m4.5 12.75 6 6 9-13.5"
                                    />
                                </svg>
                            @elseif ($activity['type'] === 'documentation')
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
                                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"
                                    />
                                </svg>
                            @elseif ($activity['type'] === 'progress')
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
                                        d="M3 13.5 9 7.5l4 4L21 3.5M21 3.5v6m0-6h-6"
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
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                    />
                                </svg>
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between sm:gap-4">
                                <div>
                                    <h3 class="font-semibold text-gray-900">
                                        {{ $activity['title'] }}
                                    </h3>

                                    <p class="mt-1 break-words text-sm leading-6 text-gray-600">
                                        {{ $activity['description'] }}
                                    </p>
                                </div>

                                <time
                                    datetime="{{ $activity['occurred_at']->toIso8601String() }}"
                                    class="shrink-0 text-xs text-gray-400"
                                >
                                    {{ $activity['occurred_at']
                                        ->translatedFormat(
                                            'd M Y, H:i'
                                        ) }}
                                </time>
                            </div>

                            <span
                                class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $style['label'] }}"
                            >
                                {{ $activity['actor'] }}
                            </span>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div
                class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 py-10 text-center"
            >
                <p class="font-semibold text-gray-700">
                    Belum ada aktivitas
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Aktivitas Project akan muncul setelah proses operasional dimulai.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>