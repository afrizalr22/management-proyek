@props(['activeWorkers'])

<div
    class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm"
    role="dialog"
    aria-modal="true"
    aria-labelledby="createTaskTitle"
    wire:key="create-task-modal"
    x-data
    x-on:keydown.escape.window="$wire.closeTaskForm()"
>
    <button
        type="button"
        wire:click="closeTaskForm"
        class="absolute inset-0 cursor-default"
        aria-label="Tutup formulir"
    ></button>

    <div class="relative flex max-h-[90dvh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">
        {{-- Header --}}
        <div class="flex shrink-0 items-start justify-between gap-4 border-b border-gray-200 px-5 py-4 sm:px-6">
            <div>
                <h2 id="createTaskTitle" class="text-xl font-bold text-gray-900">
                    Buat Task Baru
                </h2>

                <p class="mt-1 text-sm leading-6 text-gray-500">
                    Berikan pekerjaan kepada satu atau beberapa pekerja aktif pada proyek ini.
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
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 6l12 12M18 6L6 18"
                    />
                </svg>
            </button>
        </div>

        <form
            wire:submit="createTask"
            novalidate
            class="flex min-h-0 flex-1 flex-col"
        >
            {{-- Bagian yang dapat digulir --}}
            <div class="min-h-0 flex-1 space-y-5 overflow-y-auto px-5 py-5 sm:px-6">
                @if ($errors->any())
                    <div
                        role="alert"
                        class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                    >
                        <p class="font-semibold">
                            Task belum dapat disimpan.
                        </p>

                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Judul --}}
                <div>
                    <label
                        for="taskTitle"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Judul Task <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="taskTitle"
                        type="text"
                        wire:model="title"
                        maxlength="255"
                        placeholder="Contoh: Pemasangan bekisting lantai dua"
                        class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                {{-- Pilihan pekerja --}}
                <fieldset class="min-w-0">
                    <legend class="text-sm font-semibold text-gray-700">
                        Pekerja <span class="text-red-500">*</span>
                    </legend>

                    <p class="mb-3 mt-2 text-xs leading-5 text-gray-500">
                        Pilih minimal satu pekerja. Semua pekerja yang dipilih menjadi anggota Task ini.
                    </p>

                    <div class="max-h-48 overflow-y-auto rounded-xl border border-gray-200 bg-gray-50 p-3">
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                            @forelse ($activeWorkers as $worker)
                                <label
                                    wire:key="task-worker-option-{{ $worker->id }}"
                                    class="flex cursor-pointer items-start gap-3 rounded-lg border border-gray-200 bg-white p-3 transition hover:border-blue-300 hover:bg-blue-50"
                                >
                                    <input
                                        type="checkbox"
                                        wire:model="workerIds"
                                        value="{{ $worker->id }}"
                                        class="mt-1 h-4 w-4 shrink-0 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    >

                                    <span class="min-w-0">
                                        <span class="block text-sm font-semibold text-gray-900">
                                            {{ $worker->name }}
                                        </span>

                                        <span class="mt-1 block break-all text-xs text-gray-500">
                                            {{ $worker->email }}
                                        </span>
                                    </span>
                                </label>
                            @empty
                                <p class="py-2 text-sm leading-6 text-gray-500 sm:col-span-2">
                                    Belum ada pekerja aktif pada proyek ini.
                                    Owner perlu menugaskan pekerja ke proyek terlebih dahulu.
                                </p>
                            @endforelse
                        </div>
                    </div>

                    <x-input-error :messages="$errors->get('workerIds')" class="mt-2" />

                    @foreach ($errors->get('workerIds.*') as $messages)
                        <x-input-error :messages="$messages" class="mt-2" />
                    @endforeach
                </fieldset>

                {{-- Lokasi pekerjaan --}}
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
                        wire:model="location"
                        maxlength="255"
                        placeholder="Contoh: Zona A"
                        class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    <x-input-error
                        :messages="$errors->get('location')"
                        class="mt-2"
                    />
                </div>

                {{-- Jadwal --}}
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div class="min-w-0">
                        <label
                            for="taskStartAt"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Waktu Mulai <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="taskStartAt"
                            type="datetime-local"
                            wire:model="startAt"
                            class="block w-full min-w-0 rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                        <x-input-error :messages="$errors->get('startAt')" class="mt-2" />
                    </div>

                    <div class="min-w-0">
                        <label
                            for="taskDueAt"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Tenggat Waktu <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="taskDueAt"
                            type="datetime-local"
                            wire:model="dueAt"
                            class="block w-full min-w-0 rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                        <x-input-error :messages="$errors->get('dueAt')" class="mt-2" />
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label
                        for="taskDescription"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Deskripsi Pekerjaan
                    </label>

                    <textarea
                        id="taskDescription"
                        wire:model="description"
                        rows="3"
                        maxlength="5000"
                        placeholder="Jelaskan pekerjaan yang harus diselesaikan."
                        class="block w-full resize-y rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    ></textarea>

                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                {{-- Catatan --}}
                <div>
                    <label
                        for="taskMandorNotes"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Catatan Mandor
                    </label>

                    <textarea
                        id="taskMandorNotes"
                        wire:model="mandorNotes"
                        rows="2"
                        maxlength="2000"
                        placeholder="Tambahkan arahan khusus untuk pekerja."
                        class="block w-full resize-y rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    ></textarea>

                    <x-input-error :messages="$errors->get('mandorNotes')" class="mt-2" />
                </div>
            </div>

            {{-- Footer tetap terlihat --}}
            <div class="flex shrink-0 flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button
                    type="button"
                    wire:click="closeTaskForm"
                    wire:loading.attr="disabled"
                    wire:target="createTask,closeTaskForm"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 disabled:opacity-60"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="createTask"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-wait disabled:opacity-70"
                >
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