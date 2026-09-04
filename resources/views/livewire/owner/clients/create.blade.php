<form
    wire:submit="save"
    class="space-y-6"
>
    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500">
        <a
            href="{{ route('owner.dashboard') }}"
            wire:navigate
            class="hover:text-blue-600"
        >
            Dashboard
        </a>

        <span class="mx-2">/</span>

        <a
            href="{{ route('owner.clients.index') }}"
            wire:navigate
            class="hover:text-blue-600"
        >
            Clients
        </a>

        <span class="mx-2">/</span>

        <span class="font-medium text-blue-600">
            Tambah Client
        </span>
    </div>

    {{-- Header --}}
    <x-ui.page-header
        :title="$pageTitle"
        :description="$pageDescription"
    />

    {{-- Ringkasan error --}}
    @if ($errors->any())
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-5 py-4"
            role="alert"
        >
            <p class="font-semibold text-red-700">
                Data Client belum dapat disimpan.
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Client --}}
    <x-client.form :status="$status" />

    {{-- Informasi --}}
    <x-client.information />

    {{-- Tombol aksi --}}
    <div
        class="flex flex-col-reverse gap-3 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-end"
    >
        <a
            href="{{ route('owner.clients.index') }}"
            wire:navigate
            class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-gray-400 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2"
        >
            Batal
        </a>

        <button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="save"
            class="inline-flex h-11 min-w-40 items-center justify-center rounded-xl bg-blue-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60"
        >
            <span
                wire:loading.remove
                wire:target="save"
                class="inline-flex items-center gap-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15"
                    />
                </svg>

                Tambah Client
            </span>

            <span
                wire:loading
                wire:target="save"
                class="inline-flex items-center gap-2"
            >
                <svg
                    class="h-5 w-5 animate-spin"
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

                Menyimpan...
            </span>
        </button>
    </div>
</form>