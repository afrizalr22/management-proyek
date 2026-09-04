<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $title ?? config('app.name', 'Management Proyek') }}
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

    @livewireStyles
</head>

<body
    class="bg-gray-100 antialiased"
    x-data="{ sidebarOpen: false }"
>
    <div class="flex h-screen overflow-hidden">

        {{-- Overlay mobile --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            x-cloak
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        ></div>

        {{-- Sidebar mobile --}}
        <aside
            x-cloak
            class="fixed inset-y-0 left-0 z-50 w-72 transform bg-white transition-transform duration-300 lg:hidden"
            :class="sidebarOpen
                ? 'translate-x-0'
                : '-translate-x-full'"
        >
            <x-sidebar.index />
        </aside>

        {{-- Sidebar desktop --}}
        <aside
            class="hidden w-72 shrink-0 flex-col border-r border-gray-200 bg-white lg:flex"
        >
            <x-sidebar.index />
        </aside>

        {{-- Area utama --}}
        <div class="flex min-w-0 flex-1 flex-col overflow-hidden">

            <x-navbar />

            <main class="min-h-0 flex-1 overflow-y-auto">
                <div class="min-h-full">

                    <div class="p-4 sm:p-6">
                        {{ $slot }}
                    </div>

                    <x-footer />

                </div>
            </main>

        </div>
    </div>

    @livewireScripts

    @stack('scripts')
</body>

</html>