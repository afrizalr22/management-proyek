<section
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
        <div class="flex items-start gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"
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
                        d="m4.5 12.75 6 6 9-13.5"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Hasil Pekerjaan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Jelaskan hasil dan perkembangan tugas yang telah dikerjakan.
                </p>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="grid grid-cols-1 gap-5 px-5 py-5 sm:px-6 lg:grid-cols-3">
        {{-- Hasil pekerjaan --}}
        <div class="min-w-0 lg:col-span-2">
            <label
                for="workResult"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Uraian Hasil Pekerjaan
                <span class="text-red-500">*</span>
            </label>

            <textarea
                id="workResult"
                name="workResult"
                rows="4"
                maxlength="2000"
                placeholder="Jelaskan pekerjaan yang telah dilakukan dan hasil yang dicapai..."
                class="block w-full resize-none rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            ></textarea>

            <div class="mt-2 flex flex-col gap-1 sm:flex-row sm:justify-between">
                <p class="text-xs text-slate-500">
                    Tuliskan hasil pekerjaan secara ringkas dan jelas.
                </p>

                <p class="shrink-0 text-xs text-slate-400">
                    Maksimal 2.000 karakter
                </p>
            </div>
        </div>

        {{-- Status dan progres --}}
        <div class="space-y-5">
            <div>
                <label
                    for="workStatus"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Status Pekerjaan
                    <span class="text-red-500">*</span>
                </label>

                <select
                    id="workStatus"
                    name="workStatus"
                    class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                >
                    <option value="">
                        Pilih status
                    </option>

                    <option value="in_progress">
                        Sedang Dikerjakan
                    </option>

                    <option value="completed">
                        Selesai
                    </option>

                    <option value="delayed">
                        Tertunda
                    </option>
                </select>
            </div>

            <div>
                <label
                    for="workProgress"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Persentase Progres
                    <span class="text-red-500">*</span>
                </label>

                <div class="relative">
                    <input
                        id="workProgress"
                        name="workProgress"
                        type="number"
                        min="0"
                        max="100"
                        value="75"
                        class="block min-h-11 w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 pr-12 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >

                    <span
                        class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-sm font-semibold text-slate-400"
                    >
                        %
                    </span>
                </div>

                <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-100">
                    <div
                        class="h-full rounded-full bg-blue-600"
                        style="width: 75%;"
                    ></div>
                </div>

                <p class="mt-2 text-xs text-slate-500">
                    Nilai progres antara 0 sampai 100%.
                </p>
            </div>
        </div>
    </div>
</section>