<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div class="flex items-center gap-4">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 text-blue-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2V9a2 2 0 00-2-2h-1V6a5 5 0 00-10 0v1H6a2 2 0 00-2 2v10a2 2 0 002 2zm3-14a3 3 0 016 0v1H9V6z" />

                </svg>

            </div>

            <div>
                <h2 class="text-2xl font-bold text-gray-800">

                    Password

                </h2>

                <p class="mt-2 text-gray-500">

                    Isi password baru jika ingin mengganti password pengguna.

                </p>

            </div>

        </div>

        <div class="my-8 border-t"></div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- Password --}}
            <div>

                <label class="mb-2 block font-medium text-gray-700">

                    Password

                </label>

                <input
                    type="password"
                    placeholder="••••••••"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

            </div>

            {{-- Confirm Password --}}
            <div>

                <label class="mb-2 block font-medium text-gray-700">

                    Confirm Password

                </label>

                <input
                    type="password"
                    placeholder="••••••••"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

            </div>

        </div>

    </div>

</x-ui.info-card>   