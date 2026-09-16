<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">
        <div class="flex items-center gap-4">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-6 w-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Informasi Pengguna
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Lengkapi identitas dasar pengguna.
                </p>
            </div>
        </div>

        <hr class="my-6 border-gray-200 sm:my-8">

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            {{-- Nama --}}
            <div>
                <label
                    for="user-name"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Nama Lengkap
                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="user-name"
                    type="text"
                    wire:model.live.debounce.300ms="name"
                    placeholder="Masukkan nama lengkap"
                    autocomplete="name"
                    @class([
                        'min-h-11 w-full rounded-xl px-4 py-3 text-sm focus:ring-blue-500',
                        'border-red-300 focus:border-red-500' =>
                            $errors->has('name'),
                        'border-gray-300 focus:border-blue-500' =>
                            !$errors->has('name'),
                    ])
                >

                @error('name')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Telepon --}}
            <div>
                <label
                    for="user-phone"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Nomor Telepon
                </label>

                <input
                    id="user-phone"
                    type="text"
                    wire:model.blur="phone"
                    placeholder="Contoh: 081234567890"
                    autocomplete="tel"
                    @class([
                        'min-h-11 w-full rounded-xl px-4 py-3 text-sm focus:ring-blue-500',
                        'border-red-300 focus:border-red-500' =>
                            $errors->has('phone'),
                        'border-gray-300 focus:border-blue-500' =>
                            !$errors->has('phone'),
                    ])
                >

                @error('phone')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="md:col-span-2">
                <label
                    for="user-email"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Alamat Email
                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="user-email"
                    type="email"
                    wire:model.live.debounce.300ms="email"
                    placeholder="contoh@email.com"
                    autocomplete="email"
                    @class([
                        'min-h-11 w-full rounded-xl px-4 py-3 text-sm focus:ring-blue-500',
                        'border-red-300 focus:border-red-500' =>
                            $errors->has('email'),
                        'border-gray-300 focus:border-blue-500' =>
                            !$errors->has('email'),
                    ])
                >

                @error('email')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
    </div>
</x-ui.info-card>