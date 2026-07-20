@props([
    'mode' => 'create',
])

<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div>

            <h2 class="text-2xl font-bold text-gray-800">

                General Information

            </h2>

            <p class="mt-2 text-gray-500">

                Lengkapi informasi dasar proyek sebelum melanjutkan ke tahap berikutnya.

            </p>

        </div>

        <hr class="my-8">

        <div class="space-y-6">

            {{-- Nama Project --}}
            <div>

                <label class="mb-2 block text-sm font-semibold text-gray-700">

                    Nama Project
                    <span class="text-red-500">*</span>

                </label>

                <input
                    type="text"
                    value="{{ $mode === 'edit' ? 'Renovasi Gedung Kantor PT ABC' : '' }}"
                    placeholder="Contoh: Renovasi Gedung Kantor PT ABC"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                >

                <p class="mt-2 text-xs text-gray-500">

                    Gunakan nama project yang mudah dikenali.

                </p>

            </div>

            {{-- Client & Mandor --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Client --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-gray-700">

                        Client
                        <span class="text-red-500">*</span>

                    </label>

                    <select
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >

                        <option disabled {{ $mode === 'create' ? 'selected' : '' }}>

                            Pilih Client

                        </option>

                        <option {{ $mode === 'edit' ? 'selected' : '' }}>

                            PT Tekno Konstruksi Utama

                        </option>

                        <option>

                            PT Maju Bersama

                        </option>

                        <option>

                            CV Nusantara

                        </option>

                    </select>

                    <p class="mt-2 text-xs text-gray-500">

                        Client yang dipilih akan menjadi pemilik project.

                    </p>

                </div>

                {{-- Mandor --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-gray-700">

                        Mandor
                        <span class="text-red-500">*</span>

                    </label>

                    <select
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >

                        <option disabled {{ $mode === 'create' ? 'selected' : '' }}>

                            Pilih Mandor

                        </option>

                        <option {{ $mode === 'edit' ? 'selected' : '' }}>

                            Ahmad Fauzi

                        </option>

                        <option>

                            Rudi Hartono

                        </option>

                        <option>

                            Dedi Saputra

                        </option>

                    </select>

                    <p class="mt-2 text-xs text-gray-500">

                        Mandor bertanggung jawab terhadap pelaksanaan project.

                    </p>

                </div>

            </div>

            {{-- Alamat Project --}}
            <div>

                <label class="mb-2 block text-sm font-semibold text-gray-700">

                    Alamat Project
                    <span class="text-red-500">*</span>

                </label>

                <textarea
                    rows="4"
                    placeholder="Contoh: Jl. Jenderal Sudirman No.45, Kebayoran Baru, Jakarta Selatan"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                >{{ $mode === 'edit' ? 'Jl. Jenderal Sudirman No.45, Kebayoran Baru, Jakarta Selatan' : '' }}</textarea>

                <p class="mt-2 text-xs text-gray-500">

                    Masukkan alamat lengkap lokasi pelaksanaan project.

                </p>

            </div>

            {{-- Deskripsi --}}
            <div>

                <label class="mb-2 block text-sm font-semibold text-gray-700">

                    Deskripsi Project

                </label>

                <textarea
                    rows="6"
                    placeholder="Tuliskan ruang lingkup pekerjaan, tujuan project, atau informasi tambahan..."
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                >{{ $mode === 'edit'
                    ? 'Renovasi gedung kantor meliputi pekerjaan interior, plafon, pengecatan, instalasi listrik, serta penggantian lantai.'
                    : '' }}</textarea>

                <p class="mt-2 text-xs text-gray-500">

                    Deskripsi bersifat opsional namun disarankan untuk memudahkan identifikasi project.

                </p>

            </div>

        </div>

    </div>

</x-ui.info-card>