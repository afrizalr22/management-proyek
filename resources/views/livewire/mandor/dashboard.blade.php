<div class="space-y-6">

    {{-- Dashboard Header --}}
    <x-mandor.dashboard-header />

    {{-- Dashboard Statistics --}}
    <x-mandor.dashboard-statistics />

    {{-- Schedule & Activity --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Today's Schedule --}}
        <div class="xl:col-span-2">

            <x-mandor.today-schedule />

        </div>

        {{-- Recent Activity --}}
        <div>

            <x-mandor.recent-activity />

        </div>

    </div>

    {{-- Latest Documentation --}}
    <x-mandor.latest-documentation />

</div>