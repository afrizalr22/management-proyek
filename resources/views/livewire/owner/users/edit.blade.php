<div class="space-y-6">

    <x-user.user-edit-header />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        <div class="space-y-6 xl:col-span-2">

            {{-- Informasi User --}}
            <x-user.user-identity-form />

            {{-- Role --}}
            <x-user.user-role-form />

            {{-- Password --}}
            <x-user.user-password-form />

            {{-- Sprint 13.3.4 --}}
            {{-- <x-user.user-project-assignment /> --}}

        </div>

        <div class="space-y-6">

            <x-user.user-summary />

            <x-user.user-security-action />

        </div>

    </div>

</div>