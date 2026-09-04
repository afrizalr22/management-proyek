@props([
    'clients',
])

<x-ui.table>
    <table class="min-w-full divide-y divide-gray-200">

        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                    No
                </th>

                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                    Client
                </th>

                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                    Perusahaan
                </th>

                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                    Kota
                </th>

                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                    Telepon
                </th>

                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                    Status
                </th>

                <th class="px-6 py-3 text-center text-xs font-semibold uppercase">
                    Aksi
                </th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100 bg-white">
            @forelse ($clients as $client)
                <x-client.table-row
                    :client="$client"
                    :no="$clients->firstItem() + $loop->index"
                />
            @empty
                <tr>
                    <td
                        colspan="7"
                        class="px-6 py-14 text-center"
                    >
                        <div class="mx-auto max-w-sm">
                            <p class="font-semibold text-gray-700">
                                Data Client tidak ditemukan
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Tambahkan Client baru atau ubah kata pencarian.
                            </p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
</x-ui.table>