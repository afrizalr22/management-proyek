@props([
    'activities' => '',
    'workStatus' => 'in_progress',
    'reportedProgress' => 0,
    'currentTaskProgress' => 0,
])

@php
    $progressValue = max(
        0,
        min(
            100,
            (int) $reportedProgress
        )
    );
@endphp

<section
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
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
                    Jelaskan hasil dan perkembangan Task yang telah dikerjakan.
                </p>
            </div>
        </div>
    </div>

    <div
        class="grid grid-cols-1 gap-5 px-5 py-5 sm:px-6 lg:grid-cols-3"
    >
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
                wire:model.live.debounce.300ms="activities"
                rows="5"
                maxlength="2000"
                placeholder="Jelaskan pekerjaan yang telah dilakukan dan hasil yang dicapai..."
                @class([
                    'block w-full resize-none rounded-xl bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100',
                    'border-red-300' => $errors->has('activities'),
                    'border-slate-300' => ! $errors->has('activities'),
                ])
            ></textarea>

            <div class="mt-2 flex items-start justify-between gap-4">
                <div>
                    @error('activities')
                        <p class="text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @else
                        <p class="text-xs text-slate-500">
                            Tuliskan hasil pekerjaan secara ringkas dan jelas.
                        </p>
                    @enderror
                </div>

                <p class="shrink-0 text-xs text-slate-400">
                    {{ mb_strlen($activities) }}/2.000
                </p>
            </div>
        </div>

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
                    wire:model.live="workStatus"
                    @class([
                        'block min-h-11 w-full rounded-xl bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100',
                        'border-red-300' => $errors->has('workStatus'),
                        'border-slate-300' => ! $errors->has('workStatus'),
                    ])
                >
                    <option value="in_progress">
                        Sedang Dikerjakan
                    </option>

                    <option value="completed">
                        Selesai
                    </option>
                </select>

                @error('workStatus')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
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
                        wire:model.live.debounce.300ms="reportedProgress"
                        type="number"
                        min="{{ $currentTaskProgress }}"
                        max="100"
                        @class([
                            'block min-h-11 w-full rounded-xl bg-white px-4 py-2.5 pr-12 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100',
                            'border-red-300' => $errors->has('reportedProgress'),
                            'border-slate-300' => ! $errors->has('reportedProgress'),
                        ])
                    >

                    <span
                        class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-sm font-semibold text-slate-400"
                    >
                        %
                    </span>
                </div>

                <div
                    class="mt-3 h-2 overflow-hidden rounded-full bg-slate-100"
                >
                    <div
                        x-data
                        data-progress="{{ $progressValue }}"
                        x-bind:style="'width: ' + $el.dataset.progress + '%'"
                        class="h-full rounded-full bg-blue-600 transition-all duration-300"
                    ></div>
                </div>

                @error('reportedProgress')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @else
                    <p class="mt-2 text-xs leading-5 text-slate-500">
                        Progres Task saat ini {{ $currentTaskProgress }}%. Nilai laporan tidak boleh lebih rendah.
                    </p>
                @enderror
            </div>
        </div>
    </div>
</section>