<nav
    class="sticky top-0 z-30 h-16 bg-white border-b px-6 flex items-center justify-between shrink-0">

    <div class="flex items-center gap-4">

        {{-- Hamburger --}}
        <button
            class="lg:hidden"
            @click="sidebarOpen = true">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-7 h-7"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"/>

            </svg>

        </button>

        <div>

            <h1 class="text-lg font-semibold">
                Dashboard
            </h1>

            <p class="text-sm text-gray-500">
                Selamat datang, {{ auth()->user()->name }}
            </p>

        </div>

    </div>

    <div class="flex items-center gap-3">

        <div class="hidden md:flex flex-col items-end">

            <span class="font-medium">
                {{ auth()->user()->name }}
            </span>

            <span class="text-xs text-gray-500">
                {{ auth()->user()->roles->first()?->name }}
            </span>

        </div>

        <div
            class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold">

            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

        </div>

    </div>

</nav>