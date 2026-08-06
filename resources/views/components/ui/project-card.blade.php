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

<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-blue-300 hover:shadow-xl">

    {{-- Status --}}
    {{-- Status --}}
    <div class="flex items-center justify-between">

        <x-ui.badge :color="$badgeColor">

            <span
                class="mr-2 inline-block h-2 w-2 rounded-full
                {{
                    $status == 'Active'
                        ? 'bg-green-500'
                        : ($status == 'Pending'
                            ? 'bg-yellow-400'
                            : 'bg-blue-500')
                }}">
            </span>

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

    <div class="h-2.5 overflow-hidden rounded-full bg-gray-200">

        <div
            class="{{ $progressColor }} h-full rounded-full transition-all duration-500"
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
    {{-- Action --}}
    <div class="flex items-center justify-end gap-2">

        <x-ui.icon-button-view
            :href="$showUrl"
        />

        <x-ui.icon-button-edit
            :href="$editUrl"
        />

        <x-ui.icon-button-delete
            x-on:click="$dispatch('open-delete-project-modal')"
        />

    </div>

</div>