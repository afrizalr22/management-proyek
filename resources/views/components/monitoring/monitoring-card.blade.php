@props([
    'project',
    'client',
    'mandor',
    'location',
    'phase',
    'progress',
    'deadline',
    'status',
    'issues' => 0,
    'photos' => 0,
    'reports' => 0,
    'href',
])

<x-ui.card>

    <div class="p-6">

        {{-- Header --}}
        <div class="flex items-start justify-between">

            <div>

                <h3 class="text-lg font-bold text-gray-900">

                    {{ $project }}

                </h3>

                <p class="mt-1 text-sm text-gray-500">

                    {{ $client }}

                </p>

            </div>

            @php

                $badgeColor = match($status){

                    'Completed' => 'green',

                    'Delayed' => 'red',

                    default => 'blue',

                };

            @endphp

            <x-ui.badge color="{{ $badgeColor }}">

                {{ $status }}

            </x-ui.badge>

        </div>

        {{-- Progress --}}
        <div class="mt-6">

            <div class="mb-2 flex items-center justify-between">

                <span class="text-sm text-gray-600">

                    Progress

                </span>

                <span class="font-semibold text-blue-600">

                    {{ $progress }}%

                </span>

            </div>

            <div class="h-3 overflow-hidden rounded-full bg-gray-200">

                <div
                    class="h-full rounded-full bg-blue-600 transition-all"
                    style="width: {{ $progress }}%;"
                ></div>

            </div>

        </div>

        {{-- Current Phase --}}
        <div class="mt-6 rounded-xl bg-blue-50 p-4">

            <p class="text-xs uppercase tracking-wide text-gray-500">

                Current Phase

            </p>

            <h4 class="mt-1 font-semibold text-blue-700">

                {{ $phase }}

            </h4>

        </div>

        {{-- Information --}}
{{-- Information --}}
<div class="mt-6 space-y-4">

    <div class="flex justify-between">

        <span class="text-gray-500">

            Client

        </span>

        <span class="font-medium text-gray-800">

            {{ $client }}

        </span>

    </div>

    <div class="flex justify-between">

        <span class="text-gray-500">

            Mandor

        </span>

        <span class="font-medium text-gray-800">

            {{ $mandor }}

        </span>

    </div>

    <div class="flex justify-between">

        <span class="text-gray-500">

            Location

        </span>

        <span class="font-medium text-gray-800">

            

        </span>

    </div>

    <div class="flex justify-between">

        <span class="text-gray-500">

            Deadline

        </span>

        <span class="font-medium text-red-600">

            {{ $deadline }}

        </span>

    </div>

</div>

<hr class="my-6">

<div class="grid grid-cols-3 gap-4 text-center">

    <div>

        <p class="text-xs uppercase tracking-wide text-gray-400">

            Issues

        </p>

        <p class="mt-2 text-xl font-bold text-red-600">

            {{ $issues }}

        </p>

    </div>

    <div>

        <p class="text-xs uppercase tracking-wide text-gray-400">

            Photos

        </p>

        <p class="mt-2 text-xl font-bold text-blue-600">

            {{ $photos }}

        </p>

    </div>

    <div>

        <p class="text-xs uppercase tracking-wide text-gray-400">

            Reports

        </p>

        <p class="mt-2 text-xl font-bold text-green-600">

            {{ $reports }}

        </p>

    </div>

</div>

        {{-- Button --}}
        <div class="mt-8">

            <a href="{{ $href }}">

                <x-ui.button class="w-full">

                    View Monitoring

                </x-ui.button>

            </a>

        </div>

    </div>

</x-ui.card>