<div class="space-y-6">
    <header
        class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
    >
        <div>
            <a
                href="{{ route('pekerja.report.show', ['report' => $reportId]) }}"
                wire:navigate
                class="mb-3 inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-blue-600"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-4 w-4"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m15 18-6-6 6-6"
                    />
                </svg>

                Kembali ke Detail Laporan
            </a>

            <p class="text-sm font-semibold text-red-600">
                Perbaikan Laporan
            </p>

            <h1
                class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"
            >
                {{ $reportNumber }}
            </h1>

            <p class="mt-2 max-w-2xl text-sm text-slate-500 sm:text-base">
                Perbaiki laporan sesuai catatan yang diberikan oleh Mandor.
            </p>
        </div>

        <span
            class="inline-flex w-fit items-center gap-2 rounded-full border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-600"
        >
            <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>
            Perlu Revisi
        </span>
    </header>

    @error('submit')
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
            role="alert"
        >
            {{ $message }}
        </div>
    @enderror

    <section
        class="rounded-2xl border border-red-200 bg-red-50 p-5 shadow-sm sm:p-6"
    >
        <div class="flex items-start gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600"
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
                        d="M12 9v3.75m9-1.5a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM12 16.5h.008v.008H12V16.5Z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-red-900">
                    Catatan Revisi Mandor
                </h2>

                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-red-700">{{ $reviewNotes }}</p>
            </div>
        </div>
    </section>

    <section
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >
        <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
            <h2 class="text-lg font-semibold text-slate-900">
                Informasi Laporan
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Task dan proyek tidak dapat diubah saat memperbaiki laporan.
            </p>
        </div>

        <div
            class="grid grid-cols-1 gap-5 px-5 py-5 sm:px-6 lg:grid-cols-2"
        >
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Task
                </label>

                <input
                    type="text"
                    value="{{ $taskCode }} — {{ $taskTitle }}"
                    readonly
                    class="block min-h-11 w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 outline-none"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Tanggal Laporan
                </label>

                <input
                    type="date"
                    value="{{ $reportDate }}"
                    readonly
                    class="block min-h-11 w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 outline-none"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Proyek
                </label>

                <input
                    type="text"
                    value="{{ $projectName }}"
                    readonly
                    class="block min-h-11 w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 outline-none"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Lokasi Pekerjaan
                </label>

                <input
                    type="text"
                    value="{{ $taskLocation }}"
                    readonly
                    class="block min-h-11 w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-600 outline-none"
                >
            </div>
        </div>
    </section>

    <x-pekerja.report.create.work-result
        :activities="$activities"
        :work-status="$workStatus"
        :reported-progress="$reportedProgress"
        :current-task-progress="$currentTaskProgress"
    />

    <x-pekerja.report.create.obstacle-notes
        :obstacles="$obstacles"
        :notes="$notes"
    />

    @if (count($existingDocumentations) > 0)
        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        >
            <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
                <h2 class="text-lg font-semibold text-slate-900">
                    Dokumentasi Saat Ini
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Hapus foto yang tidak sesuai sebelum mengirim ulang laporan.
                </p>
            </div>

            <div
                class="grid grid-cols-2 gap-3 px-5 py-5 sm:grid-cols-3 sm:px-6 lg:grid-cols-5"
            >
                @foreach ($existingDocumentations as $documentation)
                    <article
                        wire:key="existing-report-photo-{{ $documentation['id'] }}"
                        class="relative overflow-hidden rounded-xl border border-slate-200 bg-white"
                    >
                        @if ($documentation['photo_exists'])
                            <img
                                src="{{ $documentation['photo_url'] }}"
                                alt="{{ $documentation['title'] ?? 'Dokumentasi laporan' }}"
                                class="aspect-square h-full w-full object-cover"
                            >
                        @else
                            <div
                                class="flex aspect-square items-center justify-center bg-slate-100 text-slate-400"
                            >
                                File tidak tersedia
                            </div>
                        @endif

                        <button
                            type="button"
                            wire:click="removeExistingDocumentation({{ $documentation['id'] }})"
                            wire:loading.attr="disabled"
                            wire:target="removeExistingDocumentation({{ $documentation['id'] }})"
                            class="absolute right-2 top-2 inline-flex h-8 w-8 items-center justify-center rounded-full bg-slate-900/75 text-white transition hover:bg-red-600 disabled:opacity-50"
                            aria-label="Hapus foto"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                                class="h-4 w-4"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18 18 6M6 6l12 12"
                                />
                            </svg>
                        </button>

                        <p
                            class="truncate border-t border-slate-200 px-3 py-2 text-xs text-slate-600"
                            title="{{ $documentation['original_name'] }}"
                        >
                            {{
                                $documentation['original_name']
                                ?? 'Nama file tidak tersedia'
                            }}
                        </p>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <x-pekerja.report.create.documentation-upload
        :photos="$photos"
    />

    <section
        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"
    >
        <div
            class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
        >
            <div>
                <p class="text-sm font-semibold text-slate-800">
                    Kirim ulang laporan
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Laporan akan kembali berstatus Menunggu Pemeriksaan.
                </p>
            </div>

            <div class="flex flex-col-reverse gap-3 sm:flex-row">
                <a
                    href="{{ route('pekerja.report.show', ['report' => $reportId]) }}"
                    wire:navigate
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100"
                >
                    Batal
                </a>

                <button
                    type="button"
                    wire:click="resubmitReport"
                    wire:loading.attr="disabled"
                    wire:target="resubmitReport,photos"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span
                        wire:loading.remove
                        wire:target="resubmitReport"
                    >
                        Kirim Ulang Laporan
                    </span>

                    <span
                        wire:loading
                        wire:target="resubmitReport"
                    >
                        Mengirim...
                    </span>
                </button>
            </div>
        </div>
    </section>
</div>