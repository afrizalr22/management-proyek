<div>
    @if ($showModal)
        <div
            wire:key="manage-project-workers-{{ $projectId }}"
            wire:keydown.escape.window="closeModal"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4"
            role="dialog"
            aria-modal="true"
            aria-labelledby="manage-workers-title"
        >
            {{-- Overlay --}}
            <button
                type="button"
                wire:click="closeModal"
                wire:loading.attr="disabled"
                wire:target="saveWorkers"
                class="absolute inset-0 h-full w-full cursor-default bg-gray-950/50 backdrop-blur-sm"
                aria-label="Tutup modal"
            ></button>

            {{-- Modal --}}
            <div
                class="relative z-10 flex max-h-[90vh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl"
            >
                {{-- Header --}}
                <div class="border-b border-gray-200 px-5 py-5 sm:px-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2
                                id="manage-workers-title"
                                class="text-lg font-bold text-gray-900"
                            >
                                Kelola Pekerja
                            </h2>

                            <p class="mt-1 text-sm leading-6 text-gray-500">
                                Pilih Pekerja untuk menambahkannya ke Project
                                atau hapus pilihan untuk menonaktifkan
                                penugasannya.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="closeModal"
                            wire:loading.attr="disabled"
                            wire:target="saveWorkers"
                            class="text-2xl leading-none text-gray-400 transition hover:text-gray-600 disabled:opacity-50"
                            aria-label="Tutup modal"
                        >
                            &times;
                        </button>
                    </div>
                </div>

                {{-- Keterangan status --}}
                <div class="border-b border-blue-100 bg-blue-50 px-5 py-4 sm:px-6">
                    <div class="grid gap-3 text-xs text-blue-700 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="flex items-center gap-2">
                            <span
                                class="h-2.5 w-2.5 shrink-0 rounded-full bg-blue-500"
                            ></span>

                            Tersedia
                        </div>

                        <div class="flex items-center gap-2">
                            <span
                                class="h-2.5 w-2.5 shrink-0 rounded-full bg-green-500"
                            ></span>

                            Dipilih
                        </div>

                        <div class="flex items-center gap-2">
                            <span
                                class="h-2.5 w-2.5 shrink-0 rounded-full bg-amber-500"
                            ></span>

                            Memiliki tugas aktif
                        </div>

                        <div class="flex items-center gap-2">
                            <span
                                class="h-2.5 w-2.5 shrink-0 rounded-full bg-gray-400"
                            ></span>

                            Aktif pada Project lain
                        </div>
                    </div>
                </div>

                {{-- Pencarian --}}
                <div class="border-b border-gray-200 px-5 py-4 sm:px-6">
                    <input
                        type="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari nama atau email Pekerja..."
                        autocomplete="off"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>

                {{-- Daftar pekerja --}}
                <div class="min-h-0 flex-1 overflow-y-auto p-5 sm:p-6">
                    @error('workers')
                        <div
                            class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
                            role="alert"
                        >
                            {{ $message }}
                        </div>
                    @enderror

                    @error('selectedWorkerIds')
                        <div
                            class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
                            role="alert"
                        >
                            {{ $message }}
                        </div>
                    @enderror

                    @if ($workers->isNotEmpty())
                        <div class="space-y-3">
                            @foreach ($workers as $worker)
                                @php
                                    /*
                                     * Penugasan Pekerja pada Project
                                     * yang sedang dibuka.
                                     */
                                    $assignment = $assignments->get(
                                        $worker->id
                                    );

                                    $isCurrentlyActive =
                                        $assignment?->status === 'active';

                                    /*
                                     * Jumlah Task aktif milik Pekerja
                                     * pada Project ini.
                                     */
                                    $activeTaskCount = (int) (
                                        $activeTaskCounts->get(
                                            $worker->id
                                        ) ?? 0
                                    );

                                    /*
                                     * Penugasan aktif pada Project lain.
                                     */
                                    $otherAssignment =
                                        $otherProjectAssignments->get(
                                            $worker->id
                                        );

                                    $hasOtherProject =
                                        $otherAssignment !== null;

                                    /*
                                     * Checkbox dikunci apabila:
                                     * 1. Pekerja aktif pada Project ini
                                     *    dan masih memiliki Task aktif.
                                     * 2. Pekerja sedang aktif pada
                                     *    Project lain.
                                     */
                                    $checkboxDisabled =
                                        (
                                            $isCurrentlyActive
                                            && $activeTaskCount > 0
                                        )
                                        || (
                                            !$isCurrentlyActive
                                            && $hasOtherProject
                                        );

                                    $isSelected = in_array(
                                        (string) $worker->id,
                                        array_map(
                                            'strval',
                                            $selectedWorkerIds
                                        ),
                                        true
                                    );

                                    $initials = collect(
                                        preg_split(
                                            '/\s+/',
                                            trim($worker->name)
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

                                <label
                                    wire:key="worker-option-{{ $worker->id }}"
                                    @class([
                                        'block rounded-xl border p-4 transition',

                                        'cursor-not-allowed border-amber-200 bg-amber-50' =>
                                            $isCurrentlyActive
                                            && $activeTaskCount > 0,

                                        'cursor-not-allowed border-gray-200 bg-gray-100' =>
                                            !$isCurrentlyActive
                                            && $hasOtherProject,

                                        'cursor-pointer border-green-200 bg-green-50 hover:border-green-300' =>
                                            $isSelected
                                            && !$checkboxDisabled,

                                        'cursor-pointer border-gray-200 bg-white hover:border-blue-300 hover:bg-blue-50/40' =>
                                            !$isSelected
                                            && !$checkboxDisabled,
                                    ])
                                >
                                    <div class="flex items-start gap-4">
                                        {{-- Checkbox --}}
                                        <div class="pt-2">
                                            <input
                                                type="checkbox"
                                                value="{{ $worker->id }}"
                                                wire:model.live="selectedWorkerIds"
                                                @disabled($checkboxDisabled)
                                                class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 disabled:cursor-not-allowed disabled:opacity-60"
                                            >
                                        </div>

                                        {{-- Avatar --}}
                                        <div
                                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700"
                                        >
                                            {{ $initials ?: 'P' }}
                                        </div>

                                        {{-- Identitas --}}
                                        <div class="min-w-0 flex-1">
                                            <p class="break-words font-semibold text-gray-900">
                                                {{ $worker->name }}
                                            </p>

                                            <p class="mt-1 break-all text-sm text-gray-500">
                                                {{ $worker->email }}
                                            </p>

                                            @if (
                                                $isCurrentlyActive
                                                && $activeTaskCount > 0
                                            )
                                                <p class="mt-2 text-xs font-medium leading-5 text-amber-700">
                                                    Masih memiliki
                                                    {{ $activeTaskCount }}
                                                    Task aktif. Pekerja belum
                                                    dapat dikeluarkan.
                                                </p>
                                            @elseif (
                                                !$isCurrentlyActive
                                                && $hasOtherProject
                                            )
                                                <p class="mt-2 text-xs font-medium leading-5 text-gray-600">
                                                    Sedang ditugaskan di

                                                    {{ $otherAssignment
                                                        ->project
                                                        ?->project_code
                                                        ?? 'Project lain' }}

                                                    @if (
                                                        $otherAssignment
                                                            ->project
                                                            ?->project_name
                                                    )
                                                        —
                                                        {{ $otherAssignment
                                                            ->project
                                                            ->project_name }}
                                                    @endif
                                                </p>
                                            @elseif ($isSelected)
                                                <p class="mt-2 text-xs font-medium text-green-700">
                                                    Pekerja dipilih untuk
                                                    Project ini.
                                                </p>
                                            @elseif (
                                                $assignment
                                                && !$isCurrentlyActive
                                            )
                                                <p class="mt-2 text-xs text-gray-500">
                                                    Pernah bergabung dan
                                                    tersedia untuk Project ini.
                                                </p>
                                            @else
                                                <p class="mt-2 text-xs text-gray-500">
                                                    Tersedia untuk Project ini.
                                                </p>
                                            @endif
                                        </div>

                                        {{-- Status --}}
                                        <div class="shrink-0">
                                            @if (
                                                $isCurrentlyActive
                                                && $activeTaskCount > 0
                                            )
                                                <x-ui.badge color="yellow">
                                                    Tugas Aktif
                                                </x-ui.badge>
                                            @elseif (
                                                !$isCurrentlyActive
                                                && $hasOtherProject
                                            )
                                                <x-ui.badge color="gray">
                                                    Project Lain
                                                </x-ui.badge>
                                            @elseif ($isSelected)
                                                <x-ui.badge color="green">
                                                    Dipilih
                                                </x-ui.badge>
                                            @else
                                                <x-ui.badge color="blue">
                                                    Tersedia
                                                </x-ui.badge>
                                            @endif
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <div
                            class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 py-10 text-center"
                        >
                            <p class="font-semibold text-gray-700">
                                Pekerja tidak ditemukan
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Belum tersedia Pekerja aktif atau kata
                                pencarian tidak sesuai.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Footer --}}
                <div
                    class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6"
                >
                    <div>
                        <p class="text-sm text-gray-500">
                            <span class="font-semibold text-gray-800">
                                {{ count($selectedWorkerIds) }}
                            </span>

                            Pekerja dipilih
                        </p>

                        @if ($hasChanges)
                            <p class="mt-1 text-xs font-medium text-blue-600">
                                Terdapat perubahan yang belum disimpan.
                            </p>
                        @else
                            <p class="mt-1 text-xs text-gray-400">
                                Belum ada perubahan.
                            </p>
                        @endif
                    </div>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row">
                        <button
                            type="button"
                            wire:click="closeModal"
                            wire:loading.attr="disabled"
                            wire:target="saveWorkers"
                            class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            Batal
                        </button>

                        <button
                            type="button"
                            wire:click="saveWorkers"
                            wire:loading.attr="disabled"
                            wire:target="saveWorkers"
                            @disabled(!$hasChanges)
                            @class([
                                'inline-flex min-h-11 items-center justify-center rounded-xl px-5 py-2.5 text-sm font-semibold transition focus:outline-none focus:ring-4',

                                'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-100' =>
                                    $hasChanges,

                                'cursor-not-allowed bg-gray-300 text-gray-500' =>
                                    !$hasChanges,
                            ])
                        >
                            <span
                                wire:loading.remove
                                wire:target="saveWorkers"
                            >
                                Simpan Perubahan
                            </span>

                            <span
                                wire:loading
                                wire:target="saveWorkers"
                            >
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>