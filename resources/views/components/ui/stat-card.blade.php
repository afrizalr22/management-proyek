@props([
    'title',
    'value',
    'description' => null,
    'icon' => null,
])

<x-ui.card class="h-full">

    <div class="flex items-start justify-between">

        <div>

            <p class="text-sm text-gray-500">
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
            <div class="text-blue-600">
                {{ $icon }}
            </div>
        @endif

    </div>

</x-ui.card>