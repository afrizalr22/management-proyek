@php
    $tasks = [
        [
            'name' => 'Preparation',
            'start' => 1,
            'duration' => 2,
            'progress' => 100,
            'status' => 'completed',
        ],
        [
            'name' => 'Foundation',
            'start' => 3,
            'duration' => 2,
            'progress' => 100,
            'status' => 'completed',
        ],
        [
            'name' => 'Structure',
            'start' => 5,
            'duration' => 3,
            'progress' => 75,
            'status' => 'current',
        ],
        [
            'name' => 'Wall',
            'start' => 8,
            'duration' => 2,
            'progress' => 0,
            'status' => 'pending',
        ],
        [
            'name' => 'Roof',
            'start' => 9,
            'duration' => 2,
            'progress' => 0,
            'status' => 'pending',
        ],
        [
            'name' => 'MEP',
            'start' => 10,
            'duration' => 2,
            'progress' => 0,
            'status' => 'pending',
        ],
        [
            'name' => 'Finishing',
            'start' => 11,
            'duration' => 2,
            'progress' => 0,
            'status' => 'pending',
        ],
        [
            'name' => 'Handover',
            'start' => 12,
            'duration' => 1,
            'progress' => 0,
            'status' => 'pending',
        ],
    ];
@endphp


<x-ui.info-card>

    <div class="p-8">

        {{-- Header --}}
        <div class="mb-6">

            <h2 class="text-xl font-semibold text-gray-800">
                Jadwal Konstruksi
            </h2>

            <p class="mt-1 text-sm leading-6 text-gray-500">
                Melacak jadwal proyek dan memantau kemajuan konstruksi.
            </p>


            {{-- Legend --}}
            <div class="mt-5 flex flex-wrap items-center gap-x-6 gap-y-3">

                {{-- Completed --}}
                <div class="flex items-center gap-2">

                    <span
                        class="h-3 w-3 shrink-0 rounded-full bg-emerald-500"
                    ></span>

                    <span class="text-sm text-gray-600">
                        Completed
                    </span>

                </div>


                {{-- In Progress --}}
                <div class="flex items-center gap-2">

                    <span
                        class="h-3 w-3 shrink-0 rounded-full bg-blue-600"
                    ></span>

                    <span class="text-sm text-gray-600">
                        In Progress
                    </span>

                </div>


                {{-- Pending --}}
                <div class="flex items-center gap-2">

                    <span
                        class="h-3 w-3 shrink-0 rounded-full bg-gray-400"
                    ></span>

                    <span class="text-sm text-gray-600">
                        Pending
                    </span>

                </div>

            </div>

        </div>


        {{-- Gantt Chart --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">

            <div class="overflow-x-auto">

                <div class="min-w-[1100px]">

                    {{-- Timeline Header --}}
                    <x-monitoring.gantt-header />


                    {{-- Tasks --}}
                    @foreach ($tasks as $task)

                        <x-monitoring.gantt-row
                            :task="$task"
                        />

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</x-ui.info-card>