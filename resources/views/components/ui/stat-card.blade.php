@props([
    'title',
    'value',
    'description' => null,
])

<x-ui.card class="h-full">

    <div class="flex items-start justify-between gap-4">

        <div class="flex-1">

            <p class="text-sm font-medium tracking-wide text-gray-500">
                {{ $title }}
            </p>

            <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900">
                {{ $value }}
            </h2>

            @if($description)
                <p class="mt-2 text-sm text-gray-500">
                    {{ $description }}
                </p>
            @endif

        </div>

        @isset($icon)

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">

                {{ $icon }}

            </div>

        @endisset

    </div>

</x-ui.card>