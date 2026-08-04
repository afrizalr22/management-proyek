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

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5.121 17.804A9 9 0 1118.879 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>

                </svg>

            </div>

            <div>

               <h2 class="text-2xl font-bold text-gray-800">

                    Informasi User

                </h2>

                <p class="mt-2 text-gray-500">

                    Lengkapi informasi dasar pengguna.

                </p>

            </div>

        </div>

        <div class="my-8 border-t"></div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- Full Name --}}
            <div>

                <label class="mb-2 block font-medium text-gray-700">

                    Full Name

                </label>

                <input
                    type="text"
                    placeholder="Enter full name"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

            </div>

            {{-- Phone --}}
            <div>

                <label class="mb-2 block font-medium text-gray-700">

                    Phone Number

                </label>

                <input
                    type="text"
                    placeholder="+62..."
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

            </div>

            {{-- Email --}}
            <div class="md:col-span-2">

                <label class="mb-2 block font-medium text-gray-700">

                    Email Address

                </label>

                <input
                    type="email"
                    placeholder="example@email.com"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

            </div>

        </div>

    </div>

</x-ui.info-card>