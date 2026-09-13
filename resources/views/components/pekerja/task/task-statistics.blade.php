@props([
    'statistics',
])

@php
    $cards = [
        [
            'label' => 'Total Task',
            'value' => $statistics['total'],
            'description' => 'Seluruh task aktif dan selesai',
            'iconStyle' => 'bg-blue-50 text-blue-600',
            'icon' => 'total',
        ],

        [
            'label' => 'Belum Dimulai',
            'value' => $statistics['assigned'],
            'description' => 'Menunggu untuk dikerjakan',
            'iconStyle' => 'bg-amber-50 text-amber-600',
            'icon' => 'waiting',
        ],

        [
            'label' => 'Sedang Diproses',
            'value' => $statistics['active'],
            'description' => $statistics['overdue']
                .' task melewati deadline',
            'iconStyle' => 'bg-violet-50 text-violet-600',
            'icon' => 'progress',
        ],

        [
            'label' => 'Selesai',
            'value' => $statistics['completed'],
            'description' => 'Task yang telah disetujui',
            'iconStyle' => 'bg-emerald-50 text-emerald-600',
            'icon' => 'completed',
        ],
    ];
@endphp

<section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @foreach ($cards as $card)
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        {{ $card['label'] }}
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ $card['value'] }}
                    </p>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $card['iconStyle'] }}">
                    @if ($card['icon'] === 'total')
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
                                d="M9 5.25H6.75A2.25 2.25 0 0 0 4.5 7.5v11.25A2.25 2.25 0 0 0 6.75 21h10.5a2.25 2.25 0 0 0 2.25-2.25V7.5a2.25 2.25 0 0 0-2.25-2.25H15M9 5.25A2.25 2.25 0 0 1 11.25 3h1.5A2.25 2.25 0 0 1 15 5.25"
                            />
                        </svg>
                    @elseif ($card['icon'] === 'waiting')
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
                                d="M12 6v6h4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                            />
                        </svg>
                    @elseif ($card['icon'] === 'progress')
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
                                d="M11.42 15.17 17.25 21l3.75-3.75-5.83-5.83M11.42 15.17l-4.68 4.68a2.12 2.12 0 0 1-3-3l4.68-4.68m3 3 3.75-3.75m-6.75.75-5.25-5.25L6 3l5.25 5.25"
                            />
                        </svg>
                    @else
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
                                d="m4.5 12.75 6 6 9-13.5"
                            />
                        </svg>
                    @endif
                </div>
            </div>

            <p
                @class([
                    'mt-4 text-sm',
                    'font-semibold text-red-600' =>
                        $card['icon'] === 'progress'
                        && $statistics['overdue'] > 0,
                    'text-slate-500' =>
                        $card['icon'] !== 'progress'
                        || $statistics['overdue'] === 0,
                ])
            >
                {{ $card['description'] }}
            </p>
        </article>
    @endforeach
</section>