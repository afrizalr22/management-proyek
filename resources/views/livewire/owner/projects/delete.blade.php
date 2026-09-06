<div>
    @if ($showModal && $project)
        @php
            $statusText = match ($project->status) {
                'planning' => 'Perencanaan',
                'on_progress' => 'Sedang Berjalan',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
                default => 'Tidak Diketahui',
            };

            $statusColor = match ($project->status) {
                'planning' => 'yellow',
                'on_progress' => 'blue',
                'completed' => 'green',
                'cancelled' => 'red',
                default => 'gray',
            };

            $blockingData = collect([
                'Pekerja' =>
                    (int) ($project->workers_count ?? 0),

                'Tugas' =>
                    (int) ($project->tasks_count ?? 0),

                'Riwayat progres' =>
                    (int) ($project->progresses_count ?? 0),

                'Laporan harian' =>
                    (int) ($project->daily_reports_count ?? 0),

                'Dokumentasi' =>
                    (int) ($project->documentations_count ?? 0),

                'Invoice' =>
                    (int) ($project->invoices_count ?? 0),

                'Surat jalan' =>
                    (int) ($project->delivery_orders_count ?? 0),
            ])->filter(
                fn (int $count): bool => $count > 0
            );

            $canDelete =
                $project->status === 'planning'
                && $blockingData->isEmpty();
        @endphp

        <div
            wire:key="delete-project-modal-{{ $project->id }}"
            wire:keydown.escape.window="closeModal"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4"
            role="dialog"
            aria-modal="true"
            aria-labelledby="delete-project-title"
        >
            {{-- Overlay --}}
            <button
                type="button"
                wire:click="closeModal"
                wire:loading.attr="disabled"
                wire:target="deleteProject"
                class="absolute inset-0 h-full w-full cursor-default bg-gray-950/50 backdrop-blur-sm"
                aria-label="Tutup modal"
            ></button>

            {{-- Modal --}}
            <div
                class="relative z-10 max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-2xl bg-white shadow-2xl"
            >
                {{-- Header --}}
                <div class="border-b border-gray-200 px-5 py-5 sm:px-6">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600"
                        >
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
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0V4.477c0-1.08-.834-1.977-1.913-2.01a69.697 69.697 0 0 0-3.674 0A2.063 2.063 0 0 0 8.25 4.477v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                />
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <h2
                                id="delete-project-title"
                                class="text-lg font-bold text-gray-900"
                            >
                                Hapus Project?
                            </h2>

                            <p class="mt-1 text-sm leading-6 text-gray-500">
                                Periksa kondisi Project sebelum melanjutkan penghapusan.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Body --}}
                <div class="space-y-5 p-5 sm:p-6">
                    {{-- Informasi Project --}}
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                    Project
                                </dt>

                                <dd class="mt-1 break-words font-semibold text-gray-900">
                                    {{ $project->project_name }}
                                </dd>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $project->project_code }}
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                        Client
                                    </dt>

                                    <dd class="mt-1 break-words text-sm font-semibold text-gray-800">
                                        {{ $project->client?->company_name
                                            ?? '-' }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                        Mandor
                                    </dt>

                                    <dd class="mt-1 break-words text-sm font-semibold text-gray-800">
                                        {{ $project->mandor?->name
                                            ?? '-' }}
                                    </dd>
                                </div>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                    Status
                                </dt>

                                <dd class="mt-2">
                                    <x-ui.badge :color="$statusColor">
                                        {{ $statusText }}
                                    </x-ui.badge>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    @if ($canDelete)
                        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                            <p class="font-semibold text-red-800">
                                Project dapat dihapus
                            </p>

                            <p class="mt-1 text-sm leading-6 text-red-700">
                                Project masih dalam tahap Perencanaan dan belum memiliki data operasional. Quotation sumber tidak akan dihapus dan dapat digunakan kembali.
                            </p>
                        </div>
                    @else
                        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                            <p class="font-semibold text-amber-800">
                                Project tidak dapat dihapus
                            </p>

                            @if ($project->status !== 'planning')
                                <p class="mt-1 text-sm leading-6 text-amber-700">
                                    Hanya Project berstatus Perencanaan yang dapat dihapus.
                                </p>
                            @endif

                            @if ($blockingData->isNotEmpty())
                                <p class="mt-3 text-sm font-medium text-amber-800">
                                    Data yang masih terhubung:
                                </p>

                                <ul class="mt-2 space-y-1 text-sm text-amber-700">
                                    @foreach ($blockingData as $label => $count)
                                        <li>
                                            {{ $label }}: {{ $count }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif

                    @error('delete')
                        <div
                            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
                            role="alert"
                        >
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Footer --}}
                <div
                    class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-6"
                >
                    <button
                        type="button"
                        wire:click="closeModal"
                        wire:loading.attr="disabled"
                        wire:target="deleteProject"
                        class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        Batal
                    </button>

                    <button
                        type="button"
                        wire:click="deleteProject"
                        wire:loading.attr="disabled"
                        wire:target="deleteProject"
                        @disabled(!$canDelete)
                        class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 disabled:cursor-not-allowed disabled:bg-gray-300 disabled:text-gray-500"
                    >
                        <span
                            wire:loading.remove
                            wire:target="deleteProject"
                        >
                            Hapus Project
                        </span>

                        <span
                            wire:loading
                            wire:target="deleteProject"
                        >
                            Menghapus...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>