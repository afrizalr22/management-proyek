<div class="space-y-6">
    {{-- Header dashboard --}}
    <x-pekerja.dashboard-header />

    {{-- Statistik --}}
    <x-pekerja.dashboard-statistics />

    {{-- Tugas dan aktivitas --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <x-pekerja.priority-tasks />
        </div>

        <div>
            <x-pekerja.recent-activity />
        </div>
    </div>

    {{-- Aksi cepat --}}
    <x-pekerja.quick-actions />
</div>