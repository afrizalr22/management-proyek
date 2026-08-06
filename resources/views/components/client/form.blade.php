 <x-ui.info-card>

        <div class="space-y-10 p-8">

            {{-- ================= IDENTITAS ================= --}}
            <div>

            <div class="mb-8 border-b border-gray-200 pb-4">

                <h3 class="text-lg font-semibold text-gray-900">

                    Identitas Utama

                </h3>

                <p class="mt-1 text-sm text-gray-500">

                    Informasi dasar mengenai client.

                </p>

            </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Nama Lengkap Client
                            <span class="text-red-500">*</span>

                        </label>

                            <input
                                type="text"
                                wire:model="name"
                                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            />

                    </div>

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Nama Perusahaan
                            <span class="text-red-500">*</span>

                        </label>

                            <input
                                type="text"
                                wire:model="company"
                                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            />

                    </div>

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Email Bisnis
                            <span class="text-red-500">*</span>

                        </label>

                            <input
                                type="email"
                                wire:model="email"
                                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            />

                    </div>

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Nomor Telepon

                        </label>

                        <div class="flex">

                            <span class="flex items-center rounded-l-xl border border-r-0 border-gray-300 bg-gray-100 px-4 text-gray-600">

                                +62

                            </span>

                            <input
                                type="text"
                                wire:model="phone"
                                class="w-full rounded-r-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            />

                        </div>

                    </div>

                </div>

            </div>

            {{-- ================= DETAIL LOKASI ================= --}}
            <div>

              <div class="mb-8 border-b border-gray-200 pb-4">

                    <h3 class="text-lg font-semibold text-gray-900">

                        Detail Lokasi

                    </h3>

                    <p class="mt-1 text-sm text-gray-500">

                        Informasi alamat dan lokasi client.

                    </p>

                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Kota
                            <span class="text-red-500">*</span>

                        </label>

                        <select
                            wire:model="city"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Pilih Kota</option>
                            <option>Jakarta</option>
                            <option>Bandung</option>
                            <option>Surabaya</option>
                            <option>Medan</option>
                        </select>

                    </div>

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-gray-700">

                            Status Client
                            <span class="text-red-500">*</span>

                        </label>

                        <div class="flex overflow-hidden rounded-xl border border-gray-300">

                            <button
                                type="button"
                                class="flex-1 bg-blue-600 py-3 text-sm font-semibold text-white"
                            >
                                Aktif
                            </button>

                            <button
                                type="button"
                                class="flex-1 bg-gray-100 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-200"
                            >
                                Lead
                            </button>

                            <button
                                type="button"
                                class="flex-1 bg-gray-100 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-200"
                            >
                                Nonaktif
                            </button>

                        </div>

                    </div>

                </div>

                <div class="mt-6">

                    <label class="mb-2 block text-sm font-semibold text-gray-700">

                        Alamat Lengkap

                    </label>

                        <textarea
                            wire:model="address"
                            rows="5"
                            class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        ></textarea>

                </div>

            </div>
            

        </div>

    </x-ui.info-card>