@props([
    'workerStatus' => 'Aktif',
    'activeProjects' => 1,
])

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    {{-- Status pekerja --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-6 w-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75m5.25-4.5v6c0 5.25-3.438 9.75-8.25 11.25C7.188 21 3.75 16.5 3.75 11.25v-6L12 2.25l8.25 3Z"
                    />
                </svg>
            </div>

            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Status Pekerja
                </p>

                <div class="mt-1 flex items-center gap-2">
                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>

                    <p class="text-lg font-bold text-emerald-600">
                        {{ $workerStatus }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Proyek aktif --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-6 w-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 21h16.5M4.5 3h15l-.75 18H5.25L4.5 3Zm3.75 4.5h7.5m-7.5 4.5h7.5"
                    />
                </svg>
            </div>

            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Proyek Aktif
                </p>

                <p class="mt-1 text-lg font-bold text-blue-600">
                    {{ $activeProjects }} Proyek
                </p>
            </div>
        </div>
    </section>
</div>