@php

$users = [

    [
        'id' => 1,
        'name' => 'Ahmad Rizki',
        'email' => 'ahmad@example.com',
        'role' => 'Owner',
        'status' => 'Active',
        'last_login' => '5 minutes ago',
    ],

    [
        'id' => 2,
        'name' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'role' => 'Mandor',
        'status' => 'Active',
        'last_login' => '1 hour ago',
    ],

    [
        'id' => 3,
        'name' => 'Rudi Hartono',
        'email' => 'rudi@example.com',
        'role' => 'Pekerja',
        'status' => 'Inactive',
        'last_login' => 'Yesterday',
    ],

];

@endphp

<x-ui.info-card>

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-gray-50">

                <tr>

                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                        No
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Name
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Role
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Email
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Status
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Last Login
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">

                @foreach($users as $user)   

                    <tr class="hover:bg-gray-50 transition">

                    <td class="px-6 py-5 text-center">

                        {{ $user['id'] }}

                    </td>

                    <td class="px-6 py-5">

                        <div>

                            <div class="font-semibold text-gray-800">

                                {{ $user['name'] }}

                            </div>

                            <div class="text-sm text-gray-500">

                                {{ $user['email'] }}

                            </div>

                        </div>

                    </td>

                        {{-- Role --}}
                        <td class="px-6 py-5">

                            @switch($user['role'])

                                @case('Owner')

                                    <span class="rounded-full bg-red-100 px-4 py-1.5 text-xs font-semibold text-red-600">

                                        Owner

                                    </span>

                                @break

                                @case('Mandor')

                                    <span class="rounded-full bg-blue-100 px-4 py-1.5 text-xs font-semibold text-blue-600">

                                        Mandor

                                    </span>

                                @break

                                @default

                                    <span class="rounded-full bg-gray-100 px-4 py-1.5 text-xs font-semibold text-gray-600">

                                        Pekerja

                                    </span>

                            @endswitch

                        </td>

                        {{-- Email --}}
                        <td class="px-6 py-5 text-gray-600">

                            {{ $user['email'] }}

                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-5 text-center">

                            @if($user['status'] == 'Active')

                                <span class="rounded-full bg-green-100 px-4 py-1.5 text-xs font-semibold text-green-600">

                                    Active

                                </span>

                            @else

                                <span class="rounded-full bg-red-100 px-4 py-1.5 text-xs font-semibold text-red-600">

                                    Inactive

                                </span>

                            @endif

                        </td>

                        {{-- Last Login --}}
                        <td class="px-6 py-5 text-gray-600">

                            {{ $user['last_login'] }}

                        </td>

                        {{-- Action --}}
                        <td class="px-6 py-5">

                            <div class="flex justify-center gap-2">

                                    <x-ui.icon-button-edit
                                       :href="route('owner.users.edit', 1)"
                                    />

                                    <x-ui.icon-button-view
                                       :href="route('owner.users.show', 1)"
                                    />

                                <x-ui.icon-button-delete
                                    href="javascript:void(0)"
                                    x-on:click="$dispatch('open-delete-user-modal')"
                                />

                            </div>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</x-ui.info-card>