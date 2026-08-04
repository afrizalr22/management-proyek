<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-gray-200 p-6">

        <div>

            <h2 class="text-lg font-semibold text-gray-900">
                Aktivitas Terbaru
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Aktivitas terbaru yang terjadi pada sistem.
            </p>

        </div>

        <a
            href="#"
            class="text-sm font-medium text-blue-600 transition hover:text-blue-700"
        >
            Lihat Semua
        </a>

    </div>

    {{-- Timeline --}}
    <div class="p-6">

        <div class="relative">

            {{-- Vertical Line --}}
            <div
                class="absolute left-5 top-5 bottom-5 w-px bg-gray-200">
            </div>

            <div class="space-y-8">

                {{-- Item 1 --}}
                <div class="relative flex items-start gap-4">

                    <div class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600 ring-4 ring-white">

                        <x-icon.project-activity class="h-5 w-5"/>

                    </div>

                    <div class="pt-1">

                        <h3 class="font-semibold text-gray-900">
                            Project Rumah Budi dibuat
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Project Management
                        </p>

                        <p class="mt-2 text-xs font-medium uppercase tracking-wide text-gray-400">
                            2 Jam Yang Lalu
                        </p>

                    </div>

                </div>

                {{-- Item 2 --}}
                <div class="relative flex items-start gap-4">

                    <div class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600 ring-4 ring-white">

                        <x-icon.client-activity class="h-5 w-5"/>

                    </div>

                    <div class="pt-1">

                        <h3 class="font-semibold text-gray-900">
                            Client PT Maju Bersama ditambahkan
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Client Management
                        </p>

                        <p class="mt-2 text-xs font-medium uppercase tracking-wide text-gray-400">
                            Kemarin
                        </p>

                    </div>

                </div>

                {{-- Item 3 --}}
                <div class="relative flex items-start gap-4">

                    <div class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-yellow-100 text-yellow-600 ring-4 ring-white">

                        <x-icon.monitoring-activity class="h-5 w-5"/>

                    </div>

                    <div class="pt-1">

                        <h3 class="font-semibold text-gray-900">
                            Progress Gudang ABC diperbarui
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Monitoring
                        </p>

                        <p class="mt-2 text-xs font-medium uppercase tracking-wide text-gray-400">
                            2 Hari Yang Lalu
                        </p>

                    </div>

                </div>

                {{-- Item 4 --}}
                <div class="relative flex items-start gap-4 opacity-70">

                    <div class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-600 ring-4 ring-white">

                        <x-icon.invoice-activity class="h-5 w-5"/>

                    </div>

                    <div class="pt-1">

                        <h3 class="font-semibold text-gray-700">
                            Invoice berhasil dibuat
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Administration
                        </p>

                        <p class="mt-2 text-xs font-medium uppercase tracking-wide text-gray-400">
                            3 Hari Yang Lalu
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>