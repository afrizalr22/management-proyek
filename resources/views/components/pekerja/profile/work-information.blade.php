@props([
    'projectName' => 'Pembangunan Gedung Perkantoran Sudirman',
    'projectLocation' => 'Jakarta Selatan',
    'supervisorName' => 'Agus Hermawan',
    'joinedDate' => '10 Januari 2026',
    'assignmentStatus' => 'Sedang Bertugas',
])

<section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
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
                        d="M3.75 21h16.5M4.5 3h15l-.75 18H5.25L4.5 3Zm3.75 4.5h7.5m-7.5 4.5h7.5"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Informasi Pekerjaan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi proyek dan penugasan Anda saat ini.
                </p>
            </div>
        </div>
    </div>

    {{-- Informasi --}}
    <div class="grid grid-cols-1 gap-5 px-5 py-6 sm:grid-cols-2 sm:px-6">
        <div class="sm:col-span-2">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                Proyek Aktif
            </p>

            <p class="mt-1 text-sm font-semibold text-slate-900">
                {{ $projectName }}
            </p>
        </div>

        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                Lokasi Proyek
            </p>

            <div class="mt-2 flex items-start gap-2 text-sm text-slate-700">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="mt-0.5 h-4 w-4 shrink-0 text-slate-400"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 21s7.5-4.35 7.5-11.25a7.5 7.5 0 1 0-15 0C4.5 16.65 12 21 12 21Z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M14.25 9.75a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"
                    />
                </svg>

                <span>{{ $projectLocation }}</span>
            </div>
        </div>

        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                Mandor Lapangan
            </p>

            <p class="mt-2 text-sm font-semibold text-slate-800">
                {{ $supervisorName }}
            </p>
        </div>

        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                Tanggal Bergabung
            </p>

            <p class="mt-2 text-sm text-slate-700">
                {{ $joinedDate }}
            </p>
        </div>

        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                Status Penugasan
            </p>

            <span class="mt-2 inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                {{ $assignmentStatus }}
            </span>
        </div>
    </div>
</section>