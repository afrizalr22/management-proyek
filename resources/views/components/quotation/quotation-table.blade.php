@php

    $quotations = [

        [
            'id' => 1,
            'number' => 'QT-2026-0001',
            'project' => 'Renovasi Gedung Kantor',
            'client' => 'PT Maju Bersama',
            'date' => '20 Jul 2026',
            'valid_until' => '27 Jul 2026',
            'total' => 'Rp 125.000.000',
            'status' => 'Draft',
        ],

        [
            'id' => 2,
            'number' => 'QT-2026-0002',
            'project' => 'Pembangunan Gudang',
            'client' => 'CV Nusantara',
            'date' => '21 Jul 2026',
            'valid_until' => '28 Jul 2026',
            'total' => 'Rp 245.000.000',
            'status' => 'Sent',
        ],

        [
            'id' => 3,
            'number' => 'QT-2026-0003',
            'project' => 'Renovasi Rumah Sakit',
            'client' => 'PT Sehat Sentosa',
            'date' => '22 Jul 2026',
            'valid_until' => '29 Jul 2026',
            'total' => 'Rp 310.000.000',
            'status' => 'Approved',
        ],

        [
            'id' => 4,
            'number' => 'QT-2026-0004',
            'project' => 'Pembangunan Ruko',
            'client' => 'PT Karya Mandiri',
            'date' => '23 Jul 2026',
            'valid_until' => '30 Jul 2026',
            'total' => 'Rp 998.000.000',
            'status' => 'Rejected',
        ],

    ];

@endphp

<x-ui.table>

    <table class="min-w-full divide-y divide-gray-200">

        <thead class="bg-gray-50">

            <tr>

                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">

                    No

                </th>

                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">

                    Quotation Number

                </th>

                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">

                    Project

                </th>

                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">

                    Client

                </th>

                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">

                    Date

                </th>

                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">

                    Valid Until

                </th>

                <th class="px-6 py-3 text-right text-xs font-semibold uppercase">

                    Grand Total

                </th>

                <th class="px-6 py-3 text-center text-xs font-semibold uppercase">

                    Status

                </th>

                <th class="px-6 py-3 text-center text-xs font-semibold uppercase">

                    Action

                </th>

            </tr>

        </thead>

        <tbody class="divide-y divide-gray-100 bg-white">

            @foreach ($quotations as $quotation)

                <tr class="hover:bg-gray-50 transition">

                    <td class="px-6 py-4">

                        {{ $loop->iteration }}

                    </td>

                    <td class="px-6 py-4 font-semibold text-blue-600">

                        {{ $quotation['number'] }}

                    </td>

                    <td class="px-6 py-4">

                        {{ $quotation['project'] }}

                    </td>

                    <td class="px-6 py-4">

                        {{ $quotation['client'] }}

                    </td>

                    <td class="px-6 py-4">

                        {{ $quotation['date'] }}

                    </td>

                    <td class="px-6 py-4">

                        {{ $quotation['valid_until'] }}

                    </td>

                    <td class="px-6 py-4 font-semibold text-right whitespace-nowrap">
                        {{ $quotation['total'] }}
                    </td>

                    <td class="px-6 py-4 text-center">

                        @switch($quotation['status'])

                            @case('Draft')

                                <x-ui.badge color="yellow">

                                    Draft

                                </x-ui.badge>

                            @break

                            @case('Sent')

                                <x-ui.badge color="blue">

                                    Sent

                                </x-ui.badge>

                            @break

                            @case('Approved')

                                <x-ui.badge color="green">

                                    Approved

                                </x-ui.badge>

                            @break

                            @default

                                <x-ui.badge color="red">

                                    Rejected

                                </x-ui.badge>

                        @endswitch

                    </td>

                    <td class="px-6 py-4">

                        <div class="flex items-center justify-center gap-2">

                            <x-ui.icon-button-view
                                :href="route('owner.quotations.show', $quotation['id'])"
                            />

                            <x-ui.icon-button-edit
                                :href="route('owner.quotations.edit', $quotation['id'])"
                            />

                            <x-ui.icon-button-delete
                                :href="route('owner.quotations.delete', $quotation['id'])"
                            />

                        </div>

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</x-ui.table>

<div class="flex items-center justify-between text-sm text-gray-500">

    <p>

        Showing 1 - {{ count($quotations) }} of {{ count($quotations) }} Quotations

    </p>

    <div class="flex gap-2">

        <button class="rounded-lg border px-3 py-1">

            Previous

        </button>

        <button class="rounded-lg border bg-blue-600 px-3 py-1 text-white">

            1

        </button>

        <button class="rounded-lg border px-3 py-1">

            Next

        </button>

    </div>

</div>  