<div class="space-y-6">

    {{-- Page Header --}}
    <x-mandor.daily-reports.create-header />

    {{-- General Information --}}
    <x-mandor.daily-reports.general-information />

    {{-- Work Activities and Documentation --}}
    <x-mandor.daily-reports.work-activities />

    {{-- Obstacles and Notes --}}
    <x-mandor.daily-reports.obstacles-notes />

    {{-- Bottom Actions --}}
    <div
        class="flex flex-col-reverse gap-3
               border-t border-gray-200 pt-6
               sm:flex-row sm:justify-end"
    >

        <a
            href="{{ route('mandor.daily-reports.index') }}"
            class="inline-flex h-11 items-center justify-center
                   rounded-lg border border-gray-300 bg-white
                   px-5 text-sm font-semibold text-gray-700
                   transition hover:bg-gray-50"
        >
            Batal
        </a>

        <button
            type="button"
            class="inline-flex h-11 items-center justify-center
                   rounded-lg bg-blue-600 px-6
                   text-sm font-semibold text-white
                   transition hover:bg-blue-700"
        >
            Simpan Laporan
        </button>

    </div>

</div>