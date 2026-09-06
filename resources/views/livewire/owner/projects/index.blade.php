<div class="space-y-6">
    <x-ui.page-header
        title="Project Management"
        description="Pantau seluruh Project, penanggung jawab, jadwal, dan progres pekerjaan."
    >
        <x-slot:actions>
            <a
                href="{{ route('owner.projects.create') }}"
                wire:navigate
            >
                <x-ui.button>
                    Buat dari Quotation
                </x-ui.button>
            </a>
        </x-slot:actions>
    </x-ui.page-header>

    {{-- Notifikasi --}}
    @if (session()->has('notification'))
        @php
            $notification = session('notification');

            $notificationType =
                $notification['type'] ?? 'success';

            $notificationClasses = match ($notificationType) {
                'create', 'success' =>
                    'border-green-200 bg-green-50 text-green-700',

                'update' =>
                    'border-blue-200 bg-blue-50 text-blue-700',

                'delete' =>
                    'border-red-200 bg-red-50 text-red-700',

                'error' =>
                    'border-amber-200 bg-amber-50 text-amber-700',

                default =>
                    'border-gray-200 bg-gray-50 text-gray-700',
            };

            $closeButtonClasses = match ($notificationType) {
                'create', 'success' =>
                    'text-green-500 hover:text-green-700',

                'update' =>
                    'text-blue-500 hover:text-blue-700',

                'delete' =>
                    'text-red-500 hover:text-red-700',

                'error' =>
                    'text-amber-500 hover:text-amber-700',

                default =>
                    'text-gray-500 hover:text-gray-700',
            };
        @endphp

        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            x-transition.opacity.duration.300ms
            class="flex items-start justify-between gap-4 rounded-xl border px-4 py-3 text-sm {{ $notificationClasses }}"
            role="alert"
        >
            <span>
                {{ $notification['message']
                    ?? 'Proses Project berhasil dilakukan.' }}
            </span>

            <button
                type="button"
                @click="show = false"
                class="shrink-0 text-lg leading-none transition {{ $closeButtonClasses }}"
                aria-label="Tutup notifikasi"
            >
                &times;
            </button>
        </div>
    @endif

    {{-- Statistik Project --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">
                Total Project
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-900">
                {{ $statistics['total'] }}
            </p>
        </div>

        <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5">
            <p class="text-sm font-medium text-yellow-700">
                Perencanaan
            </p>

            <p class="mt-2 text-3xl font-bold text-yellow-800">
                {{ $statistics['planning'] }}
            </p>
        </div>

        <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5">
            <p class="text-sm font-medium text-blue-700">
                Sedang Berjalan
            </p>

            <p class="mt-2 text-3xl font-bold text-blue-800">
                {{ $statistics['on_progress'] }}
            </p>
        </div>

        <div class="rounded-2xl border border-orange-200 bg-orange-50 p-5">
            <p class="text-sm font-medium text-orange-700">
                Hampir Selesai
            </p>

            <p class="mt-2 text-3xl font-bold text-orange-800">
                {{ $statistics['nearly_completed'] }}
            </p>
        </div>

        <div class="rounded-2xl border border-green-200 bg-green-50 p-5">
            <p class="text-sm font-medium text-green-700">
                Selesai
            </p>

            <p class="mt-2 text-3xl font-bold text-green-800">
                {{ $statistics['completed'] }}
            </p>
        </div>
    </div>

    <x-project.toolbar
        :search="$search"
        :status="$status"
        :sort="$sort"
    />

<x-project.grid
    :projects="$projects"
    :search="$search"
    :status="$status"
    :sort="$sort"
/>

    @if ($projects->hasPages())
        <div class="rounded-2xl border border-gray-200 bg-white px-5 py-4">
            {{ $projects->links() }}
        </div>
    @endif

    <livewire:owner.projects.delete />

</div>

