<div
    x-data="{
        open: false,
        image: '',
        title: '',
        category: '',
        description: '',
        date: '',
        time: '',
        uploader: '',
        project: '',
        projectCode: '',
        task: '',
        taskCode: '',
        report: '',
        location: '',
        fileSize: '',

        showPreview(data) {
            this.image = data.image ?? '';
            this.title = data.title ?? 'Dokumentasi Pekerjaan';
            this.category = data.category ?? 'Dokumentasi';
            this.description = data.description ?? '';
            this.date = data.date ?? '';
            this.time = data.time ?? '';
            this.uploader = data.uploader ?? '';
            this.project = data.project ?? '';
            this.projectCode = data.projectCode ?? '';
            this.task = data.task ?? '';
            this.taskCode = data.taskCode ?? '';
            this.report = data.report ?? '';
            this.location = data.location ?? '';
            this.fileSize = data.fileSize ?? '';
            this.open = true;
        },

        closePreview() {
            this.open = false;
        }
    }"
    x-on:open-documentation-preview.window="showPreview($event.detail)"
    x-on:keydown.escape.window="closePreview()"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-[100] overflow-y-auto"
    role="dialog"
    aria-modal="true"
    aria-labelledby="documentationPreviewTitle"
>
    <div
        x-show="open"
        x-transition.opacity
        x-on:click="closePreview()"
        class="fixed inset-0 bg-slate-950/75 backdrop-blur-sm"
    ></div>

    <div class="relative flex min-h-full items-center justify-center p-4 sm:p-6">
        <div
            x-show="open"
            x-transition:enter="transition duration-200 ease-out"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition duration-150 ease-in"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0"
            x-on:click.stop
            class="relative w-full max-w-5xl overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <button
                type="button"
                x-on:click="closePreview()"
                class="absolute right-4 top-4 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-black/50 text-white backdrop-blur transition hover:bg-black/70"
                aria-label="Tutup preview"
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
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>

            <div class="flex min-h-64 items-center justify-center bg-slate-950">
                <img
                    x-bind:src="image"
                    x-bind:alt="title"
                    class="max-h-[68vh] w-full object-contain"
                >
            </div>

            <div class="p-5 sm:p-6">
                <div class="flex flex-wrap items-center gap-2">
                    <span
                        class="inline-flex rounded-lg bg-blue-50 px-2.5 py-1.5 text-xs font-bold uppercase tracking-wide text-blue-700"
                        x-text="category"
                    ></span>

                    <span
                        x-show="report"
                        class="inline-flex rounded-lg bg-emerald-50 px-2.5 py-1.5 text-xs font-bold text-emerald-700"
                        x-text="report"
                    ></span>
                </div>

                <h2
                    id="documentationPreviewTitle"
                    class="mt-3 text-xl font-bold leading-8 text-gray-900"
                    x-text="title"
                ></h2>

                <p
                    class="mt-2 text-sm leading-6 text-gray-500"
                    x-text="description"
                ></p>

                <div class="mt-5 grid grid-cols-1 gap-4 border-t border-gray-100 pt-5 sm:grid-cols-2 xl:grid-cols-5">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                            Tanggal
                        </p>

                        <p class="mt-1 text-sm font-semibold text-gray-700">
                            <span x-text="date"></span>

                            <span x-show="time">
                                · <span x-text="time"></span>
                            </span>
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                            Pengunggah
                        </p>

                        <p
                            class="mt-1 truncate text-sm font-semibold text-gray-700"
                            x-text="uploader"
                        ></p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                            Project
                        </p>

                        <p
                            class="mt-1 truncate text-sm font-semibold text-gray-700"
                            x-text="project || 'Tidak tersedia'"
                        ></p>

                        <p
                            x-show="projectCode"
                            class="mt-1 text-xs font-medium text-blue-600"
                            x-text="projectCode"
                        ></p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                            Task
                        </p>

                        <p
                            class="mt-1 truncate text-sm font-semibold text-gray-700"
                            x-text="task || 'Tidak tersedia'"
                        ></p>

                        <p
                            x-show="taskCode"
                            class="mt-1 text-xs font-medium text-blue-600"
                            x-text="taskCode"
                        ></p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                            Detail
                        </p>

                        <p
                            x-show="location"
                            class="mt-1 truncate text-sm font-semibold text-gray-700"
                            x-text="location"
                        ></p>

                        <p
                            x-show="fileSize"
                            class="mt-1 text-xs text-gray-500"
                            x-text="fileSize"
                        ></p>

                        <p
                            x-show="!location && !fileSize"
                            class="mt-1 text-sm text-gray-400"
                        >
                            Tidak tersedia
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>