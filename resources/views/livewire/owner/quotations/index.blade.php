<div class="space-y-6">
    {{-- Header --}}
    <x-ui.page-header
        title="Quotation Management"
        description="Kelola seluruh quotation proyek konstruksi perusahaan."
    >
        <x-slot:actions>
            <a
                href="{{ route('owner.quotations.create') }}"
                wire:navigate
            >
                <x-ui.button>
                    Buat Quotation
                </x-ui.button>
            </a>
        </x-slot:actions>
    </x-ui.page-header>

    {{-- Notifikasi --}}
    @if (session()->has('notification'))
        @php
            $notification = session('notification');

            $notificationType =
                $notification['type'] ?? 'success';

            $notificationClasses = match ($notificationType) {
                'create', 'success' =>
                    'border-green-200 bg-green-50 text-green-700',

                'update' =>
                    'border-blue-200 bg-blue-50 text-blue-700',

                'delete' =>
                    'border-red-200 bg-red-50 text-red-700',

                'error' =>
                    'border-amber-200 bg-amber-50 text-amber-700',

                default =>
                    'border-gray-200 bg-gray-50 text-gray-700',
            };

            $closeButtonClasses = match ($notificationType) {
                'create', 'success' =>
                    'text-green-500 hover:text-green-700',

                'update' =>
                    'text-blue-500 hover:text-blue-700',

                'delete' =>
                    'text-red-500 hover:text-red-700',

                'error' =>
                    'text-amber-500 hover:text-amber-700',

                default =>
                    'text-gray-500 hover:text-gray-700',
            };
        @endphp

        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            x-transition.opacity.duration.300ms
            class="flex items-start justify-between gap-4 rounded-xl border px-4 py-3 text-sm {{ $notificationClasses }}"
            role="alert"
        >
            <div class="flex items-start gap-3">
                @if ($notificationType === 'delete')
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="mt-0.5 h-5 w-5 shrink-0"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18 18 6M6 6l12 12"
                        />
                    </svg>
                @elseif ($notificationType === 'error')
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="mt-0.5 h-5 w-5 shrink-0"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v3.75m9-3.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 7.5h.008v.008H12V16.5Z"
                        />
                    </svg>
                @else
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="mt-0.5 h-5 w-5 shrink-0"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m4.5 12.75 6 6 9-13.5"
                        />
                    </svg>
                @endif

                <span>
                    {{ $notification['message']
                        ?? 'Proses quotation berhasil dilakukan.' }}
                </span>
            </div>

            <button
                type="button"
                @click="show = false"
                class="shrink-0 text-lg leading-none transition {{ $closeButtonClasses }}"
                aria-label="Tutup notifikasi"
            >
                &times;
            </button>
        </div>
    @endif

    {{-- Statistik --}}
    <x-quotation.quotation-statistics
        :statistics="$statistics"
    />

    {{-- Pencarian dan filter --}}
    <x-quotation.quotation-toolbar
        :search="$search"
        :status="$status"
        :sort="$sort"
    />

    {{-- Tabel --}}
    <x-quotation.quotation-table
        :quotations="$quotations"
    />

    {{-- Pagination --}}
    <x-quotation.quotation-pagination
        :quotations="$quotations"
    />
</div>