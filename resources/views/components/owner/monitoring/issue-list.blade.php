@props([
    'project',
])

@php
    $issues = $project->dailyReports
        ->filter(
            fn ($report): bool =>
                filled($report->obstacles)
        )
        ->take(5);

    $priorityConfiguration = [
        'urgent' => [
            'label' => 'Darurat',
            'badge' => 'red',
            'container' =>
                'border-red-200 bg-red-50',
            'title' =>
                'text-red-700',
        ],

        'high' => [
            'label' => 'Tinggi',
            'badge' => 'red',
            'container' =>
                'border-red-200 bg-red-50',
            'title' =>
                'text-red-700',
        ],

        'medium' => [
            'label' => 'Sedang',
            'badge' => 'yellow',
            'container' =>
                'border-yellow-200 bg-yellow-50',
            'title' =>
                'text-yellow-700',
        ],

        'low' => [
            'label' => 'Rendah',
            'badge' => 'blue',
            'container' =>
                'border-blue-200 bg-blue-50',
            'title' =>
                'text-blue-700',
        ],
    ];
@endphp

<x-ui.info-card>
    <div class="p-6 sm:p-8">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h2 class="text-2xl font-bold text-gray-800">
                    Kendala Project
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Kendala yang tercatat dalam laporan harian.
                </p>
            </div>

            <x-ui.badge
                :color="$issues->isNotEmpty()
                    ? 'red'
                    : 'green'"
            >
                {{ $issues->count() }} Kendala
            </x-ui.badge>
        </div>

        @if ($issues->isNotEmpty())
            <div class="mt-8 space-y-4">
                @foreach ($issues as $report)
                    @php
                        $priority =
                            $report->task?->priority
                            ?? 'medium';

                        $configuration =
                            $priorityConfiguration[$priority]
                            ?? $priorityConfiguration['medium'];

                        $issueTitle =
                            $report->task?->title
                            ?? $report->report_number
                            ?? 'Laporan Harian';
                    @endphp

                    <article
                        wire:key="monitoring-issue-{{ $report->id }}"
                        class="rounded-2xl border p-5 transition hover:shadow-sm {{ $configuration['container'] }}"
                    >
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <h3 class="font-semibold {{ $configuration['title'] }}">
                                    {{ $issueTitle }}
                                </h3>

                                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-700">
                                    {{ $report->obstacles }}
                                </p>
                            </div>

                            <x-ui.badge
                                :color="$configuration['badge']"
                            >
                                {{ $configuration['label'] }}
                            </x-ui.badge>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500">
                            <span>
                                {{ $report->report_date
                                    ?->translatedFormat('d F Y') ?? '-' }}
                            </span>

                            <span>
                                Oleh
                                {{ $report->user?->name
                                    ?? 'Pengguna tidak tersedia' }}
                            </span>

                            @if ($report->report_number)
                                <span>
                                    {{ $report->report_number }}
                                </span>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="mt-8 rounded-2xl border border-dashed border-green-200 bg-green-50 px-6 py-10 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-6 w-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m4.5 12.75 6 6 9-13.5"
                        />
                    </svg>
                </div>

                <p class="mt-4 font-semibold text-green-700">
                    Tidak ada kendala
                </p>

                <p class="mt-1 text-sm text-green-600">
                    Belum ada kendala yang tercatat pada laporan harian.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>