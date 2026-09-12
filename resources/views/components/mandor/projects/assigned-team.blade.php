@props([
    'project',
    'workers' => collect(),
])

<x-ui.info-card class="overflow-hidden">
    {{-- Header --}}
    <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div>
            <h2 class="text-base font-bold text-gray-900">
                Tim Project
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Pekerja aktif yang ditugaskan pada Project ini.
            </p>
        </div>

        <span class="inline-flex w-fit rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
            {{ $workers->count() }}
            Pekerja
        </span>
    </div>

    @if ($workers->isNotEmpty())
        <div class="grid grid-cols-1 gap-3 p-5 sm:p-6 md:grid-cols-2">
            @foreach ($workers as $assignment)
                @php
                    $worker = $assignment->worker;

                    $initials = collect(
                        preg_split(
                            '/\s+/',
                            trim(
                                $worker?->name
                                ?? 'Pekerja'
                            )
                        )
                    )
                        ->filter()
                        ->take(2)
                        ->map(
                            fn (string $word): string =>
                                mb_strtoupper(
                                    mb_substr(
                                        $word,
                                        0,
                                        1
                                    )
                                )
                        )
                        ->implode('');

                    $photoUrl = filled(
                        $worker?->photo
                    )
                        ? asset(
                            'storage/'
                            .ltrim(
                                $worker->photo,
                                '/'
                            )
                        )
                        : null;

                    $isAccountActive =
                        $worker?->status
                        === 'active';
                @endphp

                <article
                    wire:key="mandor-project-worker-{{ $assignment->id }}"
                    class="flex min-w-0 items-center gap-4 rounded-xl border border-gray-200 bg-white p-4 transition hover:border-blue-200 hover:bg-blue-50/30"
                >
                    {{-- Foto atau inisial --}}
                    <div class="h-11 w-11 shrink-0 overflow-hidden rounded-xl bg-blue-600">
                        @if ($photoUrl)
                            <img
                                src="{{ $photoUrl }}"
                                alt="Foto {{ $worker?->name ?? 'Pekerja' }}"
                                loading="lazy"
                                class="h-full w-full object-cover"
                            >
                        @else
                            <div class="flex h-full w-full items-center justify-center text-sm font-bold text-white">
                                {{ $initials ?: 'P' }}
                            </div>
                        @endif
                    </div>

                    {{-- Identitas --}}
                    <div class="min-w-0 flex-1">
                        <div class="flex min-w-0 items-center gap-2">
                            <h3 class="truncate font-semibold text-gray-900">
                                {{ $worker?->name
                                    ?? 'Pekerja tidak ditemukan' }}
                            </h3>

                            <span
                                @class([
                                    'h-2 w-2 shrink-0 rounded-full',
                                    'bg-green-500' =>
                                        $isAccountActive,
                                    'bg-red-500' =>
                                        !$isAccountActive,
                                ])
                                title="{{ $isAccountActive
                                    ? 'Akun aktif'
                                    : 'Akun tidak aktif' }}"
                            ></span>
                        </div>

                        <p class="mt-1 truncate text-sm text-gray-500">
                            {{ $worker?->email ?: '-' }}
                        </p>

                        <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-400">
                            @if ($worker?->phone)
                                <span>
                                    {{ $worker->phone }}
                                </span>
                            @endif

                            <span>
                                Bergabung
                                {{ $assignment->joined_at
                                    ?->translatedFormat('d M Y')
                                    ?? '-' }}
                            </span>
                        </div>
                    </div>

                    {{-- Status akun --}}
                    <div class="shrink-0">
                        @if ($isAccountActive)
                            <x-ui.badge color="green">
                                Aktif
                            </x-ui.badge>
                        @else
                            <x-ui.badge color="red">
                                Nonaktif
                            </x-ui.badge>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    @else
        {{-- Kondisi kosong --}}
        <div class="px-6 py-10 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-6 w-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.205-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m10.117 0a9.027 9.027 0 0 1 .941 3.197M6 18.72c-1.355 0-2.638-.3-3.741-.479a3 3 0 0 1 4.682-2.72M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                    />
                </svg>
            </div>

            <p class="mt-4 font-semibold text-gray-700">
                Belum ada pekerja aktif
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Owner belum menugaskan pekerja aktif pada Project ini.
            </p>
        </div>
    @endif
</x-ui.info-card>