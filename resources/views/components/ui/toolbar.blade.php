<div {{ $attributes->merge([
    'class' => 'flex flex-col gap-4 rounded-xl border bg-white p-4 md:flex-row md:items-center md:justify-between'
]) }}>

    <div class="flex flex-wrap items-center gap-3">
        {{ $left ?? '' }}
    </div>

    <div class="flex flex-wrap items-center justify-end gap-3">
        {{ $right ?? '' }}
    </div>

</div>