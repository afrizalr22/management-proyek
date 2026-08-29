<section
    class="w-full min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
        <div class="flex items-start gap-3">
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
                        d="M11.25 11.25 9 13.5l2.25 2.25m1.5-4.5L15 13.5l-2.25 2.25M8.25 6.75h7.5A2.25 2.25 0 0 1 18 9v9a2.25 2.25 0 0 1-2.25 2.25h-7.5A2.25 2.25 0 0 1 6 18V9a2.25 2.25 0 0 1 2.25-2.25ZM9 3.75h6"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Informasi Laporan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi utama dari laporan pekerjaan lapangan.
                </p>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="grid gap-5 px-5 py-6 sm:px-6 lg:grid-cols-2">
        {{-- Nama proyek --}}
        <div class="min-w-0">
            <label
                for="projectName"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Nama Proyek
            </label>

            <input
                id="projectName"
                type="text"
                wire:model="projectName"
                readonly
                class="block min-h-11 w-full rounded-xl border border-slate-300 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 outline-none"
            >

            <p class="mt-2 text-xs text-slate-500">
                Proyek tidak dapat diganti setelah laporan dibuat.
            </p>
        </div>

        {{-- Tanggal laporan --}}
        <div class="min-w-0">
            <label
                for="reportDate"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Tanggal Laporan
                <span class="text-red-500">*</span>
            </label>

            <input
                id="reportDate"
                type="date"
                wire:model="reportDate"
                class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            >

            @error('reportDate')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
</section>