@php

    $invoices = [

        [
            'id' => 1,
            'number' => 'INV-2026-0001',
            'client' => 'PT Maju Bersama',
            'project' => 'Pembangunan Gudang',
            'date' => '20 Jul 2026',
            'due_date' => '27 Jul 2026',
            'total' => 'Rp 450.000.000',
            'status' => 'Paid',
        ],

        [
            'id' => 2,
            'number' => 'INV-2026-0002',
            'client' => 'CV Nusantara',
            'project' => 'Renovasi Kantor Pusat',
            'date' => '25 Jul 2026',
            'due_date' => '25 Aug 2026',
            'total' => 'Rp 1.200.000.000',
            'status' => 'Unpaid',
        ],

        [
            'id' => 3,
            'number' => 'INV-2026-0003',
            'client' => 'PT Karya Mandiri',
            'project' => 'Konsultasi Tol Cikampek',
            'date' => '02 Aug 2026',
            'due_date' => '02 Sep 2026',
            'total' => 'Rp 250.000.000',
            'status' => 'Partial',
        ],

    ];

@endphp


<x-ui.table>

    <table class="min-w-full divide-y divide-gray-200">

        {{-- Header --}}
        <thead class="bg-gray-50">

            <tr>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    No. Invoice
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Klien / Project
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Tanggal
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Jatuh Tempo
                </th>

                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Jumlah
                </th>

                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Status
                </th>

                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Aksi
                </th>

            </tr>

        </thead>


        {{-- Body --}}
        <tbody class="divide-y divide-gray-100 bg-white">

            @foreach ($invoices as $invoice)

                <tr class="transition hover:bg-gray-50">

                    {{-- Invoice Number --}}
                    <td class="px-6 py-5">

                        <a
                            href="{{ route('owner.invoices.show', $invoice['id']) }}"
                            class="font-semibold text-blue-600 hover:text-blue-700"
                        >

                            {{ $invoice['number'] }}

                        </a>

                    </td>


                    {{-- Client / Project --}}
                    <td class="px-6 py-5">

                        <div>

                            <p class="font-semibold text-gray-900">

                                {{ $invoice['client'] }}

                            </p>

                            <p class="mt-1 text-sm text-gray-500">

                                {{ $invoice['project'] }}

                            </p>

                        </div>

                    </td>


                    {{-- Date --}}
                    <td class="px-6 py-5 text-sm text-gray-600">

                        {{ $invoice['date'] }}

                    </td>


                    {{-- Due Date --}}
                    <td class="px-6 py-5 text-sm">

                        @if ($invoice['status'] === 'Unpaid')

                            <span class="font-medium text-red-600">

                                {{ $invoice['due_date'] }}

                            </span>

                        @else

                            <span class="text-gray-600">

                                {{ $invoice['due_date'] }}

                            </span>

                        @endif

                    </td>


                    {{-- Total --}}
                    <td class="px-6 py-5 text-right font-semibold text-gray-900 whitespace-nowrap">

                        {{ $invoice['total'] }}

                    </td>


                    {{-- Status --}}
                    <td class="px-6 py-5 text-center">

                        @switch($invoice['status'])

                            @case('Paid')

                                <x-ui.badge color="green">

                                    Paid

                                </x-ui.badge>

                            @break


                            @case('Partial')

                                <x-ui.badge color="yellow">

                                    Partial

                                </x-ui.badge>

                            @break


                            @default

                                <x-ui.badge color="blue">

                                    Unpaid

                                </x-ui.badge>

                        @endswitch

                    </td>


                    {{-- Action --}}
                    <td class="px-6 py-5">

                        <div class="flex items-center justify-center gap-2">

                            <x-ui.icon-button-view
                                :href="route('owner.invoices.show', $invoice['id'])"
                            />

                            <x-ui.icon-button-edit
                                :href="route('owner.invoices.edit', $invoice['id'])"
                            />

                            <x-ui.icon-button-delete
                                href="#"
                                x-on:click.prevent="$dispatch('open-delete-invoice-modal')"
                            />

                        </div>

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</x-ui.table>


{{-- Pagination --}}
<div class="flex flex-col gap-4 px-2 py-4 sm:flex-row sm:items-center sm:justify-between">

    <p class="text-sm text-gray-500">

        Menampilkan 1–{{ count($invoices) }} dari {{ count($invoices) }} invoice

    </p>


    <div class="flex items-center gap-2">

        <button
            type="button"
            class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-400"
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
            class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-100"
        >

            2

        </button>


        <button
            type="button"
            class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-100"
        >

            Next

        </button>

    </div>

</div>