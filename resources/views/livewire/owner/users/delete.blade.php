<div>
    @if ($showModal && $user)
        @php
            $role = $user->roles->first()?->name ?? '-';

            $roleText = match ($role) {
                'owner' => 'Owner',
                'mandor' => 'Mandor',
                'pekerja' => 'Pekerja',
                default => '-',
            };

            $roleColor = match ($role) {
                'owner' => 'red',
                'mandor' => 'blue',
                'pekerja' => 'green',
                default => 'gray',
            };

            $statusText = $user->status === 'active'
                ? 'Aktif'
                : 'Tidak Aktif';

            $statusColor = $user->status === 'active'
                ? 'green'
                : 'red';

            $canDelete = count($blockers) === 0;
        @endphp

        <div
            wire:key="delete-user-modal-{{ $user->id }}"
            wire:keydown.escape.window="closeModal"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4"
            role="dialog"
            aria-modal="true"
            aria-labelledby="delete-user-title"
        >
            {{-- Overlay --}}
            <button
                type="button"
                wire:click="closeModal"
                wire:loading.attr="disabled"
                wire:target="deleteUser"
                class="absolute inset-0 h-full w-full cursor-default bg-gray-950/50 backdrop-blur-sm"
                aria-label="Tutup modal"
            ></button>

            {{-- Modal --}}
            <div class="relative z-10 flex max-h-[90vh] w-full max-w-xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">
                {{-- Header --}}
                <div class="border-b border-gray-200 px-5 py-5 sm:px-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2
                                id="delete-user-title"
                                class="text-xl font-bold text-gray-900"
                            >
                                Hapus Pengguna
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Periksa keterkaitan data sebelum menghapus pengguna.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="closeModal"
                            wire:loading.attr="disabled"
                            wire:target="deleteUser"
                            class="text-2xl leading-none text-gray-400 transition hover:text-gray-600 disabled:opacity-50"
                            aria-label="Tutup modal"
                        >
                            &times;
                        </button>
                    </div>
                </div>

                {{-- Body --}}
                <div class="min-h-0 flex-1 space-y-5 overflow-y-auto p-5 sm:p-6">
                    @error('delete')
                        <div
                            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
                            role="alert"
                        >
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- Data pengguna --}}
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">
                        <dl class="space-y-4">
                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Nama
                                </dt>

                                <dd class="break-words text-right font-semibold text-gray-900">
                                    {{ $user->name }}
                                </dd>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Email
                                </dt>

                                <dd class="break-all text-right text-sm font-medium text-gray-800">
                                    {{ $user->email }}
                                </dd>
                            </div>

                            <div class="flex items-center justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Role
                                </dt>

                                <dd>
                                    <x-ui.badge :color="$roleColor">
                                        {{ $roleText }}
                                    </x-ui.badge>
                                </dd>
                            </div>

                            <div class="flex items-center justify-between gap-4">
                                <dt class="text-sm text-gray-500">
                                    Status
                                </dt>

                                <dd>
                                    <x-ui.badge :color="$statusColor">
                                        {{ $statusText }}
                                    </x-ui.badge>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    @if ($canDelete)
                        {{-- Dapat dihapus --}}
                        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                            <div class="flex items-start gap-3">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="mt-0.5 h-5 w-5 shrink-0 text-red-600"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 4.5h.008v.008H12V16.5Z"
                                    />
                                </svg>

                                <div>
                                    <p class="font-semibold text-red-700">
                                        Pengguna dapat dihapus
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-red-600">
                                        Akun ini tidak mempunyai data yang terhubung.
                                        Tindakan penghapusan tidak dapat dibatalkan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Tidak dapat dihapus --}}
                        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                            <p class="font-semibold text-amber-800">
                                Pengguna tidak dapat dihapus
                            </p>

                            <p class="mt-1 text-sm text-amber-700">
                                Ditemukan data yang harus dipertahankan:
                            </p>

                            <div class="mt-4 space-y-3">
                                @foreach ($blockers as $blocker)
                                    <div class="rounded-xl border border-amber-200 bg-white px-4 py-3">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-800">
                                                    {{ $blocker['label'] }}
                                                </p>

                                                <p class="mt-1 text-xs leading-5 text-gray-500">
                                                    {{ $blocker['description'] }}
                                                </p>
                                            </div>

                                            <span class="shrink-0 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-bold text-amber-700">
                                                {{ $blocker['count'] }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                    <button
                        type="button"
                        wire:click="closeModal"
                        wire:loading.attr="disabled"
                        wire:target="deleteUser"
                        class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        Batal
                    </button>

                    <button
                        type="button"
                        wire:click="deleteUser"
                        wire:loading.attr="disabled"
                        wire:target="deleteUser"
                        @disabled(!$canDelete)
                        @class([
                            'inline-flex min-h-11 items-center justify-center rounded-xl px-5 py-2.5 text-sm font-semibold text-white transition',
                            'bg-red-600 hover:bg-red-700' => $canDelete,
                            'cursor-not-allowed bg-gray-300' => !$canDelete,
                        ])
                    >
                        <span
                            wire:loading.remove
                            wire:target="deleteUser"
                        >
                            Hapus Pengguna
                        </span>

                        <span
                            wire:loading
                            wire:target="deleteUser"
                        >
                            Menghapus...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>