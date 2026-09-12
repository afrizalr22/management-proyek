<div class="flex h-full min-h-0 flex-col overflow-hidden bg-white">
    {{-- Logo --}}
    <x-sidebar.logo />

    {{-- Navigasi --}}
    <nav
        class="min-h-0 flex-1 space-y-4 overflow-y-auto overscroll-contain px-3 py-4"
        aria-label="Navigasi Owner"
    >
        {{-- Utama --}}
        <x-sidebar.group label="Utama">
            <x-sidebar.item
                :href="route('owner.dashboard')"
                :active="request()->routeIs('owner.dashboard')"
            >
                <x-slot:icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 13.5h8V3H3v10.5Zm10 7.5h8V10.5h-8V21ZM3 21h8v-5.5H3V21Zm10-12.5h8V3h-8v5.5Z"
                        />
                    </svg>
                </x-slot:icon>

                Dashboard
            </x-sidebar.item>
        </x-sidebar.group>

        {{-- Penjualan --}}
        <x-sidebar.group label="Penjualan">
            <x-sidebar.item
                :href="route('owner.clients.index')"
                :active="request()->routeIs('owner.clients.*')"
            >
                <x-slot:icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
                        />
                    </svg>
                </x-slot:icon>

                Client
            </x-sidebar.item>

            <x-sidebar.item
                :href="route('owner.quotations.index')"
                :active="request()->routeIs('owner.quotations.*')"
            >
                <x-slot:icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6.75 3h7.5L19.5 8.25V21H6.75V3Zm7.5 0v5.25h5.25M9.75 12h6M9.75 15.75h6"
                        />
                    </svg>
                </x-slot:icon>

                Quotation
            </x-sidebar.item>

            <x-sidebar.item
                :href="route('owner.invoices.index')"
                :active="request()->routeIs('owner.invoices.*')"
            >
                <x-slot:icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 3h12v18l-3-1.5L12 21l-3-1.5L6 21V3Zm3 5.25h6M9 12h6M9 15.75h3"
                        />
                    </svg>
                </x-slot:icon>

                Invoice
            </x-sidebar.item>
        </x-sidebar.group>

        {{-- Operasional --}}
        <x-sidebar.group label="Operasional">
            <x-sidebar.item
                :href="route('owner.projects.index')"
                :active="request()->routeIs('owner.projects.*')"
            >
                <x-slot:icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 20.25h18M5.25 20.25V8.25L12 3l6.75 5.25v12M9 20.25v-6h6v6"
                        />
                    </svg>
                </x-slot:icon>

                Project
            </x-sidebar.item>

            <x-sidebar.item
                :href="route('owner.delivery-orders.index')"
                :active="request()->routeIs('owner.delivery-orders.*')"
            >
                <x-slot:icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 6.75h10.5v10.5H3.75V6.75Zm10.5 3h3l3 3v4.5h-6v-7.5ZM8.25 20.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Zm9 0a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z"
                        />
                    </svg>
                </x-slot:icon>

                Surat Jalan
            </x-sidebar.item>

            <x-sidebar.item
                :href="route('owner.monitoring.index')"
                :active="request()->routeIs('owner.monitoring.*')"
            >
                <x-slot:icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 20.25h18M6.75 17.25v-4.5M12 17.25V9M17.25 17.25V5.25"
                        />
                    </svg>
                </x-slot:icon>

                Project Monitoring
            </x-sidebar.item>
        </x-sidebar.group>

        {{-- Pengaturan --}}
        <x-sidebar.group label="Pengaturan">
            <x-sidebar.item
                :href="route('owner.users.index')"
                :active="request()->routeIs('owner.users.*')"
            >
                <x-slot:icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM3.75 20.25a8.25 8.25 0 0 1 16.5 0M18 8.25a3 3 0 0 1 0 6M20.25 20.25a6 6 0 0 0-3.25-5.33"
                        />
                    </svg>
                </x-slot:icon>

                User Management
            </x-sidebar.item>
        </x-sidebar.group>
    </nav>

    {{-- Menu akun --}}
    <div class="shrink-0 border-t border-gray-200 bg-white px-3 py-3">
        <p class="px-3 pb-2 text-[11px] font-bold uppercase tracking-[0.16em] text-gray-400">
            Akun
        </p>

        <div class="space-y-1">
            <x-sidebar.item
                :href="route('owner.profile')"
                :active="request()->routeIs('owner.profile')"
            >
                <x-slot:icon>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
                        />
                    </svg>
                </x-slot:icon>

                Profil
            </x-sidebar.item>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="group flex min-h-11 w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-semibold text-red-600 transition hover:bg-red-50"
                >
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center text-red-400 transition group-hover:text-red-600">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l3-3m-3 3 3 3m0-3H21"
                            />
                        </svg>
                    </span>

                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>