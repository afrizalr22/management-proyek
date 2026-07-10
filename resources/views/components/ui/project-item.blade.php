@props([
    'title',
    'progress' => 0,
    'status' => 'Active',
    'date',
])

<div class="rounded-xl border border-gray-200 bg-white p-5 transition hover:shadow-md">

    <div class="flex items-start justify-between">

        <div>

            <h4 class="text-lg font-semibold text-gray-800">

                {{ $title }}

            </h4>

            <div class="mt-4">

                <div class="flex items-center justify-between text-sm">

                    <span class="text-gray-500">

                        Progress

                    </span>

                    <span class="font-semibold">

                        {{ $progress }}%

                    </span>

                </div>

                <div class="mt-2 h-2 overflow-hidden rounded-full bg-gray-200">

                    <div
                        class="h-full rounded-full bg-blue-600"
                        style="width: {{ $progress }}%"
                    ></div>

                </div>

            </div>

        </div>

    </div>

    <div class="mt-5 flex items-center justify-between">

        <x-ui.badge
            :color="$status === 'Finished' ? 'green' : 'blue'"
        >

            {{ $status }}

        </x-ui.badge>

        <span class="text-sm text-gray-500">

            {{ $date }}

        </span>

    </div>

</div>