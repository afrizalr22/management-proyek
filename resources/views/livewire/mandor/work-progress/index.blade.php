<div class="space-y-6">

    {{-- Page Header --}}
    <x-mandor.work-progress.page-header />

    {{-- Progress Overview --}}
    <div class="grid grid-cols-1 items-stretch gap-6 xl:grid-cols-3">

        <div class="xl:col-span-1">
            <x-mandor.work-progress.overall-completion />
        </div>

        <div class="xl:col-span-2">
            <x-mandor.work-progress.project-timeline />
        </div>

    </div>

    {{-- Work Status Board --}}
    <x-mandor.work-progress.work-status-board />

</div>