@props([
    'client',
    'no',
])

<tr
    wire:key="client-row-{{ $client->id }}"
    class="transition hover:bg-gray-50"
>
    {{-- Nomor --}}
    <td class="px-6 py-4 text-sm text-gray-500">
        {{ $no }}
    </td>

    {{-- Client --}}
    <td class="px-6 py-4">
        <div>
            <p class="text-sm font-medium text-gray-900">
                {{ $client->contact_person }}
            </p>

            <p class="mt-1 text-sm text-gray-500">
                {{ $client->email }}
            </p>
        </div>
    </td>

    {{-- Perusahaan --}}
    <td class="px-6 py-4 text-sm text-gray-700">
        {{ $client->company_name }}
    </td>

    {{-- Kota --}}
    <td class="px-6 py-4 text-sm text-gray-700">
        {{ $client->city ?: '-' }}
    </td>

    {{-- Telepon --}}
    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
        {{ $client->phone ?: '-' }}
    </td>

{{-- Status --}}
<td class="px-6 py-4">
    @switch($client->status)
        @case('active')
            <x-ui.badge color="green">
                Aktif
            </x-ui.badge>
            @break

        @case('lead')
            <x-ui.badge color="yellow">
                Lead
            </x-ui.badge>
            @break

        @case('inactive')
            <x-ui.badge color="red">
                Nonaktif
            </x-ui.badge>
            @break

        @default
            <x-ui.badge color="gray">
                Tidak diketahui
            </x-ui.badge>
    @endswitch
</td>

    {{-- Aksi --}}
    <td class="px-6 py-4">
        <div class="flex items-center justify-center gap-2">
            <x-ui.icon-button-view
                :href="route('owner.clients.show', [
                    'client' => $client->id,
                ])"
                wire:navigate
            />

            <x-ui.icon-button-edit
                :href="route('owner.clients.edit', [
                    'client' => $client->id,
                ])"
                wire:navigate
            />

            <x-ui.icon-button-delete
                href="#"
                wire:click.prevent="confirmDelete({{ $client->id }})"
            />
        </div>
    </td>
</tr>