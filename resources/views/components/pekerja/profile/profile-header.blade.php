@props([
    'name' => 'Budi Santoso',
    'workerId' => 'PKR-2026-001',
    'role' => 'Pekerja Lapangan',
    'specialization' => 'Teknisi Instalasi Listrik',
])

<section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
        {{-- Foto profil --}}
        <div class="relative shrink-0">
            <div class="flex h-24 w-24 items-center justify-center overflow-hidden rounded-2xl bg-blue-100 text-2xl font-bold text-blue-700 ring-4 ring-blue-50">
                BS
            </div>

            <button
                type="button"
                class="absolute -bottom-2 -right-2 inline-flex h-9 w-9 items-center justify-center rounded-full bg-blue-600 text-white shadow-md transition hover:bg-blue-700"
                aria-label="Ubah foto profil"
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
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"
                    />
                </svg>
            </button>
        </div>

        {{-- Informasi utama --}}
        <div class="min-w-0 flex-1">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                <div class="min-w-0">
                    <h1 class="truncate text-2xl font-bold text-slate-900 sm:text-3xl">
                        {{ $name }}
                    </h1>

                    <div class="mt-3 flex flex-wrap items-center gap-2">
                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                            {{ $role }}
                        </span>

                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
                            ID: {{ $workerId }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-4 border-t border-slate-100 pt-4">
                <p class="text-sm text-slate-500">
                    Bidang pekerjaan
                </p>

                <p class="mt-1 text-sm font-semibold text-slate-800">
                    {{ $specialization }}
                </p>
            </div>
        </div>
    </div>
</section>