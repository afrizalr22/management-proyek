<aside class="w-72 bg-white border-r min-h-screen flex flex-col">

    <div class="p-6 border-b">
        <h1 class="text-xl font-bold">
            Management Proyek
        </h1>

        <p class="text-sm text-gray-500">
            Owner Panel
        </p>
    </div>

 <nav class="flex-1 p-4 space-y-2">

    <a
        href="{{ route('owner.dashboard') }}"
        class="block px-4 py-2 rounded-lg hover:bg-gray-100"
    >
        Dashboard
    </a>

    <a
        href="#"
        class="block px-4 py-2 rounded-lg hover:bg-gray-100"
    >
        Client Management
    </a>

    <a
        href="#"
        class="block px-4 py-2 rounded-lg hover:bg-gray-100"
    >
        Project List
    </a>

    <a
        href="#"
        class="block px-4 py-2 rounded-lg hover:bg-gray-100"
    >
        Project Administration
    </a>

    <a
        href="#"
        class="block px-4 py-2 rounded-lg hover:bg-gray-100"
    >
        Project Monitoring
    </a>

    <a
        href="#"
        class="block px-4 py-2 rounded-lg hover:bg-gray-100"
    >
        User Management
    </a>

    <a
        href="#"
        class="block px-4 py-2 rounded-lg hover:bg-gray-100"
    >
        Profile
    </a>

</nav>

<<div class="border-t p-4">

    <div class="mb-4">

        <p class="font-semibold">
            {{ auth()->user()->name }}
        </p>

        <p class="text-sm text-gray-500">
            {{ auth()->user()->email }}
        </p>

    </div>

    <form method="POST" action="{{ route('logout') }}">

        @csrf

        <button
            type="submit"
            class="w-full rounded-lg bg-red-500 px-4 py-2 text-white hover:bg-red-600 transition"
        >
            Logout
        </button>

    </form>

</div>

</aside>