@props([
    'reportId',
])

<div class="mb-6">
    <nav class="mb-5 flex flex-wrap items-center gap-2 text-sm text-slate-500">
        <a
            href="{{ route('mandor.daily-reports.index') }}"
            wire:navigate
            class="transition hover:text-blue-600"
        >
            Laporan Harian
        </a>

        <span>/</span>

        <a
            href="{{ route('mandor.daily-reports.show', $reportId) }}"
            wire:navigate
            class="transition hover:text-blue-600"
        >
            Detail Laporan
        </a>

        <span>/</span>

        <span class="font-medium text-slate-900">
            Edit
        </span>
    </nav>

    <header>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
            Edit Laporan Harian
        </h1>

        <p class="mt-2 text-sm text-slate-500 sm:text-base">
            Perbarui informasi laporan pekerjaan lapangan yang telah dibuat.
        </p>
    </header>
</div>