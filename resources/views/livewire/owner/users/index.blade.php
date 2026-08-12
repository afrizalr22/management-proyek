<div class="space-y-6">

    <div>

        <div class="space-y-6">

            {{-- Header --}}
            <x-user.user-header />

            {{-- Filter --}}
            <x-user.user-filter />

            {{-- User Table --}}
            <x-user.user-table />

            {{-- Delete Modal --}}
            <livewire:owner.users.delete />

            {{-- Pagination --}}
            <x-user.user-pagination />

        </div>

    </div>
</div>