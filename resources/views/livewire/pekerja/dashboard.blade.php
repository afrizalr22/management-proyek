<div class="space-y-6">
    <x-pekerja.dashboard-header
        :worker="$worker"
        :active-projects="$activeProjects"
    />

    <x-pekerja.dashboard-statistics
        :statistics="$statistics"
    />

    <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <x-pekerja.priority-tasks
                :tasks="$priorityTasks"
            />
        </div>

        <div>
            <x-pekerja.recent-activity
                :activities="$recentActivities"
            />
        </div>
    </div>

    <x-pekerja.quick-actions />
</div>