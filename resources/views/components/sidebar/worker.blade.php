<aside class="w-72 bg-white border-r min-h-screen">
    <div class="p-6">
        <h1 class="text-xl font-bold">Worker Panel</h1>
    </div>

    <div class="border-t p-4 mt-auto">

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