<x-ui.info-card>

    <div class="flex flex-col items-center justify-center px-8 py-20">

        <div class="flex h-24 w-24 items-center justify-center rounded-full bg-blue-50">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-12 w-12 text-blue-500"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.8"
                      d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-8 0v2m8 0H9m8-10a4 4 0 11-8 0 4 4 0 018 0z"/>

            </svg>

        </div>

        <h3 class="mt-6 text-2xl font-bold text-gray-800">

            No Users Found

        </h3>

        <p class="mt-3 max-w-md text-center text-gray-500">

            Belum ada pengguna yang tersedia.
            Tambahkan pengguna pertama untuk mulai mengelola sistem.

        </p>

        <div class="mt-8">

            <x-ui.button
                :href="route('owner.users.create')"
            >

                + Add User

            </x-ui.button>

        </div>

    </div>

</x-ui.info-card>