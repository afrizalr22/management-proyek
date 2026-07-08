<div class="flex flex-col h-full">

    {{-- Header --}}
    <div class="p-6 border-b">

        <h1 class="text-xl font-bold">
            Management Proyek
        </h1>

        <p class="text-sm text-gray-500">
            Owner Panel
        </p>

    </div>

    {{-- Menu --}}
    <nav class="flex-1 overflow-y-auto p-4 space-y-2">

        <a
            href="{{ route('owner.dashboard') }}"
            class="block px-4 py-2 rounded-lg hover:bg-gray-100"
            @click="sidebarOpen = false"
        >
            Dashboard
        </a>

        <a
            href="#"
            class="block px-4 py-2 rounded-lg hover:bg-gray-100"
            @click="sidebarOpen = false"
        >
            Client Management
        </a>

        <a
            href="#"
            class="block px-4 py-2 rounded-lg hover:bg-gray-100"
            @click="sidebarOpen = false"
        >
            Project List
        </a>

        <a
            href="#"
            class="block px-4 py-2 rounded-lg hover:bg-gray-100"
            @click="sidebarOpen = false"
        >
            Project Administration
        </a>

        <a
            href="#"
            class="block px-4 py-2 rounded-lg hover:bg-gray-100"
            @click="sidebarOpen = false"
        >
            Project Monitoring
        </a>

        <a
            href="#"
            class="block px-4 py-2 rounded-lg hover:bg-gray-100"
            @click="sidebarOpen = false"
        >
            User Management
        </a>

    </nav>

    {{-- Bottom Menu --}}
    <div class="border-t p-4 space-y-2">

        <a
            href="#"
            class="block px-4 py-2 rounded-lg hover:bg-gray-100"
            @click="sidebarOpen = false"
        >
            Profile
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