@props([
    'primaryName' => 'Siti Aminah',
    'primaryRelation' => 'Istri',
    'primaryPhone' => '0812-3456-7890',

    'secondaryName' => 'Andi Santoso',
    'secondaryRelation' => 'Saudara',
    'secondaryPhone' => '0812-9876-5432',
])

<section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    {{-- Header --}}
    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600">
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
                    Kontak yang dapat dihubungi dalam keadaan darurat.
                </p>
            </div>
        </div>
    </div>

    {{-- Daftar kontak --}}
    <div class="grid grid-cols-1 gap-4 px-5 py-6 sm:grid-cols-2 sm:px-6">
        {{-- Kontak utama --}}
        <article class="rounded-xl border border-slate-200 bg-slate-50 p-4">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">
                    SA
                </div>

                <div class="min-w-0">
                    <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                        Kontak Utama
                    </span>

                    <p class="mt-3 text-sm font-semibold text-slate-900">
                        {{ $primaryName }}
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        {{ $primaryRelation }}
                    </p>
                </div>
            </div>

            <a
                href="tel:{{ str_replace([' ', '-'], '', $primaryPhone) }}"
                class="mt-4 flex items-center gap-2 rounded-lg bg-white px-3 py-2.5 text-sm font-semibold text-blue-600 transition hover:bg-blue-50"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-4 w-4 shrink-0"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106a1.125 1.125 0 0 0-1.173.417l-.97 1.293a1.125 1.125 0 0 1-1.21.38 12.035 12.035 0 0 1-7.143-7.143 1.125 1.125 0 0 1 .38-1.21l1.293-.97c.368-.276.526-.756.417-1.173L6.963 3.102A1.125 1.125 0 0 0 5.872 2.25H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"
                    />
                </svg>

                {{ $primaryPhone }}
            </a>
        </article>

        {{-- Kontak kedua --}}
        <article class="rounded-xl border border-slate-200 bg-slate-50 p-4">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-200 text-sm font-bold text-slate-700">
                    AS
                </div>

                <div class="min-w-0">
                    <span class="inline-flex rounded-full bg-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-600">
                        Kontak Tambahan
                    </span>

                    <p class="mt-3 text-sm font-semibold text-slate-900">
                        {{ $secondaryName }}
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        {{ $secondaryRelation }}
                    </p>
                </div>
            </div>

            <a
                href="tel:{{ str_replace([' ', '-'], '', $secondaryPhone) }}"
                class="mt-4 flex items-center gap-2 rounded-lg bg-white px-3 py-2.5 text-sm font-semibold text-blue-600 transition hover:bg-blue-50"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-4 w-4 shrink-0"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106a1.125 1.125 0 0 0-1.173.417l-.97 1.293a1.125 1.125 0 0 1-1.21.38 12.035 12.035 0 0 1-7.143-7.143 1.125 1.125 0 0 1 .38-1.21l1.293-.97c.368-.276.526-.756.417-1.173L6.963 3.102A1.125 1.125 0 0 0 5.872 2.25H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"
                    />
                </svg>

                {{ $secondaryPhone }}
            </a>
        </article>
    </div>
</section>