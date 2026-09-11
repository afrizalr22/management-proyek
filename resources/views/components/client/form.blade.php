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
                        @class([
                            'w-full rounded-xl px-4 py-3 outline-none transition focus:ring-2',
                            'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                                $errors->has('name'),
                            'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                                !$errors->has('name'),
                        ])
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
                        @class([
                            'w-full rounded-xl px-4 py-3 outline-none transition focus:ring-2',
                            'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                                $errors->has('company'),
                            'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                                !$errors->has('company'),
                        ])
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
                        @class([
                            'w-full rounded-xl px-4 py-3 outline-none transition focus:ring-2',
                            'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                                $errors->has('email'),
                            'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                                !$errors->has('email'),
                        ])
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
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="flex">
                        <span
                            @class([
                                'flex items-center rounded-l-xl border border-r-0 bg-gray-100 px-4 text-gray-600',
                                'border-red-400' =>
                                    $errors->has('phone'),
                                'border-gray-300' =>
                                    !$errors->has('phone'),
                            ])
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
                            @class([
                                'w-full rounded-r-xl px-4 py-3 outline-none transition focus:ring-2',
                                'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                                    $errors->has('phone'),
                                'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                                    !$errors->has('phone'),
                            ])
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
                <div
                    class="relative"
                    x-data="{
                        open: false,
                        query: '',

                        cities: @js([
                            'Banda Aceh',
                            'Medan',
                            'Padang',
                            'Pekanbaru',
                            'Tanjung Pinang',
                            'Jambi',
                            'Palembang',
                            'Pangkal Pinang',
                            'Bengkulu',
                            'Bandar Lampung',
                            'Jakarta',
                            'Bogor',
                            'Depok',
                            'Tangerang',
                            'Tangerang Selatan',
                            'Bekasi',
                            'Bandung',
                            'Cirebon',
                            'Semarang',
                            'Surakarta',
                            'Yogyakarta',
                            'Surabaya',
                            'Malang',
                            'Serang',
                            'Denpasar',
                            'Mataram',
                            'Kupang',
                            'Pontianak',
                            'Palangka Raya',
                            'Banjarmasin',
                            'Samarinda',
                            'Tanjung Selor',
                            'Manado',
                            'Gorontalo',
                            'Palu',
                            'Makassar',
                            'Kendari',
                            'Mamuju',
                            'Ambon',
                            'Sofifi',
                            'Jayapura',
                            'Manokwari',
                            'Sorong',
                            'Merauke',
                            'Nabire',
                            'Wamena',
                        ]),

                        get filteredCities() {
                            const keyword = this.query
                                .trim()
                                .toLowerCase();

                            if (keyword === '') {
                                return this.cities;
                            }

                            return this.cities.filter(
                                (cityOption) =>
                                    cityOption
                                        .toLowerCase()
                                        .includes(keyword)
                            );
                        },

                        selectCity(cityOption) {
                            this.query = cityOption;
                            this.$wire.set(
                                'city',
                                cityOption
                            );
                            this.open = false;
                        },

                        updateCity() {
                            this.$wire.set(
                                'city',
                                this.query
                            );
                            this.open = true;
                        }
                    }"
                    x-init="query = $wire.city ?? ''"
                    x-on:click.outside="open = false"
                    x-on:keydown.escape.window="open = false"
                >
                    <label
                        for="clientCity"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Kota
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <input
                            id="clientCity"
                            type="text"
                            x-model="query"
                            x-on:focus="open = true"
                            x-on:input.debounce.250ms="updateCity()"
                            x-on:keydown.arrow-down.prevent="
                                open = true;

                                $nextTick(() => {
                                    $refs.cityList
                                        ?.querySelector('button')
                                        ?.focus();
                                });
                            "
                            autocomplete="off"
                            placeholder="Ketik atau pilih kota"
                            @class([
                                'w-full rounded-xl py-3 pl-4 pr-11 text-left outline-none transition focus:ring-2',
                                'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                                    $errors->has('city'),
                                'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                                    !$errors->has('city'),
                            ])
                        >

                        <button
                            type="button"
                            aria-label="Tampilkan pilihan kota"
                            x-on:click="
                                open = !open;

                                if (open) {
                                    $nextTick(() => {
                                        document
                                            .getElementById(
                                                'clientCity'
                                            )
                                            ?.focus();
                                    });
                                }
                            "
                            class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-gray-400 transition hover:text-gray-600"
                        >
                            <svg
                                x-bind:class="{
                                    'rotate-180': open
                                }"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                                class="h-5 w-5 transition-transform duration-200"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m6 9 6 6 6-6"
                                />
                            </svg>
                        </button>
                    </div>

                    <div
                        x-ref="cityList"
                        x-show="open"
                        x-transition:enter="transition duration-150 ease-out"
                        x-transition:enter-start="translate-y-1 opacity-0"
                        x-transition:enter-end="translate-y-0 opacity-100"
                        x-transition:leave="transition duration-100 ease-in"
                        x-transition:leave-start="translate-y-0 opacity-100"
                        x-transition:leave-end="translate-y-1 opacity-0"
                        x-cloak
                        class="absolute left-0 right-0 top-full z-40 mt-2 max-h-64 overflow-y-auto rounded-xl border border-gray-200 bg-white p-1.5 shadow-xl"
                    >
                        <template
                            x-for="cityOption in filteredCities"
                            x-bind:key="cityOption"
                        >
                            <button
                                type="button"
                                x-on:mousedown.prevent
                                x-on:click="
                                    selectCity(cityOption)
                                "
                                x-on:keydown.arrow-down.prevent="
                                    $el.nextElementSibling
                                        ?.focus()
                                "
                                x-on:keydown.arrow-up.prevent="
                                    $el.previousElementSibling
                                        ?.focus()
                                "
                                x-on:keydown.enter.prevent="
                                    selectCity(cityOption)
                                "
                                class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-left text-sm text-gray-700 transition hover:bg-blue-50 hover:text-blue-700 focus:bg-blue-50 focus:text-blue-700 focus:outline-none"
                            >
                                <span
                                    x-text="cityOption"
                                ></span>

                                <svg
                                    x-show="
                                        query === cityOption
                                    "
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    class="h-4 w-4 shrink-0 text-blue-600"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m5 12 4 4L19 6"
                                    />
                                </svg>
                            </button>
                        </template>

                        <div
                            x-show="
                                filteredCities.length === 0
                            "
                            class="px-3 py-4 text-center"
                        >
                            <p class="text-sm font-medium text-gray-700">
                                Kota tidak ditemukan
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Nama kota yang diketik tetap
                                dapat digunakan.
                            </p>
                        </div>
                    </div>

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
                        @class([
                            'flex overflow-hidden rounded-xl border',
                            'border-red-400' =>
                                $errors->has('status'),
                            'border-gray-300' =>
                                !$errors->has('status'),
                        ])
                    >
                        <button
                            type="button"
                            wire:click="$set('status', 'active')"
                            @class([
                                'flex-1 py-3 text-sm font-semibold transition',
                                'bg-blue-600 text-white' =>
                                    $status === 'active',
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
                                'bg-yellow-500 text-white' =>
                                    $status === 'lead',
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
                                'bg-red-600 text-white' =>
                                    $status === 'inactive',
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
                    @class([
                        'w-full resize-y rounded-xl px-4 py-3 outline-none transition focus:ring-2',
                        'border-red-400 focus:border-red-500 focus:ring-red-100' =>
                            $errors->has('address'),
                        'border-gray-300 focus:border-blue-500 focus:ring-blue-100' =>
                            !$errors->has('address'),
                    ])
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