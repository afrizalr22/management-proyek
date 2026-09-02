@props([
    'email' => 'budi.santoso@example.com',
    'phone' => '0812-3456-7890',
    'address' => 'Jl. Kebagusan Raya, Pasar Minggu, Jakarta Selatan',
])

<section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
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
                        d="M21.75 12c0 1.05-.166 2.06-.474 3.007m-2.574 3.695A9.716 9.716 0 0 1 12 21.75C6.615 21.75 2.25 17.385 2.25 12S6.615 2.25 12 2.25 21.75 6.615 21.75 12Z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8.25 9.75h7.5m-7.5 4.5h4.5"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Informasi Kontak
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi yang dapat digunakan untuk menghubungi Anda.
                </p>
            </div>
        </div>
    </div>

    {{-- Detail kontak --}}
    <div class="divide-y divide-slate-100 px-5 sm:px-6">
        {{-- Email --}}
        <div class="flex items-start gap-4 py-5">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
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
                        d="M21.75 6.75v10.5A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0-8.568 5.355a2.25 2.25 0 0 1-2.364 0L2.25 6.75"
                    />
                </svg>
            </div>

            <div class="min-w-0">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Email
                </p>

                <p class="mt-1 break-all text-sm font-semibold text-slate-800">
                    {{ $email }}
                </p>
            </div>
        </div>

        {{-- Telepon --}}
        <div class="flex items-start gap-4 py-5">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
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
                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106a1.125 1.125 0 0 0-1.173.417l-.97 1.293a1.125 1.125 0 0 1-1.21.38 12.035 12.035 0 0 1-7.143-7.143 1.125 1.125 0 0 1 .38-1.21l1.293-.97c.368-.276.526-.756.417-1.173L6.963 3.102A1.125 1.125 0 0 0 5.872 2.25H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"
                    />
                </svg>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Nomor Telepon
                </p>

                <p class="mt-1 text-sm font-semibold text-slate-800">
                    {{ $phone }}
                </p>
            </div>
        </div>

        {{-- Alamat --}}
        <div class="flex items-start gap-4 py-5">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
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
                        d="M12 21s7.5-4.35 7.5-11.25a7.5 7.5 0 1 0-15 0C4.5 16.65 12 21 12 21Z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M14.25 9.75a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"
                    />
                </svg>
            </div>

            <div class="min-w-0">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Alamat
                </p>

                <p class="mt-1 text-sm font-semibold leading-6 text-slate-800">
                    {{ $address }}
                </p>
            </div>
        </div>
    </div>
</section>