<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">

            <div>

                <h2 class="text-2xl font-bold text-gray-800">

                    Recent Activity

                </h2>

                <p class="mt-2 text-gray-500">

                    Aktivitas terakhir yang dilakukan pengguna.

                </p>

            </div>

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 8v4l3 3" />

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 12a9 9 0 1018 0 9 9 0 00-18 0z" />

            </svg>

        </div>

        {{-- Timeline --}}
        <div class="relative">

            {{-- Vertical Line --}}
            <div class="absolute left-[18px] top-5 bottom-5 w-px bg-gray-200"></div>

            <div class="space-y-8">

                {{-- Activity 1 --}}
                <div class="relative flex gap-4">

                    <div class="relative z-10 flex h-9 w-9 items-center justify-center rounded-full bg-black text-white shadow">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 3v12m0 0l3-3m-3 3l-3-3M5 21h14" />

                        </svg>

                    </div>

                    <div>

                        <h4 class="font-semibold text-gray-900">

                            Upload Daily Report

                        </h4>

                        <p class="mt-1 text-sm text-gray-500">

                            Proyek Apartemen Grand Skyline

                        </p>

                        <span class="mt-2 block text-xs text-gray-400">

                            Hari ini, 08:30 WIB

                        </span>

                    </div>

                </div>

                {{-- Activity 2 --}}
                <div class="relative flex gap-4">

                    <div class="relative z-10 flex h-9 w-9 items-center justify-center rounded-full bg-blue-600 text-white shadow">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 13l4 4L19 7" />

                        </svg>

                    </div>

                    <div>

                        <h4 class="font-semibold text-gray-900">

                            Menyelesaikan Tahap Fondasi

                        </h4>

                        <p class="mt-1 text-sm text-gray-500">

                            Pengecoran Zona B selesai 100%

                        </p>

                        <span class="mt-2 block text-xs text-gray-400">

                            Kemarin, 16:45 WIB

                        </span>

                    </div>

                </div>

                {{-- Activity 3 --}}
                <div class="relative flex gap-4">

                    <div class="relative z-10 flex h-9 w-9 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-500 shadow-sm">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M17 20h5V4H2v16h5m10 0v-8H7v8m10 0H7" />

                        </svg>

                    </div>

                    <div>

                        <h4 class="font-semibold text-gray-900">

                            Update Status Kehadiran

                        </h4>

                        <p class="mt-1 text-sm text-gray-500">

                            Check-in melalui aplikasi mobile.

                        </p>

                        <span class="mt-2 block text-xs text-gray-400">

                            05 Mar, 07:00 WIB

                        </span>

                    </div>

                </div>

                {{-- Activity 4 --}}
                <div class="relative flex gap-4">

                    <div class="relative z-10 flex h-9 w-9 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-400 shadow-sm">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 8v4l3 3" />

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 12a9 9 0 1018 0 9 9 0 00-18 0z" />

                        </svg>

                    </div>

                    <div>

                        <h4 class="font-semibold text-gray-500">

                            Mengubah Detail Jadwal Kru

                        </h4>

                        <p class="mt-1 text-sm text-gray-400">

                            Penyesuaian shift malam Zona C.

                        </p>

                        <span class="mt-2 block text-xs text-gray-400">

                            04 Mar, 11:20 WIB

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>