@props([
    'timelineStart',
    'timelineEnd',
    'totalDays',
])

@php
    $columns = 12;

    $timelineLabels = collect(
        range(0, $columns - 1)
    )->map(function (int $index) use (
        $timelineStart,
        $totalDays,
        $columns
    ): array {
        $offset = (int) floor(
            ($index * $totalDays) / $columns
        );

        $date = $timelineStart
            ->copy()
            ->addDays($offset);

        return [
            'date' => $date->translatedFormat('d M'),
            'month' => $date->translatedFormat('M Y'),
        ];
    });
@endphp

<div class="border-b border-gray-200 bg-gray-50">
    <div class="grid grid-cols-[300px_1fr]">
        <div class="flex items-center px-5 py-4">
            <div>
                <p class="text-sm font-semibold text-gray-700">
                    Daftar Task
                </p>

                <p class="mt-1 text-xs text-gray-400">
                    {{ $timelineStart->translatedFormat('d M Y') }}
                    –
                    {{ $timelineEnd->translatedFormat('d M Y') }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-12">
            @foreach ($timelineLabels as $label)
                <div class="border-l border-gray-200 px-1 py-3 text-center">
                    <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-500">
                        {{ $label['month'] }}
                    </p>

                    <p class="mt-1 text-xs font-medium text-gray-700">
                        {{ $label['date'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</div>