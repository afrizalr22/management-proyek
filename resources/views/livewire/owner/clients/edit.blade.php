<div class="min-h-full bg-slate-50">
    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="mb-4 flex items-center gap-2 text-sm text-slate-500">
            <a
                href="{{ route('owner.clients.index') }}"
                wire:navigate
                class="transition hover:text-blue-600"
            >
                Client
            </a>

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
                    d="m9 18 6-6-6-6"
                />
            </svg>

            <a
                href="{{ route('owner.clients.show', ['client' => $client->id]) }}"
                wire:navigate
                class="transition hover:text-blue-600"
            >
                {{ $client->company_name }}
            </a>

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
                    d="m9 18 6-6-6-6"
                />
            </svg>

            <span class="font-medium text-slate-700">
                Edit
            </span>
        </nav>

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                Ubah Data Client
            </h1>

            <p class="mt-2 text-sm text-slate-500 sm:text-base">
                Perbarui informasi client sesuai kebutuhan.
            </p>
        </div>

        @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            x-transition.opacity.duration.300ms
            class="mb-6 flex items-start justify-between gap-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
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

                <span>{{ session('success') }}</span>
            </div>

            <button
                type="button"
                @click="show = false"
                class="text-emerald-600 transition hover:text-emerald-800"
                aria-label="Tutup notifikasi"
            >
                &times;
            </button>
        </div>
    @endif

        {{-- Form --}}
        <form wire:submit="update">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
                    <h2 class="text-lg font-semibold text-slate-900">
                        Informasi Client
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Pastikan data client yang dimasukkan sudah benar.
                    </p>
                </div>

                <div class="px-5 py-6 sm:px-6">
                    <x-client.form :status="$status" />
                </div>

                {{-- Action --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                    <a
                        href="{{ route('owner.clients.index') }}"
                        wire:navigate
                        class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 focus:outline-none focus:ring-4 focus:ring-slate-200"
                    >
                        Batal
                    </a>    

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="update"
                        class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <span wire:loading.remove wire:target="update">
                            Simpan Perubahan
                        </span>

                        <span
                            wire:loading.flex
                            wire:target="update"
                            class="items-center gap-2"
                        >
                            <svg
                                class="h-4 w-4 animate-spin"
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
                                    d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"
                                ></path>
                            </svg>

                            Menyimpan...
                        </span>
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>