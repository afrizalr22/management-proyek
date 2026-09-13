@props([
    'documentations',
    'totalDocumentations' => 0,
])

<section>
    <div
        class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between"
    >
        <div>
            <h2 class="text-lg font-bold text-slate-900">
                Galeri Dokumentasi
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Dokumentasi pekerjaan lapangan yang telah Anda unggah.
            </p>
        </div>

        <p class="text-sm text-slate-500">
            <span class="font-semibold text-slate-700">
                {{ $documentations->total() }}
            </span>
            dokumentasi ditemukan
        </p>
    </div>

    <div
        wire:loading.delay
        wire:target="search,task,category,sort,resetFilters"
        class="rounded-2xl border border-blue-100 bg-blue-50 px-5 py-8 text-center"
    >
        <svg
            class="mx-auto h-7 w-7 animate-spin text-blue-600"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
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
                d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z"
            ></path>
        </svg>

        <p class="mt-3 text-sm font-semibold text-blue-700">
            Memuat dokumentasi...
        </p>
    </div>

    <div
        wire:loading.remove
        wire:target="search,task,project,category,sort,resetFilters"
    >
        @if ($documentations->count() > 0)
            <div
                class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3"
            >
                @foreach ($documentations as $documentation)
                    <x-pekerja.documentation.documentation-card
                        :documentation="$documentation"
                        wire:key="worker-documentation-{{ $documentation->id }}"
                    />
                @endforeach
            </div>
        @else
            <div
                class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center"
            >
                <div
                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.6"
                        stroke="currentColor"
                        class="h-7 w-7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909"
                        />
                    </svg>
                </div>

                @if ($totalDocumentations > 0)
                    <h3 class="mt-4 font-semibold text-slate-900">
                        Dokumentasi Tidak Ditemukan
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        Tidak ada dokumentasi yang sesuai dengan pencarian atau filter yang dipilih.
                    </p>

                    <button
                        type="button"
                        wire:click="resetFilters"
                        wire:loading.attr="disabled"
                        wire:target="resetFilters"
                        class="mt-5 inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        Reset Filter
                    </button>
                @else
                    <h3 class="mt-4 font-semibold text-slate-900">
                        Belum Ada Dokumentasi
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        Dokumentasi pekerjaan yang Anda unggah akan tampil pada halaman ini.
                    </p>

                    <a
                        href="{{ route('pekerja.documentation.create') }}"
                        wire:navigate
                        class="mt-5 inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                    >
                        Tambah Dokumentasi
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>