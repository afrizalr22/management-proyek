@props([
    'no',
    'client',
])

@php
    $statusColor = match ($client->status) {
        'active' => 'green',
        'lead' => 'yellow',
        'inactive' => 'red',
        default => 'gray',
    };

    $statusText = match ($client->status) {
        'active' => 'Aktif',
        'lead' => 'Lead',
        'inactive' => 'Nonaktif',
        default => 'Tidak diketahui',
    };
@endphp

<tr wire:key="client-row-{{ $client->id }}">

    <td class="whitespace-nowrap px-6 py-4">
        {{ $no }}
    </td>

    <td class="px-6 py-4 font-medium text-gray-900">
        {{ $client->contact_person }}
    </td>

    <td class="px-6 py-4">
        {{ $client->company_name }}
    </td>

    <td class="px-6 py-4">
        {{ $client->city ?: '-' }}
    </td>

    <td class="whitespace-nowrap px-6 py-4">
        {{ $client->phone ?: '-' }}
    </td>

    <td class="px-6 py-4">
        <x-ui.badge :color="$statusColor">
            {{ $statusText }}
        </x-ui.badge>
    </td>

    <td class="px-6 py-4">
        <div class="flex items-center justify-center gap-2">

            <x-ui.icon-button-view
                :href="route(
                    'owner.clients.show',
                    ['client' => $client->id]
                )"
            />

            <x-ui.icon-button-edit
                :href="route(
                    'owner.clients.edit',
                    ['client' => $client->id]
                )"
            />

            <x-ui.icon-button-delete
                x-on:click="$dispatch(
                    'open-delete-client-modal',
                    { clientId: {{ $client->id }} }
                )"
            />

        </div>
    </td>

</tr>