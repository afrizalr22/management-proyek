@props([
    'quotation',
    'statusText',
    'statusColor',
])

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Riwayat Quotation
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Informasi pembuatan dan perubahan status quotation.
                </p>
            </div>

            <x-ui.badge :color="$statusColor">
                {{ $statusText }}
            </x-ui.badge>
        </div>

        <hr class="my-6 border-gray-200">

        <div class="relative space-y-6">

            {{-- Garis timeline --}}
            <div class="absolute bottom-3 left-[7px] top-3 w-px bg-gray-200"></div>

            {{-- Dibuat --}}
            <div class="relative flex gap-4">
                <span class="relative z-10 mt-1 h-4 w-4 shrink-0 rounded-full border-4 border-blue-100 bg-blue-600"></span>

                <div class="min-w-0">
                    <p class="font-semibold text-gray-900">
                        Quotation Dibuat
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $quotation->created_at
                            ? $quotation->created_at->format('d M Y, H:i')
                            : '-' }}
                    </p>

                    <p class="mt-1 break-words text-xs text-gray-400">
                        Oleh {{ $quotation->creator?->name ?: 'Owner' }}
                    </p>
                </div>
            </div>

            {{-- Dikirim --}}
            @if ($quotation->sent_at)
                <div class="relative flex gap-4">
                    <span class="relative z-10 mt-1 h-4 w-4 shrink-0 rounded-full border-4 border-blue-100 bg-blue-500"></span>

                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900">
                            Dikirim ke Client
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $quotation->sent_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Disetujui --}}
            @if ($quotation->approved_at)
                <div class="relative flex gap-4">
                    <span class="relative z-10 mt-1 h-4 w-4 shrink-0 rounded-full border-4 border-green-100 bg-green-500"></span>

                    <div class="min-w-0">
                        <p class="font-semibold text-green-700">
                            Disetujui Client
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $quotation->approved_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Ditolak --}}
            @if ($quotation->rejected_at)
                <div class="relative flex gap-4">
                    <span class="relative z-10 mt-1 h-4 w-4 shrink-0 rounded-full border-4 border-red-100 bg-red-500"></span>

                    <div class="min-w-0">
                        <p class="font-semibold text-red-700">
                            Ditolak Client
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $quotation->rejected_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Status draft --}}
            @if (
                $quotation->status === 'draft' &&
                !$quotation->sent_at
            )
                <div class="relative flex gap-4">
                    <span class="relative z-10 mt-1 h-4 w-4 shrink-0 rounded-full border-4 border-yellow-100 bg-yellow-400"></span>

                    <div class="min-w-0">
                        <p class="font-semibold text-yellow-700">
                            Menunggu Pengiriman
                        </p>

                        <p class="mt-1 text-sm leading-6 text-gray-500">
                            Quotation masih dalam tahap penyusunan.
                        </p>
                    </div>
                </div>
            @endif

            {{-- Kedaluwarsa --}}
            @if ($quotation->status === 'expired')
                <div class="relative flex gap-4">
                    <span class="relative z-10 mt-1 h-4 w-4 shrink-0 rounded-full border-4 border-gray-200 bg-gray-500"></span>

                    <div class="min-w-0">
                        <p class="font-semibold text-gray-700">
                            Quotation Kedaluwarsa
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Masa berlaku quotation telah berakhir.
                        </p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Terakhir diperbarui --}}
        <div class="mt-6 border-t border-gray-200 pt-5">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <span class="text-sm text-gray-500">
                    Terakhir diperbarui
                </span>

                <span class="text-sm font-semibold text-gray-700">
                    {{ $quotation->updated_at
                        ? $quotation->updated_at->format('d M Y, H:i')
                        : '-' }}
                </span>
            </div>
        </div>
    </div>
</x-ui.info-card>