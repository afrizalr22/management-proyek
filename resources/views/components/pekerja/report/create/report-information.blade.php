@props([
    'availableTasks',
    'reportDate' => '',
    'projectName' => '',
    'taskLocation' => '',
])

<section
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
        <div class="flex items-start gap-3">
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
                        d="M9 5.25H6.75A2.25 2.25 0 0 0 4.5 7.5v11.25A2.25 2.25 0 0 0 6.75 21h10.5a2.25 2.25 0 0 0 2.25-2.25V7.5a2.25 2.25 0 0 0-2.25-2.25H15M9 5.25A2.25 2.25 0 0 1 11.25 3h1.5A2.25 2.25 0 0 1 15 5.25"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Informasi Laporan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Pilih Task dan tanggal pekerjaan yang akan dilaporkan.
                </p>
            </div>
        </div>
    </div>

    <div
        class="grid grid-cols-1 gap-5 px-5 py-5 sm:px-6 lg:grid-cols-2"
    >
        <div class="min-w-0">
            <label
                for="reportTask"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Task
                <span class="text-red-500">*</span>
            </label>

            <select
                id="reportTask"
                wire:model.live="taskId"
                @disabled($availableTasks->isEmpty())
                @class([
                    'block min-h-11 w-full rounded-xl bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100',
                    'border-red-300' => $errors->has('taskId'),
                    'border-slate-300' => ! $errors->has('taskId'),
                    'cursor-not-allowed bg-slate-100 opacity-70' =>
                        $availableTasks->isEmpty(),
                ])
            >
                <option value="">
                    Pilih Task yang akan dilaporkan
                </option>

                @foreach ($availableTasks as $task)
                    <option value="{{ $task->id }}">
                        {{ $task->task_code }} — {{ $task->title }}
                    </option>
                @endforeach
            </select>

            @error('taskId')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @else
                <p class="mt-2 text-xs text-slate-500">
                    Hanya Task yang sedang dikerjakan yang ditampilkan.
                </p>
            @enderror
        </div>

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
                wire:model="reportDate"
                type="date"
                max="{{ now('Asia/Jakarta')->toDateString() }}"
                @class([
                    'block min-h-11 w-full rounded-xl bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100',
                    'border-red-300' => $errors->has('reportDate'),
                    'border-slate-300' => ! $errors->has('reportDate'),
                ])
            >

            @error('reportDate')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @else
                <p class="mt-2 text-xs text-slate-500">
                    Tanggal laporan tidak boleh melewati hari ini.
                </p>
            @enderror
        </div>

        <div class="min-w-0">
            <label
                for="reportProject"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Proyek
            </label>

            <input
                id="reportProject"
                type="text"
                value="{{ $projectName }}"
                placeholder="Pilih Task terlebih dahulu"
                readonly
                class="block min-h-11 w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 outline-none"
            >
        </div>

        <div class="min-w-0">
            <label
                for="reportLocation"
                class="mb-2 block text-sm font-semibold text-slate-700"
            >
                Lokasi Pekerjaan
            </label>

            <input
                id="reportLocation"
                type="text"
                value="{{ $taskLocation }}"
                placeholder="Pilih Task terlebih dahulu"
                readonly
                class="block min-h-11 w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 outline-none"
            >
        </div>
    </div>
</section>