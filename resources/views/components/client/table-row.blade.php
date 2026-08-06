@props([
    'no',
    'client',
    'company',
    'city',
    'phone',
    'status',
    'statusText',
    'id',
])

<tr>

    <td class="px-6 py-4">{{ $no }}</td>

    <td class="px-6 py-4 font-medium">{{ $client }}</td>

    <td class="px-6 py-4">{{ $company }}</td>

    <td class="px-6 py-4">{{ $city }}</td>

    <td class="px-6 py-4">{{ $phone }}</td>

    <td class="px-6 py-4">

        <x-ui.badge :color="$status">
            {{ $statusText }}
        </x-ui.badge>

    </td>

    <td class="px-6 py-4">

        <div class="flex items-center justify-center gap-2">

            <x-ui.icon-button-view
                :href="route('owner.clients.show', $id)"
            />

            <x-ui.icon-button-edit
                :href="route('owner.clients.edit', $id)"
            />

            <x-ui.icon-button-delete
    x-on:click="$dispatch('open-delete-client-modal')"
/>

        </div>

    </td>

</tr>