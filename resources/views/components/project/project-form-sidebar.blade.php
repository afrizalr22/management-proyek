@props([
    'mode' => 'create',
])

@php
    $priority = $mode === 'edit' ? 'Medium' : null;

    $status = $mode === 'edit'
        ? 'Active'
        : 'Planning';

    $progress = $mode === 'edit'
        ? 35
        : 0;

    $projectCode = 'PRJ-2026-001';
@endphp

<div class="space-y-6">

    {{-- Project Settings --}}
    <x-ui.summary-card>

        <div class="p-6">

            <h3 class="text-lg font-bold text-gray-800">

                Project Settings

            </h3>

            <div class="mt-6 space-y-5">

                {{-- Priority --}}
                <div>

                    <p class="mb-3 text-sm font-semibold text-gray-700">

                        Priority

                    </p>

                    <div class="space-y-2">

                        @php
                            $priority = $mode === 'edit'
                                ? 'Medium'
                                : null;
                        @endphp

                        @foreach (['High','Medium','Low'] as $item)

                            <label class="flex items-center gap-3">

                                <input
                                    type="radio"
                                    name="priority"
                                    {{ $priority === $item ? 'checked' : '' }}
                                >

                                <span class="text-sm text-gray-700">

                                    {{ $item }}

                                </span>

                            </label>

                        @endforeach

                    </div>

                </div>

                <hr>

                {{-- Status --}}
                <div class="flex items-center justify-between">

                    <span class="text-gray-600">

                        Status

                    </span>

                    @if($mode === 'create')

                        <x-ui.badge color="gray">

                            Planning

                        </x-ui.badge>

                    @else

                        <x-ui.badge color="green">

                            Active

                        </x-ui.badge>

                    @endif

                </div>

                <hr>

                {{-- Progress --}}
                <div>

                    <div class="flex justify-between text-sm">

                        <span>

                            Project Progress

                        </span>

                        <span>

                            {{ $mode === 'edit' ? '35%' : '0%' }}

                        </span>

                    </div>
                    

                    <div class="mt-3 h-2 overflow-hidden rounded-full bg-gray-200">

                        <div
                            class="h-full rounded-full bg-blue-600"
                            {{ $progress }}%
                        ></div>

                    </div>

                </div>

            </div>

        </div>

    </x-ui.summary-card>

    {{-- Information --}}
    <x-ui.summary-card>

        <div class="p-6">

            <h3 class="text-lg font-bold text-gray-800">

                Information

            </h3>

            @if($mode === 'create')

                <p class="mt-4 text-sm leading-7 text-gray-500">

                    Pastikan seluruh informasi project telah diisi dengan benar
                    sebelum menyimpan data.

                </p>

            @else

                <div class="mt-5 space-y-5">

                    <div class="flex justify-between">

                        <span class="text-gray-500">

                            Project Code

                        </span>

                        <span class="font-semibold">

                            PRJ-2026-001

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-gray-500">

                            Created

                        </span>

                        <span>

                            12 Jul 2026

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-gray-500">

                            Updated

                        </span>

                        <span>

                            15 Jul 2026

                        </span>

                    </div>

                </div>

            @endif

        </div>

    </x-ui.summary-card>

</div>