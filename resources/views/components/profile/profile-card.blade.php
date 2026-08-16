<x-ui.info-card>

    <div class="p-6">

        {{-- Header --}}
        <div>

            <h2 class="text-xl font-bold text-gray-900">
                Account Information
            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500">
                Informasi dasar akun yang sedang digunakan.
            </p>

        </div>


        {{-- Account Details --}}
        <div class="mt-8 space-y-5">

            {{-- Name --}}
            <div>

                <p class="text-sm text-gray-500">
                    Name
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    Ahmad Afrizal
                </p>

            </div>


            {{-- Email --}}
            <div>

                <p class="text-sm text-gray-500">
                    Email
                </p>

                <p class="mt-1 break-words font-medium text-gray-800">
                    ahmad@example.com
                </p>

            </div>


            {{-- Role --}}
            <div class="flex items-center justify-between gap-4">

                <div>

                    <p class="text-sm text-gray-500">
                        Account Type
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        Owner
                    </p>

                </div>

                <x-ui.badge color="blue">
                    Owner
                </x-ui.badge>

            </div>


            {{-- Status --}}
            <div class="flex items-center justify-between gap-4">

                <div>

                    <p class="text-sm text-gray-500">
                        Account Status
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        Active
                    </p>

                </div>

                <x-ui.badge color="green">
                    Active
                </x-ui.badge>

            </div>

        </div>


        {{-- Divider --}}
        <div class="my-6 border-t border-gray-200"></div>


        {{-- Account Activity --}}
        <div class="space-y-4">

            <div>

                <p class="text-sm text-gray-500">
                    Last Login
                </p>

                <p class="mt-1 text-sm font-medium text-gray-800">
                    Today, 10:30 AM
                </p>

            </div>


            <div>

                <p class="text-sm text-gray-500">
                    Account Created
                </p>

                <p class="mt-1 text-sm font-medium text-gray-800">
                    15 January 2026
                </p>

            </div>

        </div>

    </div>

</x-ui.info-card>