@props([
    'emergencyContactSuccess' => '',
])

<section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
        <div class="flex items-center gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600"
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
                        d="M12 9v3.75m9-1.5a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12V16.5Z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Kontak Darurat
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola kontak yang dapat dihubungi dalam keadaan darurat.
                </p>
            </div>
        </div>
    </div>

    <form
        wire:submit="updateEmergencyContacts"
        class="space-y-6 p-5 sm:p-6"
    >
        @if ($emergencyContactSuccess)
            <div
                class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700"
                role="status"
            >
                {{ $emergencyContactSuccess }}
            </div>
        @endif

        @error('emergencyContacts')
            <div
                class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
                role="alert"
            >
                {{ $message }}
            </div>
        @enderror

        {{-- Kontak utama --}}
        <fieldset class="rounded-xl border border-slate-200 p-4 sm:p-5">
            <legend
                class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700"
            >
                Kontak Utama
            </legend>

            <div class="mt-2 grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label
                        for="primary-name"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Nama Lengkap
                    </label>

                    <input
                        id="primary-name"
                        type="text"
                        wire:model="primaryName"
                        maxlength="255"
                        autocomplete="off"
                        placeholder="Masukkan nama kontak utama"
                        class="block min-h-11 w-full rounded-xl border-slate-300 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('primaryName')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="primary-relationship"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Hubungan
                    </label>

                    <input
                        id="primary-relationship"
                        type="text"
                        wire:model="primaryRelationship"
                        maxlength="100"
                        autocomplete="off"
                        placeholder="Contoh: Orang Tua"
                        class="block min-h-11 w-full rounded-xl border-slate-300 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('primaryRelationship')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="primary-phone"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Nomor Telepon
                    </label>

                    <input
                        id="primary-phone"
                        type="tel"
                        wire:model="primaryPhone"
                        maxlength="20"
                        autocomplete="tel"
                        inputmode="tel"
                        placeholder="Contoh: 081234567890"
                        class="block min-h-11 w-full rounded-xl border-slate-300 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('primaryPhone')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </fieldset>

        {{-- Kontak tambahan --}}
        <fieldset class="rounded-xl border border-slate-200 p-4 sm:p-5">
            <legend
                class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600"
            >
                Kontak Tambahan
            </legend>

            <p class="mt-2 text-xs text-slate-500">
                Kontak tambahan bersifat opsional. Kosongkan seluruh kolom
                apabila tidak digunakan.
            </p>

            <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label
                        for="secondary-name"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Nama Lengkap
                    </label>

                    <input
                        id="secondary-name"
                        type="text"
                        wire:model="secondaryName"
                        maxlength="255"
                        autocomplete="off"
                        placeholder="Masukkan nama kontak tambahan"
                        class="block min-h-11 w-full rounded-xl border-slate-300 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('secondaryName')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="secondary-relationship"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Hubungan
                    </label>

                    <input
                        id="secondary-relationship"
                        type="text"
                        wire:model="secondaryRelationship"
                        maxlength="100"
                        autocomplete="off"
                        placeholder="Contoh: Saudara"
                        class="block min-h-11 w-full rounded-xl border-slate-300 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('secondaryRelationship')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="secondary-phone"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Nomor Telepon
                    </label>

                    <input
                        id="secondary-phone"
                        type="tel"
                        wire:model="secondaryPhone"
                        maxlength="20"
                        autocomplete="off"
                        inputmode="tel"
                        placeholder="Contoh: 081298765432"
                        class="block min-h-11 w-full rounded-xl border-slate-300 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('secondaryPhone')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </fieldset>

        <div class="flex justify-end border-t border-slate-100 pt-5">
            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="updateEmergencyContacts"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <svg
                    wire:loading
                    wire:target="updateEmergencyContacts"
                    class="h-4 w-4 animate-spin"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
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
                        d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z"
                    ></path>
                </svg>

                <span
                    wire:loading.remove
                    wire:target="updateEmergencyContacts"
                >
                    Simpan Kontak
                </span>

                <span
                    wire:loading
                    wire:target="updateEmergencyContacts"
                >
                    Menyimpan...
                </span>
            </button>
        </div>
    </form>
</section>