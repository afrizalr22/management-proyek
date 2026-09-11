<div class="border-b border-gray-200 px-5 py-5">
    <a
        href="{{ route('owner.dashboard') }}"
        wire:navigate
        x-on:click="sidebarOpen = false"
        class="flex items-center gap-3"
    >
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm shadow-blue-200">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 21h18M5.25 21V8.25L12 3l6.75 5.25V21M9 21v-6h6v6"
                />
            </svg>
        </div>

        <div class="min-w-0">
            <p class="truncate text-lg font-bold text-gray-900">
                Management Proyek
            </p>

            <p class="mt-0.5 text-xs font-medium text-gray-500">
                Owner Panel
            </p>
        </div>
    </a>
</div>