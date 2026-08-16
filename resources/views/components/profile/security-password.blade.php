<x-ui.info-card>

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5">

        <div>

            <h2 class="text-xl font-bold text-gray-900">
                Security & Password
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Perbarui password untuk menjaga keamanan akun Anda.
            </p>

        </div>

    </div>

    {{-- Form --}}
    <div class="space-y-6 p-6">

        {{-- Current Password --}}
        <div>

            <label class="text-sm font-medium text-gray-700">
                Current Password
            </label>

            <input
                type="password"
                placeholder="••••••••••••"
                class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
            >

        </div>

        {{-- New Password --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            <div>

                <label class="text-sm font-medium text-gray-700">
                    New Password
                </label>

                <input
                    type="password"
                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

            </div>

            <div>

                <label class="text-sm font-medium text-gray-700">
                    Confirm New Password
                </label>

                <input
                    type="password"
                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

            </div>

        </div>

        {{-- Password Requirement --}}
        <div class="rounded-xl bg-blue-50 p-4">

            <div class="flex items-start gap-3">

                <div class="mt-0.5 text-blue-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"
                        />
                    </svg>

                </div>

                <div>

                    <h3 class="text-sm font-semibold text-gray-800">
                        Password Requirements
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-gray-600">
                        Gunakan minimal 8 karakter dengan kombinasi
                        huruf dan angka untuk menjaga keamanan akun.
                    </p>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>