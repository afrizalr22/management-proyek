<x-ui.info-card>

    <div class="grid grid-cols-1 gap-4 p-6 lg:grid-cols-4">

        <input
            type="text"
            placeholder="Search documentation..."
            class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
        >

        <select
            class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
        >
            <option>All Categories</option>
            <option>Foundation</option>
            <option>Structure</option>
            <option>Finishing</option>
        </select>

        <input
            type="date"
            class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
        >

        <button
            class="rounded-xl bg-blue-600 px-4 py-2 font-medium text-white transition hover:bg-blue-700"
        >
            Filter
        </button>

    </div>

</x-ui.info-card>