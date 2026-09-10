@props([
    'user',
    'photo' => null,
    'photoSuccess' => '',
])

@php
    $initials = \Illuminate\Support\Str::of(
        $user->name
    )
        ->explode(' ')
        ->filter()
        ->take(2)
        ->map(
            fn (string $name): string =>
                strtoupper(
                    mb_substr($name, 0, 1)
                )
        )
        ->implode('');

    $initials = $initials ?: 'O';

    $existingPhotoUrl = filled($user->photo)
        ? \Illuminate\Support\Facades\Storage::url(
            $user->photo
        )
        : null;

    $previewPhotoUrl = $photo
        ? $photo->temporaryUrl()
        : $existingPhotoUrl;

    $statusText = $user->status === 'active'
        ? 'Aktif'
        : 'Tidak Aktif';

    $statusColor = $user->status === 'active'
        ? 'green'
        : 'red';
@endphp

<x-ui.info-card class="h-full">
    <div class="p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                Informasi Akun
            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500">
                Foto dan informasi dasar akun yang sedang digunakan.
            </p>
        </div>

        <div class="mt-8 text-center">
            <div class="relative mx-auto h-32 w-32">
                @if ($previewPhotoUrl)
                    <img
                        src="{{ $previewPhotoUrl }}"
                        alt="Foto profil {{ $user->name }}"
                        class="h-32 w-32 rounded-full border-4 border-white object-cover shadow-lg ring-1 ring-gray-200"
                    >
                @else
                    <div class="flex h-32 w-32 items-center justify-center rounded-full border-4 border-white bg-blue-600 text-4xl font-bold text-white shadow-lg ring-1 ring-gray-200">
                        {{ $initials }}
                    </div>
                @endif

                <label
                    for="owner-profile-photo"
                    class="absolute bottom-1 right-1 flex h-10 w-10 cursor-pointer items-center justify-center rounded-full border-4 border-white bg-blue-600 text-white shadow-md transition hover:bg-blue-700"
                    title="Pilih foto profil"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175A2.25 2.25 0 0 0 2.25 9.625v8.5a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25v-8.5a2.25 2.25 0 0 0-1.802-2.22 48.424 48.424 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.233a2.25 2.25 0 0 0-1.872-1.002H9.52a2.25 2.25 0 0 0-1.872 1.002l-.821 1.233Z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 12.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                        />
                    </svg>
                </label>

                <input
                    id="owner-profile-photo"
                    type="file"
                    wire:model="photo"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    class="hidden"
                >
            </div>

            <h3 class="mt-5 text-xl font-bold text-gray-900">
                {{ $user->name }}
            </h3>

            <p class="mt-1 break-words text-sm text-gray-500">
                {{ $user->email }}
            </p>

            <div class="mt-3 flex flex-wrap items-center justify-center gap-2">
                <x-ui.badge color="blue">
                    Owner
                </x-ui.badge>

                <x-ui.badge :color="$statusColor">
                    {{ $statusText }}
                </x-ui.badge>
            </div>
        </div>

        <div
            wire:loading.flex
            wire:target="photo"
            class="mt-5 items-center justify-center gap-2 rounded-xl bg-blue-50 px-4 py-3 text-sm text-blue-700"
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

            Memuat foto...
        </div>

        @error('photo')
            <div
                class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                role="alert"
            >
                {{ $message }}
            </div>
        @enderror

        @error('photoSave')
            <div
                class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                role="alert"
            >
                {{ $message }}
            </div>
        @enderror

        @if ($photoSuccess)
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 4000)"
                x-show="show"
                x-transition.opacity
                class="mt-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
                role="status"
            >
                {{ $photoSuccess }}
            </div>
        @endif

        <div class="mt-5 flex flex-col gap-3">
            <button
                type="button"
                wire:click="updatePhoto"
                wire:loading.attr="disabled"
                wire:target="updatePhoto,photo"
                class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-gray-300 disabled:text-gray-500"
            >
                <span
                    wire:loading.remove
                    wire:target="updatePhoto"
                >
                    Simpan Foto
                </span>

                <span
                    wire:loading
                    wire:target="updatePhoto"
                >
                    Menyimpan...
                </span>
            </button>

            @if ($user->photo)
                <button
                    type="button"
                    wire:click="removePhoto"
                    wire:loading.attr="disabled"
                    wire:target="removePhoto"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span
                        wire:loading.remove
                        wire:target="removePhoto"
                    >
                        Hapus Foto
                    </span>

                    <span
                        wire:loading
                        wire:target="removePhoto"
                    >
                        Menghapus...
                    </span>
                </button>
            @endif
        </div>

        <p class="mt-4 text-center text-xs leading-5 text-gray-400">
            JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
        </p>

        <hr class="my-6 border-gray-200">

        <dl class="space-y-5">
            <div>
                <dt class="text-sm text-gray-500">
                    Nomor Telepon
                </dt>

                <dd class="mt-1 font-medium text-gray-800">
                    {{ $user->phone ?: '-' }}
                </dd>
            </div>

            <div>
                <dt class="text-sm text-gray-500">
                    Verifikasi Email
                </dt>

                <dd class="mt-1">
                    @if ($user->email_verified_at)
                        <span class="text-sm font-semibold text-green-600">
                            Terverifikasi
                        </span>
                    @else
                        <span class="text-sm font-semibold text-amber-600">
                            Belum terverifikasi
                        </span>
                    @endif
                </dd>
            </div>

            <div>
                <dt class="text-sm text-gray-500">
                    Akun Dibuat
                </dt>

                <dd class="mt-1 text-sm font-medium text-gray-800">
                    {{ $user->created_at
                        ?->translatedFormat('d F Y, H:i') ?? '-' }}
                </dd>
            </div>

            <div>
                <dt class="text-sm text-gray-500">
                    Terakhir Diperbarui
                </dt>

                <dd class="mt-1 text-sm font-medium text-gray-800">
                    {{ $user->updated_at
                        ?->translatedFormat('d F Y, H:i') ?? '-' }}
                </dd>
            </div>
        </dl>
    </div>
</x-ui.info-card>