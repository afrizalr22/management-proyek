<div class="space-y-6">

    <x-user.user-create-header />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Left Content --}}
        <div class="space-y-6 xl:col-span-2">

            <x-user.user-identity-form />

            <x-user.user-role-form />

            <x-user.user-password-form />

        </div>

        {{-- Right Sidebar --}}
        <div class="space-y-6">

            <x-user.user-security-guide />

            <x-user.user-profile-preview />

        </div>

    </div>

</div>