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
      @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            x-cloak
            class="flex items-start justify-between gap-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
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
                    {{ session('success') }}
                </span>
            </div>

            <button
                type="button"
                @click="show = false"
                class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-md text-emerald-600 transition hover:bg-emerald-100 hover:text-emerald-800"
                aria-label="Tutup notifikasi"
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
        </div>
    @endif

    <x-client.toolbar
        :search="$search"
        :status="$status"
        :sort="$sort"
    />

    <x-client.table :clients="$clients" />

    <x-client.pagination :clients="$clients" />

    <livewire:owner.clients.delete />

</div>