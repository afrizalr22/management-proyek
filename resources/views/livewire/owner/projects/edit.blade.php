<div class="space-y-6">
    {{-- Breadcrumb --}}
    <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
        <a
            href="{{ route('owner.projects.index') }}"
            wire:navigate
            class="transition hover:text-blue-600"
        >
            Project
        </a>

        <span>/</span>

        <a
            href="{{ route('owner.projects.show', [
                'project' => $project->id,
            ]) }}"
            wire:navigate
            class="transition hover:text-blue-600"
        >
            {{ $project->project_code }}
        </a>

        <span>/</span>

        <span class="font-medium text-gray-700">
            Edit
        </span>
    </nav>

    {{-- Header --}}
    <x-ui.page-header
        :title="$pageTitle"
        :description="$pageDescription"
    />

    {{-- Informasi data terkunci --}}
    <div
        class="rounded-2xl border border-blue-200 bg-blue-50 px-5 py-4"
    >
        <p class="font-semibold text-blue-900">
            Informasi Project
        </p>

        <p class="mt-1 text-sm leading-6 text-blue-700">
            Client, kode Project, nilai kontrak, status, dan progres tidak dapat diubah dari halaman ini.
        </p>
    </div>

    @error('save')
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
            role="alert"
        >
            {{ $message }}
        </div>
    @enderror

    <form
        wire:submit="updateProject"
        class="space-y-6"
    >
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            {{-- Konten utama --}}
            <div class="space-y-6 xl:col-span-2">
                <x-project.project-general-information
                    mode="edit"
                    :clients="$clients"
                    :mandors="$mandors"
                    :selected-client="$selectedClient"
                    :source-quotation="$sourceQuotation"
                />

                <x-project.project-timeline-budget
                    mode="edit"
                    :source-quotation="$sourceQuotation"
                />
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6">
                <x-project.project-administrative-note
                    mode="edit"
                    :source-quotation="$sourceQuotation"
                />
            </aside>
        </div>

        {{-- Tombol aksi --}}
        <div
            class="flex flex-col-reverse gap-3 rounded-2xl border border-gray-200 bg-white p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5"
        >
            <p class="text-sm text-gray-500">
                Pastikan seluruh perubahan telah sesuai sebelum disimpan.
            </p>

            <div class="flex flex-col-reverse gap-3 sm:flex-row">
                <a
                    href="{{ route('owner.projects.show', [
                        'project' => $project->id,
                    ]) }}"
                    wire:navigate
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="updateProject"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span
                        wire:loading.remove
                        wire:target="updateProject"
                    >
                        Simpan Perubahan
                    </span>

                    <span
                        wire:loading.flex
                        wire:target="updateProject"
                        class="items-center gap-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            class="h-4 w-4 animate-spin"
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
                                d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"
                            ></path>
                        </svg>

                        Menyimpan...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>