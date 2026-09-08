<div class="space-y-6">
    {{-- Header --}}
    <x-user.user-header />

    {{-- Notifikasi --}}
    @if (session()->has('notification'))
        @php
            $notification = session('notification');

            $notificationType =
                $notification['type'] ?? 'success';

            $notificationClasses = match ($notificationType) {
                'delete' =>
                    'border-red-200 bg-red-50 text-red-700',

                'warning' =>
                    'border-amber-200 bg-amber-50 text-amber-700',

                'update' =>
                    'border-blue-200 bg-blue-50 text-blue-700',

                default =>
                    'border-green-200 bg-green-50 text-green-700',
            };

            $closeButtonClasses = match ($notificationType) {
                'delete' =>
                    'text-red-500 hover:text-red-700',

                'warning' =>
                    'text-amber-500 hover:text-amber-700',

                'update' =>
                    'text-blue-500 hover:text-blue-700',

                default =>
                    'text-green-500 hover:text-green-700',
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
                @elseif ($notificationType === 'warning')
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
                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 4.5h.008v.008H12V16.5Z"
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
                        ?? 'Data pengguna berhasil diproses.' }}
                </span>
            </div>

            <button
                type="button"
                x-on:click="show = false"
                class="shrink-0 text-xl leading-none transition {{ $closeButtonClasses }}"
                aria-label="Tutup notifikasi"
            >
                &times;
            </button>
        </div>
    @endif

    {{-- Statistik --}}
    <x-user.user-statistics
        :statistics="$statistics"
    />

    {{-- Filter --}}
    <x-user.user-filter
        :search="$search"
        :role="$role"
        :status="$status"
        :sort="$sort"
        :per-page="$perPage"
    />

    {{-- Tabel pengguna --}}
    <x-user.user-table
        :users="$users"
    />

    {{-- Pagination --}}
    <x-user.user-pagination
        :users="$users"
    />

    {{-- Modal hapus --}}
    <livewire:owner.users.delete />
</div>