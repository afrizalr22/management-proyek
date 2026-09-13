<div class="w-full min-w-0 space-y-6">

    @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            x-transition
            class="flex items-start justify-between gap-4 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700"
            role="alert"
        >
            <p class="font-medium">
                {{ session('success') }}
            </p>

            <button
                type="button"
                x-on:click="show = false"
                class="rounded-lg p-1 transition hover:bg-emerald-100"
                aria-label="Tutup notifikasi"
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
                        d="M6 6l12 12M18 6L6 18"
                    />
                </svg>
            </button>
        </div>
    @endif

    <x-mandor.daily-reports.detail-header
        :report="$report"
    />

    <x-mandor.daily-reports.report-overview
        :report="$report"
    />

    <x-mandor.daily-reports.report-activities
        :report="$report"
    />

    <x-mandor.daily-reports.report-documentations
        :report="$report"
        :documentations="$report->documentations"
    />

    <x-mandor.daily-reports.report-obstacles-notes
        :report="$report"
    />

    <x-mandor.documentations.documentation-preview />

</div>