@props([
    'activities',
])

@php
    $typeConfiguration = [
        'client' => [
            'background' => 'bg-green-100',
            'text' => 'text-green-600',
            'label' => 'Client',
        ],

        'project' => [
            'background' => 'bg-blue-100',
            'text' => 'text-blue-600',
            'label' => 'Monitoring',
        ],

        'invoice' => [
            'background' => 'bg-purple-100',
            'text' => 'text-purple-600',
            'label' => 'Invoice',
        ],

        'delivery_order' => [
            'background' => 'bg-amber-100',
            'text' => 'text-amber-600',
            'label' => 'Surat Jalan',
        ],
    ];
@endphp

<div class="h-full overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="border-b border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900">
            Aktivitas Terbaru
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Pembaruan terbaru pada sistem.
        </p>
    </div>

    <div class="p-6">
        @if ($activities->isNotEmpty())
            <div class="relative">
                <div class="absolute bottom-5 left-5 top-5 w-px bg-gray-200"></div>

                <div class="space-y-6">
                    @foreach ($activities as $activity)
                        @php
                            $configuration =
                                $typeConfiguration[
                                    $activity['type']
                                ]
                                ?? [
                                    'background' =>
                                        'bg-gray-100',

                                    'text' =>
                                        'text-gray-600',

                                    'label' =>
                                        'Aktivitas',
                                ];
                        @endphp

                        <a
                            href="{{ $activity['href'] }}"
                            wire:navigate
                            wire:key="dashboard-activity-{{ $activity['key'] }}"
                            class="group relative flex items-start gap-4"
                        >
                            <div class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full ring-4 ring-white {{ $configuration['background'] }} {{ $configuration['text'] }}">
                                @if ($activity['type'] === 'client')
                                    <x-icon.client-activity class="h-5 w-5" />
                                @elseif ($activity['type'] === 'project')
                                    <x-icon.project-activity class="h-5 w-5" />
                                @elseif ($activity['type'] === 'invoice')
                                    <x-icon.invoice-activity class="h-5 w-5" />
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
                                            d="M8.25 18.75a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6.75m-9.75 0H3.75V6.75A2.25 2.25 0 0 1 6 4.5h7.5v14.25m1.5 0a1.5 1.5 0 1 0 3 0m-3 0a1.5 1.5 0 0 1 3 0m0 0h2.25v-6.75l-3-3H13.5"
                                        />
                                    </svg>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1 pt-0.5">
                                <h3 class="truncate font-semibold text-gray-900 transition group-hover:text-blue-600">
                                    {{ $activity['title'] }}
                                </h3>

                                <p class="mt-1 line-clamp-2 text-sm leading-5 text-gray-500">
                                    {{ $activity['description'] }}
                                </p>

                                <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1">
                                    <span class="text-xs font-semibold uppercase tracking-wide {{ $configuration['text'] }}">
                                        {{ $configuration['label'] }}
                                    </span>

                                    <time
                                        datetime="{{ $activity['occurred_at']->toIso8601String() }}"
                                        class="text-xs text-gray-400"
                                    >
                                        {{ $activity['occurred_at']->diffForHumans() }}
                                    </time>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <div class="flex min-h-[340px] items-center justify-center text-center">
                <div>
                    <p class="font-semibold text-gray-700">
                        Belum ada aktivitas
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Aktivitas terbaru akan muncul di sini.
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>