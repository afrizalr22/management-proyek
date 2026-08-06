@props([
    'progress' => 0,
])

        <x-ui.info-card>

            <div class="p-8">

                {{-- Header --}}
                <div class="flex items-center justify-between">

            <div>

                <h2 class="text-xl font-bold text-gray-900">

                    Project Progress

                </h2>

                <p class="mt-1 text-gray-500">

                    Monitoring tahapan pengerjaan proyek.

                </p>

            </div>

            <x-ui.badge color="green">

                On Schedule

            </x-ui.badge>

        </div>

        <hr class="my-8">

        {{-- Progress --}}
        <div>

            <div class="mb-2 flex items-center justify-between">

                <span class="text-sm font-medium text-gray-600">
                    Progress
                </span>

                <span class="text-sm font-bold text-gray-800">
                    {{ $progress }}%
                </span>

            </div>

            <div class="h-4 overflow-hidden rounded-full bg-gray-200">

                <div
                    class="h-full rounded-full bg-blue-600 transition-all duration-500"
                    style="width: {{ $progress }}%"
                ></div>

            </div>

        </div>

       {{-- Tahapan Project --}}
<div class="mt-10 space-y-5">

    <div class="flex items-center justify-between">

        <div class="flex items-center gap-3">

            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 text-green-600">

                ✓

            </div>

            <span class="font-medium">

                Planning

            </span>

        </div>

        <span class="text-sm font-semibold text-green-600">

            Completed

        </span>

    </div>

    <div class="flex items-center justify-between">

        <div class="flex items-center gap-3">

            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 text-green-600">

                ✓

            </div>

            <span class="font-medium">

                Foundation

            </span>

        </div>

        <span class="text-sm font-semibold text-green-600">

            Completed

        </span>

    </div>

    <div class="flex items-center justify-between">

        <div class="flex items-center gap-3">

            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 text-green-600">

                ✓

            </div>

            <span class="font-medium">

                Structure

            </span>

        </div>

        <span class="text-sm font-semibold text-green-600">

            Completed

        </span>

    </div>

    <div class="flex items-center justify-between">

        <div class="flex items-center gap-3">

            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-yellow-100 text-yellow-600">

                ●

            </div>

            <span class="font-medium">

                Roofing

            </span>

        </div>

        <span class="text-sm font-semibold text-yellow-600">

            In Progress

        </span>

    </div>

    <div class="flex items-center justify-between">

        <div class="flex items-center gap-3">

            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-500">

                ○

            </div>

            <span class="font-medium">

                Finishing

            </span>

        </div>

        <span class="text-sm font-semibold text-gray-500">

            Pending

        </span>

    </div>

</div>

<hr class="my-8">

<div class="flex items-center justify-between text-sm">

    <span class="text-gray-500">

        Last Update

    </span>

    <span class="font-semibold text-gray-700">

        2 Agustus 2026

    </span>

</div>

    </div>

</x-ui.info-card>