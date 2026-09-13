@props([
    'report',
    'documentations',
])

<x-ui.info-card class="overflow-hidden">
    <div class="flex items-center justify-between gap-4 border-b border-gray-200 px-6 py-5">
        <div>
            <h2 class="text-lg font-bold text-gray-900">
                Dokumentasi Pekerjaan
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Foto yang dikirim bersama laporan harian.
            </p>
        </div>

        <span class="shrink-0 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
            {{ $documentations->count() }} Foto
        </span>
    </div>

    @if ($documentations->isEmpty())
        <div class="px-6 py-12 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                <svg
                    class="h-7 w-7"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                >
                    <rect
                        x="3"
                        y="3"
                        width="18"
                        height="18"
                        rx="2"
                    />

                    <circle cx="8.5" cy="8.5" r="1.5" />

                    <path d="M21 15l-5-5L5 21" />
                </svg>
            </div>

            <p class="mt-3 text-sm text-gray-500">
                Tidak ada dokumentasi pada laporan ini.
            </p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($documentations as $documentation)
                @php
                    $title = $documentation->title
                        ?: 'Dokumentasi Pekerjaan';

                    $description = $documentation->description
                        ?: 'Tidak ada keterangan tambahan.';

                    $documentationDate =
                        $documentation->documentation_date
                        ?? $documentation->taken_at
                        ?? $documentation->created_at;

                    $formattedDate = $documentationDate
                        ? $documentationDate
                            ->locale('id')
                            ->translatedFormat('d F Y')
                        : 'Tanggal tidak tersedia';

                    $formattedTime = $documentationDate
                        ? $documentationDate->format('H.i').' WIB'
                        : '';

                    $categoryLabel = match ($documentation->category) {
                        'progress' => 'Progres',
                        'material' => 'Material',
                        'safety' => 'Keselamatan',
                        'quality' => 'Kualitas',
                        'obstacle' => 'Kendala',
                        default => ucfirst(
                            str_replace(
                                '_',
                                ' ',
                                $documentation->category
                                    ?: 'Dokumentasi'
                            )
                        ),
                    };

                    $fileSize = match (true) {
                        empty($documentation->file_size) =>
                            '',

                        $documentation->file_size >= 1048576 =>
                            number_format(
                                $documentation->file_size / 1048576,
                                2,
                                ',',
                                '.'
                            ).' MB',

                        $documentation->file_size >= 1024 =>
                            number_format(
                                $documentation->file_size / 1024,
                                2,
                                ',',
                                '.'
                            ).' KB',

                        default =>
                            $documentation->file_size.' Byte',
                    };
                @endphp

                <article
                    wire:key="report-documentation-{{ $documentation->id }}"
                    class="group overflow-hidden rounded-xl border border-gray-200 bg-white transition duration-200 hover:border-blue-200 hover:shadow-md"
                >
                    <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                        @if ($documentation->photo_exists)
                            <button
                                type="button"
                                title="Lihat dokumentasi"
                                data-image="{{ $documentation->photo_url }}"
                                data-title="{{ $title }}"
                                data-category="{{ $categoryLabel }}"
                                data-description="{{ $description }}"
                                data-date="{{ $formattedDate }}"
                                data-time="{{ $formattedTime }}"
                                data-uploader="{{ $documentation->user?->name ?? 'Pekerja' }}"
                                data-task="{{ $report->task?->title ?? 'Task tidak tersedia' }}"
                                data-task-code="{{ $report->task?->task_code ?? '' }}"
                                data-report="{{ $report->report_number ?? '' }}"
                                data-location="{{ $report->task?->location ?? $report->project?->location ?? '' }}"
                                data-file-size="{{ $fileSize }}"
                                x-on:click="
                                    $dispatch(
                                        'open-documentation-preview',
                                        {
                                            image: $el.dataset.image,
                                            title: $el.dataset.title,
                                            category: $el.dataset.category,
                                            description: $el.dataset.description,
                                            date: $el.dataset.date,
                                            time: $el.dataset.time,
                                            uploader: $el.dataset.uploader,
                                            task: $el.dataset.task,
                                            taskCode: $el.dataset.taskCode,
                                            report: $el.dataset.report,
                                            location: $el.dataset.location,
                                            fileSize: $el.dataset.fileSize
                                        }
                                    )
                                "
                                class="relative block h-full w-full cursor-zoom-in focus:outline-none focus:ring-4 focus:ring-inset focus:ring-blue-200"
                            >
                                <img
                                    src="{{ $documentation->photo_url }}"
                                    alt="{{ $title }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                >

                                <span
                                    class="absolute inset-0 bg-black/0 transition group-hover:bg-black/20"
                                ></span>

                                <span
                                    class="absolute bottom-3 right-3 flex h-10 w-10 items-center justify-center rounded-xl bg-black/60 text-white opacity-100 shadow-lg backdrop-blur-sm transition sm:opacity-0 sm:group-hover:opacity-100"
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
                                            d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="3"
                                        />
                                    </svg>
                                </span>
                            </button>
                        @else
                            <div class="flex h-full flex-col items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 px-5 text-center">
                                <svg
                                    class="h-9 w-9 text-gray-400"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                >
                                    <rect
                                        x="3"
                                        y="3"
                                        width="18"
                                        height="18"
                                        rx="2"
                                    />

                                    <circle
                                        cx="8.5"
                                        cy="8.5"
                                        r="1.5"
                                    />

                                    <path d="M21 15l-5-5L5 21" />
                                </svg>

                                <p class="mt-2 text-xs font-semibold text-gray-500">
                                    File foto tidak tersedia
                                </p>
                            </div>
                        @endif

                        <span class="pointer-events-none absolute left-3 top-3 rounded-lg bg-blue-600 px-2.5 py-1.5 text-[10px] font-bold uppercase tracking-wide text-white shadow-sm">
                            {{ $categoryLabel }}
                        </span>
                    </div>

                    <div class="p-4">
                        <h3 class="line-clamp-2 font-semibold leading-6 text-gray-900">
                            {{ $title }}
                        </h3>

                        <p class="mt-2 line-clamp-2 text-sm leading-5 text-gray-500">
                            {{ $description }}
                        </p>

                        <div class="mt-3 border-t border-gray-100 pt-3">
                            <p class="text-xs text-gray-400">
                                {{ $formattedDate }}

                                @if ($formattedTime !== '')
                                    · {{ $formattedTime }}
                                @endif
                            </p>

                            <p class="mt-1 truncate text-xs font-medium text-gray-600">
                                Oleh {{ $documentation->user?->name ?? 'Pekerja' }}
                            </p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</x-ui.info-card>