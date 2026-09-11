@php
    $authenticatedUser = auth()->user();

    $photoUrl = filled($authenticatedUser?->photo)
        ? \Illuminate\Support\Facades\Storage::url(
            $authenticatedUser->photo
        )
        : '';

    $roleName = $authenticatedUser
        ?->roles
        ->first()
        ?->name;

    $roleLabel = match ($roleName) {
        'owner' => 'Owner',
        'mandor' => 'Mandor',
        'pekerja' => 'Pekerja',
        default => ucfirst(
            $roleName ?? 'Pengguna'
        ),
    };

    $profileRoute = match ($roleName) {
        'owner' => route('owner.profile'),
        default => null,
    };

    /*
     * Menentukan konteks halaman berdasarkan route
     * yang sedang dibuka.
     */
    [$sectionLabel, $pageLabel] = match (true) {
        request()->routeIs('owner.dashboard') => [
            'Utama',
            'Dashboard',
        ],

        request()->routeIs('owner.clients.*') => [
            'Penjualan',
            'Client',
        ],

        request()->routeIs('owner.quotations.*') => [
            'Penjualan',
            'Quotation',
        ],

        request()->routeIs('owner.invoices.*') => [
            'Penjualan',
            'Invoice',
        ],

        request()->routeIs('owner.projects.*') => [
            'Operasional',
            'Project',
        ],

        request()->routeIs('owner.delivery-orders.*') => [
            'Operasional',
            'Surat Jalan',
        ],

        request()->routeIs('owner.monitoring.*') => [
            'Operasional',
            'Project Monitoring',
        ],

        request()->routeIs('owner.users.*') => [
            'Pengaturan',
            'User Management',
        ],

        request()->routeIs('owner.profile') => [
            'Akun',
            'Profil',
        ],

        request()->routeIs('mandor.dashboard') => [
            'Utama',
            'Dashboard Mandor',
        ],

        request()->routeIs('mandor.projects.*') => [
            'Operasional',
            'Project',
        ],

        request()->routeIs('mandor.work-progress.*') => [
            'Operasional',
            'Progress Pekerjaan',
        ],

        request()->routeIs('mandor.documentations.*') => [
            'Operasional',
            'Dokumentasi',
        ],

        request()->routeIs('mandor.daily-reports.*') => [
            'Operasional',
            'Laporan Harian',
        ],

        request()->routeIs('pekerja.dashboard') => [
            'Utama',
            'Dashboard Pekerja',
        ],

        request()->routeIs('pekerja.tasks.*') => [
            'Pekerjaan',
            'Task',
        ],

        request()->routeIs('pekerja.documentation.*') => [
            'Pekerjaan',
            'Dokumentasi',
        ],

        request()->routeIs('pekerja.report.*') => [
            'Pekerjaan',
            'Laporan',
        ],

        request()->routeIs('pekerja.profile.*') => [
            'Akun',
            'Profil',
        ],

        default => [
            'Sistem',
            'Management Proyek',
        ],
    };
@endphp

<nav
    x-data="{
        name: '',
        photo: ''
    }"
    x-init="
        name = $el.dataset.userName || 'Pengguna';
        photo = $el.dataset.photoUrl || '';
    "
    data-user-name="{{ $authenticatedUser?->name ?? 'Pengguna' }}"
    data-photo-url="{{ $photoUrl }}"
    x-on:profile-updated.window="
        name = $event.detail.name || 'Pengguna';
        photo = $event.detail.photoUrl || '';
    "
    class="sticky top-0 z-30 flex h-16 shrink-0 items-center justify-between border-b border-gray-200 bg-white px-4 sm:px-6"
>
    {{-- Bagian kiri --}}
    <div class="flex min-w-0 items-center gap-3">
        {{-- Tombol menu mobile --}}
        <button
            type="button"
            x-on:click="sidebarOpen = true"
            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-gray-600 transition hover:bg-gray-100 lg:hidden"
            aria-label="Buka menu navigasi"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
        </button>

        {{-- Informasi halaman --}}
        <div class="min-w-0">
            <div class="flex min-w-0 items-center gap-2">
                <span class="hidden text-[11px] font-bold uppercase tracking-[0.14em] text-blue-600 sm:inline">
                    {{ $sectionLabel }}
                </span>

                <span class="hidden text-gray-300 sm:inline">
                    /
                </span>

                <h1 class="truncate text-base font-bold text-gray-900 sm:text-lg">
                    {{ $pageLabel }}
                </h1>
            </div>

            <p class="mt-0.5 hidden truncate text-xs text-gray-500 sm:block">
                Selamat datang,
                <span x-text="name"></span>
            </p>
        </div>
    </div>

    {{-- Bagian kanan --}}
    <div class="flex shrink-0 items-center gap-3">
        <div class="hidden flex-col items-end md:flex">
            <span
                x-text="name"
                class="max-w-48 truncate text-sm font-semibold text-gray-900"
            ></span>

            <span class="text-xs text-gray-500">
                {{ $roleLabel }}
            </span>
        </div>

        @if ($profileRoute)
            <a
                href="{{ $profileRoute }}"
                wire:navigate
                class="relative block h-10 w-10 shrink-0 overflow-hidden rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                title="Buka profil"
                aria-label="Buka profil pengguna"
            >
                <img
                    x-show="photo"
                    x-bind:src="photo"
                    x-bind:alt="'Foto profil ' + name"
                    x-on:error="photo = ''"
                    class="h-10 w-10 rounded-full border border-gray-200 object-cover shadow-sm"
                >

                <div
                    x-show="!photo"
                    x-cloak
                    x-text="
                        name
                            .trim()
                            .charAt(0)
                            .toUpperCase()
                        || 'P'
                    "
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 font-semibold text-white shadow-sm"
                ></div>
            </a>
        @else
            <div class="relative h-10 w-10 shrink-0 overflow-hidden rounded-full">
                <img
                    x-show="photo"
                    x-bind:src="photo"
                    x-bind:alt="'Foto profil ' + name"
                    x-on:error="photo = ''"
                    class="h-10 w-10 rounded-full border border-gray-200 object-cover shadow-sm"
                >

                <div
                    x-show="!photo"
                    x-cloak
                    x-text="
                        name
                            .trim()
                            .charAt(0)
                            .toUpperCase()
                        || 'P'
                    "
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 font-semibold text-white shadow-sm"
                ></div>
            </div>
        @endif
    </div>
</nav>