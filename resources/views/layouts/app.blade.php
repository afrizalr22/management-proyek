<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @livewireStyles
</head>

<body
    class="bg-gray-100"
    x-data="{ sidebarOpen:false }"
>

<div class="h-screen flex overflow-hidden">

    {{-- Overlay --}}
    <div
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-40 lg:hidden"
        x-cloak
    ></div>

    {{-- Mobile Sidebar --}}
    <aside
        class="fixed inset-y-0 left-0 w-72 bg-white z-50 transform transition-transform duration-300 lg:hidden"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >

        <x-sidebar.index />

    </aside>

    {{-- Desktop Sidebar --}}
    <aside class="hidden lg:flex lg:w-72 lg:flex-col border-r bg-white">

        <x-sidebar.index />

    </aside>

    {{-- Main Area --}}
    <div class="flex flex-1 flex-col overflow-hidden">

        {{-- Navbar --}}
        <x-navbar />

        {{-- Breadcrumb --}}
        <!-- <x-breadcrumb /> -->

        {{-- Scroll Area --}}
        <main class="flex-1 overflow-y-auto">

            <div class="p-6">

                {{ $slot }}

            </div>

            {{-- Footer ikut scroll --}}
            <x-footer />

        </main>

    </div>

</div>

@livewireScripts

</body>

</html>