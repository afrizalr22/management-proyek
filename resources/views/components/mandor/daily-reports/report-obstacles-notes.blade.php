@props([
    'report',
])

@php
    $hasObstacle = filled($report->obstacles);

    $reviewedAt = $report->reviewed_at
        ? $report->reviewed_at
            ->locale('id')
            ->translatedFormat('d F Y, H.i')
            . ' WIB'
        : null;
@endphp

<div class="space-y-6">

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-ui.info-card class="overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-5">
                <div class="flex items-center gap-3">
                    <span
                        @class([
                            'flex h-10 w-10 items-center justify-center rounded-xl',
                            'bg-red-50 text-red-600' => $hasObstacle,
                            'bg-emerald-50 text-emerald-600' => ! $hasObstacle,
                        ])
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
                                d="M12 3L2.5 20h19L12 3z"
                            />

                            <path
                                stroke-linecap="round"
                                d="M12 9v5M12 17h.01"
                            />
                        </svg>
                    </span>

                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Kendala Pekerjaan
                        </h2>

                        <p
                            @class([
                                'mt-1 text-xs font-semibold',
                                'text-red-600' => $hasObstacle,
                                'text-emerald-600' => ! $hasObstacle,
                            ])
                        >
                            {{ $hasObstacle ? 'Memerlukan perhatian' : 'Tidak ada kendala' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @if ($hasObstacle)
                    <p class="whitespace-pre-line text-sm leading-7 text-red-700">{{ $report->obstacles }}</p>
                @else
                    <p class="text-sm leading-7 text-gray-400">
                        Pekerja tidak melaporkan kendala pada pekerjaan ini.
                    </p>
                @endif
            </div>
        </x-ui.info-card>

        <x-ui.info-card class="overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-5">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M4 4h16v16H4z" />

                            <path d="M8 9h8M8 13h6" />
                        </svg>
                    </span>

                    <h2 class="text-lg font-bold text-gray-900">
                        Catatan Tambahan
                    </h2>
                </div>
            </div>

            <div class="p-6">
                @if (filled($report->notes))
                    <p class="whitespace-pre-line text-sm leading-7 text-gray-700">{{ $report->notes }}</p>
                @else
                    <p class="text-sm leading-7 text-gray-400">
                        Tidak ada catatan tambahan pada laporan ini.
                    </p>
                @endif
            </div>
        </x-ui.info-card>
    </div>

    @if (in_array($report->status, ['revision', 'approved'], true))
        <x-ui.info-card
            @class([
                'overflow-hidden',
                'border-red-200' => $report->status === 'revision',
                'border-emerald-200' => $report->status === 'approved',
            ])
        >
            <div
                @class([
                    'border-b px-6 py-5',
                    'border-red-100 bg-red-50/50' =>
                        $report->status === 'revision',
                    'border-emerald-100 bg-emerald-50/50' =>
                        $report->status === 'approved',
                ])
            >
                <h2
                    @class([
                        'text-lg font-bold',
                        'text-red-700' => $report->status === 'revision',
                        'text-emerald-700' => $report->status === 'approved',
                    ])
                >
                    {{ $report->status === 'approved'
                        ? 'Hasil Validasi Mandor'
                        : 'Catatan Revisi Mandor' }}
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Diperiksa oleh
                    <span class="font-semibold text-gray-700">
                        {{ $report->reviewer?->name ?? 'Mandor' }}
                    </span>

                    @if ($reviewedAt)
                        pada {{ $reviewedAt }}
                    @endif
                </p>
            </div>

            <div class="p-6">
                @if (filled($report->review_notes))
                    <p class="whitespace-pre-line text-sm leading-7 text-gray-700">{{ $report->review_notes }}</p>
                @else
                    <p class="text-sm text-gray-400">
                        Laporan disetujui tanpa catatan tambahan.
                    </p>
                @endif
            </div>
        </x-ui.info-card>
    @endif

</div>