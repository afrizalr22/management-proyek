@props([
    'report',
])

@php
    $reportDate = $report->report_date
        ? $report->report_date
            ->locale('id')
            ->translatedFormat('d F Y')
        : '-';

    $submittedAt = $report->submitted_at
        ? $report->submitted_at
            ->copy()
            ->timezone('Asia/Jakarta')
            ->locale('id')
            ->translatedFormat('d F Y, H.i')
            . ' WIB'
        : 'Belum dikirim';

    $location = $report->task?->location
        ?: (
            $report->project?->location
            ?: 'Lokasi belum tersedia'
        );
@endphp

<section
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
        <div class="flex items-start gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
            >
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
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.5-1.632Z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Ringkasan Laporan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi pekerja dan Task yang dilaporkan.
                </p>
            </div>
        </div>
    </div>

    <dl
        class="grid grid-cols-1 gap-x-6 gap-y-5 px-5 py-5 sm:grid-cols-2 sm:px-6"
    >
        <div>
            <dt
                class="text-xs font-medium uppercase tracking-wide text-slate-400"
            >
                Nama Pekerja
            </dt>

            <dd class="mt-1 text-sm font-semibold text-slate-900">
                {{ $report->user?->name ?? 'Pekerja tidak tersedia' }}
            </dd>
        </div>

        <div>
            <dt
                class="text-xs font-medium uppercase tracking-wide text-slate-400"
            >
                Tanggal Laporan
            </dt>

            <dd class="mt-1 text-sm font-semibold text-slate-900">
                {{ $reportDate }}
            </dd>
        </div>

        <div class="sm:col-span-2">
            <dt
                class="text-xs font-medium uppercase tracking-wide text-slate-400"
            >
                Task
            </dt>

            <dd class="mt-1 text-sm font-semibold text-slate-900">
                @if ($report->task)
                    {{ $report->task->task_code }}
                    —
                    {{ $report->task->title }}
                @else
                    Task tidak tersedia
                @endif
            </dd>
        </div>

        <div>
            <dt
                class="text-xs font-medium uppercase tracking-wide text-slate-400"
            >
                Proyek
            </dt>

            <dd class="mt-1 text-sm font-semibold text-slate-900">
                {{ $report->project?->project_name ?? 'Proyek tidak tersedia' }}
            </dd>
        </div>

        <div>
            <dt
                class="text-xs font-medium uppercase tracking-wide text-slate-400"
            >
                Lokasi Pekerjaan
            </dt>

            <dd class="mt-1 text-sm font-semibold text-slate-900">
                {{ $location }}
            </dd>
        </div>

        <div class="border-t border-slate-100 pt-4 sm:col-span-2">
            <dt
                class="text-xs font-medium uppercase tracking-wide text-slate-400"
            >
                Waktu Pengiriman
            </dt>

            <dd class="mt-1 text-sm text-slate-600">
                {{ $submittedAt }}
            </dd>
        </div>
    </dl>
</section>