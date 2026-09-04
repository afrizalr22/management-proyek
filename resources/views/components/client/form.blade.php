@props([
    'status' => 'active',
])

<x-ui.info-card>
    <div class="space-y-10 p-8">

        {{-- Identitas utama --}}
        <div>
            <div class="mb-8 border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    Identitas Utama
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Informasi dasar mengenai Client.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                {{-- Nama Client --}}
                <div>
                    <label
                        for="clientName"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Nama Lengkap Client
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="clientName"
                        type="text"
                        wire:model.blur="name"
                        autocomplete="name"
                        class="w-full rounded-xl px-4 py-3 outline-none transition focus:ring-2
                            @error('name')
                                border-red-400 focus:border-red-500 focus:ring-red-100
                            @else
                                border-gray-300 focus:border-blue-500 focus:ring-blue-100
                            @enderror"
                    >

                    @error('name')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Perusahaan --}}
                <div>
                    <label
                        for="company"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Nama Perusahaan
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="company"
                        type="text"
                        wire:model.blur="company"
                        autocomplete="organization"
                        class="w-full rounded-xl px-4 py-3 outline-none transition focus:ring-2
                            @error('company')
                                border-red-400 focus:border-red-500 focus:ring-red-100
                            @else
                                border-gray-300 focus:border-blue-500 focus:ring-blue-100
                            @enderror"
                    >

                    @error('company')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label
                        for="clientEmail"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Email Bisnis
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="clientEmail"
                        type="email"
                        wire:model.blur="email"
                        autocomplete="email"
                        class="w-full rounded-xl px-4 py-3 outline-none transition focus:ring-2
                            @error('email')
                                border-red-400 focus:border-red-500 focus:ring-red-100
                            @else
                                border-gray-300 focus:border-blue-500 focus:ring-blue-100
                            @enderror"
                    >

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Telepon --}}
                <div>
                    <label
                        for="clientPhone"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Nomor Telepon
                    </label>

                    <div class="flex">
                        <span
                            class="flex items-center rounded-l-xl border border-r-0 border-gray-300 bg-gray-100 px-4 text-gray-600"
                        >
                            +62
                        </span>

                        <input
                            id="clientPhone"
                            type="text"
                            wire:model.blur="phone"
                            inputmode="numeric"
                            autocomplete="tel"
                            placeholder="81234567890"
                            class="w-full rounded-r-xl px-4 py-3 outline-none transition focus:ring-2
                                @error('phone')
                                    border-red-400 focus:border-red-500 focus:ring-red-100
                                @else
                                    border-gray-300 focus:border-blue-500 focus:ring-blue-100
                                @enderror"
                        >
                    </div>

                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Detail lokasi --}}
        <div>
            <div class="mb-8 border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    Detail Lokasi
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Informasi alamat dan lokasi Client.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                {{-- Kota --}}
                <div>
                    <label
                        for="clientCity"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Kota
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="clientCity"
                        wire:model="city"
                        class="w-full rounded-xl px-4 py-3 outline-none transition focus:ring-2
                            @error('city')
                                border-red-400 focus:border-red-500 focus:ring-red-100
                            @else
                                border-gray-300 focus:border-blue-500 focus:ring-blue-100
                            @enderror"
                    >
                        <option value="">Pilih Kota</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Medan">Medan</option>
                    </select>

                    @error('city')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <span class="mb-2 block text-sm font-semibold text-gray-700">
                        Status Client
                        <span class="text-red-500">*</span>
                    </span>

                    <div
                        class="flex overflow-hidden rounded-xl border
                            @error('status')
                                border-red-400
                            @else
                                border-gray-300
                            @enderror"
                    >
                        <button
                            type="button"
                            wire:click="$set('status', 'active')"
                            @class([
                                'flex-1 py-3 text-sm font-semibold transition',
                                'bg-blue-600 text-white' => $status === 'active',
                                'bg-gray-100 text-gray-700 hover:bg-gray-200' =>
                                    $status !== 'active',
                            ])
                        >
                            Aktif
                        </button>

                        <button
                            type="button"
                            wire:click="$set('status', 'lead')"
                            @class([
                                'flex-1 border-x border-gray-300 py-3 text-sm font-semibold transition',
                                'bg-yellow-500 text-white' => $status === 'lead',
                                'bg-gray-100 text-gray-700 hover:bg-gray-200' =>
                                    $status !== 'lead',
                            ])
                        >
                            Lead
                        </button>

                        <button
                            type="button"
                            wire:click="$set('status', 'inactive')"
                            @class([
                                'flex-1 py-3 text-sm font-semibold transition',
                                'bg-red-600 text-white' => $status === 'inactive',
                                'bg-gray-100 text-gray-700 hover:bg-gray-200' =>
                                    $status !== 'inactive',
                            ])
                        >
                            Nonaktif
                        </button>
                    </div>

                    @error('status')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            {{-- Alamat --}}
            <div class="mt-6">
                <label
                    for="clientAddress"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Alamat Lengkap
                </label>

                <textarea
                    id="clientAddress"
                    wire:model.blur="address"
                    rows="5"
                    maxlength="2000"
                    class="w-full resize-y rounded-xl px-4 py-3 outline-none transition focus:ring-2
                        @error('address')
                            border-red-400 focus:border-red-500 focus:ring-red-100
                        @else
                            border-gray-300 focus:border-blue-500 focus:ring-blue-100
                        @enderror"
                ></textarea>

                @error('address')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>
    </div>
</x-ui.info-card>