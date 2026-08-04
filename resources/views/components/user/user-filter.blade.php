<x-ui.info-card>

    <div class="flex flex-col gap-4 p-6 lg:flex-row lg:items-center lg:justify-between">

        <div class="flex flex-1 flex-col gap-4 lg:flex-row">

            {{-- Search --}}
            <div class="flex-1">

                <input
                    type="text"
                    placeholder="Search by name or email..."
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

            </div>

            {{-- Role --}}
            <div class="w-full lg:w-52">

                <select
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

                    <option>All Roles</option>
                    <option>Owner</option>
                    <option>Mandor</option>
                    <option>Pekerja</option>

                </select>

            </div>

            {{-- Status --}}
            <div class="w-full lg:w-52">

                <select
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

                    <option>All Status</option>
                    <option>Active</option>
                    <option>Inactive</option>

                </select>

            </div>

        </div>

        {{-- Reset --}}
        <button
            class="rounded-xl border border-gray-300 px-5 py-2 font-medium text-gray-700 transition hover:bg-gray-100"
        >

            Reset Filter

        </button>

    </div>

</x-ui.info-card>