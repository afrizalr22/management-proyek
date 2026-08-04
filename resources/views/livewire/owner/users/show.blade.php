<div class="space-y-6">

    <x-user.user-show-header />

    {{-- Information + Statistics --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">

        <div class="xl:col-span-8">

            <x-user.user-information-card />

        </div>

        <div class="xl:col-span-4">

            <x-user.user-statistics />

        </div>

    </div>

    {{-- Project History + Recent Activity --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">

        <div class="xl:col-span-8">

            <x-user.user-project-history />

        </div>

        <div class="xl:col-span-4">

            <x-user.user-recent-activity />

        </div>

    </div>

</div>