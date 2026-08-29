@props([
    'reportId',
])

<div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">
    <a
        href="{{ route('mandor.daily-reports.show', $reportId) }}"
        wire:navigate
        class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
    >
        Batal
    </a>

    <button
        type="submit"
        wire:loading.attr="disabled"
        wire:target="updateReport"
        class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
    >
        <span wire:loading.remove wire:target="updateReport">
            Simpan Perubahan
        </span>

        <span wire:loading.inline-flex wire:target="updateReport" class="items-center gap-2">
            Menyimpan...
        </span>
    </button>
</div>