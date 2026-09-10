@props([
    'user',
])

<div>
    <p class="text-sm font-semibold text-blue-600">
        Pengaturan Akun
    </p>

    <h1 class="mt-2 text-3xl font-bold text-gray-900">
        Profil Owner
    </h1>

    <p class="mt-2 max-w-2xl text-gray-500">
        Kelola informasi pribadi, foto profil, email, dan keamanan akun
        {{ $user->name }}.
    </p>
</div>