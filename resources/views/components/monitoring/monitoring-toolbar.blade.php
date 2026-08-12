<div
    class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm lg:flex-row lg:items-center lg:justify-between"
>

    {{-- Search --}}
    <div class="w-full lg:flex-1">

        <div class="relative w-full lg:max-w-md">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m21 21-4.35-4.35m1.35-5.15a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0Z"
                />

            </svg>

            <input
                type="text"
                placeholder="Cari proyek..."
                class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-10 pr-4 text-sm text-gray-700 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
            >

        </div>

    </div>


    {{-- Filters --}}
    <div class="flex w-full flex-col gap-3 sm:flex-row lg:w-auto">

        {{-- Status --}}
        <div class="relative w-full sm:w-44">

            <select
                class="w-full appearance-none rounded-xl border border-gray-300 bg-white px-4 py-3 pr-10 text-sm text-gray-700 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
            >

                <option>Semua Status</option>
                <option>On Progress</option>
                <option>Completed</option>
                <option>Delayed</option>

            </select>

            <div
                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400"
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
                        d="m6 9 6 6 6-6"
                    />

                </svg>

            </div>

        </div>


        {{-- Mandor --}}
        <div class="relative w-full sm:w-44">

            <select
                class="w-full appearance-none rounded-xl border border-gray-300 bg-white px-4 py-3 pr-10 text-sm text-gray-700 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
            >

                <option>Semua Mandor</option>
                <option>Mandor A</option>
                <option>Mandor B</option>

            </select>

            <div
                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400"
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
                        d="m6 9 6 6 6-6"
                    />

                </svg>

            </div>

        </div>

    </div>

</div>