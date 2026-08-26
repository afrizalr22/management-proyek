<div class="min-h-screen bg-slate-50">
    <main class="w-full px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto w-full max-w-7xl">

            {{-- Breadcrumb --}}
            <nav class="mb-5 flex flex-wrap items-center gap-2 text-sm text-slate-500">
                <a
                    href="{{ route('mandor.daily-reports.index') }}"
                    wire:navigate
                    class="transition hover:text-blue-600"
                >
                    Laporan Harian
                </a>

                <span>/</span>

                <a
                    href="{{ route('mandor.daily-reports.show', $reportId) }}"
                    wire:navigate
                    class="transition hover:text-blue-600"
                >
                    Detail Laporan
                </a>

                <span>/</span>

                <span class="font-medium text-slate-900">
                    Edit
                </span>
            </nav>

            {{-- Header --}}
            <header class="mb-6">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Edit Laporan Harian
                </h1>

                <p class="mt-2 text-sm text-slate-500 sm:text-base">
                    Perbarui informasi laporan pekerjaan lapangan yang telah dibuat.
                </p>
            </header>

            {{-- Form --}}
            <form wire:submit="updateReport" class="space-y-6">

                {{-- Komponen akan ditambahkan pada sprint berikutnya --}}
                <section
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                >
                    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
                        <h2 class="text-lg font-semibold text-slate-900">
                            Informasi Laporan
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Komponen informasi umum akan dibuat pada Sprint 2.
                        </p>
                    </div>

                    <div class="px-5 py-6 sm:px-6">
                        <div
                            class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-10 text-center"
                        >
                            <p class="text-sm text-slate-500">
                                Form edit laporan sedang dipersiapkan.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Tombol bagian bawah --}}
                <div
                    class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end"
                >
                    <a
                        href="{{ route('mandor.daily-reports.show', $reportId) }}"
                        wire:navigate
                        class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                    >
                        <span wire:loading.remove wire:target="updateReport">
                            Simpan Perubahan
                        </span>

                        <span
                            wire:loading
                            wire:target="updateReport"
                            class="items-center gap-2"
                        >
                            Menyimpan...
                        </span>
                    </button>
                </div>

            </form>
        </div>
    </main>
</div>