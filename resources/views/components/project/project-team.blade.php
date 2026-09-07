@props([
    'project',
])

@php
    $assignments =
        $project->workerAssignments
        ?? collect();

    $activeAssignments = $assignments
        ->where('status', 'active')
        ->values();

    $inactiveAssignments = $assignments
        ->where('status', '!=', 'active')
        ->values();

    $mandorName =
        $project->mandor?->name
        ?? 'Belum ditentukan';

    $mandorEmail =
        $project->mandor?->email
        ?? '-';

    $mandorInitials = collect(
        preg_split(
            '/\s+/',
            trim($mandorName)
        )
    )
        ->filter()
        ->take(2)
        ->map(
            fn (string $word): string =>
                mb_strtoupper(
                    mb_substr($word, 0, 1)
                )
        )
        ->implode('');
@endphp

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Tim Project
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Mandor dan pekerja yang ditugaskan pada Project ini.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <span
                    class="inline-flex min-h-10 items-center rounded-xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700"
                >
                    {{ $activeAssignments->count() }}
                    Pekerja Aktif
                </span>

                @if (
                    $project->status === 'planning'
                    || $project->status === 'on_progress'
                )
                    <button
                        type="button"
                        wire:click="$dispatch(
                            'open-manage-project-workers',
                            { projectId: {{ $project->id }} }
                        )"
                        class="inline-flex min-h-10 items-center justify-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
                    >
                        Kelola Pekerja
                    </button>
                @endif
            </div>
        </div>

        <hr class="my-6 border-gray-200">

        {{-- Mandor --}}
        <section>
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                Penanggung Jawab
            </p>

            <div class="mt-4 flex flex-col gap-4 rounded-2xl border border-purple-200 bg-purple-50 p-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex min-w-0 items-center gap-4">
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-purple-600 text-sm font-bold text-white"
                    >
                        {{ $mandorInitials ?: 'M' }}
                    </div>

                    <div class="min-w-0">
                        <p class="break-words font-semibold text-gray-900">
                            {{ $mandorName }}
                        </p>

                        <p class="mt-1 break-all text-sm text-gray-500">
                            {{ $mandorEmail }}
                        </p>
                    </div>
                </div>

                <x-ui.badge color="blue">
                    Mandor
                </x-ui.badge>
            </div>
        </section>

        <hr class="my-6 border-gray-200">

        {{-- Pekerja aktif --}}
        <section>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h3 class="font-semibold text-gray-900">
                        Pekerja Aktif
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Pekerja yang dapat menerima tugas dari Mandor.
                    </p>
                </div>

                <span class="text-sm font-medium text-gray-500">
                    {{ $activeAssignments->count() }} orang
                </span>
            </div>

            @if ($activeAssignments->isNotEmpty())
                <div class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-2">
                    @foreach ($activeAssignments as $assignment)
                        @php
                            $workerName =
                                $assignment->worker?->name
                                ?? 'Pekerja tidak tersedia';

                            $workerInitials = collect(
                                preg_split(
                                    '/\s+/',
                                    trim($workerName)
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
                        @endphp

                        <article
                            wire:key="active-worker-{{ $assignment->id }}"
                            class="rounded-2xl border border-gray-200 bg-white p-4"
                        >
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex min-w-0 items-center gap-3">
                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700"
                                    >
                                        {{ $workerInitials ?: 'P' }}
                                    </div>

                                    <div class="min-w-0">
                                        <p class="break-words font-semibold text-gray-900">
                                            {{ $workerName }}
                                        </p>

                                        <p class="mt-1 break-all text-sm text-gray-500">
                                            {{ $assignment->worker?->email
                                                ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <x-ui.badge color="green">
                                    Aktif
                                </x-ui.badge>
                            </div>

                            <dl class="mt-4 grid grid-cols-1 gap-3 border-t border-gray-100 pt-4 sm:grid-cols-2">
                                <div>
                                    <dt class="text-xs text-gray-500">
                                        Bergabung
                                    </dt>

                                    <dd class="mt-1 text-sm font-medium text-gray-700">
                                        {{ $assignment->joined_at
                                            ? $assignment->joined_at
                                                ->translatedFormat('d M Y')
                                            : '-' }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-xs text-gray-500">
                                        Ditugaskan oleh
                                    </dt>

                                    <dd class="mt-1 break-words text-sm font-medium text-gray-700">
                                        {{ $assignment->assignedBy?->name
                                            ?? '-' }}
                                    </dd>
                                </div>
                            </dl>
                        </article>
                    @endforeach
                </div>
            @else
                <div
                    class="mt-5 rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 py-8 text-center"
                >
                    <p class="font-semibold text-gray-700">
                        Belum ada pekerja
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Tambahkan pekerja sebelum Mandor membuat dan membagikan tugas.
                    </p>
                </div>
            @endif
        </section>

        {{-- Riwayat pekerja tidak aktif --}}
        @if ($inactiveAssignments->isNotEmpty())
            <hr class="my-6 border-gray-200">

            <section>
                <h3 class="font-semibold text-gray-900">
                    Riwayat Keanggotaan
                </h3>

                <div class="mt-4 space-y-3">
                    @foreach ($inactiveAssignments as $assignment)
                        <div
                            wire:key="inactive-worker-{{ $assignment->id }}"
                            class="flex flex-col gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4 sm:flex-row sm:items-center sm:justify-between"
                        >
                            <div>
                                <p class="font-semibold text-gray-700">
                                    {{ $assignment->worker?->name
                                        ?? 'Pekerja tidak tersedia' }}
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Berakhir:
                                    {{ $assignment->ended_at
                                        ? $assignment->ended_at
                                            ->translatedFormat('d M Y')
                                        : '-' }}
                                </p>
                            </div>

                            <x-ui.badge color="gray">
                                Tidak Aktif
                            </x-ui.badge>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-ui.info-card>