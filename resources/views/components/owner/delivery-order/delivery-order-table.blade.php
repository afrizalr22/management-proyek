@props([
    'deliveryOrders',
])

<x-ui.table>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Nomor Surat Jalan
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Project / Client
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Tujuan / Penerima
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Tanggal
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Item
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Status
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($deliveryOrders as $deliveryOrder)
                    @php
                        [$statusText, $statusColor] =
                            match ($deliveryOrder->status) {
                                'draft' => [
                                    'Draft',
                                    'yellow',
                                ],
                                'sent' => [
                                    'Dikirim',
                                    'blue',
                                ],
                                'received' => [
                                    'Diterima',
                                    'green',
                                ],
                                'cancelled' => [
                                    'Dibatalkan',
                                    'red',
                                ],
                                default => [
                                    'Tidak Diketahui',
                                    'gray',
                                ],
                            };
                    @endphp

                    <tr
                        wire:key="delivery-order-row-{{ $deliveryOrder->id }}"
                        class="transition hover:bg-gray-50"
                    >
                        <td class="px-6 py-5">
                            <a
                                href="{{ route(
                                    'owner.delivery-orders.show',
                                    [
                                        'deliveryOrder' =>
                                            $deliveryOrder->id,
                                    ]
                                ) }}"
                                wire:navigate
                                class="font-semibold text-blue-600 transition hover:text-blue-700"
                            >
                                {{ $deliveryOrder->delivery_number }}
                            </a>

                            <p class="mt-1 text-xs text-gray-500">
                                Dibuat oleh:
                                {{ $deliveryOrder->creator?->name
                                    ?? 'Pengguna tidak tersedia' }}
                            </p>
                        </td>

                        <td class="px-6 py-5">
                            <p class="font-semibold text-gray-900">
                                {{ $deliveryOrder->project?->project_name
                                    ?? 'Project tidak tersedia' }}
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                {{ $deliveryOrder->project?->project_code
                                    ?? '-' }}
                            </p>

                            <p class="mt-1 text-xs text-gray-400">
                                {{ $deliveryOrder->project?->client
                                    ?->company_name ?? '-' }}
                            </p>
                        </td>

                        <td class="px-6 py-5">
                            <p class="font-medium text-gray-800">
                                {{ $deliveryOrder->destination }}
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                {{ $deliveryOrder->receiver_name }}
                            </p>

                            @if ($deliveryOrder->receiver_phone)
                                <p class="mt-1 text-xs text-gray-400">
                                    {{ $deliveryOrder->receiver_phone }}
                                </p>
                            @endif
                        </td>

                        <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-600">
                            {{ $deliveryOrder->delivery_date
                                ?->translatedFormat('d M Y')
                                ?? '-' }}
                        </td>

                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex min-w-8 items-center justify-center rounded-full bg-gray-100 px-3 py-1 text-sm font-semibold text-gray-700">
                                {{ $deliveryOrder->items_count }}
                            </span>
                        </td>

                        <td class="px-6 py-5 text-center">
                            <x-ui.badge :color="$statusColor">
                                {{ $statusText }}
                            </x-ui.badge>
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <x-ui.icon-button-view
                                    :href="route(
                                        'owner.delivery-orders.show',
                                        [
                                            'deliveryOrder' =>
                                                $deliveryOrder->id,
                                        ]
                                    )"
                                />

                                @can('update delivery orders')
                                    @if ($deliveryOrder->status === 'draft')
                                        <x-ui.icon-button-edit
                                            :href="route(
                                                'owner.delivery-orders.edit',
                                                [
                                                    'deliveryOrder' =>
                                                        $deliveryOrder->id,
                                                ]
                                            )"
                                        />
                                    @else
                                        <button
                                            type="button"
                                            disabled
                                            title="Hanya Surat Jalan Draft yang dapat diedit"
                                            class="inline-flex h-9 w-9 cursor-not-allowed items-center justify-center rounded-lg bg-gray-100 text-gray-400 opacity-60"
                                            aria-label="Surat Jalan tidak dapat diedit"
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
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"
                                                />
                                            </svg>
                                        </button>
                                    @endif
                                @endcan
                                @can('delete delivery orders')
    @if ($deliveryOrder->status === 'draft')
        <x-ui.icon-button-delete
            href="javascript:void(0)"
            x-on:click="$dispatch(
                'open-delete-delivery-order-modal',
                {
                    id: {{ $deliveryOrder->id }}
                }
            )"
        />
    @else
        <button
            type="button"
            disabled
            title="Hanya Surat Jalan Draft yang dapat dihapus"
            class="inline-flex h-9 w-9 cursor-not-allowed items-center justify-center rounded-lg bg-gray-100 text-gray-400 opacity-60"
            aria-label="Surat Jalan tidak dapat dihapus"
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
                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M18.228 5.79 17.16 19.673A2.25 2.25 0 0 1 14.916 21.75H9.084a2.25 2.25 0 0 1-2.244-2.077L5.772 5.79"
                />
            </svg>
        </button>
    @endif
@endcan
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
                                Surat Jalan tidak ditemukan
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Belum ada data atau filter tidak sesuai.
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-ui.table>

@if ($deliveryOrders->hasPages())
    <div class="mt-4 rounded-xl border border-gray-200 bg-white px-4 py-4">
        {{ $deliveryOrders->links() }}
    </div>
@endif

<p class="mt-4 px-2 text-sm text-gray-500">
    @if ($deliveryOrders->total() > 0)
        Menampilkan
        <span class="font-medium text-gray-700">
            {{ $deliveryOrders->firstItem() }}
        </span>
        sampai
        <span class="font-medium text-gray-700">
            {{ $deliveryOrders->lastItem() }}
        </span>
        dari
        <span class="font-medium text-gray-700">
            {{ $deliveryOrders->total() }}
        </span>
        Surat Jalan
    @else
        Tidak ada Surat Jalan yang ditampilkan
    @endif
</p>