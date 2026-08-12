<x-ui.info-card>

    <div class="p-6">

        <div class="flex flex-col gap-4 lg:flex-row lg:items-end">

            {{-- Search --}}
            <div class="flex-1">

                <label
                    for="documentation-search"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Search Documentation
                </label>

                <div class="relative">

                    {{-- Search Icon --}}
                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                            />
                        </svg>
                    </div>

                    <input
                        id="documentation-search"
                        type="text"
                        placeholder="Cari dokumentasi proyek..."
                        class="w-full rounded-xl border-gray-300 py-2.5 pl-11 pr-4 text-sm shadow-sm transition focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>

            </div>


            {{-- Category --}}
            <div class="w-full lg:w-52">

                <label
                    for="documentation-category"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Category
                </label>

                <select
                    id="documentation-category"
                    class="w-full rounded-xl border-gray-300 py-2.5 text-sm shadow-sm transition focus:border-blue-500 focus:ring-blue-500"
                >

                    <option>All Categories</option>
                    <option>Foundation</option>
                    <option>Structure</option>
                    <option>Finishing</option>

                </select>

            </div>


            {{-- Date --}}
            <div class="w-full lg:w-52">

                <label
                    for="documentation-date"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Date
                </label>

                <input
                    id="documentation-date"
                    type="date"
                    class="w-full rounded-xl border-gray-300 py-2.5 text-sm shadow-sm transition focus:border-blue-500 focus:ring-blue-500"
                >

            </div>


            {{-- Filter Button --}}
            <div class="w-full lg:w-auto">

                <button
                    type="button"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 lg:w-auto"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 5h18M6 12h12M10 19h4"
                        />
                    </svg>

                    Filter

                </button>

            </div>

        </div>

    </div>

</x-ui.info-card>