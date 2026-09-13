<div class="space-y-6">

    @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            x-transition
            class="flex items-start justify-between gap-4 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700"
            role="alert"
        >
            <div class="flex items-start gap-3">
                <svg
                    class="mt-0.5 h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                    />
                </svg>

                <p class="font-medium">
                    {{ session('success') }}
                </p>
            </div>

            <button
                type="button"
                x-on:click="show = false"
                class="shrink-0 rounded-lg p-1 transition hover:bg-emerald-100"
                aria-label="Tutup notifikasi"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 6l12 12M18 6L6 18"
                    />
                </svg>
            </button>
        </div>
    @endif

    <x-mandor.work-progress.page-header
        :project="$project"
        :active-worker-count="$activeWorkers->count()"
    />

    <div class="grid grid-cols-1 items-stretch gap-6 xl:grid-cols-3">
        <div class="xl:col-span-1">
            <x-mandor.work-progress.overall-completion
                :actual-progress="$actualProgress"
                :planned-progress="$plannedProgress"
                :progress-variance="$progressVariance"
                :task-statistics="$taskStatistics"
            />
        </div>

        <div class="xl:col-span-2">
            <x-mandor.work-progress.project-timeline
                :tasks="$tasks"
                :project="$project"
            />
        </div>
    </div>

    <x-mandor.work-progress.work-status-board
        :assigned-tasks="$assignedTasks"
        :active-tasks="$activeTasks"
        :completed-tasks="$completedTasks"
        :cancelled-tasks="$cancelledTasks"
    />

    @if ($showTaskForm)
        <x-mandor.work-progress.task-form-modal
            :active-workers="$activeWorkers"
        />
    @endif

</div>