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

        {{-- Header --}}
        <thead class="bg-gray-50">

            <tr>

                <th
                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"
                >
                    No
                </th>

                <th
                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"
                >
                    Quotation
                </th>

                <th
                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"
                >
                    Project
                </th>

                <th
                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"
                >
                    Client
                </th>

                <th
                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"
                >
                    Date
                </th>

                <th
                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"
                >
                    Valid Until
                </th>

                <th
                    class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500"
                >
                    Grand Total
                </th>

                <th
                    class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500"
                >
                    Status
                </th>

                <th
                    class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500"
                >
                    Action
                </th>

            </tr>

        </thead>

        {{-- Body --}}
        <tbody class="divide-y divide-gray-100 bg-white">

            @foreach ($quotations as $quotation)

                <tr class="transition hover:bg-gray-50">

                    {{-- No --}}
                    <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-500">

                        {{ $loop->iteration }}

                    </td>

                    {{-- Quotation --}}
                    <td class="whitespace-nowrap px-6 py-5">

                        <div>

                            <p class="font-semibold text-gray-900">

                                {{ $quotation['number'] }}

                            </p>

                            <p class="mt-1 text-xs text-gray-500">

                                Quotation

                            </p>

                        </div>

                    </td>

                    {{-- Project --}}
                    <td class="px-6 py-5">

                        <p class="font-medium text-gray-800">

                            {{ $quotation['project'] }}

                        </p>

                    </td>

                    {{-- Client --}}
                    <td class="px-6 py-5">

                        <p class="font-medium text-gray-800">

                            {{ $quotation['client'] }}

                        </p>

                    </td>

                    {{-- Date --}}
                    <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-600">

                        {{ $quotation['date'] }}

                    </td>

                    {{-- Valid Until --}}
                    <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-600">

                        {{ $quotation['valid_until'] }}

                    </td>

                    {{-- Grand Total --}}
                    <td
                        class="whitespace-nowrap px-6 py-5 text-right font-semibold text-gray-900"
                    >

                        {{ $quotation['total'] }}

                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-5 text-center">

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

                            @case('Rejected')

                                <x-ui.badge color="red">

                                    Rejected

                                </x-ui.badge>

                            @break

                        @endswitch

                    </td>

                    {{-- Action --}}
                    <td class="px-6 py-5">

                        <div class="flex items-center justify-center gap-2">

                            <x-ui.icon-button-view
                                :href="route(
                                    'owner.quotations.show',
                                    $quotation['id']
                                )"
                            />

                            <x-ui.icon-button-edit
                                :href="route(
                                    'owner.quotations.edit',
                                    $quotation['id']
                                )"
                            />

                            <x-ui.icon-button-delete
                                href="#"
                                x-on:click.prevent="$dispatch('open-delete-quotation-modal')"
                            />

                        </div>

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</x-ui.table>

{{-- Table Footer --}}
<div
    class="flex flex-col gap-4 border-t border-gray-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between"
>

    <p class="text-sm text-gray-500">

        Showing
        <span class="font-medium text-gray-700">
            1
        </span>

        -
        <span class="font-medium text-gray-700">
            {{ count($quotations) }}
        </span>

        of
        <span class="font-medium text-gray-700">
            {{ count($quotations) }}
        </span>

        Quotations

    </p>

    <div class="flex items-center gap-2">

        <button
            type="button"
            class="rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-400"
            disabled
        >
            Previous
        </button>

        <button
            type="button"
            class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white"
        >
            1
        </button>

        <button
            type="button"
            class="rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
        >
            Next
        </button>

    </div>

</div>