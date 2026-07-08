@props([
    'title',
    'value',
    'description' => null,
    'icon' => null,
])

<x-ui.card class="h-full">

    <div class="flex items-start justify-between">

        <div class="flex-1">

            <p class="text-sm font-medium text-gray-500">
                {{ $title }}
            </p>

            <h2 class="mt-2 text-3xl font-bold text-gray-900">
                {{ $value }}
            </h2>

            @if($description)
                <p class="mt-2 text-sm text-gray-500">
                    {{ $description }}
                </p>
            @endif

        </div>

        @if($icon)
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-100 text-blue-600">

                {{ $icon }}

            </div>
        @endif

    </div>

</x-ui.card>