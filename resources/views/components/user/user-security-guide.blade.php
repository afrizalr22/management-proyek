<x-ui.info-card>

    <div class="rounded-2xl bg-slate-900 p-8">

        {{-- Header --}}
        <div class="mb-8">

            <h2 class="text-2xl font-bold text-slate-100">

                Security Guide

            </h2>

            <p class="mt-2 text-sm text-slate-300">

                Pastikan data pengguna memenuhi standar keamanan sistem.

            </p>

        </div>

        {{-- Guide List --}}
        <div class="space-y-6">

            {{-- Item --}}
            <div class="flex items-start gap-4">

                <div class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-green-500">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-3.5 w-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="#FFFFFF"
                        stroke-width="3">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"/>

                    </svg>

                </div>

                <p class="text-sm leading-6 text-slate-300">

                    Email harus unik dan belum digunakan oleh pengguna lain.

                </p>

            </div>

            {{-- Item --}}
            <div class="flex items-start gap-4">

                <div class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-green-500">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-3.5 w-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="#FFFFFF"
                        stroke-width="3">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"/>

                    </svg>

                </div>

                <p class="text-sm leading-6 text-slate-300">

                    Password minimal terdiri dari <strong>8 karakter</strong>.

                </p>

            </div>

            {{-- Item --}}
            <div class="flex items-start gap-4">

                <div class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-green-500">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-3.5 w-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="#FFFFFF"
                        stroke-width="3">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"/>

                    </svg>

                </div>

                <p class="text-sm leading-6 text-slate-300">

                    Hak akses pengguna ditentukan berdasarkan <strong>Role</strong> yang dipilih.

                </p>

            </div>

            {{-- Item --}}
            <div class="flex items-start gap-4">

                <div class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-green-500">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-3.5 w-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="#FFFFFF"
                        stroke-width="3">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"/>

                    </svg>

                </div>

                <p class="text-sm leading-6 text-slate-300">

                    Pengguna dengan status <strong>Inactive</strong> tidak dapat login ke sistem.

                </p>

            </div>

        </div>

    </div>

</x-ui.info-card>