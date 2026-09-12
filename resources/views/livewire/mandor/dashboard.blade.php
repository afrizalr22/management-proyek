<div class="space-y-6">
    {{-- Header --}}
    <x-mandor.dashboard-header
        :mandor="$mandor"
        :statistics="$statistics"
    />

    {{-- Statistik --}}
    <x-mandor.dashboard-statistics
        :statistics="$statistics"
    />

    {{-- Jadwal dan aktivitas --}}
    <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <x-mandor.today-schedule
                :tasks="$todayTasks"
            />
        </div>

        <div>
            <x-mandor.recent-activity
                :activities="$recentActivities"
            />
        </div>
    </div>

    {{-- Dokumentasi terbaru --}}
    <x-mandor.latest-documentation
        :documentations="$latestDocumentations"
    />
</div>