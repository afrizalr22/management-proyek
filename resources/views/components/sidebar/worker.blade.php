<div class="flex flex-col h-full">

    {{-- Header --}}
    <div class="p-6 border-b">

        <h1 class="text-xl font-bold">
            Management Proyek
        </h1>

        <p class="text-sm text-gray-500">
            Pekerja
        </p>

    </div>

    {{-- Menu --}}
<nav class="flex-1 space-y-2 overflow-y-auto p-4">
    <a
        href="{{ route('pekerja.dashboard') }}"
        wire:navigate
        class="block rounded-lg px-4 py-2 transition
            {{ request()->routeIs('pekerja.dashboard')
                ? 'bg-blue-50 font-semibold text-blue-600'
                : 'text-gray-700 hover:bg-gray-100' }}"
        @click="sidebarOpen = false"
    >
        Dashboard
    </a>

    <a
        href="{{ route('pekerja.tasks.index') }}"
        wire:navigate
        class="block rounded-lg px-4 py-2 transition
            {{ request()->routeIs('pekerja.task.*')
                ? 'bg-blue-50 font-semibold text-blue-600'
                : 'text-gray-700 hover:bg-gray-100' }}"
        @click="sidebarOpen = false"
    >
        Tugas Saya
    </a>

    <a
        href="{{ route('pekerja.documentations.index') }}"
        wire:navigate
        class="block rounded-lg px-4 py-2 transition
            {{ request()->routeIs('pekerja.documentation.*')
                ? 'bg-blue-50 font-semibold text-blue-600'
                : 'text-gray-700 hover:bg-gray-100' }}"
        @click="sidebarOpen = false"
    >
        Dokumentasi
    </a>

    <a
        href="{{ route('pekerja.reports.index') }}"
        wire:navigate
        class="block rounded-lg px-4 py-2 transition
            {{ request()->routeIs('pekerja.report.*')
                ? 'bg-blue-50 font-semibold text-blue-600'
                : 'text-gray-700 hover:bg-gray-100' }}"
        @click="sidebarOpen = false"
    >
        Laporan
    </a>

</nav>

    {{-- Bottom Menu --}}
    <div class="border-t p-4 space-y-2">

        <a
            href="{{ route('pekerja.profile.index') }}"
            wire:navigate
            class="block rounded-lg px-4 py-2 transition
                {{ request()->routeIs('pekerja.profile.*')
                    ? 'bg-blue-50 font-semibold text-blue-600'
                    : 'text-gray-700 hover:bg-gray-100' }}"
            @click="sidebarOpen = false"
        >
            Profil
        </a>

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button
                type="submit"
                class="w-full text-left px-4 py-2 rounded-lg text-red-600 hover:bg-red-50"
            >
                Logout
            </button>

        </form>

    </div>

</div>