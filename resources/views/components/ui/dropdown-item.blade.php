@props([
    'value',
])

<button
    type="button"

    @click="
        selected='{{ $value }}';
        open=false;
    "

    class="flex w-full items-center justify-between px-4 py-3 text-left text-sm transition hover:bg-blue-50"
>

    <span>

        {{ $value }}

    </span>

</button>