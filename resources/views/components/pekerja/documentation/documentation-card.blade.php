@props([
    'documentation',
])

@php
    $category = match ($documentation->category) {
        'progress' => [
            'label' => 'Progres',
            'class' => 'bg-blue-600 text-white',
        ],

        'material' => [
            'label' => 'Material',
            'class' => 'bg-amber-500 text-white',
        ],

        'safety' => [
            'label' => 'Keselamatan',
            'class' => 'bg-emerald-600 text-white',
        ],

        'obstacle' => [
            'label' => 'Kendala',
            'class' => 'bg-red-600 text-white',
        ],

        default => [
            'label' => 'Lainnya',
            'class' => 'bg-slate-600 text-white',
        ],
    };

    $photoExists = filled($documentation->photo)
        && \Illuminate\Support\Facades\Storage::disk(
            'public'
        )->exists($documentation->photo);

    $photoUrl = $photoExists
        ? asset(
            'storage/'
            . ltrim($documentation->photo, '/')
        )
        : null;

    $title = $documentation->title
        ?? $documentation->task?->title
        ?? 'Dokumentasi Pekerjaan';

    $taskLabel = $documentation->task
        ? trim(
            $documentation->task->task_code
            . ' — '
            . $documentation->task->title
        )
        : 'Tidak terhubung dengan Task';

    $projectLabel =
        $documentation->project?->project_name
        ?? 'Proyek tidak tersedia';

    $location = $documentation->task?->location
        ?: (
            $documentation->project?->location
            ?: 'Lokasi belum tersedia'
        );

    $date = $documentation->documentation_date
        ?->locale('id')
        ->translatedFormat('d F Y')
        ?? '-';

    $time = $documentation->taken_at
        ?->timezone('Asia/Jakarta')
        ->locale('id')
        ->translatedFormat('H.i')
        ?? null;
@endphp

<article
    {{ $attributes->class([
        'group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200',
        'hover:-translate-y-1 hover:border-blue-200 hover:shadow-lg',
    ]) }}
>
    <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
        @if ($photoUrl)
            <a
                href="{{ $photoUrl }}"
                target="_blank"
                rel="noopener noreferrer"
                class="block h-full w-full"
                title="Buka foto dokumentasi"
            >
                <img
                    src="{{ $photoUrl }}"
                    alt="Dokumentasi {{ $title }}"
                    loading="lazy"
                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                >
            </a>
        @else
            <div
                class="flex h-full w-full flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 px-4 text-center text-slate-400"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-12 w-12"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 19.5h16.5A1.5 1.5 0 0 0 21.75 18V6A1.5 1.5 0 0 0 20.25 4.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"
                    />
                </svg>

                <p class="mt-2 text-sm font-medium">
                    File foto tidak tersedia
                </p>
            </div>
        @endif

        <span
            class="absolute left-3 top-3 inline-flex rounded-full px-3 py-1.5 text-xs font-semibold shadow-sm {{ $category['class'] }}"
        >
            {{ $category['label'] }}
        </span>

        @if ($photoUrl)
            <span
                class="absolute bottom-3 right-3 inline-flex items-center gap-1.5 rounded-lg bg-slate-900/75 px-2.5 py-1.5 text-xs font-semibold text-white backdrop-blur-sm"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-4 w-4"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                    />
                </svg>

                Buka foto
            </span>
        @endif
    </div>

    <div class="p-5">
        <div
            class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-slate-500"
        >
            <span class="inline-flex items-center gap-1.5">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-4 w-4"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6.75 3v2.25M17.25 3v2.25M3.75 9.75h16.5M5.25 5.25h13.5A1.5 1.5 0 0 1 20.25 6.75v12a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-12a1.5 1.5 0 0 1 1.5-1.5Z"
                    />
                </svg>

                {{ $date }}
            </span>

            @if ($time)
                <span>
                    {{ $time }} WIB
                </span>
            @endif
        </div>

        <h2 class="mt-4 text-lg font-bold leading-6 text-slate-900">
            {{ $title }}
        </h2>

        <p class="mt-2 line-clamp-3 text-sm leading-6 text-slate-500">
            {{ filled($documentation->description)
                ? $documentation->description
                : 'Tidak ada keterangan tambahan.' }}
        </p>

        <div class="mt-4 space-y-3 rounded-xl bg-slate-50 p-3">
            <div>
                <p
                    class="text-xs font-medium uppercase tracking-wide text-slate-400"
                >
                    Task terkait
                </p>

                <p class="mt-1 text-sm font-semibold text-slate-700">
                    {{ $taskLabel }}
                </p>
            </div>

            <div class="border-t border-slate-200 pt-3">
                <p class="text-xs text-slate-500">
                    {{ $projectLabel }}
                </p>

                <p class="mt-1 inline-flex items-start gap-1.5 text-xs text-slate-500">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="mt-0.5 h-3.5 w-3.5 shrink-0"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 21s6-4.35 6-10.5a6 6 0 1 0-12 0C6 16.65 12 21 12 21Z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 12.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z"
                        />
                    </svg>

                    {{ $location }}
                </p>
            </div>
        </div>

        @if (filled($documentation->original_name))
            <p
                class="mt-4 truncate text-xs text-slate-400"
                title="{{ $documentation->original_name }}"
            >
                File: {{ $documentation->original_name }}
            </p>
        @endif
    </div>
</article>