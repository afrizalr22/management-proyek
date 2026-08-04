<x-ui.info-card>

    <div class="p-8">

        <div class="mb-8 flex items-center justify-between">

            <div>

                <h2 class="text-2xl font-bold text-gray-800">

                    Project History

                </h2>

                <p class="mt-2 text-gray-500">

                    Daftar proyek yang pernah maupun sedang ditangani pengguna.

                </p>

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead>

                    <tr class="border-b border-gray-200">

                        <th class="py-3 text-left text-sm font-semibold text-gray-600">
                            Project
                        </th>

                        <th class="py-3 text-left text-sm font-semibold text-gray-600">
                            Client
                        </th>

                        <th class="py-3 text-left text-sm font-semibold text-gray-600">
                            Role
                        </th>

                        <th class="py-3 text-left text-sm font-semibold text-gray-600">
                            Status
                        </th>

                        <th class="py-3 text-left text-sm font-semibold text-gray-600">
                            Start
                        </th>

                        <th class="py-3 text-left text-sm font-semibold text-gray-600">
                            End
                        </th>

                        <th class="py-3 text-right text-sm font-semibold text-gray-600">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach(range(1,4) as $project)

                        <tr class="border-b border-gray-100">

                            <td class="py-4">

                                Renovasi Gedung A

                            </td>

                            <td class="py-4">

                                PT ABC Indonesia

                            </td>

                            <td class="py-4">

                                Mandor

                            </td>

                            <td class="py-4">

                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">

                                    Active

                                </span>

                            </td>

                            <td class="py-4">

                                01 Jul 2026

                            </td>

                            <td class="py-4">

                                -

                            </td>

                            <td class="py-4 text-right">

                                <x-ui.button
                                    variant="outline"
                                    size="sm">

                                    View

                                </x-ui.button>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</x-ui.info-card>