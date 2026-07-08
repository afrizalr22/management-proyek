@props([
    'title',
    'description' => null,
])

<div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">

    <div>

        <h1 class="text-2xl font-bold text-gray-900">
            {{ $title }}
        </h1>

        @if($description)

            <p class="mt-1 text-gray-500">
                {{ $description }}
            </p>

        @endif

    </div>

    @if(isset($actions))

        <div>

            {{ $actions }}

        </div>

    @endif

</div>