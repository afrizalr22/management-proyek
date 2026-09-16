@props([
    'user',
    'role' => '-',
])

@php
    $roleText = match ($role) {
        'owner' => 'Owner',
        'mandor' => 'Mandor',
        'pekerja' => 'Pekerja',
        default => '-',
    };

    $statusText = $user->status === 'active'
        ? 'Aktif'
        : 'Tidak Aktif';

    $statusClasses = $user->status === 'active'
        ? 'bg-green-100 text-green-700'
        : 'bg-red-100 text-red-700';
@endphp

<div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
    <div class="min-w-0">
        <nav class="mb-3 flex flex-wrap items-center gap-2 text-sm text-gray-500">
            <a
                href="{{ route('owner.dashboard') }}"
                wire:navigate
                class="transition hover:text-blue-600"
            >
                Dashboard
            </a>

            <span>/</span>

            <a
                href="{{ route('owner.users.index') }}"
                wire:navigate
                class="transition hover:text-blue-600"
            >
                User Management
            </a>

            <span>/</span>

            <span class="font-medium text-gray-700">
                Detail User
            </span>
        </nav>

        <div class="flex flex-wrap items-center gap-3">
            <h1 class="break-words text-3xl font-bold text-gray-900 sm:text-4xl">
                {{ $user->name }}
            </h1>

            <span class="rounded-full px-3 py-1 text-sm font-semibold {{ $statusClasses }}">
                {{ $statusText }}
            </span>
        </div>

        <div class="mt-3 flex flex-wrap items-center gap-3 text-sm text-gray-500">
            <span>{{ $roleText }}</span>

            <span aria-hidden="true">•</span>

            <span>
                Bergabung
                {{ $user->created_at?->translatedFormat('d F Y') ?? '-' }}
            </span>

            @if ($user->id === auth()->id())
                <span class="rounded-full bg-blue-100 px-3 py-1 font-semibold text-blue-700">
                    Akun Anda
                </span>
            @endif
        </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row">
        <a
            href="{{ route('owner.users.index') }}"
            wire:navigate
            class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
        >
            Kembali
        </a>

        @can('update users')
            <a
                href="{{ route('owner.users.edit', [
                    'user' => $user->id,
                ]) }}"
                wire:navigate
                class="inline-flex min-h-11 items-center justify-center rounded-xl bg-amber-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-amber-600"
            >
                Edit User
            </a>
        @endcan
    </div>
</div>