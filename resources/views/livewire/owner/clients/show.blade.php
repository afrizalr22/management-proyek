<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500">
        <a
            href="{{ route('owner.clients.index') }}"
            wire:navigate
            class="hover:text-blue-600"
        >
            Clients
        </a>

        <span class="mx-2">/</span>

        <span class="font-medium text-gray-700">
            {{ $client->contact_person }}
        </span>
    </div>

    {{-- Header --}}
    <x-ui.page-header
        title="Detail Client"
        description="Informasi lengkap Client dan ringkasan Project."
    >
        <x-slot:actions>
            <div class="flex flex-wrap items-center gap-3">

                {{-- Batal --}}
                <a
                    href="{{ route('owner.clients.index') }}"
                    wire:navigate
                    class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-gray-400 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2"
                >
                    Batal
                </a>


                {{-- Ubah Data --}}
                <a
                    href="{{ route(
                        'owner.clients.edit',
                        ['client' => $client->id]
                    ) }}"
                    wire:navigate
                    class="inline-flex h-11 items-center justify-center rounded-xl bg-blue-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="mr-2 h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931ZM16.862 4.487 19.5 7.125"
                        />
                    </svg>

                    Ubah Data
                </a>

            </div>
        </x-slot:actions>
    </x-ui.page-header>
        @if (session()->has('error'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 5000)"
            x-show="show"
            x-transition.opacity.duration.300ms
            class="mb-6 flex items-start justify-between gap-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
            role="alert"
        >
            <span>{{ session('error') }}</span>

            <button
                type="button"
                @click="show = false"
                class="text-lg leading-none text-red-600 hover:text-red-800"
                aria-label="Tutup notifikasi"
            >
                &times;
            </button>
        </div>
    @endif

    {{-- Informasi Client --}}
    <x-client.detail-information
        :client="$client"
    />

    {{-- Project terbaru --}}
    <x-client.recent-project
        :projects="$recentProjects"
    />

</div>