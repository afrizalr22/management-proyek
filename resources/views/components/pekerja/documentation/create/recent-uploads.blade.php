@props([
    'uploads',
])

@php
    $categoryStyles = [
        'progress' => [
            'label' => 'Progres',
            'class' => 'bg-blue-50 text-blue-600',
        ],

        'material' => [
            'label' => 'Material',
            'class' => 'bg-amber-50 text-amber-600',
        ],

        'safety' => [
            'label' => 'Keselamatan',
            'class' => 'bg-emerald-50 text-emerald-600',
        ],

        'obstacle' => [
            'label' => 'Kendala',
            'class' => 'bg-red-50 text-red-600',
        ],

        'other' => [
            'label' => 'Lainnya',
            'class' => 'bg-slate-100 text-slate-600',
        ],
    ];
@endphp

<aside
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
>
    <div
        class="flex items-center justify-between gap-3 border-b border-slate-200 px-5 py-5"
    >
        <div>
            <h2 class="font-semibold text-slate-900">
                Dokumentasi Hari Ini
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Foto yang baru Anda tambahkan.
            </p>
        </div>

        <span
            class="inline-flex shrink-0 rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-600"
        >
            {{ $uploads->count() }} foto
        </span>
    </div>

    <div class="space-y-3 p-4">
        @forelse ($uploads as $upload)
            @php
                $category = $categoryStyles[
                    $upload->category
                ] ?? $categoryStyles['other'];

                $photoExists = filled($upload->photo)
                    && \Illuminate\Support\Facades\Storage::disk(
                        'public'
                    )->exists($upload->photo);

                $photoUrl = $photoExists
                    ? asset(
                        'storage/'
                        . ltrim($upload->photo, '/')
                    )
                    : null;
            @endphp

            <article
                wire:key="recent-documentation-{{ $upload->id }}"
                class="rounded-xl border border-slate-200 p-3 transition hover:border-blue-200 hover:bg-blue-50/30"
            >
                <div class="flex gap-3">
                    <div
                        class="h-16 w-16 shrink-0 overflow-hidden rounded-lg bg-slate-100"
                    >
                        @if ($photoUrl)
                            <img
                                src="{{ $photoUrl }}"
                                alt="Dokumentasi {{ $upload->title ?? $upload->task?->title ?? 'pekerjaan' }}"
                                class="h-full w-full object-cover"
                            >
                        @else
                            <div
                                class="flex h-full w-full items-center justify-center text-slate-400"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.6"
                                    stroke="currentColor"
                                    class="h-6 w-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909"
                                    />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="min-w-0 flex-1">
                        <h3
                            class="line-clamp-2 text-sm font-semibold text-slate-900"
                        >
                            {{ $upload->title
                                ?? $upload->task?->title
                                ?? 'Dokumentasi Pekerjaan' }}
                        </h3>

                        <p class="mt-1 truncate text-xs text-slate-500">
                            {{ $upload->project?->project_name
                                ?? 'Proyek tidak tersedia' }}
                        </p>

                        <div class="mt-2 flex flex-wrap items-center gap-2">
                            <span
                                class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $category['class'] }}"
                            >
                                {{ $category['label'] }}
                            </span>

                            <span class="text-xs text-slate-400">
                                {{ $upload->taken_at
                                    ?->timezone('Asia/Jakarta')
                                    ->locale('id')
                                    ->translatedFormat('H.i') ?? '-' }}
                                WIB
                            </span>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-3 flex items-center justify-between gap-3 border-t border-slate-100 pt-3"
                >
                    <span
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600"
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
                                d="m4.5 12.75 6 6 9-13.5"
                            />
                        </svg>

                        Tersimpan
                    </span>

                    @unless ($photoExists)
                        <span
                            class="text-xs font-semibold text-amber-600"
                            title="File foto tidak ditemukan pada penyimpanan"
                        >
                            Foto tidak tersedia
                        </span>
                    @endunless
                </div>
            </article>
        @empty
            <div class="px-4 py-10 text-center">
                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.6"
                        stroke="currentColor"
                        class="h-6 w-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159"
                        />
                    </svg>
                </div>

                <h3 class="mt-4 text-sm font-semibold text-slate-900">
                    Belum Ada Dokumentasi
                </h3>

                <p class="mt-1 text-xs leading-5 text-slate-500">
                    Dokumentasi yang ditambahkan hari ini akan tampil di sini.
                </p>
            </div>
        @endforelse
    </div>

    <a
        href="{{ route('pekerja.documentation.index') }}"
        wire:navigate
        class="flex items-center justify-center gap-2 border-t border-slate-200 px-4 py-4 text-sm font-semibold text-blue-600 transition hover:bg-blue-50"
    >
        Lihat Semua Dokumentasi

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
                d="m9 18 6-6-6-6"
            />
        </svg>
    </a>
</aside>