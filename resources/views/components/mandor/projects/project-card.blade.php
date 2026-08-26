@props([
    'project',
])

<div
    class="group overflow-hidden rounded-2xl border border-gray-200 bg-white
           shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg"
>

    {{-- Project Image --}}
    <div class="relative aspect-video overflow-hidden bg-gray-100">

        <div
            class="flex h-full items-center justify-center
                   bg-gradient-to-br from-gray-200 to-gray-300"
        >

            <span class="text-sm font-medium text-gray-400">
                Project Image
            </span>

        </div>


        {{-- Status --}}
        <div class="absolute right-4 top-4">

            @if($project['status'] === 'Active')

                <x-ui.badge color="green">
                    Active
                </x-ui.badge>

            @elseif($project['status'] === 'On Hold')

                <x-ui.badge color="yellow">
                    On Hold
                </x-ui.badge>

            @else

                <x-ui.badge color="blue">
                    Completed
                </x-ui.badge>

            @endif

        </div>

    </div>


    {{-- Project Content --}}
    <div class="p-6">

        {{-- Project Name --}}
        <h3 class="text-xl font-bold text-gray-900">
            {{ $project['name'] }}
        </h3>


        {{-- Client --}}
        <p class="mt-1 text-sm text-gray-500">
            {{ $project['client'] }}
        </p>


        {{-- Project Information --}}
        <div class="mt-5 grid grid-cols-2 gap-4">

            <div>

                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Start Date
                </p>

                <p class="mt-1 text-sm font-semibold text-gray-700">
                    {{ $project['start_date'] }}
                </p>

            </div>


            <div>

                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                    Current Phase
                </p>

                <p class="mt-1 text-sm font-semibold text-gray-700">
                    {{ $project['phase'] }}
                </p>

            </div>

        </div>


        {{-- Progress --}}
        <div class="mt-6">

            <div class="flex items-center justify-between">

                <span class="text-sm font-medium text-gray-600">
                    Overall Progress
                </span>

                <span class="text-sm font-bold text-gray-900">
                    {{ $project['progress'] }}%
                </span>

            </div>


            <div class="mt-2 h-2.5 overflow-hidden rounded-full bg-gray-100">

                <div
                    class="h-full rounded-full bg-blue-600 transition-all"
                    style="width: {{ $project['progress'] }}%"
                ></div>

            </div>

        </div>


        {{-- Footer --}}
        <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-5">

            <div>

                <p class="text-xs text-gray-400">
                    Last update
                </p>

                <p class="mt-1 text-sm font-medium text-gray-600">
                    {{ $project['last_update'] }}
                </p>

            </div>


            <a
                href="{{ route('mandor.projects.show', $project['id']) }}"
                class="text-sm font-semibold text-blue-600 transition hover:text-blue-700"
            >
                View Details
            </a>

        </div>

    </div>

</div>