@props([
    'activities',
])

<section class="h-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
        <h2 class="text-lg font-bold text-slate-900">
            Aktivitas Terbaru
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Riwayat task, laporan, dan dokumentasi Anda.
        </p>
    </div>

    @if ($activities->isEmpty())
        <div class="px-6 py-14 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.7"
                    stroke="currentColor"
                    class="h-7 w-7"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 6v6l4 2"
                    />

                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                    />
                </svg>
            </div>

            <h3 class="mt-4 font-semibold text-slate-900">
                Belum Ada Aktivitas
            </h3>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Aktivitas pekerjaan terbaru akan tampil di sini.
            </p>
        </div>
    @else
        <div class="px-5 py-5 sm:px-6">
            @foreach ($activities as $activity)
                @php
                    $activityUrl = match (
                        $activity['type']
                    ) {
                        'task' =>
                            route('pekerja.task.index'),

                        'report' =>
                            route('pekerja.report.index'),

                        'documentation' =>
                            route(
                                'pekerja.documentation.index'
                            ),

                        default =>
                            null,
                    };

                    $timeLabel =
                        $activity['occurred_at']
                            ?->locale('id')
                            ->diffForHumans()
                        ?? 'Waktu tidak tersedia';
                @endphp

                <div
                    wire:key="worker-activity-{{ $loop->index }}-{{ $activity['occurred_at']?->getTimestamp() ?? 0 }}"
                    class="flex gap-3"
                >
                    <div class="flex w-4 shrink-0 flex-col items-center">
                        <span class="mt-1 h-3 w-3 shrink-0 rounded-full {{ $activity['color'] }} ring-4 ring-white"></span>

                        @unless ($loop->last)
                            <span class="w-px flex-1 bg-slate-200"></span>
                        @endunless
                    </div>

                    <div class="min-w-0 flex-1 pb-6">
                        @if ($activityUrl)
                            <a
                                href="{{ $activityUrl }}"
                                wire:navigate
                                class="text-sm font-semibold text-slate-900 transition hover:text-blue-600"
                            >
                                {{ $activity['title'] }}
                            </a>
                        @else
                            <h3 class="text-sm font-semibold text-slate-900">
                                {{ $activity['title'] }}
                            </h3>
                        @endif

                        <p class="mt-1 text-sm leading-5 text-slate-500">
                            {{ $activity['description'] }}
                        </p>

                        <p class="mt-2 text-xs text-slate-400">
                            {{ $timeLabel }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>