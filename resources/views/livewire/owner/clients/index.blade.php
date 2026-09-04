<div class="space-y-6">

    <x-ui.page-header
        title="Client Management"
        description="Kelola seluruh data client perusahaan."
    >
        <x-slot:actions>
            <a
                href="{{ route('owner.clients.create') }}"
                wire:navigate
            >
                <x-ui.button>
                    Tambah Client
                </x-ui.button>
            </a>
        </x-slot:actions>
        </x-ui.page-header>
    @if (session()->has('notification'))
    @php
        $notification = session('notification');

        $notificationStyles = match ($notification['type'] ?? 'create') {
            'create' => [
                'wrapper' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                'button' => 'text-emerald-600 hover:text-emerald-800',
            ],
            'update' => [
                'wrapper' => 'border-blue-200 bg-blue-50 text-blue-700',
                'button' => 'text-blue-600 hover:text-blue-800',
            ],
            'delete' => [
                'wrapper' => 'border-red-200 bg-red-50 text-red-700',
                'button' => 'text-red-600 hover:text-red-800',
            ],
            'error' => [
                'wrapper' => 'border-amber-200 bg-amber-50 text-amber-800',
                'button' => 'text-amber-600 hover:text-amber-900',
            ],
            default => [
                'wrapper' => 'border-slate-200 bg-slate-50 text-slate-700',
                'button' => 'text-slate-600 hover:text-slate-800',
            ],
        };
    @endphp

    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition.opacity.duration.300ms
        class="mb-6 flex items-start justify-between gap-4 rounded-xl border px-4 py-3 text-sm {{ $notificationStyles['wrapper'] }}"
        role="alert"
    >
        <div class="flex items-start gap-3">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
                class="mt-0.5 h-5 w-5 shrink-0"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m4.5 12.75 6 6 9-13.5"
                />
            </svg>

            <span>
                {{ $notification['message'] ?? '' }}
            </span>
        </div>

        <button
            type="button"
            @click="show = false"
            class="text-lg leading-none transition {{ $notificationStyles['button'] }}"
            aria-label="Tutup notifikasi"
        >
            &times;
        </button>
    </div>
@endif

    <x-client.toolbar
        :search="$search"
        :status="$status"
        :sort="$sort"
    />

    <x-client.table :clients="$clients" />
    <x-client.pagination :clients="$clients" />
    @if ($showDeleteModal)
    <div
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
        aria-labelledby="delete-client-title"
    >
        {{-- Backdrop --}}
        <button
            type="button"
            wire:click="cancelDelete"
            class="absolute inset-0 cursor-default bg-slate-900/50 backdrop-blur-sm"
            aria-label="Tutup modal"
        ></button>

        {{-- Modal --}}
        <div class="relative z-10 w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="flex items-start gap-4 border-b border-slate-200 px-5 py-5 sm:px-6">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
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
                            d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H4.645c-1.73 0-2.813-1.874-1.948-3.374L10.052 3.38c.865-1.5 3.03-1.5 3.896 0l7.355 12.746ZM12 15.75h.008v.008H12v-.008Z"
                        />
                    </svg>
                </div>

                <div class="min-w-0">
                    <h2
                        id="delete-client-title"
                        class="text-lg font-semibold text-slate-900"
                    >
                        Hapus Client
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-slate-500">
                        Periksa kembali data sebelum melakukan penghapusan.
                    </p>
                </div>
            </div>

            <div class="space-y-5 px-5 py-6 sm:px-6">
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Client yang dipilih
                    </p>

                    <p class="mt-1 text-base font-semibold text-slate-900">
                        {{ $selectedClientName }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-xs text-slate-500">
                            Quotation
                        </p>

                        <p class="mt-1 text-xl font-bold text-slate-900">
                            {{ $selectedQuotationsCount }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-xs text-slate-500">
                            Proyek
                        </p>

                        <p class="mt-1 text-xl font-bold text-slate-900">
                            {{ $selectedProjectsCount }}
                        </p>
                    </div>
                </div>

                @if (
                    $selectedProjectsCount > 0 ||
                    $selectedQuotationsCount > 0
                )
                    <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm leading-6 text-amber-800">
                        Client tidak dapat dihapus karena sudah mempunyai
                        quotation atau proyek. Data harus dipertahankan untuk
                        menjaga riwayat transaksi.
                    </div>
                @else
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm leading-6 text-red-700">
                        Apakah Anda yakin ingin menghapus client ini? Data yang
                        telah dihapus tidak dapat dikembalikan.
                    </div>
                @endif
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button
                    type="button"
                    wire:click="cancelDelete"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                >
                    Batal
                </button>

                <button
                    type="button"
                    wire:click="deleteClient"
                    wire:loading.attr="disabled"
                    wire:target="deleteClient"
                    @disabled(
                        $selectedProjectsCount > 0 ||
                        $selectedQuotationsCount > 0
                    )
                    class="inline-flex min-h-11 items-center justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 disabled:cursor-not-allowed disabled:bg-slate-300 disabled:text-slate-500"
                >
                    <span wire:loading.remove wire:target="deleteClient">
                        Hapus Client
                    </span>

                    <span wire:loading wire:target="deleteClient">
                        Menghapus...
                    </span>
                </button>
            </div>
        </div>
    </div>
@endif

</div>