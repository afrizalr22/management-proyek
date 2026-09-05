<div class="space-y-6">

    {{-- Header --}}
    <x-quotation.quotation-show-header
        :quotation="$quotation"
        :status-text="$statusText"
        :status-color="$statusColor"
    />

    {{-- Notifikasi --}}
    @if (session()->has('notification'))
        @php
            $notification = session('notification');

            $notificationType =
                $notification['type'] ?? 'update';

            $notificationClasses = match ($notificationType) {
                'success' =>
                    'border-green-200 bg-green-50 text-green-700',

                'delete' =>
                    'border-red-200 bg-red-50 text-red-700',

                default =>
                    'border-blue-200 bg-blue-50 text-blue-700',
            };

            $closeButtonClasses = match ($notificationType) {
                'success' =>
                    'text-green-500 hover:text-green-700',

                'delete' =>
                    'text-red-500 hover:text-red-700',

                default =>
                    'text-blue-500 hover:text-blue-700',
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
                        ?? 'Status quotation berhasil diperbarui.' }}
                </span>
            </div>

            <button
                type="button"
                @click="show = false"
                class="shrink-0 transition {{ $closeButtonClasses }}"
                aria-label="Tutup notifikasi"
            >
                &times;
            </button>
        </div>
    @endif

    {{-- Aksi status --}}
    <x-quotation.quotation-status-actions
        :quotation="$quotation"
    />

    {{-- Informasi utama --}}
    <x-quotation.quotation-show-information
        :quotation="$quotation"
        :status-text="$statusText"
        :status-color="$statusColor"
    />

    {{-- Daftar item --}}
    <x-quotation.quotation-show-items
        :items="$quotation->items"
    />

    {{-- Ringkasan biaya --}}
    <x-quotation.quotation-show-summary
        :quotation="$quotation"
    />

    {{-- Catatan dan riwayat --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <x-quotation.quotation-show-notes
            :quotation="$quotation"
        />

        <x-quotation.quotation-show-history
            :quotation="$quotation"
            :status-text="$statusText"
            :status-color="$statusColor"
        />
    </div>

    <x-quotation.quotation-status-confirmation-modal
        :action="$pendingStatusAction"
        :quotation="$quotation"
    />

    <x-quotation.quotation-delete-modal
        :show="$showDeleteModal"
        :quotation="$quotation"
    />

</div>