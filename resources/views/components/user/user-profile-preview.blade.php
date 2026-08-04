<x-ui.info-card>

    <div>

        {{-- Header --}}
        <div class="rounded-t-2xl bg-gradient-to-r from-blue-600 to-sky-400 p-8">

            <div class="flex items-center gap-4">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-7 w-7 text-blue-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5.121 17.804A9 9 0 1118.879 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>

                    </svg>

                </div>

                <div>

                    <h2 class="text-xl font-bold text-white">

                        User Preview

                    </h2>

                    <p class="text-sm text-blue-100">

                        Preview informasi akun

                    </p>

                </div>

            </div>

        </div>

        {{-- Content --}}
        <div class="p-8">

            <div class="flex flex-col items-center">

                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-gray-100">

                    <span class="text-3xl font-bold text-gray-500">

                        A

                    </span>

                </div>

                <h3 class="mt-5 text-2xl font-bold text-gray-800">

                    Full Name

                </h3>

                <p class="mt-1 text-gray-500">

                    example@email.com

                </p>

                <div class="mt-6 flex flex-wrap justify-center gap-2">

                    <span class="rounded-full bg-blue-100 px-4 py-1.5 text-sm font-semibold text-blue-700">

                        Owner

                    </span>

                    <span class="rounded-full bg-green-100 px-4 py-1.5 text-sm font-semibold text-green-700">

                        Active

                    </span>

                </div>

            </div>

            <div class="mt-8 border-t pt-6">

                <div class="space-y-3 text-sm">

                    <div class="flex justify-between">

                        <span class="text-gray-500">

                            Phone

                        </span>

                        <span class="font-medium text-gray-700">

                            -

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-gray-500">

                            Role

                        </span>

                        <span class="font-medium text-gray-700">

                            Owner

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-gray-500">

                            Status

                        </span>

                        <span class="font-medium text-green-600">

                            Active

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>