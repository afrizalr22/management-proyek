@props([
    'documentation',
])

@php
    $displayDate = $documentation->documentation_date
        ?? $documentation->taken_at
        ?? $documentation->created_at;

    $formattedDate = $displayDate
        ? $displayDate
            ->locale('id')
            ->translatedFormat('d F Y')
        : 'Tanggal tidak tersedia';

    $formattedTime = $documentation->taken_at
        ? $documentation->taken_at
            ->locale('id')
            ->translatedFormat('H.i')
            . ' WIB'
        : null;

    $title = filled($documentation->title)
        ? $documentation->title
        : 'Dokumentasi Pekerjaan';

    $description = filled($documentation->description)
        ? $documentation->description
        : 'Tidak ada keterangan tambahan untuk dokumentasi ini.';

    $category = filled($documentation->category)
        ? str($documentation->category)
            ->replace('_', ' ')
            ->title()
        : 'Dokumentasi';

    $uploader = $documentation->user?->name
        ?? 'Pengguna tidak tersedia';

    $taskName = $documentation->task?->title
        ?? 'Tidak terkait Task';

    $taskCode = $documentation->task?->task_code;

    $reportNumber = $documentation->dailyReport?->report_number;

    $location = $documentation->task?->location;

    $fileSize = $documentation->file_size
        ? number_format(
            $documentation->file_size / 1024 / 1024,
            2,
            ',',
            '.'
        ) . ' MB'
        : null;
@endphp

<article
    class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-blue-200 hover:shadow-lg"
>
    <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">

        @if ($documentation->photo_exists)
            <img
                src="{{ $documentation->photo_url }}"
                alt="{{ $title }}"
                loading="lazy"
                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
            >

            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/5 to-transparent"></div>
        @else
            <div class="flex h-full w-full flex-col items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 px-6 text-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-gray-400 shadow-sm">
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

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 15l-5-5L5 21"
                        />
                    </svg>
                </div>

                <p class="mt-3 text-sm font-semibold text-gray-500">
                    File foto tidak tersedia
                </p>

                @if ($documentation->original_name)
                    <p class="mt-1 max-w-full truncate text-xs text-gray-400">
                        {{ $documentation->original_name }}
                    </p>
                @endif
            </div>
        @endif

        <span class="absolute left-3 top-3 max-w-[70%] truncate rounded-lg bg-blue-600 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wide text-white shadow-sm">
            {{ $category }}
        </span>

        @if ($documentation->photo_exists)
            <button
                type="button"
                title="Lihat dokumentasi"
                data-image="{{ $documentation->photo_url }}"
                data-title="{{ $title }}"
                data-category="{{ $category }}"
                data-description="{{ $description }}"
                data-date="{{ $formattedDate }}"
                data-time="{{ $formattedTime }}"
                data-uploader="{{ $uploader }}"
                data-task="{{ $taskName }}"
                data-task-code="{{ $taskCode }}"
                data-report="{{ $reportNumber }}"
                data-location="{{ $location }}"
                data-file-size="{{ $fileSize }}"
                x-on:click="
                    $dispatch('open-documentation-preview', {
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
                    })
                "
                class="absolute bottom-3 right-3 flex h-10 w-10 items-center justify-center rounded-xl bg-black/50 text-white opacity-100 backdrop-blur-sm transition hover:bg-black/70 sm:opacity-0 sm:group-hover:opacity-100"
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

                    <circle cx="12" cy="12" r="3" />
                </svg>
            </button>
        @endif
    </div>

    <div class="p-5">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-400">
            <span>
                {{ $formattedDate }}
            </span>

            @if ($formattedTime)
                <span class="h-1 w-1 rounded-full bg-gray-300"></span>

                <span>
                    {{ $formattedTime }}
                </span>
            @endif
        </div>

        <h2 class="mt-3 line-clamp-2 min-h-12 font-bold leading-6 text-gray-900">
            {{ $title }}
        </h2>

        <p class="mt-2 line-clamp-2 min-h-10 text-sm leading-5 text-gray-500">
            {{ $description }}
        </p>

        <div class="mt-4 rounded-xl bg-gray-50 p-3">
            <p class="text-[10px] font-bold uppercase tracking-wide text-gray-400">
                Task terkait
            </p>

            <p class="mt-1 truncate text-sm font-semibold text-gray-700">
                {{ $taskName }}
            </p>

            @if ($taskCode)
                <p class="mt-1 text-xs font-medium text-blue-600">
                    {{ $taskCode }}
                </p>
            @endif
        </div>

        <div class="mt-4 flex items-center justify-between gap-3 border-t border-gray-100 pt-4">
            <div class="flex min-w-0 items-center gap-2">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-50 text-xs font-bold text-blue-600">
                    {{ str($uploader)->substr(0, 1)->upper() }}
                </span>

                <div class="min-w-0">
                    <p class="truncate text-xs font-semibold text-gray-700">
                        {{ $uploader }}
                    </p>

                    <p class="text-[11px] text-gray-400">
                        Pengunggah
                    </p>
                </div>
            </div>

            @if ($reportNumber)
                <span class="shrink-0 rounded-lg bg-emerald-50 px-2.5 py-1.5 text-[10px] font-bold text-emerald-700">
                    {{ $reportNumber }}
                </span>
            @endif
        </div>
    </div>
</article>