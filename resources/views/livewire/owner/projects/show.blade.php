<div class="space-y-6">
    {{-- Breadcrumb --}}
    <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
        <a
            href="{{ route('owner.projects.index') }}"
            wire:navigate
            class="transition hover:text-blue-600"
        >
            Project
        </a>

        <span>/</span>

        <span class="font-medium text-gray-700">
            {{ $project->project_code }}
        </span>
    </nav>

    {{-- Header --}}
    <x-ui.page-header
        :title="$project->project_name"
        :description="'Detail Project '.$project->project_code"
    >
        <x-slot:actions>
            <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
                <a
                    href="{{ route('owner.projects.index') }}"
                    wire:navigate
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100"
                >
                    Kembali
                </a>

                @if (
                    $project->status !== 'completed'
                    && $project->status !== 'cancelled'
                )
                    <a
                        href="{{ route('owner.projects.edit', [
                            'project' => $project->id,
                        ]) }}"
                        wire:navigate
                        class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
                    >
                        Edit Project
                    </a>
                @else
                    <button
                        type="button"
                        disabled
                        class="inline-flex min-h-11 cursor-not-allowed items-center justify-center rounded-xl bg-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-500"
                    >
                        Edit Project
                    </button>
                @endif
            </div>
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
                    ?? 'Data Project berhasil diperbarui.' }}
            </span>

            <button
                type="button"
                @click="show = false"
                class="shrink-0 text-lg leading-none opacity-70 transition hover:opacity-100"
                aria-label="Tutup notifikasi"
            >
                &times;
            </button>
        </div>
    @endif

    {{-- Status Project --}}
    <section
        class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between"
    >
        <div>
            <div class="flex flex-wrap items-center gap-3">
                <h2 class="font-semibold text-gray-900">
                    Status Project
                </h2>

                <x-ui.badge :color="$statusColor">
                    {{ $statusText }}
                </x-ui.badge>
            </div>

            <p class="mt-2 text-sm text-gray-500">
                Progres Project dihitung dari pekerjaan dan laporan yang telah divalidasi Mandor.
            </p>
        </div>

        <div class="text-left sm:text-right">
            <p class="text-sm text-gray-500">
                Progres
            </p>

            <p class="mt-1 text-2xl font-bold text-blue-600">
                {{ min(100, max(0, (int) $project->progress)) }}%
            </p>
        </div>
    </section>

    {{-- Informasi utama --}}
    {{-- Konten detail Project --}}
<div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-3">
    {{-- Konten utama --}}
    <main class="min-w-0 space-y-6 xl:col-span-2">
        {{-- Informasi Project --}}
        <x-project.project-information
            :project="$project"
            :source-quotation="$sourceQuotation"
            :status-text="$statusText"
            :status-color="$statusColor"
        />

        {{-- Progres Project --}}
        <x-project.project-progress
            :project="$project"
        />

        {{-- Deskripsi dan ruang lingkup --}}
        <x-project.project-description
            :project="$project"
            :source-quotation="$sourceQuotation"
        />

        {{-- Aktivitas terbaru --}}
        <x-project.project-activity
            :project="$project"
            :activities="$activities"
        />
    </main>

    {{-- Sidebar ringkasan --}}
    <aside class="min-w-0 xl:sticky xl:top-6">
        <x-project.project-summary
            :project="$project"
            :source-quotation="$sourceQuotation"
            :status-text="$statusText"
            :status-color="$statusColor"
        />
    </aside>
</div>
</div>