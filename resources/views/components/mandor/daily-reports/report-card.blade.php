@props([
    'id',
    'project',
    'date',
    'uploader',
    'activities',
    'obstacles' => null,
    'notes' => null,
])

@php
    $hasObstacle = !empty($obstacles);
@endphp

<article
    class="overflow-hidden rounded-2xl
           border border-gray-200 bg-white shadow-sm
           transition hover:shadow-md"
>

    {{-- Report Header --}}
    <div
        class="flex flex-col gap-4 border-b border-gray-100
               px-5 py-4 sm:flex-row sm:items-center
               sm:justify-between"
    >

        <div class="flex items-center gap-3">

            {{-- Calendar Icon --}}
            <span
                class="flex h-11 w-11 shrink-0 items-center
                       justify-center rounded-xl bg-blue-50
                       text-blue-600"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <rect
                        x="3"
                        y="5"
                        width="18"
                        height="16"
                        rx="2"
                    />

                    <path d="M16 3v4M8 3v4M3 11h18" />
                </svg>
            </span>

            {{-- Report Identity --}}
            <div class="min-w-0">

                <h2 class="font-bold text-gray-900">
                    {{ $date }}
                </h2>

                <p class="mt-1 truncate text-sm text-gray-500">
                    {{ $project }}
                </p>

            </div>

        </div>

        <div class="flex items-center gap-3">

            {{-- Condition --}}
            @if ($hasObstacle)

                <span
                    class="inline-flex items-center gap-1.5
                           rounded-full bg-red-50 px-3 py-1.5
                           text-xs font-semibold text-red-700"
                >
                    <span class="h-2 w-2 rounded-full bg-red-500"></span>

                    Ada Kendala
                </span>

            @else

                <span
                    class="inline-flex items-center gap-1.5
                           rounded-full bg-emerald-50 px-3 py-1.5
                           text-xs font-semibold text-emerald-700"
                >
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                    Tanpa Kendala
                </span>

            @endif

        </div>

    </div>

    {{-- Report Content --}}
    <div class="grid grid-cols-1 gap-5 p-5 lg:grid-cols-12">

        {{-- Activities --}}
        <div class="lg:col-span-5">

            <div class="flex items-center gap-2">

                <span
                    class="flex h-8 w-8 items-center justify-center
                           rounded-lg bg-blue-50 text-blue-600"
                >
                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 11l3 3L22 4"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 12v7a2 2 0 01-2 2H5
                               a2 2 0 01-2-2V5a2 2 0
                               012-2h11"
                        />
                    </svg>
                </span>

                <h3
                    class="text-xs font-semibold uppercase
                           tracking-wide text-gray-500"
                >
                    Aktivitas
                </h3>

            </div>

            <p class="mt-3 text-sm leading-6 text-gray-700">
                {{ $activities }}
            </p>

        </div>

        {{-- Obstacles --}}
        <div class="lg:col-span-4">

            <div class="flex items-center gap-2">

                <span
                    @class([
                        'flex h-8 w-8 items-center justify-center rounded-lg',
                        'bg-red-50 text-red-600' => $hasObstacle,
                        'bg-gray-100 text-gray-400' => !$hasObstacle,
                    ])
                >
                    <svg
                        class="h-4 w-4"
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

                <h3
                    class="text-xs font-semibold uppercase
                           tracking-wide text-gray-500"
                >
                    Kendala
                </h3>

            </div>

            @if ($hasObstacle)

                <p class="mt-3 text-sm leading-6 text-red-600">
                    {{ $obstacles }}
                </p>

            @else

                <p class="mt-3 text-sm leading-6 text-gray-400">
                    Tidak terdapat kendala dalam pekerjaan.
                </p>

            @endif

        </div>

        {{-- Notes --}}
        <div class="lg:col-span-3">

            <div class="flex items-center gap-2">

                <span
                    class="flex h-8 w-8 items-center justify-center
                           rounded-lg bg-amber-50 text-amber-600"
                >
                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 4h16v16H4z"
                        />

                        <path d="M8 9h8M8 13h6" />
                    </svg>
                </span>

                <h3
                    class="text-xs font-semibold uppercase
                           tracking-wide text-gray-500"
                >
                    Catatan
                </h3>

            </div>

            <p
                class="mt-3 text-sm leading-6
                       {{ $notes ? 'text-gray-700' : 'text-gray-400' }}"
            >
                {{ $notes ?: 'Tidak ada catatan tambahan.' }}
            </p>

        </div>

    </div>

    {{-- Report Footer --}}
    <div
        class="flex flex-col gap-2 border-t border-gray-100
               bg-gray-50 px-5 py-3 sm:flex-row
               sm:items-center sm:justify-between"
    >

        <p class="text-xs text-gray-500">
            Dilaporkan oleh
            <span class="font-semibold text-gray-700">
                {{ $uploader }}
            </span>
        </p>

        <a
            href="{{ route('mandor.daily-reports.show', $id) }}"
            title="Lihat detail laporan"
            class="flex h-9 w-9 items-center justify-center
                rounded-lg border border-gray-200
                text-gray-500 transition
                hover:border-blue-200 hover:bg-blue-50
                hover:text-blue-600"
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
                    d="M2 12s3.5-7 10-7 10 7 10 7-3.5
                    7-10 7S2 12 2 12z"
                />

                <circle cx="12" cy="12" r="3" />
            </svg>
</a>

    </div>

</article>