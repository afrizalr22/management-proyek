<div class="space-y-6">
    <x-pekerja.documentation.create.page-header />

    <form
        wire:submit="save"
        novalidate
    >
        <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2">
                <x-pekerja.documentation.create.documentation-form
                    :available-tasks="$availableTasks"
                    :photos="$photos"
                    :project-name="$projectName"
                    :task-location="$taskLocation"
                    :description="$description"
                />
            </div>

            <div>
                <x-pekerja.documentation.create.recent-uploads
                    :uploads="$recentUploads"
                />
            </div>
        </div>
    </form>
</div>