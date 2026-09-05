@props([
    'quotation',
])

@php
    $status = $quotation->status;

    $statusText = match ($status) {
        'draft' => 'Draft',
        'sent' => 'Dikirim',
        'approved' => 'Disetujui',
        'rejected' => 'Ditolak',
        'expired' => 'Kedaluwarsa',
        default => 'Tidak diketahui',
    };

    $statusDescription = match ($status) {
        'draft' =>
            'Quotation masih berupa Draft. Setelah quotation diserahkan kepada Client melalui email, WhatsApp, cetak, atau pertemuan langsung, tandai sebagai sudah dikirim.',

        'sent' =>
            'Quotation telah diserahkan kepada Client dan sedang menunggu keputusan persetujuan atau penolakan.',

        'approved' =>
            'Quotation telah disetujui dan dapat dilanjutkan ke proses pembuatan Project.',

        'rejected' =>
            'Quotation telah ditolak. Periksa kembali penawaran sebelum membuat quotation baru.',

        'expired' =>
            'Masa berlaku quotation telah berakhir.',

        default =>
            'Status quotation tidak diketahui.',
    };

    $statusColor = match ($status) {
        'draft' => 'yellow',
        'sent' => 'blue',
        'approved' => 'green',
        'rejected' => 'red',
        default => 'gray',
    };
@endphp

<section
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm"
>
    <div
        class="flex flex-col gap-5 p-5 sm:p-6 lg:flex-row lg:items-center lg:justify-between"
    >
        {{-- Informasi status --}}
        <div class="flex min-w-0 items-start gap-4">
            <div
                @class([
                    'flex h-11 w-11 shrink-0 items-center justify-center rounded-xl',
                    'bg-yellow-100 text-yellow-700' =>
                        $status === 'draft',
                    'bg-blue-100 text-blue-700' =>
                        $status === 'sent',
                    'bg-green-100 text-green-700' =>
                        $status === 'approved',
                    'bg-red-100 text-red-700' =>
                        $status === 'rejected',
                    'bg-gray-100 text-gray-600' => !in_array(
                        $status,
                        [
                            'draft',
                            'sent',
                            'approved',
                            'rejected',
                        ],
                        true
                    ),
                ])
            >
                @if ($status === 'approved')
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-6 w-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m4.5 12.75 6 6 9-13.5"
                        />
                    </svg>
                @elseif ($status === 'rejected')
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-6 w-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18 18 6M6 6l12 12"
                        />
                    </svg>
                @else
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-6 w-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>
                @endif
            </div>

            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="text-base font-semibold text-gray-900">
                        Status Quotation
                    </h2>

                    <x-ui.badge :color="$statusColor">
                        {{ $statusText }}
                    </x-ui.badge>
                </div>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                    {{ $statusDescription }}
                </p>
            </div>
        </div>

        {{-- Tombol berdasarkan status --}}
        <div class="flex shrink-0 flex-col gap-3 sm:flex-row">
            @if ($status === 'draft')
    <button
        type="button"
        wire:click="openDeleteModal"
        wire:loading.attr="disabled"
        wire:target="openDeleteModal"
        class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-red-300 bg-white px-5 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50 focus:outline-none focus:ring-4 focus:ring-red-100 disabled:cursor-not-allowed disabled:opacity-60"
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
                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166"
            />
        </svg>

        Hapus
    </button>
@else
    <button
        type="button"
        disabled
        title="Hanya quotation Draft yang dapat dihapus"
        class="inline-flex min-h-11 cursor-not-allowed items-center justify-center gap-2 rounded-xl border border-gray-200 bg-gray-100 px-5 py-2.5 text-sm font-semibold text-gray-400"
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
                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166"
            />
        </svg>

        Hapus
    </button>
@endif

            {{-- Draft: tandai sudah dikirim --}}
            @if ($status === 'draft')
                <button
                    type="button"
                    wire:click="openStatusConfirmation('send')"
                    wire:loading.attr="disabled"
                    wire:target="openStatusConfirmation"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-60"
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
                            d="m6 12 3.269 3.269a2.25 2.25 0 0 0 3.182 0L18 9.75M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"
                        />
                    </svg>

                    Tandai Sudah Dikirim
                </button>

            {{-- Dikirim: Tolak atau Setujui --}}
            @elseif ($status === 'sent')
                <button
                    type="button"
                    wire:click="openStatusConfirmation('reject')"
                    wire:loading.attr="disabled"
                    wire:target="openStatusConfirmation"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-red-300 bg-white px-5 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50 focus:outline-none focus:ring-4 focus:ring-red-100 disabled:cursor-not-allowed disabled:opacity-60"
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
                            d="M6 18 18 6M6 6l12 12"
                        />
                    </svg>

                    Tolak
                </button>

                <button
                    type="button"
                    wire:click="openStatusConfirmation('approve')"
                    wire:loading.attr="disabled"
                    wire:target="openStatusConfirmation"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-100 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m4.5 12.75 6 6 9-13.5"
                        />
                    </svg>

                    Setujui
                </button>

            {{-- Disetujui --}}
            @elseif ($status === 'approved')
                <div
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-green-200 bg-green-50 px-5 py-2.5 text-sm font-semibold text-green-700"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m4.5 12.75 6 6 9-13.5"
                        />
                    </svg>

                    Siap Dibuat Project
                </div>

            {{-- Ditolak --}}
            @elseif ($status === 'rejected')
                <div
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-red-200 bg-red-50 px-5 py-2.5 text-sm font-semibold text-red-700"
                >
                    Quotation Ditolak
                </div>

            {{-- Kedaluwarsa --}}
            @elseif ($status === 'expired')
                <div
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-200 bg-gray-100 px-5 py-2.5 text-sm font-semibold text-gray-500"
                >
                    Masa Berlaku Berakhir
                </div>
            @endif
        </div>
    </div>

    {{-- Pesan error --}}
    @error('statusAction')
        <div
            class="border-t border-red-200 bg-red-50 px-5 py-3 sm:px-6"
        >
            <p class="text-sm font-medium text-red-700">
                {{ $message }}
            </p>
        </div>
    @enderror
</section>