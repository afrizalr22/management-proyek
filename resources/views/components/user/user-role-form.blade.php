<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div class="flex items-center gap-4">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 text-blue-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 11c0-1.657 1.79-3 4-3s4 1.343 4 3m-8 0c0 1.657-1.79 3-4 3S4 12.657 4 11m8 0V7m0 4v6"
                    />

                </svg>

            </div>

            <div>

                <h2 class="text-2xl font-bold text-gray-800">

                    Access & Role

                </h2>

                <p class="text-gray-500">

                    Tentukan hak akses dan status akun pengguna.

                </p>

            </div>

        </div>

        <div class="my-8 border-t"></div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- Role --}}
            <div>

                <label class="mb-2 block font-medium text-gray-700">

                    User Role

                </label>

                <select
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

                    <option selected disabled>

                        Select Role

                    </option>

                    <option>Owner</option>

                    <option>Mandor</option>

                    <option>Pekerja</option>

                </select>

            </div>

            {{-- Status --}}
            <div>

                <label class="mb-2 block font-medium text-gray-700">

                    Account Status

                </label>

                <div class="mt-3 flex items-center gap-8">

                    <label class="flex items-center gap-2">

                        <input
                            type="radio"
                            name="status"
                            checked
                            class="text-blue-600 focus:ring-blue-500"
                        >

                        <span class="text-gray-700">

                            Active

                        </span>

                    </label>

                    <label class="flex items-center gap-2">

                        <input
                            type="radio"
                            name="status"
                            class="text-blue-600 focus:ring-blue-500"
                        >

                        <span class="text-gray-700">

                            Inactive

                        </span>

                    </label>

                </div>

            </div>

        </div>

        {{-- Information --}}
        <div class="mt-8 rounded-xl border border-blue-200 bg-blue-50 p-5">

            <h4 class="font-semibold text-blue-700">

                Role Description

            </h4>

            <p class="mt-2 text-sm leading-6 text-blue-600">

                <strong>Owner</strong> memiliki akses penuh ke seluruh sistem.<br>

                <strong>Mandor</strong> mengelola proyek, pekerja, serta laporan harian.<br>

                <strong>Pekerja</strong> hanya dapat melihat tugas dan mengirim laporan pekerjaan.

            </p>

        </div>

    </div>

</x-ui.info-card>