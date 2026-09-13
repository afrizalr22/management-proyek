@props([
    'tasks',
])

<section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div>
            <h2 class="text-lg font-bold text-slate-900">
                Daftar Task
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Ditemukan {{ $tasks->total() }} task yang sesuai.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
            <span class="inline-flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-slate-400"></span>
                Belum dimulai
            </span>

            <span class="inline-flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                Diproses
            </span>

            <span class="inline-flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                Selesai
            </span>
        </div>
    </div>

    @if ($tasks->isEmpty())
        <div class="px-6 py-14 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.7"
                    stroke="currentColor"
                    class="h-7 w-7"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m4.5 12.75 6 6 9-13.5"
                    />
                </svg>
            </div>

            <h3 class="mt-4 font-semibold text-slate-900">
                Task Tidak Ditemukan
            </h3>

            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                Belum ada task atau tidak ada data yang sesuai dengan filter.
            </p>

            <button
                type="button"
                wire:click="resetFilters"
                class="mt-5 inline-flex min-h-10 items-center justify-center rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
            >
                Reset Filter
            </button>
        </div>
    @else
        <div class="hidden grid-cols-[minmax(0,2fr)_minmax(140px,1fr)_minmax(145px,1fr)_115px_135px_150px] items-center gap-5 bg-slate-50 px-6 py-4 text-sm font-semibold text-slate-600 lg:grid">
            <span>Detail Task</span>
            <span>Lokasi</span>
            <span>Deadline</span>
            <span>Prioritas</span>
            <span>Status</span>
            <span class="text-center">Aksi</span>
        </div>

        <div class="divide-y divide-slate-100">
            @foreach ($tasks as $task)
                <x-pekerja.task.task-row
                    :task="$task"
                    wire:key="worker-task-{{ $task->id }}"
                />
            @endforeach
        </div>

        <x-pekerja.task.task-pagination
            :tasks="$tasks"
        />
    @endif
</section>