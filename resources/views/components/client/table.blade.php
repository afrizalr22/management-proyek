<x-ui.table>

    <table class="min-w-full divide-y divide-gray-200">

        <thead class="bg-gray-50">

            <tr>

                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">No</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Client</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Company</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">City</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Phone</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Status</th>
                <th class="px-6 py-3 text-center text-xs font-semibold uppercase">Action</th>

            </tr>

        </thead>

        <tbody class="divide-y divide-gray-100 bg-white">

            <x-client.table-row
                no="1"
                client="Ahmad"
                company="PT ABC"
                city="Medan"
                phone="081234567890"
                status="green"
                statusText="Active"
                id="1"
            />

            <x-client.table-row
                no="2"
                client="Budi"
                company="PT XYZ"
                city="Aceh"
                phone="081398765432"
                status="green"
                statusText="Active"
                id="2"
            />

            <x-client.table-row
                no="3"
                client="Andi"
                company="PT DEF"
                city="Jakarta"
                phone="081567890123"
                status="red"
                statusText="Inactive"
                id="3"
            />

        </tbody>

    </table>

</x-ui.table>