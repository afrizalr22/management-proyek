@props([
    'activeWorkers',
])

<div
    class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-slate-950/50 p-4 backdrop-blur-sm"
    role="dialog"
    aria-modal="true"
    aria-labelledby="createTaskTitle"
    wire:key="create-task-modal"
>
    <button
        type="button"
        wire:click="closeTaskForm"
        class="absolute inset-0 cursor-default"
        aria-label="Tutup formulir"
    ></button>

    <div class="relative my-auto w-full max-w-3xl overflow-hidden rounded-2xl bg-white shadow-2xl">

        <div class="flex items-start justify-between gap-4 border-b border-gray-200 px-6 py-5">
            <div>
                <h2
                    id="createTaskTitle"
                    class="text-xl font-bold text-gray-900"
                >
                    Buat Task Baru
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Berikan pekerjaan kepada pekerja aktif pada proyek ini.
                </p>
            </div>

            <button
                type="button"
                wire:click="closeTaskForm"
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
                aria-label="Tutup formulir"
            >
                <svg
                    class="h-5 w-5"
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

        <form wire:submit="createTask">
            <div class="max-h-[70vh] space-y-6 overflow-y-auto px-6 py-6">

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label
                            for="taskWorker"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Pekerja
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="taskWorker"
                            wire:model="workerId"
                            @class([
                                'w-full rounded-xl border bg-white px-4 py-3 text-sm outline-none transition focus:ring-2',

                                'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                                    $errors->has('workerId'),

                                'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                                    ! $errors->has('workerId'),
                            ])
                        >
                            <option value="">
                                Pilih pekerja
                            </option>

                            @foreach ($activeWorkers as $worker)
                                <option value="{{ $worker->id }}">
                                    {{ $worker->name }} — {{ $worker->email }}
                                </option>
                            @endforeach
                        </select>

                        @error('workerId')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label
                            for="taskPriority"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Prioritas
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="taskPriority"
                            wire:model="priority"
                            @class([
                                'w-full rounded-xl border bg-white px-4 py-3 text-sm outline-none transition focus:ring-2',

                                'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                                    $errors->has('priority'),

                                'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                                    ! $errors->has('priority'),
                            ])
                        >
                            <option value="low">Rendah</option>
                            <option value="medium">Sedang</option>
                            <option value="high">Tinggi</option>
                            <option value="urgent">Mendesak</option>
                        </select>

                        @error('priority')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label
                        for="taskTitle"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Judul Task
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="taskTitle"
                        type="text"
                        wire:model.blur="title"
                        placeholder="Contoh: Pemasangan bekisting lantai dua"
                        @class([
                            'w-full rounded-xl border px-4 py-3 text-sm outline-none transition focus:ring-2',

                            'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                                $errors->has('title'),

                            'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                                ! $errors->has('title'),
                        ])
                    >

                    @error('title')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="taskDescription"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Deskripsi Pekerjaan
                    </label>

                    <textarea
                        id="taskDescription"
                        wire:model.blur="description"
                        rows="4"
                        placeholder="Jelaskan pekerjaan yang harus diselesaikan."
                        @class([
                            'w-full resize-y rounded-xl border px-4 py-3 text-sm outline-none transition focus:ring-2',

                            'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                                $errors->has('description'),

                            'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                                ! $errors->has('description'),
                        ])
                    ></textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label
                            for="taskLocation"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Lokasi Pekerjaan
                        </label>

                        <input
                            id="taskLocation"
                            type="text"
                            wire:model.blur="location"
                            placeholder="Contoh: Zona A"
                            @class([
                                'w-full rounded-xl border px-4 py-3 text-sm outline-none transition focus:ring-2',

                                'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                                    $errors->has('location'),

                                'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                                    ! $errors->has('location'),
                            ])
                        >

                        @error('location')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label
                            for="taskWeight"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Bobot Task
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="taskWeight"
                            type="number"
                            wire:model.blur="weight"
                            min="0.01"
                            max="100"
                            step="0.01"
                            @class([
                                'w-full rounded-xl border px-4 py-3 text-sm outline-none transition focus:ring-2',

                                'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                                    $errors->has('weight'),

                                'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                                    ! $errors->has('weight'),
                            ])
                        >

                        <p class="mt-2 text-xs text-gray-400">
                            Bobot menentukan kontribusi Task. Total bobot Task aktif maksimal 100.
                        </p>

                        @error('weight')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label
                            for="taskStartAt"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Waktu Mulai
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="taskStartAt"
                            type="datetime-local"
                            wire:model="startAt"
                            @class([
                                'w-full rounded-xl border px-4 py-3 text-sm outline-none transition focus:ring-2',

                                'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                                    $errors->has('startAt'),

                                'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                                    ! $errors->has('startAt'),
                            ])
                        >

                        @error('startAt')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label
                            for="taskDueAt"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Tenggat Waktu
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="taskDueAt"
                            type="datetime-local"
                            wire:model="dueAt"
                            @class([
                                'w-full rounded-xl border px-4 py-3 text-sm outline-none transition focus:ring-2',

                                'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                                    $errors->has('dueAt'),

                                'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                                    ! $errors->has('dueAt'),
                            ])
                        >

                        @error('dueAt')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label
                        for="taskMandorNotes"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Catatan Mandor
                    </label>

                    <textarea
                        id="taskMandorNotes"
                        wire:model.blur="mandorNotes"
                        rows="3"
                        placeholder="Tambahkan arahan atau catatan khusus untuk pekerja."
                        @class([
                            'w-full resize-y rounded-xl border px-4 py-3 text-sm outline-none transition focus:ring-2',

                            'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                                $errors->has('mandorNotes'),

                            'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                                ! $errors->has('mandorNotes'),
                        ])
                    ></textarea>

                    @error('mandorNotes')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end">
                <button
                    type="button"
                    wire:click="closeTaskForm"
                    wire:loading.attr="disabled"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="createTask"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-wait disabled:opacity-70"
                >
                    <svg
                        wire:loading
                        wire:target="createTask"
                        class="h-4 w-4 animate-spin"
                        viewBox="0 0 24 24"
                        fill="none"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>

                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                        ></path>
                    </svg>

                    <span wire:loading.remove wire:target="createTask">
                        Simpan Task
                    </span>

                    <span wire:loading wire:target="createTask">
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>