@props([
    'projectId' => null,
    'code' => '-',
    'name' => 'Project',
    'type' => null,
    'client' => '-',
    'mandor' => 'Belum ditentukan',
    'progress' => 0,
    'budget' => 'Rp0',
    'target' => 'Belum ditentukan',
    'status' => 'planning',
    'showUrl' => '#',
    'editUrl' => '#',
    'canEdit' => true,
    'canDelete' => true,
])

@php
    $safeProgress = min(
        100,
        max(0, (int) $progress)
    );

    $statusText = match ($status) {
        'planning' => 'Perencanaan',
        'on_progress' => 'Sedang Berjalan',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
        default => 'Tidak Diketahui',
    };

    $badgeColor = match ($status) {
        'planning' => 'yellow',
        'on_progress' => 'blue',
        'completed' => 'green',
        'cancelled' => 'red',
        default => 'gray',
    };

    $statusDotColor = match ($status) {
        'planning' => 'bg-yellow-400',
        'on_progress' => 'bg-blue-500',
        'completed' => 'bg-green-500',
        'cancelled' => 'bg-red-500',
        default => 'bg-gray-400',
    };
@endphp

<article
    class="flex flex-col rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-blue-300 hover:shadow-lg sm:p-6"
>
    {{-- Status dan kode --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <x-ui.badge :color="$badgeColor">
            <span
                class="mr-2 inline-block h-2 w-2 rounded-full {{ $statusDotColor }}"
            ></span>

            {{ $statusText }}
        </x-ui.badge>

        <span class="break-all text-xs font-semibold text-gray-400">
            {{ $code }}
        </span>
    </div>

    {{-- Identitas Project --}}
    <div class="mt-5">
        <h3 class="break-words text-lg font-bold leading-7 text-gray-900">
            {{ $name }}
        </h3>

        @if ($type)
            <p class="mt-1 break-words text-sm text-gray-500">
                {{ $type }}
            </p>
        @endif
    </div>

    <hr class="my-5 border-gray-200">

    {{-- Client dan Mandor --}}
    <dl class="space-y-4">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between sm:gap-4">
            <dt class="shrink-0 text-sm text-gray-500">
                Client
            </dt>

            <dd class="break-words text-sm font-semibold text-gray-900 sm:text-right">
                {{ $client }}
            </dd>
        </div>

        <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between sm:gap-4">
            <dt class="shrink-0 text-sm text-gray-500">
                Mandor
            </dt>

            <dd class="break-words text-sm font-semibold text-gray-900 sm:text-right">
                {{ $mandor }}
            </dd>
        </div>
    </dl>

    <hr class="my-5 border-gray-200">

    {{-- Progres --}}
    <div>
        <div class="mb-2 flex items-center justify-between gap-4">
            <span class="text-sm font-medium text-gray-600">
                Progres
            </span>

            <span class="text-sm font-bold text-gray-900">
                {{ $safeProgress }}%
            </span>
        </div>

        @if ($status === 'planning')
            <progress
                value="{{ $safeProgress }}"
                max="100"
                aria-label="Progres Project {{ $safeProgress }} persen"
                class="block h-2.5 w-full appearance-none overflow-hidden rounded-full [&::-moz-progress-bar]:rounded-full [&::-moz-progress-bar]:bg-yellow-500 [&::-webkit-progress-bar]:rounded-full [&::-webkit-progress-bar]:bg-gray-200 [&::-webkit-progress-value]:rounded-full [&::-webkit-progress-value]:bg-yellow-500"
            >
                {{ $safeProgress }}%
            </progress>
        @elseif ($status === 'on_progress')
            <progress
                value="{{ $safeProgress }}"
                max="100"
                aria-label="Progres Project {{ $safeProgress }} persen"
                class="block h-2.5 w-full appearance-none overflow-hidden rounded-full [&::-moz-progress-bar]:rounded-full [&::-moz-progress-bar]:bg-blue-600 [&::-webkit-progress-bar]:rounded-full [&::-webkit-progress-bar]:bg-gray-200 [&::-webkit-progress-value]:rounded-full [&::-webkit-progress-value]:bg-blue-600"
            >
                {{ $safeProgress }}%
            </progress>
        @elseif ($status === 'completed')
            <progress
                value="{{ $safeProgress }}"
                max="100"
                aria-label="Progres Project {{ $safeProgress }} persen"
                class="block h-2.5 w-full appearance-none overflow-hidden rounded-full [&::-moz-progress-bar]:rounded-full [&::-moz-progress-bar]:bg-green-600 [&::-webkit-progress-bar]:rounded-full [&::-webkit-progress-bar]:bg-gray-200 [&::-webkit-progress-value]:rounded-full [&::-webkit-progress-value]:bg-green-600"
            >
                {{ $safeProgress }}%
            </progress>
        @elseif ($status === 'cancelled')
            <progress
                value="{{ $safeProgress }}"
                max="100"
                aria-label="Progres Project {{ $safeProgress }} persen"
                class="block h-2.5 w-full appearance-none overflow-hidden rounded-full [&::-moz-progress-bar]:rounded-full [&::-moz-progress-bar]:bg-red-500 [&::-webkit-progress-bar]:rounded-full [&::-webkit-progress-bar]:bg-gray-200 [&::-webkit-progress-value]:rounded-full [&::-webkit-progress-value]:bg-red-500"
            >
                {{ $safeProgress }}%
            </progress>
        @else
            <progress
                value="{{ $safeProgress }}"
                max="100"
                aria-label="Progres Project {{ $safeProgress }} persen"
                class="block h-2.5 w-full appearance-none overflow-hidden rounded-full [&::-moz-progress-bar]:rounded-full [&::-moz-progress-bar]:bg-gray-500 [&::-webkit-progress-bar]:rounded-full [&::-webkit-progress-bar]:bg-gray-200 [&::-webkit-progress-value]:rounded-full [&::-webkit-progress-value]:bg-gray-500"
            >
                {{ $safeProgress }}%
            </progress>
        @endif
    </div>

    <hr class="my-5 border-gray-200">

    {{-- Nilai dan target --}}
    <dl class="space-y-4">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between sm:gap-4">
            <dt class="shrink-0 text-sm text-gray-500">
                Nilai Project
            </dt>

            <dd class="break-words text-sm font-bold text-gray-900 sm:text-right">
                {{ $budget }}
            </dd>
        </div>

        <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between sm:gap-4">
            <dt class="shrink-0 text-sm text-gray-500">
                Target Selesai
            </dt>

            <dd class="break-words text-sm font-semibold text-gray-900 sm:text-right">
                {{ $target }}
            </dd>
        </div>
    </dl>

    {{-- Aksi --}}
    <div class="mt-6">
        <div class="flex items-center justify-end gap-2 border-t border-gray-200 pt-5">
            <x-ui.icon-button-view
                :href="$showUrl"
                wire:navigate
            />

            @if ($canEdit)
                <x-ui.icon-button-edit
                    :href="$editUrl"
                    wire:navigate
                />
            @else
                <button
                    type="button"
                    disabled
                    title="Project tidak dapat diubah"
                    aria-label="Project tidak dapat diubah"
                    class="inline-flex h-10 w-10 cursor-not-allowed items-center justify-center rounded-xl border border-gray-200 bg-gray-100 text-gray-400 opacity-70"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"
                        />
                    </svg>
                </button>
            @endif

            @if ($canDelete && $projectId)
    <button
        type="button"
        wire:click="$dispatch(
            'open-delete-project-modal',
            { projectId: {{ $projectId }} }
        )"
        wire:loading.attr="disabled"
        title="Hapus Project"
        aria-label="Hapus Project"
        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-red-200 bg-red-50 text-red-600 transition hover:border-red-300 hover:bg-red-100 hover:text-red-700 focus:outline-none focus:ring-4 focus:ring-red-100 disabled:cursor-not-allowed disabled:opacity-50"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.8"
            stroke="currentColor"
            class="h-5 w-5"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0V4.477c0-1.08-.834-1.977-1.913-2.01a69.697 69.697 0 0 0-3.674 0A2.063 2.063 0 0 0 8.25 4.477v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
            />
        </svg>
    </button>
@endif
        </div>
    </div>
</article>