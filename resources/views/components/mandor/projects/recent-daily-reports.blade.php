@props([
    'project',
    'reports' => collect(),
    'total' => 0,
])

@php
    $statusConfiguration = [
        'draft' => [
            'text' => 'Draft',
            'class' => 'bg-gray-100 text-gray-600',
        ],

        'submitted' => [
            'text' => 'Menunggu Pemeriksaan',
            'class' => 'bg-amber-50 text-amber-700',
        ],

        'pending' => [
            'text' => 'Menunggu Pemeriksaan',
            'class' => 'bg-amber-50 text-amber-700',
        ],

        'approved' => [
            'text' => 'Disetujui',
            'class' => 'bg-green-50 text-green-700',
        ],

        'rejected' => [
            'text' => 'Perlu Perbaikan',
            'class' => 'bg-red-50 text-red-700',
        ],
    ];
@endphp

<x-ui.info-card class="overflow-hidden">
    {{-- Header --}}
    <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div>
            <h2 class="text-base font-bold text-gray-900">
                Laporan Harian Terbaru
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Aktivitas terbaru yang dilaporkan Pekerja.
            </p>
        </div>

        <span class="inline-flex w-fit rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
            {{ (int) $total }}
            Laporan
        </span>
    </div>

    @if ($reports->isNotEmpty())
        {{-- Daftar laporan --}}
        <div class="divide-y divide-gray-100">
            @foreach ($reports as $report)
                @php
                    $configuration =
                        $statusConfiguration[
                            $report->status
                        ] ?? [
                            'text' => ucfirst(
                                str_replace(
                                    '_',
                                    ' ',
                                    $report->status
                                        ?: 'Tidak diketahui'
                                )
                            ),
                            'class' =>
                                'bg-gray-100 text-gray-600',
                        ];

                    $hasObstacle = filled(
                        $report->obstacles
                    );

                    $reportTime =
                        $report->submitted_at
                        ?? $report->created_at;
                @endphp

                <a
                    href="{{ route(
                        'mandor.daily-reports.show',
                        [
                            'report' => $report->id,
                        ]
                    ) }}"
                    wire:navigate
                    wire:key="mandor-project-report-{{ $report->id }}"
                    class="group block px-5 py-5 transition hover:bg-blue-50/30 sm:px-6"
                >
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0 flex-1">
                            {{-- Tanggal dan status --}}
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="font-semibold text-gray-900 transition group-hover:text-blue-600">
                                    {{ $report->report_date
                                        ?->translatedFormat(
                                            'd F Y'
                                        ) ?? 'Tanggal tidak tersedia' }}
                                </h3>

                                <span class="rounded-md px-2 py-1 text-[10px] font-bold uppercase {{ $configuration['class'] }}">
                                    {{ $configuration['text'] }}
                                </span>

                                @if ($hasObstacle)
                                    <span class="rounded-md bg-red-50 px-2 py-1 text-[10px] font-bold uppercase text-red-700">
                                        Ada Kendala
                                    </span>
                                @endif
                            </div>

                            {{-- Nomor dan pelapor --}}
                            <p class="mt-1 text-xs text-gray-400">
                                {{ $report->report_number }}

                                <span class="mx-1">
                                    •
                                </span>

                                {{ $report->user?->name
                                    ?? 'Pekerja tidak ditemukan' }}
                            </p>

                            {{-- Task --}}
                            @if ($report->task)
                                <p class="mt-2 truncate text-xs font-medium text-blue-600">
                                    {{ $report->task->title }}
                                </p>
                            @endif

                            {{-- Aktivitas --}}
                            <p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-600">
                                {{ $report->activities
                                    ?: 'Tidak ada rincian aktivitas.' }}
                            </p>

                            {{-- Informasi tambahan --}}
                            <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-gray-500">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor"
                                        class="h-4 w-4 text-gray-400"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"
                                        />
                                    </svg>

                                    {{ $report->documentations->count() }}
                                    Foto
                                </span>

                                <span class="inline-flex items-center gap-1.5">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor"
                                        class="h-4 w-4 text-gray-400"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                        />
                                    </svg>

                                    {{ $reportTime
                                        ?->format('H:i') ?? '-' }}
                                    WIB
                                </span>

                                <span>
                                    Progress:
                                    <strong class="font-semibold text-gray-700">
                                        {{ min(
                                            100,
                                            max(
                                                0,
                                                (int) $report
                                                    ->reported_progress
                                            )
                                        ) }}%
                                    </strong>
                                </span>
                            </div>
                        </div>

                        {{-- Panah --}}
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-gray-400 transition group-hover:bg-blue-100 group-hover:text-blue-600">
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
                                    d="m9 18 6-6-6-6"
                                />
                            </svg>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Footer --}}
        <div class="border-t border-gray-200 px-5 py-4 sm:px-6">
            <a
                href="{{ route(
                    'mandor.daily-reports.index'
                ) }}"
                wire:navigate
                class="inline-flex min-h-10 w-full items-center justify-center rounded-xl text-sm font-semibold text-blue-600 transition hover:bg-blue-50 hover:text-blue-700"
            >
                Lihat Semua Laporan
            </a>
        </div>
    @else
        {{-- Kondisi kosong --}}
        <div class="px-6 py-10 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-400">
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
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m0 12.75h7.5m-7.5 3h4.5m-7.5 3h9a2.25 2.25 0 0 0 2.25-2.25V8.108a2.25 2.25 0 0 0-.659-1.591l-3.108-3.108a2.25 2.25 0 0 0-1.591-.659H5.25A2.25 2.25 0 0 0 3 5v13.75A2.25 2.25 0 0 0 5.25 21Z"
                    />
                </svg>
            </div>

            <p class="mt-4 font-semibold text-gray-700">
                Belum ada laporan
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Laporan dari Pekerja untuk Project ini akan muncul di sini.
            </p>
        </div>
    @endif
</x-ui.info-card>