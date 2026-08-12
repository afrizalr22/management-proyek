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

            {{-- Header --}}
            <thead class="bg-gray-50">

                <tr>

                    <th
                        class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500"
                    >
                        No
                    </th>

                    <th
                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                    >
                        Name
                    </th>

                    <th
                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                    >
                        Role
                    </th>

                    <th
                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                    >
                        Email
                    </th>

                    <th
                        class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500"
                    >
                        Status
                    </th>

                    <th
                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                    >
                        Last Login
                    </th>

                    <th
                        class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500"
                    >
                        Action
                    </th>

                </tr>

            </thead>


            {{-- Body --}}
            <tbody class="divide-y divide-gray-100 bg-white">

                @foreach($users as $user)

                    <tr class="transition hover:bg-gray-50">

                        {{-- No --}}
                        <td class="px-6 py-5 text-center text-sm text-gray-500">

                            {{ $loop->iteration }}

                        </td>


                        {{-- Name --}}
                        <td class="px-6 py-5">

                            <div>

                                <div class="font-semibold text-gray-800">

                                    {{ $user['name'] }}

                                </div>

                                <div class="mt-1 text-sm text-gray-500">

                                    {{ $user['email'] }}

                                </div>

                            </div>

                        </td>


                        {{-- Role --}}
                        <td class="px-6 py-5">

                            @php

                                $roleColor = match ($user['role']) {

                                    'Owner' => 'red',

                                    'Mandor' => 'blue',

                                    'Pekerja' => 'gray',

                                    default => 'gray',

                                };

                            @endphp

                            <x-ui.badge :color="$roleColor">

                                {{ $user['role'] }}

                            </x-ui.badge>

                        </td>


                        {{-- Email --}}
                        <td class="px-6 py-5 text-sm text-gray-600">

                            {{ $user['email'] }}

                        </td>


                        {{-- Status --}}
                        <td class="px-6 py-5 text-center">

                            @php

                                $statusColor = match ($user['status']) {

                                    'Active' => 'green',

                                    'Inactive' => 'red',

                                    default => 'gray',

                                };

                            @endphp

                            <x-ui.badge :color="$statusColor">

                                {{ $user['status'] }}

                            </x-ui.badge>

                        </td>


                        {{-- Last Login --}}
                        <td class="px-6 py-5 text-sm text-gray-600">

                            {{ $user['last_login'] }}

                        </td>


                        {{-- Action --}}
                        <td class="px-6 py-5">

                            <div class="flex justify-center gap-2">

                                {{-- Edit --}}
                                <x-ui.icon-button-edit
                                    :href="route('owner.users.edit', $user['id'])"
                                />


                                {{-- View --}}
                                <x-ui.icon-button-view
                                    :href="route('owner.users.show', $user['id'])"
                                />


                                {{-- Delete --}}
                                <x-ui.icon-button-delete
                                    href="javascript:void(0)"
                                    x-on:click="$dispatch(
                                        'open-delete-user-modal',
                                        { id: {{ $user['id'] }} }
                                    )"
                                />

                            </div>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</x-ui.info-card>