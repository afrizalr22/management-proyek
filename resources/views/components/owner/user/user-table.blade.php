@props([
    'users',
])

<x-ui.info-card>
    <div class="overflow-x-auto">
        <table class="min-w-[1050px] divide-y divide-gray-200 xl:min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                        No
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Pengguna
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Role
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Telepon
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Status Akun
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Ketersediaan
                    </th>

                    <th class="sticky right-0 z-10 bg-gray-50 px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 shadow-[-8px_0_12px_-12px_rgba(15,23,42,0.35)]">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($users as $user)
                    @php
                        $role = $user->roles
                            ->first()?->name
                            ?? '-';

                        $roleText = match ($role) {
                            'owner' => 'Owner',
                            'mandor' => 'Mandor',
                            'pekerja' => 'Pekerja',
                            default => 'Tanpa Role',
                        };

                        $roleColor = match ($role) {
                            'owner' => 'red',
                            'mandor' => 'blue',
                            'pekerja' => 'green',
                            default => 'gray',
                        };

                        $statusText = match ($user->status) {
                            'active' => 'Aktif',
                            'inactive' => 'Tidak Aktif',
                            default => 'Tidak Diketahui',
                        };

                        $statusColor = match ($user->status) {
                            'active' => 'green',
                            'inactive' => 'red',
                            default => 'gray',
                        };

                        if ($user->status !== 'active') {
                            $availabilityText =
                                'Akun tidak aktif';

                            $availabilityColor = 'red';
                        } elseif (
                            $role === 'mandor'
                            && $user->active_managed_projects_count > 0
                        ) {
                            $availabilityText = sprintf(
                                'Mengelola %d Project',
                                $user->active_managed_projects_count
                            );

                            $availabilityColor = 'blue';
                        } elseif (
                            $role === 'pekerja'
                            && $user->active_project_assignments_count > 0
                        ) {
                            $availabilityText = sprintf(
                                'Aktif di %d Project',
                                $user->active_project_assignments_count
                            );

                            $availabilityColor = 'yellow';
                        } elseif ($role === 'pekerja') {
                            $availabilityText =
                                'Tersedia';

                            $availabilityColor = 'green';
                        } elseif ($role === 'mandor') {
                            $availabilityText =
                                'Belum mengelola Project';

                            $availabilityColor = 'gray';
                        } else {
                            $availabilityText =
                                'Administrator Sistem';

                            $availabilityColor = 'gray';
                        }

                        $initials = collect(
                            preg_split(
                                '/\s+/',
                                trim($user->name)
                            )
                        )
                            ->filter()
                            ->take(2)
                            ->map(
                                fn (string $word): string =>
                                    mb_strtoupper(
                                        mb_substr(
                                            $word,
                                            0,
                                            1
                                        )
                                    )
                            )
                            ->implode('');
                    @endphp

                    <tr
                        wire:key="user-row-{{ $user->id }}"
                        class="group transition hover:bg-gray-50"
                    >
                        <td class="whitespace-nowrap px-6 py-5 text-center text-sm text-gray-500">
                            {{ $users->firstItem()
                                + $loop->index }}
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">
                                    {{ $initials ?: 'U' }}
                                </div>

                                <div class="min-w-0">
                                    <p class="break-words font-semibold text-gray-900">
                                        {{ $user->name }}

                                        @if ($user->id === auth()->id())
                                            <span class="ml-1 text-xs font-medium text-blue-600">
                                                (Anda)
                                            </span>
                                        @endif
                                    </p>

                                    <p class="mt-1 break-all text-sm text-gray-500">
                                        {{ $user->email }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-5">
                            <x-ui.badge :color="$roleColor">
                                {{ $roleText }}
                            </x-ui.badge>
                        </td>

                        <td class="px-6 py-5 text-sm text-gray-600">
                            {{ $user->phone ?: '-' }}
                        </td>

                        <td class="px-6 py-5 text-center">
                            <x-ui.badge :color="$statusColor">
                                {{ $statusText }}
                            </x-ui.badge>
                        </td>

                        <td class="px-6 py-5">
                            <x-ui.badge :color="$availabilityColor">
                                {{ $availabilityText }}
                            </x-ui.badge>
                        </td>

                        <td class="sticky right-0 whitespace-nowrap bg-white px-6 py-5 shadow-[-8px_0_12px_-12px_rgba(15,23,42,0.35)] transition group-hover:bg-gray-50">
                            <div class="flex items-center justify-center gap-2">
                                <x-ui.icon-button-view
                                    :href="route(
                                        'owner.users.show',
                                        ['user' => $user->id]
                                    )"
                                    wire:navigate
                                />

                                <x-ui.icon-button-edit
                                    :href="route(
                                        'owner.users.edit',
                                        ['user' => $user->id]
                                    )"
                                    wire:navigate
                                />

                                @if (
                                    $user->id !== auth()->id()
                                )
                                    <x-ui.icon-button-delete
                                        x-on:click="$dispatch(
                                            'open-delete-user-modal',
                                            { id: {{ $user->id }} }
                                        )"
                                    />
                                @else
                                    <button
                                        type="button"
                                        disabled
                                        title="Akun yang sedang digunakan tidak dapat dihapus"
                                        class="inline-flex h-10 w-10 cursor-not-allowed items-center justify-center rounded-xl border border-gray-200 bg-gray-100 text-gray-400 opacity-70"
                                    >
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
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.327L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                            />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="7"
                            class="px-6 py-14 text-center"
                        >
                            <p class="font-semibold text-gray-700">
                                Pengguna tidak ditemukan
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Ubah pencarian atau reset filter pengguna.
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-ui.info-card>