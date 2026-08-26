<div
    x-data="{
        open: false,
        image: '',
        project: '',
        description: '',
        date: '',
        uploader: '',

        showPreview(data) {
            this.image = data.image;
            this.project = data.project;
            this.description = data.description;
            this.date = data.date;
            this.uploader = data.uploader;
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
>

    {{-- Overlay --}}
    <div
        x-show="open"
        x-transition.opacity
        x-on:click="closePreview()"
        class="fixed inset-0 bg-black/75 backdrop-blur-sm"
    ></div>

    {{-- Modal Wrapper --}}
    <div
        class="relative flex min-h-full items-center
               justify-center p-4 sm:p-6"
    >

        {{-- Modal Content --}}
        <div
            x-show="open"
            x-transition:enter="transition duration-200 ease-out"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition duration-150 ease-in"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0"
            x-on:click.stop
            class="relative w-full max-w-5xl overflow-hidden
                   rounded-2xl bg-white shadow-2xl"
        >

            {{-- Close Button --}}
            <button
                type="button"
                x-on:click="closePreview()"
                class="absolute right-4 top-4 z-10
                       flex h-10 w-10 items-center justify-center
                       rounded-full bg-black/50 text-white
                       backdrop-blur transition hover:bg-black/70"
                title="Tutup"
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

            {{-- Preview Image --}}
            <div class="bg-slate-950">

                <img
                    x-bind:src="image"
                    x-bind:alt="description"
                    class="max-h-[70vh] w-full object-contain"
                >

            </div>

            {{-- Documentation Information --}}
            <div class="p-6">

                <span
                    class="inline-flex rounded-md bg-blue-50
                           px-2.5 py-1.5 text-xs font-bold
                           uppercase tracking-wide text-blue-700"
                    x-text="project"
                ></span>

                <h2
                    class="mt-3 text-xl font-bold leading-8 text-gray-900"
                    x-text="description"
                ></h2>

                <div
                    class="mt-5 flex flex-col gap-3
                           border-t border-gray-100 pt-5
                           sm:flex-row sm:items-center sm:gap-8"
                >

                    {{-- Date --}}
                    <div class="flex items-center gap-2 text-sm text-gray-500">

                        <svg
                            class="h-5 w-5 text-gray-400"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <rect
                                x="3"
                                y="5"
                                width="18"
                                height="16"
                                rx="2"
                            />

                            <path d="M16 3v4M8 3v4M3 11h18" />
                        </svg>

                        <span x-text="date"></span>

                    </div>

                    {{-- Uploader --}}
                    <div class="flex items-center gap-2 text-sm text-gray-500">

                        <svg
                            class="h-5 w-5 text-gray-400"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <circle cx="12" cy="8" r="4" />

                            <path
                                stroke-linecap="round"
                                d="M4 21a8 8 0 0116 0"
                            />
                        </svg>

                        <span>
                            Diunggah oleh
                            <strong
                                class="font-semibold text-gray-700"
                                x-text="uploader"
                            ></strong>
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>