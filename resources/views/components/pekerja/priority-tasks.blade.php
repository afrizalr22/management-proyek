@php
    $tasks = [
        [
            'title' => 'Pemasangan Bekisting Kolom',
            'location' => 'Gedung Utama, Zona A',
            'time' => '08.00–10.00',
            'priority' => 'Prioritas Tinggi',
            'badge' => 'bg-red-50 text-red-600',
            'icon' => 'bg-red-50 text-red-600',
        ],
        [
            'title' => 'Pengecekan Material Besi',
            'location' => 'Gudang Material',
            'time' => '10.30–12.00',
            'priority' => 'Prioritas Sedang',
            'badge' => 'bg-amber-50 text-amber-600',
            'icon' => 'bg-amber-50 text-amber-600',
        ],
        [
            'title' => 'Pembersihan Area Kerja',
            'location' => 'Lantai 2, Zona B',
            'time' => '14.00–15.30',
            'priority' => 'Normal',
            'badge' => 'bg-slate-100 text-slate-600',
            'icon' => 'bg-blue-50 text-blue-600',
        ],
    ];
@endphp

<section
    class="h-full rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"
>
    {{-- Header --}}
    <div
        class="flex flex-col gap-3 border-b border-slate-200 pb-5 sm:flex-row sm:items-start sm:justify-between"
    >
        <div>
            <h2 class="text-lg font-bold text-slate-900">
                Tugas Prioritas
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Pekerjaan yang perlu diselesaikan hari ini.
            </p>
        </div>

        <a
            href="#"
            class="w-fit text-sm font-semibold text-blue-600 transition hover:text-blue-700"
        >
            Lihat Semua
        </a>
    </div>

    {{-- Daftar tugas --}}
    <div class="mt-5 space-y-4">
        @foreach ($tasks as $task)
            <article
                class="rounded-xl border border-slate-200 p-4 transition hover:border-blue-200 hover:bg-blue-50/30"
            >
                <div
                    class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div class="flex min-w-0 items-start gap-3">
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $task['icon'] }}"
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
                                    d="m4.5 12.75 6 6 9-13.5"
                                />
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <h3 class="font-semibold text-slate-900">
                                {{ $task['title'] }}
                            </h3>

                            <div
                                class="mt-2 flex flex-col gap-1 text-sm text-slate-500 sm:flex-row sm:flex-wrap sm:items-center sm:gap-3"
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
                                            d="M12 21a9 9 0 0 0 6.364-15.364A9 9 0 1 0 12 21Z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 8.25v3.75l2.25 1.5"
                                        />
                                    </svg>

                                    {{ $task['time'] }}
                                </span>

                                <span class="hidden sm:inline">
                                    •
                                </span>

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
                                            d="M12 21s6-4.35 6-10.5a6 6 0 1 0-12 0C6 16.65 12 21 12 21Z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 12.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z"
                                        />
                                    </svg>

                                    {{ $task['location'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <span
                        class="inline-flex w-fit shrink-0 rounded-full px-3 py-1 text-xs font-semibold {{ $task['badge'] }}"
                    >
                        {{ $task['priority'] }}
                    </span>
                </div>
            </article>
        @endforeach
    </div>
</section>