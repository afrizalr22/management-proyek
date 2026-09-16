@props([
    'assignment' => null,
])

@php
    $project = $assignment?->project;
    $supervisor = $project?->mandor;

    $assignmentStatus = match ($assignment?->status) {
        'active' => 'Sedang Bertugas',
        'inactive' => 'Tidak Aktif',
        'completed' => 'Selesai',
        default => 'Belum Ditugaskan',
    };

    $assignmentStatusClasses = match ($assignment?->status) {
        'active' => 'bg-emerald-100 text-emerald-700',
        'completed' => 'bg-blue-100 text-blue-700',
        'inactive' => 'bg-slate-100 text-slate-600',
        default => 'bg-amber-100 text-amber-700',
    };

    $projectStatus = match ($project?->status) {
        'draft' => 'Draf',
        'planning' => 'Perencanaan',
        'on_progress' => 'Sedang Berjalan',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
        default => '-',
    };
@endphp

<section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
        <div class="flex items-center gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
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
                        d="M3.75 21h16.5M4.5 3h15l-.75 18H5.25L4.5 3Zm3.75 4.5h7.5m-7.5 4.5h7.5"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Informasi Penugasan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi proyek dan penugasan aktif Anda saat ini.
                </p>
            </div>
        </div>
    </div>

    @if ($assignment && $project)
        <div class="grid grid-cols-1 gap-5 px-5 py-6 sm:grid-cols-2 sm:px-6">
            {{-- Nama proyek --}}
            <div class="sm:col-span-2">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Proyek Aktif
                </p>

                <p class="mt-1 text-base font-semibold text-slate-900">
                    {{ $project->project_name }}
                </p>

                <div class="mt-2 flex flex-wrap items-center gap-2">
                    <span
                        class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700"
                    >
                        {{ $project->project_code }}
                    </span>

                    <span
                        class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600"
                    >
                        {{ $projectStatus }}
                    </span>
                </div>
            </div>

            {{-- Lokasi proyek --}}
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

                    <span>
                        {{ $project->location ?: 'Lokasi belum tersedia' }}
                    </span>
                </div>
            </div>

            {{-- Mandor --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Mandor Lapangan
                </p>

                <p class="mt-2 text-sm font-semibold text-slate-800">
                    {{ $supervisor?->name ?? 'Mandor belum ditentukan' }}
                </p>
            </div>

            {{-- Tanggal bergabung --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Tanggal Bergabung
                </p>

                <p class="mt-2 text-sm text-slate-700">
                    {{ $assignment->joined_at
                        ? $assignment->joined_at
                            ->timezone('Asia/Jakarta')
                            ->translatedFormat('d F Y')
                        : 'Tanggal belum tersedia' }}
                </p>
            </div>

            {{-- Status penugasan --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Status Penugasan
                </p>

                <span
                    class="mt-2 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $assignmentStatusClasses }}"
                >
                    {{ $assignmentStatus }}
                </span>
            </div>
        </div>
    @else
        <div class="px-5 py-8 sm:px-6">
            <div
                class="flex flex-col items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-center"
            >
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-200 text-slate-500"
                >
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

                <h3 class="mt-4 text-sm font-semibold text-slate-900">
                    Belum Ada Proyek Aktif
                </h3>

                <p class="mt-1 max-w-md text-sm leading-6 text-slate-500">
                    Anda belum memiliki penugasan pada proyek yang sedang
                    direncanakan atau berjalan.
                </p>
            </div>
        </div>
    @endif
</section>