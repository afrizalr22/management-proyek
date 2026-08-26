<div class="space-y-6">

    <x-mandor.projects.detail-header />

    <x-mandor.projects.summary-cards />

    <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-3">

        {{-- Kolom Kiri --}}
        <div class="space-y-6 xl:col-span-2">

            <x-mandor.projects.progress-timeline />

            <x-mandor.projects.assigned-team />

            {{-- Dibuat pada langkah berikutnya --}}
            <x-mandor.projects.project-documentation />

        </div>

        {{-- Kolom Kanan --}}
        <div class="space-y-6">

            <x-mandor.projects.project-information />

            <x-mandor.projects.recent-daily-reports />

        </div>

    </div>

</div>