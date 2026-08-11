<div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        {{-- Left --}}
        <div class="flex flex-1">

            {{-- Search --}}
            <div class="relative w-full lg:max-w-md">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m21 21-4.35-4.35m1.35-5.15a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0Z"
                    />

                </svg>

                <input
                    type="text"
                    placeholder="Cari client, proyek, atau no. invoice..."
                    class="w-full rounded-xl border-gray-300 py-3 pl-10 pr-4 text-sm text-gray-700 placeholder:text-gray-400 focus:border-blue-500 focus:ring-blue-500"
                >

            </div>

        </div>


        {{-- Right --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">

            {{-- Status Filter --}}
            <div
                x-data="{
                    open: false,
                    selected: 'Semua Status',
                    options: [
                        {
                            label: 'Semua Status',
                            color: 'gray'
                        },
                        {
                            label: 'Unpaid',
                            color: 'blue'
                        },
                        {
                            label: 'Partial',
                            color: 'yellow'
                        },
                        {
                            label: 'Paid',
                            color: 'green'
                        }
                    ]
                }"
                class="relative w-full sm:w-44"
            >

                {{-- Trigger --}}
                <button
                    type="button"
                    x-on:click="open = !open"
                    class="flex w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 transition hover:border-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                >

                    <span class="flex items-center gap-2">

                        <span
                            class="h-2.5 w-2.5 rounded-full"
                            :class="{
                                'bg-gray-400': selected === 'Semua Status',
                                'bg-blue-500': selected === 'Unpaid',
                                'bg-yellow-500': selected === 'Partial',
                                'bg-green-500': selected === 'Paid'
                            }"
                        ></span>

                        <span x-text="selected"></span>

                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 text-gray-400 transition-transform"
                        :class="{ 'rotate-180': open }"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m19 9-7 7-7-7"
                        />

                    </svg>

                </button>


                {{-- Dropdown --}}
                <div
                    x-show="open"
                    x-transition
                    x-on:click.outside="open = false"
                    class="absolute right-0 top-full z-30 mt-2 w-full overflow-hidden rounded-xl border border-gray-200 bg-white p-1 shadow-lg"
                    style="display: none;"
                >

                    <template
                        x-for="option in options"
                        :key="option.label"
                    >

                        <button
                            type="button"
                            x-on:click="
                                selected = option.label;
                                open = false;
                            "
                            class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm text-gray-700 transition hover:bg-gray-50"
                        >

                            <span
                                class="h-2.5 w-2.5 rounded-full"
                                :class="{
                                    'bg-gray-400': option.color === 'gray',
                                    'bg-blue-500': option.color === 'blue',
                                    'bg-yellow-500': option.color === 'yellow',
                                    'bg-green-500': option.color === 'green'
                                }"
                            ></span>

                            <span x-text="option.label"></span>

                        </button>

                    </template>

                </div>

            </div>


            {{-- Reset --}}
            <button
                type="button"
                class="rounded-xl border border-gray-300 px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
            >

                Reset Filter

            </button>

        </div>

    </div>

</div>