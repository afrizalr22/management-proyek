@props([
    'code' => 'PRJ-001',
    'name' => 'Renovasi Kantor Cabang',
    'type' => 'Renovasi Gedung',
    'client' => 'PT Maju Bersama',
    'mandor' => 'Budi Santoso',
    'progress' => 70,
    'budget' => 'Rp850.000.000',
    'target' => '20 Desember 2026',
    'status' => 'Active',

    'showUrl' => '#',
    'editUrl' => '#',
    'deleteUrl' => '#',
])

@php
    if ($status == 'Completed') {
        $badgeColor = 'blue';
        $progressColor = 'bg-blue-600';
    } elseif ($status == 'Pending') {
        $badgeColor = 'yellow';
        $progressColor = 'bg-yellow-500';
    } else {
        $badgeColor = 'green';
        $progressColor = 'bg-green-600';
    }
@endphp

<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">

    {{-- Status --}}
    <div class="flex items-center justify-between">

        <x-ui.badge :color="$badgeColor">

            {{ $status }}

        </x-ui.badge>

        <span class="text-xs font-semibold text-gray-400">

            {{ $code }}

        </span>

    </div>

    {{-- Project --}}
    <div class="mt-5">

        <h3 class="text-lg font-bold text-gray-900">

            {{ $name }}

        </h3>

        <p class="mt-1 text-sm text-gray-500">

            {{ $type }}

        </p>

    </div>

    <hr class="my-5">

    {{-- Client --}}
    <div class="space-y-4">

        <div class="flex justify-between">

            <span class="text-gray-500">

                Client

            </span>

            <span class="font-semibold">

                {{ $client }}

            </span>

        </div>

        <div class="flex justify-between">

            <span class="text-gray-500">

                Mandor

            </span>

            <span class="font-semibold">

                {{ $mandor }}

            </span>

        </div>

    </div>

    <hr class="my-5">

    {{-- Progress --}}
    <div>

        <div class="mb-2 flex justify-between">

            <span class="text-gray-600">

                Progress

            </span>

            <span class="font-semibold">

                {{ $progress }}%

            </span>

        </div>

        <div class="h-3 overflow-hidden rounded-full bg-gray-200">

            <div
                class="{{ $progressColor }} h-full rounded-full"
                style="width: {{ $progress }}%"
            ></div>

        </div>

    </div>

    <hr class="my-5">

    {{-- Budget --}}
    <div class="flex justify-between">

        <span class="text-gray-500">

            Nilai Project

        </span>

        <span class="font-bold">

            {{ $budget }}

        </span>

    </div>

    <div class="mt-3 flex justify-between">

        <span class="text-gray-500">

            Target Selesai

        </span>

        <span class="font-semibold">

            {{ $target }}

        </span>

    </div>

    <hr class="my-5">

    {{-- Action --}}
    <div class="flex gap-2">

        <a
             href="{{ $showUrl }}"
            class="flex-1 rounded-xl bg-blue-100 py-2 text-center text-sm font-medium text-blue-700 hover:bg-blue-200"
        >
            View
        </a>

        <a
            href="{{ $editUrl }}"
            class="flex-1 rounded-xl bg-yellow-100 py-2 text-center text-sm font-medium text-yellow-700 hover:bg-yellow-200"
        >
            Edit
        </a>

        <a
            href="{{ $deleteUrl }}"
            class="flex-1 rounded-xl bg-red-100 py-2 text-center text-sm font-medium text-red-700 hover:bg-red-200"
        >
            Delete
        </a>

    </div>

</div>