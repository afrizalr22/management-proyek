<form
    wire:submit.prevent="createUser"
    class="space-y-6"
    novalidate
>
    {{-- Header --}}
    <x-user.user-create-header />

    {{-- Kesalahan penyimpanan --}}
    @error('save')
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
            role="alert"
        >
            {{ $message }}
        </div>
    @enderror

    {{-- Ringkasan kesalahan validasi --}}
    @if ($errors->any())
        <div
            class="rounded-xl border border-red-200 bg-red-50 px-5 py-4"
            role="alert"
        >
            <p class="font-semibold text-red-700">
                Data belum dapat disimpan
            </p>

            <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        {{-- Konten utama --}}
        <div class="space-y-6 xl:col-span-2">
            <x-user.user-identity-form />

            <x-user.user-role-form
                :role="$role"
                :status="$status"
            />

            <x-user.user-password-form />
        </div>

        {{-- Sidebar --}}
        <aside class="space-y-6">
            <x-user.user-security-guide />

            <x-user.user-profile-preview
                :name="$name"
                :email="$email"
                :phone="$phone"
                :role="$role"
                :status="$status"
            />
        </aside>
    </div>

    {{-- Tombol tindakan --}}
    <div
        class="flex flex-col-reverse gap-4 rounded-2xl border border-gray-200 bg-white p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5"
    >
        <p class="text-sm text-gray-500">
            Pastikan informasi, role, dan status pengguna sudah sesuai.
        </p>

        <div class="flex flex-col-reverse gap-3 sm:flex-row">
            <a
                href="{{ route('owner.users.index') }}"
                wire:navigate
                wire:loading.class="pointer-events-none opacity-60"
                wire:target="createUser"
                class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100"
            >
                Batal
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="createUser"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span
                    wire:loading.remove
                    wire:target="createUser"
                >
                    Simpan Pengguna
                </span>

                <span
                    wire:loading
                    wire:target="createUser"
                    class="items-center gap-2"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        class="h-4 w-4 animate-spin"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>

                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"
                        ></path>
                    </svg>

                    Menyimpan...
                </span>
            </button>
        </div>
    </div>
</form>