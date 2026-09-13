@props([
    'availableTasks',
    'projectName' => '',
    'taskLocation' => '',
    'description' => '',
])

<div class="grid min-w-0 grid-cols-1 gap-5 md:grid-cols-2">
    <div class="min-w-0">
        <label
            for="taskId"
            class="mb-2 block text-sm font-semibold text-slate-700"
        >
            Pilih Task
            <span class="text-red-500">*</span>
        </label>

        <select
            id="taskId"
            wire:model.live="taskId"
            @disabled($availableTasks->isEmpty())
            @class([
                'block min-h-11 w-full rounded-xl bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100',
                'border-red-300' => $errors->has('taskId'),
                'border-slate-300' => ! $errors->has('taskId'),
                'cursor-not-allowed bg-slate-100 opacity-70' => $availableTasks->isEmpty(),
            ])
        >
            <option value="">
                Pilih Task
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
        @enderror

        <p class="mt-2 text-xs leading-5 text-slate-500">
            Hanya Task aktif dari proyek tempat Anda masih bertugas yang dapat dipilih.
        </p>
    </div>

    <div class="min-w-0">
        <label
            for="documentationCategory"
            class="mb-2 block text-sm font-semibold text-slate-700"
        >
            Kategori Dokumentasi
            <span class="text-red-500">*</span>
        </label>

        <select
            id="documentationCategory"
            wire:model="category"
            @class([
                'block min-h-11 w-full rounded-xl bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100',
                'border-red-300' => $errors->has('category'),
                'border-slate-300' => ! $errors->has('category'),
            ])
        >
            <option value="progress">
                Progres
            </option>

            <option value="material">
                Material
            </option>

            <option value="safety">
                Keselamatan
            </option>

            <option value="obstacle">
                Kendala
            </option>

            <option value="other">
                Lainnya
            </option>
        </select>

        @error('category')
            <p class="mt-2 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="min-w-0">
        <label
            for="projectName"
            class="mb-2 block text-sm font-semibold text-slate-700"
        >
            Proyek
        </label>

        <input
            id="projectName"
            type="text"
            value="{{ $projectName }}"
            placeholder="Pilih Task terlebih dahulu"
            readonly
            class="block min-h-11 w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 outline-none"
        >
    </div>

    <div class="min-w-0">
        <label
            for="taskLocation"
            class="mb-2 block text-sm font-semibold text-slate-700"
        >
            Lokasi
        </label>

        <input
            id="taskLocation"
            type="text"
            value="{{ $taskLocation }}"
            placeholder="Pilih Task terlebih dahulu"
            readonly
            class="block min-h-11 w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 outline-none"
        >
    </div>

    <div class="min-w-0 md:col-span-2">
        <label
            for="documentationDescription"
            class="mb-2 block text-sm font-semibold text-slate-700"
        >
            Keterangan Lapangan
            <span class="text-red-500">*</span>
        </label>

        <textarea
            id="documentationDescription"
            wire:model="description"
            rows="4"
            maxlength="1000"
            placeholder="Tuliskan kondisi dan hasil pekerjaan yang terlihat pada foto..."
            @class([
                'block w-full resize-none rounded-xl bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100',
                'border-red-300' => $errors->has('description'),
                'border-slate-300' => ! $errors->has('description'),
            ])
        ></textarea>

        <div class="mt-2 flex items-start justify-between gap-4">
            <div>
                @error('description')
                    <p class="text-sm text-red-600">
                        {{ $message }}
                    </p>
                @else
                    <p class="text-xs text-slate-500">
                        Maksimal 1.000 karakter.
                    </p>
                @enderror
            </div>

            <p class="shrink-0 text-xs text-slate-400">
                {{ mb_strlen($description) }}/1.000
            </p>
        </div>
    </div>
</div>