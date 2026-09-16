<div class="space-y-6">
    @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 5000)"
            x-show="show"
            x-transition
            class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3"
            role="alert"
        >
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-start gap-3">
                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
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

                    <div>
                        <p class="text-sm font-semibold text-emerald-900">
                            Berhasil
                        </p>

                        <p class="mt-1 text-sm text-emerald-700">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>

                <button
                    type="button"
                    x-on:click="show = false"
                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-emerald-600 transition hover:bg-emerald-100"
                    aria-label="Tutup notifikasi"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-4 w-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18 18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <x-pekerja.report.page-header />

    <x-pekerja.report.report-statistics
        :statistics="$statistics"
    />

    <x-pekerja.report.report-toolbar
        :search="$search"
        :status="$status"
        :period="$period"
        :sort="$sort"
    />

    <x-pekerja.report.report-list
        :reports="$reports"
    />
</div>