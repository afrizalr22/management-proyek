@props([
    'quotations',
])

<x-ui.table>
    <table class="min-w-[1100px] divide-y divide-gray-200 xl:min-w-full">

        {{-- Header --}}
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    No
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Quotation
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Proyek
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Client
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Tanggal
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Berlaku Sampai
                </th>

                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Total
                </th>

                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Status
                </th>

                <th
                    class="sticky right-0 z-10 bg-gray-50 px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 shadow-[-8px_0_12px_-12px_rgba(15,23,42,0.35)]"
                >
                    Aksi
                </th>
            </tr>
        </thead>

        {{-- Body --}}
        <tbody class="divide-y divide-gray-100 bg-white">
            @forelse ($quotations as $quotation)
                @php
                    $statusText = match ($quotation->status) {
                        'draft' => 'Draft',
                        'sent' => 'Dikirim',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'expired' => 'Kedaluwarsa',
                        default => 'Tidak diketahui',
                    };

                    $statusColor = match ($quotation->status) {
                        'draft' => 'yellow',
                        'sent' => 'blue',
                        'approved' => 'green',
                        'rejected' => 'red',
                        'expired' => 'gray',
                        default => 'gray',
                    };

                    $projectName =
                        $quotation->project?->project_name
                        ?? $quotation->project_name
                        ?? '-';

                    $clientName =
                        $quotation->client?->company_name
                        ?? $quotation->client_name
                        ?? '-';

                    $canEdit = $quotation->status === 'draft';
                @endphp

                <tr
                    wire:key="quotation-row-{{ $quotation->id }}"
                    class="group transition hover:bg-gray-50"
                >
                    {{-- Nomor urut --}}
                    <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-500">
                        {{ $quotations->firstItem() + $loop->index }}
                    </td>

                    {{-- Nomor quotation --}}
                    <td class="whitespace-nowrap px-6 py-5">
                        <p class="font-semibold text-gray-900">
                            {{ $quotation->quotation_number }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            Quotation
                        </p>
                    </td>

                    {{-- Proyek --}}
                    <td class="px-6 py-5">
                        <p class="max-w-xs break-words font-medium text-gray-800">
                            {{ $projectName }}
                        </p>
                    </td>

                    {{-- Client --}}
                    <td class="px-6 py-5">
                        <p class="max-w-xs break-words font-medium text-gray-800">
                            {{ $clientName }}
                        </p>

                        @if ($quotation->client?->contact_person)
                            <p class="mt-1 text-xs text-gray-500">
                                {{ $quotation->client->contact_person }}
                            </p>
                        @elseif ($quotation->client_contact_person)
                            <p class="mt-1 text-xs text-gray-500">
                                {{ $quotation->client_contact_person }}
                            </p>
                        @endif
                    </td>

                    {{-- Tanggal --}}
                    <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-600">
                        {{ $quotation->quotation_date
                            ? $quotation->quotation_date->format('d M Y')
                            : '-' }}
                    </td>

                    {{-- Berlaku sampai --}}
                    <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-600">
                        {{ $quotation->valid_until
                            ? $quotation->valid_until->format('d M Y')
                            : '-' }}
                    </td>

                    {{-- Total --}}
                    <td class="whitespace-nowrap px-6 py-5 text-right font-semibold text-gray-900">
                        Rp {{ number_format(
                            (float) $quotation->grand_total,
                            0,
                            ',',
                            '.'
                        ) }}
                    </td>

                    {{-- Status --}}
                    <td class="whitespace-nowrap px-6 py-5 text-center">
                        <x-ui.badge :color="$statusColor">
                            {{ $statusText }}
                        </x-ui.badge>
                    </td>

                    {{-- Aksi --}}
                    <td
                        class="sticky right-0 whitespace-nowrap bg-white px-6 py-5 shadow-[-8px_0_12px_-12px_rgba(15,23,42,0.35)] transition group-hover:bg-gray-50"
                    >
                        <div class="flex items-center justify-center gap-2">

                            {{-- Detail selalu aktif --}}
                            <x-ui.icon-button-view
                                :href="route(
                                    'owner.quotations.show',
                                    ['quotation' => $quotation->id]
                                )"
                                wire:navigate
                            />

                            {{-- Edit hanya aktif untuk Draft --}}
                            @if ($canEdit)
                                <x-ui.icon-button-edit
                                    :href="route(
                                        'owner.quotations.edit',
                                        ['quotation' => $quotation->id]
                                    )"
                                    wire:navigate
                                />
                            @else
                                <button
                                    type="button"
                                    disabled
                                    title="Hanya quotation Draft yang dapat diubah"
                                    aria-label="Edit quotation tidak tersedia"
                                    class="inline-flex h-10 w-10 cursor-not-allowed items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-gray-400 opacity-70"
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
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487ZM19.5 7.125 16.875 4.5"
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
                        colspan="9"
                        class="px-6 py-14 text-center"
                    >
                        <div class="mx-auto max-w-sm">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="mx-auto h-10 w-10 text-gray-300"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5V6.75A3.75 3.75 0 0 0 10.875 3h-4.5m4.5 0H5.25A2.25 2.25 0 0 0 3 5.25v13.5A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75v-1.5m-10.125-9V3.375c0-.207.168-.375.375-.375h.375a3 3 0 0 1 3 3v2.25m-3.75 0h3.75"
                                />
                            </svg>

                            <p class="mt-4 font-semibold text-gray-700">
                                Data quotation tidak ditemukan
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Tambahkan quotation baru atau ubah filter pencarian.
                            </p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-ui.table>