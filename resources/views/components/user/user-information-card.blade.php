<x-ui.info-card>

    <div class="p-8">

        <div class="mb-8">

            <h2 class="text-2xl font-bold text-gray-800">

                User Information

            </h2>

            <p class="mt-2 text-gray-500">

                Informasi lengkap mengenai akun pengguna.

            </p>

        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- Nama --}}

            <div>

                <p class="mb-2 text-sm font-medium text-gray-500">

                    Full Name

                </p>

                <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">

                    Ahmad Subarjo

                </div>

            </div>

            {{-- Email --}}

            <div>

                <p class="mb-2 text-sm font-medium text-gray-500">

                    Email

                </p>

                <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">

                    ahmad@email.com

                </div>

            </div>

            {{-- Telepon --}}

            <div>

                <p class="mb-2 text-sm font-medium text-gray-500">

                    Phone Number

                </p>

                <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">

                    +62 812 3456 7890

                </div>

            </div>

            {{-- Role --}}

            <div>

                <p class="mb-2 text-sm font-medium text-gray-500">

                    Role

                </p>

                <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">

                    Mandor

                </div>

            </div>

            {{-- Status --}}

            <div>

                <p class="mb-2 text-sm font-medium text-gray-500">

                    Account Status

                </p>

                <div>

                    <span class="rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">

                        Active

                    </span>

                </div>

            </div>

            {{-- Bergabung --}}

            <div>

                <p class="mb-2 text-sm font-medium text-gray-500">

                    Join Date

                </p>

                <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">

                    27 Juli 2026

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>