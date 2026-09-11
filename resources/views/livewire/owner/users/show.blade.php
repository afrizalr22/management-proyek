<div class="space-y-6">
    {{-- Header --}}
    <x-user.user-show-header
        :user="$user"
        :role="$role"
    />

    {{-- Notifikasi --}}
    @if (session()->has('notification'))
        @php
            $notification = session('notification');

            $notificationType =
                $notification['type'] ?? 'success';

            $notificationClasses = match ($notificationType) {
                'success' =>
                    'border-green-200 bg-green-50 text-green-700',

                'warning' =>
                    'border-amber-200 bg-amber-50 text-amber-700',

                'delete' =>
                    'border-red-200 bg-red-50 text-red-700',

                default =>
                    'border-blue-200 bg-blue-50 text-blue-700',
            };

            $closeButtonClasses = match ($notificationType) {
                'success' =>
                    'text-green-500 hover:text-green-700',

                'warning' =>
                    'text-amber-500 hover:text-amber-700',

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
                {{-- Ikon berhasil --}}
                @if ($notificationType === 'success')
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

                {{-- Ikon peringatan --}}
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

                {{-- Ikon gagal/hapus --}}
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
                            d="M6 18 18 6M6 6l12 12"
                        />
                    </svg>
                @endif

                <span>
                    {{ $notification['message']
                        ?? 'Data pengguna berhasil diperbarui.' }}
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

    {{-- Informasi dan ringkasan --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">
        <div class="xl:col-span-8">
            <x-user.user-information-card
                :user="$user"
                :role="$role"
            />
        </div>

        <div class="xl:col-span-4">
            <x-user.user-summary
                :user="$user"
                :role="$role"
                :total-projects="$totalProjects"
                :active-projects="$activeProjects"
            />
        </div>
    </div>

    {{-- Riwayat Project dan aktivitas --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">
        <div class="xl:col-span-8">
            <x-user.user-project-history
                :user="$user"
                :projects="$projectHistory"
            />
        </div>

        <div class="xl:col-span-4">
            <x-user.user-recent-activity
                :activities="$recentActivities"
            />
        </div>
    </div>
</div>