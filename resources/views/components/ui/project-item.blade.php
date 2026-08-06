<div class="rounded-xl border border-gray-200 p-5 hover:border-blue-200 hover:bg-blue-50/30 transition">

    {{-- Header --}}
    <div class="flex items-start justify-between">

        <div>

            <h3 class="font-semibold text-gray-900">
                {{ $title }}
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                {{ $date }}
            </p>

        </div>

        <div class="text-right">

            <x-ui.badge
                :color="$status === 'Finished' ? 'green' : 'blue'"
            >
                {{ $status }}
            </x-ui.badge>

        </div>

    </div>

    {{-- Progress --}}
    <div class="mt-5">

        <div class="mb-2 flex items-center justify-between">

            <span class="text-sm text-gray-500">
                Progress
            </span>

            <span class="text-sm font-semibold text-blue-600">
                {{ $progress }}%
            </span>

        </div>

        <div class="h-3 overflow-hidden rounded-full bg-gray-200">

            <div
                class="h-full rounded-full bg-blue-600 transition-all duration-500"
                style="width: {{ $progress }}%;"
            ></div>

        </div>

    </div>

</div>