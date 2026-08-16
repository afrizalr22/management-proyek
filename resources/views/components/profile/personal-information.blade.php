<x-ui.info-card>

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5">

        <div>

            <h2 class="text-xl font-bold text-gray-900">
                Personal Information
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Informasi pribadi yang digunakan pada akun Anda.
            </p>

        </div>

    </div>

    {{-- Form --}}
    <div class="p-6">

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- First Name --}}
            <div>

                <label class="text-sm font-medium text-gray-700">
                    First Name
                </label>

                <input
                    type="text"
                    value="Ahmad"
                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

            </div>

            {{-- Last Name --}}
            <div>

                <label class="text-sm font-medium text-gray-700">
                    Last Name
                </label>

                <input
                    type="text"
                    value="Afrizal"
                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

            </div>

            {{-- Email --}}
            <div class="md:col-span-2">

                <label class="text-sm font-medium text-gray-700">
                    Email Address
                </label>

                <input
                    type="email"
                    value="ahmad@example.com"
                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

            </div>

            {{-- Phone --}}
            <div>

                <label class="text-sm font-medium text-gray-700">
                    Phone Number
                </label>

                <input
                    type="text"
                    value="+62 812-3456-7890"
                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

            </div>

            {{-- Position --}}
            <div>

                <label class="text-sm font-medium text-gray-700">
                    Position
                </label>

                <input
                    type="text"
                    value="Owner"
                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

            </div>

        </div>

    </div>

</x-ui.info-card>