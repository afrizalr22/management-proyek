<x-ui.toolbar>

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        {{-- Left --}}
        <div class="flex flex-1 flex-col gap-4 md:flex-row">

            {{-- Search --}}
            <div class="relative w-full md:max-w-sm">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"
                    />

                </svg>

                <input
                    type="text"
                    placeholder="Cari quotation..."
                    class="w-full rounded-xl border-gray-300 py-3 pl-10 pr-4 focus:border-blue-500 focus:ring-blue-500"
                >

            </div>

            {{-- Status --}}
            <select
                class="rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">

                <option>Semua Status</option>

                <option>Draft</option>

                <option>Sent</option>

                <option>Approved</option>

                <option>Rejected</option>

            </select>

            {{-- Project --}}
            <select
                class="rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">

                <option>Semua Project</option>

                <option>Renovasi Gudang</option>

                <option>Pembangunan Ruko</option>

                <option>Renovasi Kantor</option>

            </select>

        </div>

        {{-- Right --}}
        <div class="flex items-center gap-3">

            <button
                class="rounded-xl border border-gray-300 px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100">

                Reset Filter

            </button>

            <a href="{{ route('owner.quotations.create') }}">

                <x-ui.button>

                    + Create Quotation

                </x-ui.button>

            </a>

        </div>

    </div>

</x-ui.toolbar>