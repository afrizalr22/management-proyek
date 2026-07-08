@props([
    'title',
    'description' => null,
])

<x-ui.card class="h-full">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h3 class="text-lg font-semibold text-gray-900">
                {{ $title }}
            </h3>

            @if($description)
                <p class="mt-1 text-sm text-gray-500">
                    {{ $description }}
                </p>
            @endif

        </div>

        {{ $actions ?? '' }}

    </div>

    <div>

        {{ $slot }}

    </div>

</x-ui.card>