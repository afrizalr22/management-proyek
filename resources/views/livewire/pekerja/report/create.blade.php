<div class="space-y-6">
    <x-pekerja.report.create.page-header />

    <div class="space-y-6">
        @error('submit')
            <div
                class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                role="alert"
            >
                {{ $message }}
            </div>
        @enderror

        @if ($availableTasks->isEmpty())
            <div
                class="rounded-xl border border-amber-200 bg-amber-50 px-5 py-4"
                role="status"
            >
                <p class="font-semibold text-amber-900">
                    Belum ada Task yang dapat dilaporkan
                </p>

                <p class="mt-1 text-sm leading-6 text-amber-800">
                    Mulai Task yang telah diberikan terlebih dahulu. Task yang
                    sedang menunggu pemeriksaan atau revisi tidak dapat dibuatkan
                    laporan baru.
                </p>

                <a
                    href="{{ route('pekerja.task.index') }}"
                    wire:navigate
                    class="mt-3 inline-flex text-sm font-semibold text-amber-900 underline decoration-amber-400 underline-offset-4"
                >
                    Buka daftar Task
                </a>
            </div>
        @endif

        <x-pekerja.report.create.report-information
            :available-tasks="$availableTasks"
            :report-date="$reportDate"
            :project-name="$projectName"
            :task-location="$taskLocation"
        />

        <x-pekerja.report.create.work-result
            :activities="$activities"
            :work-status="$workStatus"
            :reported-progress="$reportedProgress"
            :current-task-progress="$currentTaskProgress"
        />

        <x-pekerja.report.create.obstacle-notes
            :obstacles="$obstacles"
            :notes="$notes"
        />

        <x-pekerja.report.create.documentation-upload
            :photos="$photos"
        />

        <x-pekerja.report.create.form-actions
            :disabled="$availableTasks->isEmpty()"
        />
    </div>
</div>