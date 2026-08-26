@php

    $tasks = [

        [
            'time' => '08:00 - 10:00',
            'name' => 'Pengecoran Kolom Lantai 2',
            'location' => 'Area Timur',
            'workers' => 8,
            'progress' => 75,
            'status' => 'In Progress',
        ],

        [
            'time' => '10:00 - 12:00',
            'name' => 'Pemasangan Bekisting',
            'location' => 'Area Barat',
            'workers' => 6,
            'progress' => 45,
            'status' => 'In Progress',
        ],

        [
            'time' => '13:00 - 15:00',
            'name' => 'Pemasangan Tulangan',
            'location' => 'Lantai 2',
            'workers' => 10,
            'progress' => 100,
            'status' => 'Completed',
        ],

        [
            'time' => '15:00 - 17:00',
            'name' => 'Persiapan Material',
            'location' => 'Gudang Material',
            'workers' => 4,
            'progress' => 0,
            'status' => 'Pending',
        ],

    ];

@endphp


<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-2xl font-bold text-gray-800">
                    Today's Schedule
                </h2>

                <p class="mt-2 text-gray-500">
                    Jadwal pekerjaan yang harus dilakukan hari ini.
                </p>

            </div>

            <span
                class="inline-flex w-fit items-center rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-600"
            >
                4 Tasks
            </span>

        </div>


        {{-- Schedule --}}
        <div class="mt-8 space-y-4">

            @foreach($tasks as $task)

                @php

                    $statusClass = match ($task['status']) {

                        'Completed'
                            => 'bg-emerald-50 text-emerald-700',

                        'In Progress'
                            => 'bg-blue-50 text-blue-700',

                        default
                            => 'bg-gray-100 text-gray-600',

                    };

                    $progressClass = match ($task['status']) {

                        'Completed'
                            => 'bg-emerald-500',

                        'In Progress'
                            => 'bg-blue-600',

                        default
                            => 'bg-gray-300',

                    };

                @endphp


                <div
                    class="rounded-2xl border border-gray-200 p-5 transition duration-200 hover:border-blue-200 hover:bg-blue-50/30"
                >

                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center">

                        {{-- Time --}}
                        <div class="w-full lg:w-32">

                            <p class="text-sm font-semibold text-gray-700">
                                {{ $task['time'] }}
                            </p>

                            <p class="mt-1 text-xs text-gray-400">
                                Today
                            </p>

                        </div>


                        {{-- Task --}}
                        <div class="flex-1">

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                <div>

                                    <h3 class="font-semibold text-gray-800">
                                        {{ $task['name'] }}
                                    </h3>

                                    <div class="mt-2 flex flex-wrap items-center gap-4 text-sm text-gray-500">

                                        <span class="flex items-center gap-1.5">

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                                />

                                            </svg>

                                            {{ $task['location'] }}

                                        </span>


                                        <span class="flex items-center gap-1.5">

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-9a4 4 0 11-8 0 4 4 0 018 0zm6 2a3 3 0 10-6 0"
                                                />

                                            </svg>

                                            {{ $task['workers'] }} Workers

                                        </span>

                                    </div>

                                </div>


                                {{-- Status --}}
                                <span
                                    class="inline-flex w-fit rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClass }}"
                                >
                                    {{ $task['status'] }}
                                </span>

                            </div>


                            {{-- Progress --}}
                            <div class="mt-5">

                                <div class="flex items-center justify-between">

                                    <span class="text-xs font-medium text-gray-500">
                                        Progress
                                    </span>

                                    <span class="text-xs font-semibold text-gray-700">
                                        {{ $task['progress'] }}%
                                    </span>

                                </div>

                                <div class="mt-2 h-2 overflow-hidden rounded-full bg-gray-100">

                                    <div
                                        class="h-full rounded-full transition-all {{ $progressClass }}"
                                        style="width: {{ $task['progress'] }}%;"
                                    ></div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</x-ui.info-card>