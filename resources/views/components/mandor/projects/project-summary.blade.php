@props([
    'statistics' => [],
])

@php
    $total = (int) (
        $statistics['total']
        ?? 0
    );

    $active = (int) (
        $statistics['active']
        ?? 0
    );

    $completed = (int) (
        $statistics['completed']
        ?? 0
    );

    $averageProgress = min(
        100,
        max(
            0,
            (int) (
                $statistics['average_progress']
                ?? 0
            )
        )
    );
@endphp

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    {{-- Total Project --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-gray-500">
                    Total Project
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $total }}
                </p>
            </div>

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-600">
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
                        d="M3 20.25h18M5.25 20.25V8.25L12 3l6.75 5.25v12M9 20.25v-6h6v6"
                    />
                </svg>
            </div>
        </div>

        <p class="mt-3 text-xs text-gray-400">
            Seluruh Project yang ditugaskan
        </p>
    </div>

    {{-- Project Aktif --}}
    <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-blue-700">
                    Project Aktif
                </p>

                <p class="mt-2 text-3xl font-bold text-blue-800">
                    {{ $active }}
                </p>
            </div>

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
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
                        d="M5.25 5.25v13.5m6-9v9m6-13.5v13.5M3 21h18"
                    />
                </svg>
            </div>
        </div>

        <p class="mt-3 text-xs text-blue-600">
            Sedang dalam tanggung jawab
        </p>
    </div>

    {{-- Project Selesai --}}
    <div class="rounded-2xl border border-green-200 bg-green-50 p-5">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-green-700">
                    Project Selesai
                </p>

                <p class="mt-2 text-3xl font-bold text-green-800">
                    {{ $completed }}
                </p>
            </div>

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-600">
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
        </div>

        <p class="mt-3 text-xs text-green-600">
            Telah mencapai tahap selesai
        </p>
    </div>

    {{-- Rata-rata Progress --}}
    <div class="rounded-2xl border border-purple-200 bg-purple-50 p-5">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-purple-700">
                    Rata-rata Progres
                </p>

                <p class="mt-2 text-3xl font-bold text-purple-800">
                    {{ $averageProgress }}%
                </p>
            </div>

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-purple-100 text-purple-600">
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
                        d="M3 20.25h18M6.75 17.25v-4.5M12 17.25V9M17.25 17.25V5.25"
                    />
                </svg>
            </div>
        </div>

        <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-purple-100">
            <div
                x-data="{
                    progress: @js($averageProgress)
                }"
                x-bind:style="{
                    width: progress + '%'
                }"
                class="h-full rounded-full bg-purple-600 transition-all duration-500"
            ></div>
        </div>
    </div>
</div>