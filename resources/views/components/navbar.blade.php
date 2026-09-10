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
    <div class="flex min-w-0 items-center gap-4">
        <button
            type="button"
            x-on:click="sidebarOpen = true"
            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-gray-600 transition hover:bg-gray-100 lg:hidden"
            aria-label="Buka menu navigasi"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
                class="h-7 w-7"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
        </button>

        <div class="min-w-0">
            <h1 class="text-lg font-semibold text-gray-900">
                Dashboard
            </h1>

            <p class="truncate text-sm text-gray-500">
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
                class="max-w-48 truncate font-medium text-gray-900"
            ></span>

            <span class="text-xs text-gray-500">
                {{ $roleLabel }}
            </span>
        </div>

        @if ($profileRoute)
            <a
                href="{{ $profileRoute }}"
                wire:navigate
                class="relative block h-10 w-10 shrink-0 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                title="Buka profil"
            >
                <img
                    x-show="photo"
                    x-bind:src="photo"
                    x-bind:alt="'Foto profil ' + name"
                    x-on:error="photo = ''"
                    class="h-10 w-10 rounded-full border border-gray-200 object-cover shadow-sm"
                >

                <div
                    x-show="! photo"
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
            <div class="relative h-10 w-10 shrink-0">
                <img
                    x-show="photo"
                    x-bind:src="photo"
                    x-bind:alt="'Foto profil ' + name"
                    x-on:error="photo = ''"
                    class="h-10 w-10 rounded-full border border-gray-200 object-cover shadow-sm"
                >

                <div
                    x-show="! photo"
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