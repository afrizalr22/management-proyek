<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="bg-gray-100">

    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <x-sidebar.index/>

        <div class="flex flex-col flex-1">

            {{-- Navbar --}}
            <x-navbar />

            {{-- Breadcrumb --}}
            <x-breadcrumb />

            {{-- Main Content --}}
            <main class="flex-1 p-6">

                {{ $slot }}

            </main>

            {{-- Footer --}}
            <x-footer />

        </div>

    </div>

    @livewireScripts

</body>

</html>